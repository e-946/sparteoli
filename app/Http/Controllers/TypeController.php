<?php

namespace App\Http\Controllers;

use App\Nature;
use App\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseBase;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $types = Type::query()->orderBy('nature_id')->get();
        return response(view('type.index', compact('types')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $natures = Nature::all();
        return response(view('type.create', compact('natures')), 200);
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
        Type::create($request->all());

        return response(redirect()->route('index-type'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $type = Type::find($id);

        return response(view('type.one', compact('type')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $type = Type::find($id);
        $natures = Nature::all();
        return response(view('type.update', compact('type', 'natures')));
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
        $type = Type::find($id);
        $type->update($request->all());

        return response(redirect()->route('show-type', $type->id)->with('message',
            "Tipo alterado com sucesso"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function destroy(int $id): ResponseBase
    {
        $type = Type::find($id);

        if ($type->occurrences()->exists()) {
            return back()->withErrors(['error' => 'Há ocorrências utilizando esse elemento']);
        }

        $type->delete();

        return response(redirect(route('index-type'))->with('message',
            "Tipo excluído com sucesso"));
    }
}
