<?php

namespace App\Http\Controllers;

use App\Meanused;
use App\Nature;
use App\Occurrence;
use App\Placefreature;
use App\Placeuse;
use Illuminate\Http\Request;

class OccurrenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $occurrences = Occurrence::query()->orderBy('created_at', 'DESC')->limit(10);
        return response(view('occurrence.index', compact('occurrences')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $means = Meanused::all();
        $uses = Placeuse::all();
        $freatures = Placefreature::all();
        $natures = Nature::all();

        return response(view('occurrence.create', compact('means', 'uses', 'freatures', 'natures')), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['address'] = $data['street'] . ', Nº ' . $data['number'];
        unset($data['street'], $data['number']);
        $occurrence = Occurrence::create($data);
        $data['occurrence_id'] = $occurrence->id;

        return response(redirect()->route('show-occurrence', $occurrence->id));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $occurrence = Occurrence::find($id);
        return response(view('occurrence.one', compact('occurrence')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Occurrence  $occurrence
     * @return \Illuminate\Http\Response
     */
    public function edit(Occurrence $occurrence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Occurrence  $occurrence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Occurrence $occurrence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Occurrence  $occurrence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Occurrence $occurrence)
    {
        //
    }
}
