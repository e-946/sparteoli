<?php

namespace App\Http\Controllers;

use App\Helpers\VictimCreator;
use App\Helpers\VictimDestroyer;
use App\Problem;
use App\Rescuer;
use App\Victim;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VictimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $occurrence_id
     * @return Response
     */
    public function index(int $occurrence_id)
    {
        $victims = Victim::query()->orderBy('name')->get();
        return response(view('victim.index', compact('victims', 'occurrence_id')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $occurrence_id
     * @return Response
     */
    public function create(int $occurrence_id)
    {
        $rescuers = Rescuer::all();
        $problems = Problem::all();
        return response(view('victim.create', compact('rescuers', 'problems', 'occurrence_id')), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param int $occurrence_id
     * @return Response
     */
    public function store(Request $request, int $occurrence_id)
    {

        if (!empty($request->problemForSave)){
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

        return response(redirect()->route('index-victim', $occurrence_id));
    }

    /**
     * Display the specified resource.
     *
     * @param int $occurrence_id
     * @param int $id
     * @return Response
     */
    public function show(int $occurrence_id, int $id)
    {
        $victim = Victim::find($id);
        return response(view('victim.one', compact('victim', 'occurrence_id')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $occurrence_id
     * @param int $id
     * @return Response
     */
    public function edit(int $occurrence_id, int $id)
    {
        $victim = Victim::find($id);
        $rescuers = Rescuer::all();
        $problems = Problem::all();
        return response(view('victim.update', compact('victim', 'rescuers', 'problems', 'occurrence_id')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $occurrence_id
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $occurrence_id, int $id)
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

        return response(redirect()->route('show-victim', ['occurrence_id' => $occurrence_id, 'id' => $victim->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $occurrence_id
     * @param int $id
     * @return Response
     */
    public function destroy(int $occurrence_id, int $id)
    {
        new VictimDestroyer($id);

        return response(redirect(route('index-victim', $occurrence_id)));
    }
}
