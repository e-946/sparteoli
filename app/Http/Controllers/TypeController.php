<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $types = Type::query()->orderBy('nature_id')->get();

        return response(view('type.index', compact('types')), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $natures = Nature::all();

        return response(view('type.create', compact('natures')), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Type::create($request->all());

        return redirect()->route('index-type');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $type = Type::find($id);

        return response(view('type.one', compact('type')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $type = Type::find($id);
        $natures = Nature::all();

        return response(view('type.update', compact('type', 'natures')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $type = Type::find($id);
        $type->update($request->all());

        return redirect()->route('show-type', $type->id)->with(
            'message',
            'Tipo alterado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response|RedirectResponse
    {
        $type = Type::find($id);

        if ($type->occurrences()->exists()) {
            return back()->withErrors(['error' => 'Há ocorrências utilizando esse elemento']);
        }

        $type->delete();

        return redirect(route('index-type'))->with(
            'message',
            'Tipo excluído com sucesso'
        );
    }
}
