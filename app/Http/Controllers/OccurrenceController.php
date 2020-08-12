<?php

namespace App\Http\Controllers;

use App\Helpers\VictimDestroyer;
use App\Meanused;
use App\Nature;
use App\Occurrence;
use App\Placefreature;
use App\Placeuse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OccurrenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $occurrences = Occurrence::query()->orderBy('created_at', 'DESC')->limit(10)->get();
        return response(view('occurrence.index', compact('occurrences')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
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
     * @param Request $request
     * @return Response
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
     * @return Response
     */
    public function show(int $id)
    {
        $occurrence = Occurrence::find($id);
        return response(view('occurrence.one', compact('occurrence')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        $means = Meanused::all();
        $uses = Placeuse::all();
        $freatures = Placefreature::all();
        $natures = Nature::all();
        $occurrence = Occurrence::find($id);
        return response(view('occurrence.update', compact('occurrence','means', 'uses', 'freatures', 'natures')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $occurrence = Occurrence::find($id);
        $data = $request->all();
        $data['address'] = $data['street'] . ', Nº ' . $data['number'];
        unset($data['street'], $data['number']);
        $occurrence->update($data);

        return response(redirect()->route('show-occurrence', $occurrence->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $occurrence = Occurrence::find($id);

        foreach($occurrence->victims as $victim) {
            new VictimDestroyer($victim->id);
        }

        $occurrence->delete();

        return response(redirect(route('index-occurrence')));
    }
}
