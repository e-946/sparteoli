<?php

namespace App\Http\Controllers;

use App\Enums\ReportFormat;
use App\Enums\ReportStatus;
use App\Jobs\GenerateOccurrenceReportJob;
use App\Models\Report;
use App\Models\User;
use App\Support\OccurrenceReportFields;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $reports = Report::with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Reports/Index', [
            'reports' => $reports,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Reports/Create', [
            'fields' => OccurrenceReportFields::labels(),
            'users' => User::orderBy('name')->get(['id', 'name']),
        ]);
    }

    private function rules(): array
    {
        return [
            'format' => ['required', Rule::enum(ReportFormat::class)],
            'fields' => ['required', 'array', 'min:1'],
            'fields.*' => ['string', Rule::in(array_keys(OccurrenceReportFields::COLUMNS))],
            'filters' => ['nullable', 'array'],
            'filters.type_id' => ['nullable', 'integer', 'exists:types,id'],
            'filters.date_from' => ['nullable', 'date'],
            'filters.date_to' => ['nullable', 'date', 'after_or_equal:filters.date_from'],
            'filters.city' => ['nullable', 'string', 'max:255'],
            'filters.caller' => ['nullable', 'string', 'max:255'],
            'filters.meanused_id' => ['nullable', 'integer', 'exists:meanuseds,id'],
            'filters.placefreature_id' => ['nullable', 'integer', 'exists:placefreatures,id'],
            'filters.placeuse_id' => ['nullable', 'integer', 'exists:placeuses,id'],
            'filters.filler_name' => ['nullable', 'string', 'max:255'],
            'filters.user_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Empty strings from unselected SearchableSelect/select filters must be
        // treated as absent, not as a value to validate/store.
        $request->merge([
            'filters' => collect($request->input('filters', []))
                ->map(fn (mixed $value): mixed => $value === '' ? null : $value)
                ->all(),
        ]);

        $validated = $request->validate($this->rules());

        $report = Report::create([
            'user_id' => Auth::id(),
            'filters' => $validated['filters'] ?? [],
            'fields' => $validated['fields'],
            'format' => $validated['format'],
            'status' => ReportStatus::Pending,
        ]);

        GenerateOccurrenceReportJob::dispatch($report);

        return redirect()->route('index-report')->with(
            'message',
            'Relatório solicitado com sucesso'
        );
    }

    /**
     * Download the generated file for the specified resource.
     */
    public function download(int $id): StreamedResponse
    {
        $report = Report::findOrFail($id);

        abort_if($report->status !== ReportStatus::Completed || ! $report->file_path, 404);

        return Storage::disk('reports')->download(
            $report->file_path,
            "relatorio-ocorrencias-{$report->id}.{$report->format->value}"
        );
    }
}
