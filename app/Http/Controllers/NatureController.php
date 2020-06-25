<?php

namespace App\Http\Controllers;

use App\Nature;
use Illuminate\Http\Request;

class NatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $natures = Nature::query()->orderBy('name')->get();
        return response(view('nature.index', compact('natures')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('nature.create'), 200);
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
        Nature::create($request->all());

        return response(redirect()->route('index-nature'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nature = Nature::find($id);
        return response(view('nature.one', compact('nature')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nature = Nature::find($id);
        return response(view('nature.update', compact('nature')));
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
        $nature = Nature::find($id);
        $nature->update($request->all());

        return response(redirect()->route('show-nature', $nature->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nature = Nature::find($id);
        foreach ($nature->types as $type) {
            $type->delete();
        }
        $nature->delete();

        return response(redirect(route('index-nature')));
    }
}
