<?php

namespace App\Http\Controllers;

use App\Placefreature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlacefreatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $freatures = Placefreature::query()->orderBy('name')->get();
        return response(view('placefreature.index', compact('freatures')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response(view('placefreature.create'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
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
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $freature = Placefreature::find($id);
        return response(view('placefreature.update', compact('freature')));
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
        $freature = Placefreature::find($id);
        $freature->update($request->all());

        return response(redirect()->route('index-placefreature', $freature->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function destroy(int $id): Response
    {
        $freature = Placefreature::find($id);

        if ($freature->occurrences()->exists()) {
            return back()->withErrors(['error' => 'Há ocorrências utilizando esse elemento']);
        }

        $freature->delete();

        return response(redirect(route('index-placefreature')));
    }
}
