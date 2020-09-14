<?php

namespace App\Http\Controllers;

use App\Nature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseBase;

class NatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $natures = Nature::query()->orderBy('name')->get();
        return response(view('nature.index', compact('natures')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response(view('nature.create'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (empty($request)) {
            return response('Formulário vazio');
        }

        Nature::create($request->all());

        return response(redirect()->route('index-nature'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id)
    {
        $nature = Nature::find($id);
        return response(view('nature.one', compact('nature')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id)
    {
        $nature = Nature::find($id);
        return response(view('nature.update', compact('nature')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $nature = Nature::find($id);
        $nature->update($request->all());

        return response(redirect()->route('show-nature', $nature->id)->with('message',
            "Natureza alterada com sucesso"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function destroy(int $id): ResponseBase
    {
        $nature = Nature::find($id);

        if ($nature->types()->exists()) {
            return back()->withErrors(['error' => 'Há tipos utilizando esse elemento']);
        }

        $nature->delete();

        return response(redirect(route('index-nature'))->with('message',
            "Natureza excluída com sucesso"));
    }
}
