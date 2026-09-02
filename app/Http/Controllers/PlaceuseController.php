<?php

namespace App\Http\Controllers;

use App\Models\Placeuse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlaceuseController extends Controller
{
    private function fields(): array
    {
        return [
            ['key' => 'name', 'label' => 'Nome', 'type' => 'text', 'required' => true],
        ];
    }

    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $uses = Placeuse::query()->orderBy('name')->get();

        return Inertia::render('Lookups/Index', [
            'title' => 'Utilização do local',
            'items' => $uses,
            'fields' => $this->fields(),
            'routes' => [
                'index' => 'index-placeuse',
                'create' => 'create-placeuse',
                'store' => 'store-placeuse',
                'edit' => 'edit-placeuse',
                'update' => 'update-placeuse',
                'destroy' => 'destroy-placeuse',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Lookups/Form', [
            'title' => 'Adicionar uso ao local',
            'mode' => 'create',
            'backRoute' => 'index-placeuse',
            'submitRoute' => 'store-placeuse',
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Placeuse::create($request->validate($this->rules()));

        return redirect()->route('index-placeuse')->with(
            'message',
            'Uso do local criado com sucesso'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $use = Placeuse::findOrFail($id);

        return Inertia::render('Lookups/Form', [
            'title' => 'Alterar uso do local',
            'mode' => 'edit',
            'backRoute' => 'index-placeuse',
            'submitRoute' => 'update-placeuse',
            'submitRouteParams' => $use->id,
            'item' => $use,
            'confirmLabel' => $use->name,
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $use = Placeuse::find($id);
        $use->update($request->validate($this->rules()));

        return redirect()->route('index-placeuse', $use->id)->with(
            'message',
            'Uso do local alterado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
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
