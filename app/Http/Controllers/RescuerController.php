<?php

namespace App\Http\Controllers;

use App\Models\Rescuer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RescuerController extends Controller
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
        $rescuers = Rescuer::query()->orderBy('name')->get();

        return Inertia::render('Lookups/Index', [
            'title' => 'Tipos de socorristas',
            'items' => $rescuers,
            'fields' => $this->fields(),
            'routes' => [
                'index' => 'index-rescuer',
                'create' => 'create-rescuer',
                'store' => 'store-rescuer',
                'edit' => 'edit-rescuer',
                'update' => 'update-rescuer',
                'destroy' => 'destroy-rescuer',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Lookups/Form', [
            'title' => 'Adicionar tipo de socorrista',
            'mode' => 'create',
            'backRoute' => 'index-rescuer',
            'submitRoute' => 'store-rescuer',
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Rescuer::create($request->validate($this->rules()));

        return redirect()->route('index-rescuer')->with(
            'message',
            'Socorrista criado com sucesso'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $rescuer = Rescuer::findOrFail($id);

        return Inertia::render('Lookups/Form', [
            'title' => 'Alterar tipo de socorrista',
            'mode' => 'edit',
            'backRoute' => 'index-rescuer',
            'submitRoute' => 'update-rescuer',
            'submitRouteParams' => $rescuer->id,
            'item' => $rescuer,
            'confirmLabel' => $rescuer->name,
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $rescuer = Rescuer::findOrFail($id);
        $rescuer->update($request->validate($this->rules()));

        return redirect()->route('index-rescuer', $rescuer->id)->with(
            'message',
            'Socorrista alterado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $rescuer = Rescuer::findOrFail($id);

        if ($rescuer->victims()->exists()) {
            return back()->withErrors(['error' => 'Há vítimas utilizando esse elemento']);
        }

        $rescuer->delete();

        return redirect(route('index-rescuer'))->with(
            'message',
            'Socorrista excluído com sucesso'
        );
    }
}
