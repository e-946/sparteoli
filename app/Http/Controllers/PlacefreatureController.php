<?php

namespace App\Http\Controllers;

use App\Placefreature;
use Illuminate\Http\Request;

class PlacefreatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freatures = Placefreature::query()->orderBy('name')->get();
        return response(view('placefreature.index', compact('freatures')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('placefreature.create'), 200);
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
        Placefreature::create($request->all());

        return response(redirect()->route('index-placefreature'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $freature = Placefreature::find($id);
        return response(view('placefreature.one', compact('freature')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $freature = Placefreature::find($id);
        return response(view('placefreature.update', compact('freature')));
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
        $freature = Placefreature::find($id);
        $freature->update($request->all());

        return response(redirect()->route('show-placefreature', $freature->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $freature = Placefreature::find($id);
        $freature->delete();

        return response(redirect(route('index-placefreature')));
    }
}
