<?php

namespace App\Http\Controllers;

use App\Models\Placefreature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlacefreatureController extends Controller
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
        $freatures = Placefreature::query()->orderBy('name')->get();

        return Inertia::render('Lookups/Index', [
            'title' => 'Características do local',
            'items' => $freatures,
            'fields' => $this->fields(),
            'routes' => [
                'index' => 'index-placefreature',
                'create' => 'create-placefreature',
                'store' => 'store-placefreature',
                'edit' => 'edit-placefreature',
                'update' => 'update-placefreature',
                'destroy' => 'destroy-placefreature',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Lookups/Form', [
            'title' => 'Adicionar característica de local',
            'mode' => 'create',
            'backRoute' => 'index-placefreature',
            'submitRoute' => 'store-placefreature',
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Placefreature::create($request->validate($this->rules()));

        return redirect()->route('index-placefreature')->with(
            'message',
            'Característica de local criada com sucesso'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $freature = Placefreature::findOrFail($id);

        return Inertia::render('Lookups/Form', [
            'title' => 'Alterar característica do local',
            'mode' => 'edit',
            'backRoute' => 'index-placefreature',
            'submitRoute' => 'update-placefreature',
            'submitRouteParams' => $freature->id,
            'item' => $freature,
            'confirmLabel' => $freature->name,
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $freature = Placefreature::findOrFail($id);
        $freature->update($request->validate($this->rules()));

        return redirect()->route('index-placefreature', $freature->id)->with(
            'message',
            'Característica de local alterada com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $freature = Placefreature::findOrFail($id);

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
