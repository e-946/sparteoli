<?php

namespace App\Http\Controllers;

use App\Helpers\VictimCreator;
use App\Helpers\VictimDestroyer;
use App\Models\Problem;
use App\Models\Rescuer;
use App\Models\Victim;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VictimController extends Controller
{
    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:0', 'max:150'],
            'sex' => ['required', 'in:M,F'],
            'rescuer_id' => ['required', 'exists:rescuers,id'],
            'fatal' => ['required', 'boolean'],
            'conscious' => ['nullable', 'boolean'],
            'problemForSave' => ['nullable', 'array'],
            'problemForSave.*' => ['integer', 'exists:problems,id'],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $occurrence_id): Response
    {
        $victims = Victim::query()->where('occurrence_id', '=', $occurrence_id)->orderBy('name')->get();

        return Inertia::render('Victims/Index', [
            'victims' => $victims,
            'occurrence_id' => $occurrence_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $occurrence_id): Response
    {
        return Inertia::render('Victims/Form', [
            'mode' => 'create',
            'occurrence_id' => $occurrence_id,
            'rescuers' => Rescuer::all(['id', 'name']),
            'problems' => Problem::all(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $occurrence_id): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        if (! empty($validated['problemForSave'])) {
            new VictimCreator(
                $validated['name'],
                $validated['age'],
                $validated['sex'],
                $validated['fatal'],
                $validated['conscious'] ?? null,
                $validated['rescuer_id'],
                $validated['problemForSave'],
                $occurrence_id
            );
        }

        return redirect()->route('index-victim', $occurrence_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $occurrence_id, int $id): Response
    {
        $victim = Victim::with('rescuer:id,name', 'problems:id,name')->findOrFail($id);

        return Inertia::render('Victims/Show', [
            'victim' => $victim,
            'occurrence_id' => $occurrence_id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $occurrence_id, int $id): Response
    {
        $victim = Victim::with('problems:id')->findOrFail($id);

        return Inertia::render('Victims/Form', [
            'mode' => 'edit',
            'occurrence_id' => $occurrence_id,
            'victim' => $victim,
            'rescuers' => Rescuer::all(['id', 'name']),
            'problems' => Problem::all(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $occurrence_id, int $id): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $victim = Victim::find($id);
        $victim->update([
            'name' => $validated['name'],
            'age' => $validated['age'],
            'sex' => $validated['sex'],
            'rescuer_id' => $validated['rescuer_id'],
            'fatal' => $validated['fatal'],
            'conscious' => $validated['conscious'] ?? null,
        ]);

        $victim->problems()->sync($validated['problemForSave'] ?? []);

        return redirect()
            ->route('show-victim', ['occurrence_id' => $occurrence_id, 'id' => $victim->id])
            ->with(
                'message',
                'Vítima alterada com sucesso'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $occurrence_id, int $id): RedirectResponse
    {
        new VictimDestroyer($id);

        return redirect(route('index-victim', $occurrence_id))->with(
            'message',
            'Vítima excluída com sucesso'
        );
    }
}
