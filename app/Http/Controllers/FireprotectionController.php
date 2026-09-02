<?php

namespace App\Http\Controllers;

use App\Models\Fireprotection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FireprotectionController extends Controller
{
    private function fields(): array
    {
        return [
            ['key' => 'name', 'label' => 'Nome', 'type' => 'text', 'required' => true],
            ['key' => 'desc', 'label' => 'Descrição', 'type' => 'textarea'],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $protections = Fireprotection::query()->orderBy('name')->get();

        return Inertia::render('Lookups/Index', [
            'title' => 'Sistemas de proteção',
            'items' => $protections,
            'fields' => $this->fields(),
            'routes' => [
                'index' => 'index-fireprotection',
                'create' => 'create-fireprotection',
                'store' => 'store-fireprotection',
                'show' => 'show-fireprotection',
                'edit' => 'edit-fireprotection',
                'update' => 'update-fireprotection',
                'destroy' => 'destroy-fireprotection',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Lookups/Form', [
            'title' => 'Adicionar proteção contra incêndio',
            'mode' => 'create',
            'backRoute' => 'index-fireprotection',
            'submitRoute' => 'store-fireprotection',
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Fireprotection::create($request->all());

        return redirect()->route('index-fireprotection');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $protection = Fireprotection::findOrFail($id);

        return Inertia::render('Lookups/Show', [
            'title' => "Sistema de proteção: {$protection->name}",
            'backRoute' => 'index-fireprotection',
            'routes' => ['edit' => 'edit-fireprotection', 'destroy' => 'destroy-fireprotection'],
            'item' => $protection,
            'desc' => $protection->desc,
            'createdAt' => $protection->created_at,
            'updatedAt' => $protection->updated_at,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $protection = Fireprotection::findOrFail($id);

        return Inertia::render('Lookups/Form', [
            'title' => "Alterar sistema de proteção: {$protection->name}",
            'mode' => 'edit',
            'backRoute' => 'show-fireprotection',
            'backRouteParams' => $protection->id,
            'submitRoute' => 'update-fireprotection',
            'submitRouteParams' => $protection->id,
            'item' => $protection,
            'confirmLabel' => $protection->name,
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $protection = Fireprotection::find($id);
        $protection->update($request->all());

        return redirect()->route('index-fireprotection')->with(
            'message',
            'Proteção alterada com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $protection = Fireprotection::find($id);

        if ($protection->occurrences()->exists()) {
            return back()->withErrors(['error' => 'Há ocorrências utilizando esse elemento']);
        }

        $protection->delete();

        return redirect(route('index-fireprotection'))->with(
            'message',
            'Proteção excluída com sucesso'
        );
    }
}
