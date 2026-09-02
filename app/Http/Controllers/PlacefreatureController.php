<?php

namespace App\Http\Controllers;

use App\Models\Placefreature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlacefreatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $freatures = Placefreature::query()->orderBy('name')->get();

        return response(view('placefreature.index', compact('freatures')), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response(view('placefreature.create'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Placefreature::create($request->all());

        return redirect()->route('index-placefreature')->with(
            'message',
            'Característica de local criada com sucesso'
        );
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     *
     * public function show($id)
     * {
     * $freature = Placefreature::find($id);
     * return response(view('placefreature.one', compact('freature')));
     * }
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $freature = Placefreature::find($id);

        return response(view('placefreature.update', compact('freature')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $freature = Placefreature::find($id);
        $freature->update($request->all());

        return redirect()->route('index-placefreature', $freature->id)->with(
            'message',
            'Característica de local alterada com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response|RedirectResponse
    {
        $freature = Placefreature::find($id);

        if ($freature->occurrences()->exists()) {
            return back()->withErrors(['error' => 'Há ocorrências utilizando esse elemento']);
        }

        $freature->delete();

        return redirect(route('index-placefreature'))->with(
            'message',
            'Característica de local excluída com sucesso'
        );
    }
}
