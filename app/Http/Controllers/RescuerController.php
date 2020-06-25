<?php

namespace App\Http\Controllers;

use App\Rescuer;
use Illuminate\Http\Request;

class RescuerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rescuers = Rescuer::query()->orderBy('name')->get();
        return response(view('rescuer.index', compact('rescuers')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('rescuer.create'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request)) {
            return response('Formulário vazio');
        }
        Rescuer::create($request->all());

        return response(redirect()->route('index-rescuer'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rescuer = Rescuer::find($id);
        return response(view('rescuer.one', compact('rescuer')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rescuer = Rescuer::find($id);
        return response(view('rescuer.update', compact('rescuer')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rescuer = Rescuer::find($id);
        $rescuer->update($request->all());

        return response(redirect()->route('show-rescuer', $rescuer->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rescuer = Rescuer::find($id);
        $rescuer->delete();

        return response(redirect(route('index-rescuer')));
    }
}
