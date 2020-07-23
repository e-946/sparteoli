<?php

namespace App\Http\Controllers;

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
     * @return Response
     */
    public function index()
    {
        $victims = Victim::query()->orderBy('name')->get();
        return response(view('victim.index', compact('victims')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $rescuers = Rescuer::all();
        $problems = Problem::all();
        return response(view('victim.create', compact('rescuers', 'problems')), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (empty($request)) {
            return response('Formulário vazio');
        }
        Victim::create($request->all());

        return response(redirect()->route('index-victim'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $victim = Victim::find($id);
        return response(view('victim.one', compact('victim')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $victim = Victim::find($id);
        return response(view('victim.update', compact('victim')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $victim = Victim::find($id);
        $victim->update($request->all());

        return response(redirect()->route('show-victim', $victim->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $victim = Victim::find($id);
        $victim->delete();

        return response(redirect(route('index-victim')));
    }
}
