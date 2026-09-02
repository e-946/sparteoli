<?php

namespace App\Http\Controllers;

use App\Helpers\VictimDestroyer;
use App\Models\Occurrence;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class OccurrenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $occurrences = Occurrence::query()
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['id', 'filler_name']);

        return Inertia::render('Occurrences/Index', [
            'occurrences' => $occurrences,
        ]);
    }

    private function fillers(): Collection
    {
        return Occurrence::select(['filler_register', 'filler_name', 'filler_patent'])
            ->distinct()
            ->get();
    }

    private function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'call_time' => ['required'],
            'arrival_time' => ['required'],
            'end_time' => ['required'],
            'meanused_id' => ['required', 'exists:meanuseds,id'],
            'zip_code' => ['required', 'string', 'max:20'],
            'street' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:20'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'requester' => ['required', 'string', 'max:255'],
            'requester_phone' => ['required', 'string', 'max:20'],
            'resume' => ['required', 'string'],
            'placefreature_id' => ['required', 'exists:placefreatures,id'],
            'placeuse_id' => ['required', 'exists:placeuses,id'],
            'place_preservation' => ['required', 'boolean'],
            'filler_register' => ['required', 'string', 'max:10'],
            'filler_name' => ['required', 'string', 'max:255'],
            'filler_patent' => ['required', 'string', 'max:255'],
            'type_id' => ['required', 'exists:types,id'],
            'protectionsForSave' => ['nullable', 'array'],
            'protectionsForSave.*' => ['integer', 'exists:fireprotections,id'],
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Occurrences/Form', [
            'mode' => 'create',
            'fillers' => $this->fillers(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $data = collect($validated)->except(['street', 'number', 'protectionsForSave'])->all();
        $data['address'] = $validated['street'] . ', Nº ' . $validated['number'];
        $data['user_id'] = Auth::id();

        $occurrence = Occurrence::create($data);

        if (! empty($validated['protectionsForSave'])) {
            $occurrence->fireprotections()->attach($validated['protectionsForSave']);
        }

        return redirect()->route('show-occurrence', $occurrence->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $occurrence = Occurrence::with([
            'meanused', 'placefreature', 'placeuse', 'type.nature', 'fireprotections',
            'victims', 'resources',
        ])->findOrFail($id);

        return Inertia::render('Occurrences/Show', [
            'occurrence' => $occurrence,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $occurrence = Occurrence::with([
            'meanused:id,name',
            'placefreature:id,name',
            'placeuse:id,name',
            'type:id,name,nature_id',
            'type.nature:id,name',
            'fireprotections:id,name',
        ])->findOrFail($id);

        [$street, $number] = array_pad(explode(', Nº ', $occurrence->address, 2), 2, '');

        return Inertia::render('Occurrences/Form', [
            'mode' => 'edit',
            'occurrence' => [
                ...$occurrence->toArray(),
                'street' => $street,
                'number' => $number,
            ],
            'fillers' => $this->fillers(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $occurrence = Occurrence::findOrFail($id);
        $validated = $request->validate($this->rules());

        $data = collect($validated)->except(['street', 'number', 'protectionsForSave'])->all();
        $data['address'] = $validated['street'] . ', Nº ' . $validated['number'];

        $occurrence->fireprotections()->sync($validated['protectionsForSave'] ?? []);
        $occurrence->update($data);

        return redirect()->route('show-occurrence', $occurrence->id)->with(
            'message',
            'Ocorrência alterada com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $occurrence = Occurrence::findOrFail($id);

        foreach ($occurrence->victims as $victim) {
            new VictimDestroyer($victim->id);
        }
        foreach ($occurrence->resources as $resource) {
            $resource->delete();
        }

        $occurrence->fireprotections()->detach();

        $occurrence->delete();

        return redirect(route('index-occurrence'))->with(
            'message',
            'Ocorrência excluída com sucesso'
        );
    }

    /**
     * Generate PDF for resource
     *
     * @return BinaryFileResponse
     */
    public function toPdf(int $id)
    {
        $occurrence = Occurrence::findOrFail($id);

        $filename = "occurrence-{$id}-" . Str::uuid() . '.html';

        Storage::put($filename, view('occurrence.pdf', compact('occurrence'))->render());

        return response()->file(storage_path("app/{$filename}"))->deleteFileAfterSend();
    }
}
