<?php

namespace App\Http\Controllers;

use App\Models\Meanused;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MeanusedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $means = Meanused::query()->orderBy('name')->get();

        return response(view('meanused.index', compact('means')), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response(view('meanused.create'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Meanused::create($request->all());

        return redirect()->route('index-meanused')->with(
            'message',
            'Meio de chamado criado com sucesso'
        );
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     *
     * public function show(int $id)
     * {
     * $mean = Meanused::find($id);
     * return response(view('meanused.one', compact('mean')));
     * }
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $mean = Meanused::find($id);

        return response(view('meanused.update', compact('mean')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $mean = Meanused::find($id);
        $mean->update($request->all());

        return redirect()->route('index-meanused', $mean->id)->with(
            'message',
            'Meio de chamado alterado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response|RedirectResponse
    {
        $mean = Meanused::find($id);

        if ($mean->occurrences()->exists()) {
            return back()->withErrors(['error' => 'Há ocorrências utilizando esse elemento']);
        }

        $mean->delete();

        return redirect(route('index-meanused'))->with(
            'message',
            'Meio de chamado excluído com sucesso'
        );
    }
}
