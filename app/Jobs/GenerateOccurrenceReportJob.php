<?php

namespace App\Jobs;

use App\Enums\ReportFormat;
use App\Enums\ReportStatus;
use App\Models\Occurrence;
use App\Models\Report;
use App\Support\OccurrenceReportFields;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Csv\Writer;
use Throwable;

class GenerateOccurrenceReportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 1;

    public function __construct(private readonly Report $report) {}

    public function handle(): void
    {
        $this->report->update(['status' => ReportStatus::Processing]);

        try {
            $fields = $this->report->fields;
            $query = $this->buildQuery($fields);

            $path = match ($this->report->format) {
                ReportFormat::Csv => $this->writeCsv($query, $fields),
                ReportFormat::Pdf => $this->writePdf($query, $fields),
            };

            $this->report->update([
                'status' => ReportStatus::Completed,
                'file_path' => $path,
                'completed_at' => now(),
            ]);
        } catch (Throwable $e) {
            $this->report->update([
                'status' => ReportStatus::Failed,
                'error_message' => Str::limit($e->getMessage(), 1000),
            ]);

            report($e);
        }
    }

    /**
     * @param  array<int, string>  $fields
     * @return Builder<Occurrence>
     */
    private function buildQuery(array $fields): Builder
    {
        $resolved = OccurrenceReportFields::resolve($fields);

        $query = Occurrence::query()
            ->select($resolved['select'])
            ->with($resolved['with'])
            ->orderBy('date', 'desc');

        $filters = $this->report->filters;

        if (! empty($filters['type_id'])) {
            $query->where('type_id', $filters['type_id']);
        }

        if (! empty($filters['date_from'])) {
            $query->whereDate('date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->whereDate('date', '<=', $filters['date_to']);
        }

        if (! empty($filters['city'])) {
            $query->where('city', 'like', '%' . $filters['city'] . '%');
        }

        if (! empty($filters['caller'])) {
            $caller = $filters['caller'];
            $query->where(function (Builder $q) use ($caller): void {
                $q->where('requester', 'like', '%' . $caller . '%')
                    ->orWhere('requester_phone', 'like', '%' . $caller . '%');
            });
        }

        if (! empty($filters['meanused_id'])) {
            $query->where('meanused_id', $filters['meanused_id']);
        }

        if (! empty($filters['placefreature_id'])) {
            $query->where('placefreature_id', $filters['placefreature_id']);
        }

        if (! empty($filters['placeuse_id'])) {
            $query->where('placeuse_id', $filters['placeuse_id']);
        }

        if (! empty($filters['filler_name'])) {
            $query->where('filler_name', 'like', '%' . $filters['filler_name'] . '%');
        }

        if (! empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query;
    }

    /**
     * @param  Builder<Occurrence>  $query
     * @param  array<int, string>  $fields
     */
    private function writeCsv(Builder $query, array $fields): string
    {
        $csv = Writer::createFromString('');

        $csv->insertOne([
            'ID',
            ...array_map(fn (string $field): string => OccurrenceReportFields::label($field), $fields),
        ]);

        foreach ($query->cursor() as $occurrence) {
            $csv->insertOne([
                $occurrence->id,
                ...array_map(
                    fn (string $field): mixed => OccurrenceReportFields::value($occurrence, $field),
                    $fields
                ),
            ]);
        }

        $path = 'occurrence-report-' . $this->report->id . '-' . Str::uuid()->toString() . '.csv';

        Storage::disk('reports')->put($path, $csv->toString());

        return $path;
    }

    /**
     * @param  Builder<Occurrence>  $query
     * @param  array<int, string>  $fields
     */
    private function writePdf(Builder $query, array $fields): string
    {
        $occurrences = $query->get();

        $path = 'occurrence-report-' . $this->report->id . '-' . Str::uuid()->toString() . '.pdf';

        Pdf::loadView('reports.pdf', ['occurrences' => $occurrences, 'fields' => $fields])
            ->save($path, 'reports');

        return $path;
    }
}
