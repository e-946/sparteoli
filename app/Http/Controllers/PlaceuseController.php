<?php

namespace App\Http\Controllers;

use App\Placeuse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlaceuseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $uses = Placeuse::query()->orderBy('name')->get();
        return response(view('placeuse.index', compact('uses')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response(view('placeuse.create'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
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
     * @return Response
     *
     * public function show($id)
    * {
        * $use = Placeuse::find($id);
        * return response(view('placeuse.one', compact('use')));
    * }
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $use = Placeuse::find($id);
        return response(view("placeuse.update", compact('use')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $use = Placeuse::find($id);
        $use->update($request->all());

        return response(redirect()->route('index-placeuse', $use->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function destroy(int $id): Response
    {
        $use = Placeuse::find($id);

        if ($use->occurrences()->exists()) {
            return back()->withErrors(['error' => 'Há ocorrências utilizando esse elemento']);
        }

        $use->delete();

        return response(redirect(route('index-placeuse')));
    }
}
