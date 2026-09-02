<?php

namespace App\Http\Controllers;

use App\Models\Placeuse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlaceuseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $uses = Placeuse::query()->orderBy('name')->get();

        return response(view('placeuse.index', compact('uses')), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response(view('placeuse.create'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Placeuse::create($request->all());

        return redirect()->route('index-placeuse')->with(
            'message',
            'Uso do local criado com sucesso'
        );
    }

    /**
     * Display the specified resource.
     *
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
     */
    public function edit(int $id): Response
    {
        $use = Placeuse::find($id);

        return response(view('placeuse.update', compact('use')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $use = Placeuse::find($id);
        $use->update($request->all());

        return redirect()->route('index-placeuse', $use->id)->with(
            'message',
            'Uso do local alterado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response|RedirectResponse
    {
        $use = Placeuse::find($id);

        if ($use->occurrences()->exists()) {
            return back()->withErrors(['error' => 'Há ocorrências utilizando esse elemento']);
        }

        $use->delete();

        return redirect(route('index-placeuse'))->with(
            'message',
            'Uso do local excluído com sucesso'
        );
    }
}
