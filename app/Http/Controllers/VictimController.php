<?php

namespace App\Http\Controllers;

use App\Helpers\VictimCreator;
use App\Helpers\VictimDestroyer;
use App\Models\Problem;
use App\Models\Rescuer;
use App\Models\Victim;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VictimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $occurrence_id): Response
    {
        $victims = Victim::query()->where('occurrence_id', '=', $occurrence_id)->orderBy('name')->get();

        return response(view('victim.index', compact('victims', 'occurrence_id')), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $occurrence_id): Response
    {
        $rescuers = Rescuer::all();
        $problems = Problem::all();

        return response(view('victim.create', compact('rescuers', 'problems', 'occurrence_id')), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $occurrence_id): RedirectResponse
    {

        if (! empty($request->problemForSave)) {
            new VictimCreator(
                $request->name,
                $request->age,
                $request->sex,
                $request->fatal,
                $request->conscious,
                $request->rescuer_id,
                $request->problemForSave,
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
        $victim = Victim::find($id);

        return response(view('victim.one', compact('victim', 'occurrence_id')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $occurrence_id, int $id): Response
    {
        $victim = Victim::find($id);
        $rescuers = Rescuer::all();
        $problems = Problem::all();

        return response(view('victim.update', compact('victim', 'rescuers', 'problems', 'occurrence_id')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $occurrence_id, int $id): RedirectResponse
    {
        $victim = Victim::find($id);
        $victim->update([
            'name' => $request->name,
            'age' => $request->age,
            'sex' => $request->sex,
            'rescuer_id' => $request->rescuer_id,
            'fatal' => $request->fatal,
            'conscious' => $request->conscious,
        ]);

        $victim->problems()->sync($request->problemForSave);

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
