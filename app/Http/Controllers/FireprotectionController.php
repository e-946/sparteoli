<?php

namespace App\Http\Controllers;

use App\Fireprotection;
use Illuminate\Http\Request;

class FireprotectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $protections = Fireprotection::query()->orderBy('name')->get();
        return response(view('fireprotection.index', compact('protections')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('fireprotection.create'), 200);
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
        Fireprotection::create($request->all());

        return response(redirect()->route('index-fireprotection'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $protection = Fireprotection::find($id);
        return response(view('fireprotection.one', compact('protection')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $protection = Fireprotection::find($id);
        return response(view('fireprotection.update', compact('protection')));
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
        $protection = Fireprotection::find($id);
        $protection->update($request->all());

        return response(redirect()->route('show-fireprotection', $protection->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $protection = Fireprotection::find($id);
        $protection->delete();

        return response(redirect(route('index-fireprotection')));
    }
}
