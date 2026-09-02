<?php

namespace App\Http\Controllers;

use App\Models\Meanused;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MeanusedController extends Controller
{
    private function fields(): array
    {
        return [
            ['key' => 'name', 'label' => 'Nome', 'type' => 'text', 'required' => true],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $means = Meanused::query()->orderBy('name')->get();

        return Inertia::render('Lookups/Index', [
            'title' => 'Meios de chamado',
            'items' => $means,
            'fields' => $this->fields(),
            'routes' => [
                'index' => 'index-meanused',
                'create' => 'create-meanused',
                'store' => 'store-meanused',
                'edit' => 'edit-meanused',
                'update' => 'update-meanused',
                'destroy' => 'destroy-meanused',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Lookups/Form', [
            'title' => 'Adicionar meio de chamado',
            'mode' => 'create',
            'backRoute' => 'index-meanused',
            'submitRoute' => 'store-meanused',
            'fields' => $this->fields(),
        ]);
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
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $mean = Meanused::findOrFail($id);

        return Inertia::render('Lookups/Form', [
            'title' => 'Alterar meio de chamado',
            'mode' => 'edit',
            'backRoute' => 'index-meanused',
            'submitRoute' => 'update-meanused',
            'submitRouteParams' => $mean->id,
            'item' => $mean,
            'confirmLabel' => $mean->name,
            'fields' => $this->fields(),
        ]);
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
    public function destroy(int $id): RedirectResponse
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
