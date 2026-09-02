<?php

namespace App\Http\Controllers;

use App\Helpers\VictimDestroyer;
use App\Models\Occurrence;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $occurrences = Occurrence::query()->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Occurrences/Index', [
            'occurrences' => $occurrences,
        ]);
    }

    private function fillers()
    {
        return Occurrence::select(['filler_register', 'filler_name', 'filler_patent'])
            ->distinct()
            ->get();
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
        $data = $request->except('protectionsForSave');
        $data['address'] = $data['street'].', Nº '.$data['number'];
        $data['user_id'] = Auth::id();
        unset($data['street'], $data['number']);
        $occurrence = Occurrence::create($data);
        if (! empty($request->protectionsForSave)) {
            $occurrence->fireprotections()->attach($request->protectionsForSave);
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
        $occurrence = Occurrence::find($id);
        $data = $request->except('protectionsForSave');
        $data['address'] = $data['street'].', Nº '.$data['number'];
        unset($data['street'], $data['number']);
        $occurrence->fireprotections()->sync($request->protectionsForSave ?? []);
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
        $occurrence = Occurrence::find($id);

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
        $occurrence = Occurrence::find($id);

        Storage::put('occurrence.html', view('occurrence.pdf', compact('occurrence'))->render());

        return response()->file(storage_path('app/occurrence.html'))->deleteFileAfterSend();
    }
}
