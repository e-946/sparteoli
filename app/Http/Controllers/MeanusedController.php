<?php

namespace App\Http\Controllers;

use App\Meanused;
use Illuminate\Http\Request;

class MeanusedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $means = Meanused::query()->orderBy('name')->get();
        return response(view('meanused.index', compact('means')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('meanused.create'), 200);
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
        Meanused::create($request->all());

        return response(redirect()->route('index-meanused'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mean = Meanused::find($id);
        return response(view('meanused.one', compact('mean')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mean = Meanused::find($id);
        return response(view('meanused.update', compact('mean')));
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
        $mean = Meanused::find($id);
        $mean->update($request->all());

        return response(redirect()->route('show-meanused', $mean->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mean = Meanused::find($id);
        $mean->delete();

        return response(redirect(route('index-meanused')));
    }
}
