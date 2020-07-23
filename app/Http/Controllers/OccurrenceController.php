<?php

namespace App\Http\Controllers;

use App\Occurrence;
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
        $occurrences = Occurrence::query()->orderBy('name')->get();
        return response(view('occurrence.index', compact('occurrences')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('occurrence.create'), 200);
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
        Occurrence::create($request->all());

        return response(redirect()->route('index-occurrence'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $occurrence = Occurrence::find($id);
        return response(view('occurrence.one', compact('occurrence')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $occurrence = Occurrence::find($id);
        return response(view('occurrence.update', compact('occurrence')));
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
        $occurrence = Occurrence::find($id);
        $occurrence->update($request->all());

        return response(redirect()->route('show-occurrence', $occurrence->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $occurrence = Occurrence::find($id);
        $occurrence->delete();

        return response(redirect(route('index-occurrence')));
    }
}
