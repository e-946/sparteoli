<?php

namespace App\Http\Controllers;

use App\Placeuse;
use Illuminate\Http\Request;

class PlaceuseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uses = Placeuse::query()->orderBy('name')->get();
        return response(view('placeuse.index', compact('uses')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('placeuse.create'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request)){
            return response('Formulário vazio');
        }
        Placeuse::create($request->all());

        return response(redirect()->route('index-placeuse'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $use = Placeuse::find($id);
        return response(view('placeuse.one', compact('use')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $use = Placeuse::find($id);
        return response(view("placeuse.update", compact('use')));
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
        $use = Placeuse::find($id);
        $use->update($request->all());

        return response(redirect()->route('show-placeuse', $use->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $use = Placeuse::find($id);
        $use->delete();

        return response(redirect(route('index-placeuse')));
    }
}
