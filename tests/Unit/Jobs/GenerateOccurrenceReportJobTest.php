<?php

namespace Tests\Unit\Jobs;

use App\Enums\ReportFormat;
use App\Enums\ReportStatus;
use App\Jobs\GenerateOccurrenceReportJob;
use App\Models\Occurrence;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GenerateOccurrenceReportJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_a_csv_report_matching_the_filters(): void
    {
        Storage::fake('reports');

        Occurrence::factory()->create(['city' => 'Salvador']);
        Occurrence::factory()->create(['city' => 'Feira De Santana']);

        $report = Report::factory()->create([
            'filters' => ['city' => 'Salvador'],
            'fields' => ['date', 'city', 'requester'],
            'format' => ReportFormat::Csv->value,
            'status' => ReportStatus::Pending->value,
        ]);

        (new GenerateOccurrenceReportJob($report))->handle();

        $report->refresh();

        $this->assertSame(ReportStatus::Completed, $report->status);
        $this->assertNotNull($report->file_path);
        $this->assertNotNull($report->completed_at);

        Storage::disk('reports')->assertExists($report->file_path);

        $csv = Storage::disk('reports')->get($report->file_path);
        $this->assertStringContainsString('Salvador', $csv);
        $this->assertStringNotContainsString('Feira De Santana', $csv);
    }

    public function test_it_generates_a_pdf_report(): void
    {
        Storage::fake('reports');

        Occurrence::factory()->create();

        $report = Report::factory()->create([
            'filters' => [],
            'fields' => ['date', 'city'],
            'format' => ReportFormat::Pdf->value,
            'status' => ReportStatus::Pending->value,
        ]);

        (new GenerateOccurrenceReportJob($report))->handle();

        $report->refresh();

        $this->assertSame(ReportStatus::Completed, $report->status);
        Storage::disk('reports')->assertExists($report->file_path);
        $this->assertStringStartsWith('%PDF', Storage::disk('reports')->get($report->file_path));
    }

    public function test_it_marks_the_report_as_failed_on_error(): void
    {
        Storage::fake('reports');

        // Inserted via the query builder (bypassing Eloquent's enum cast) so the
        // invalid format only blows up when the job itself reads it, inside its
        // try/catch — mirroring how a bad/legacy row would fail at runtime.
        $id = DB::table('reports')->insertGetId([
            'user_id' => User::factory()->create()->id,
            'filters' => json_encode([]),
            'fields' => json_encode(['date']),
            'format' => 'not-a-real-format',
            'status' => ReportStatus::Pending->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $report = Report::findOrFail($id);

        (new GenerateOccurrenceReportJob($report))->handle();

        $report->refresh();

        $this->assertSame(ReportStatus::Failed, $report->status);
        $this->assertNotNull($report->error_message);
    }
}
