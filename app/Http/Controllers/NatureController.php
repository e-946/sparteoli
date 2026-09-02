<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NatureController extends Controller
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
        $natures = Nature::query()->orderBy('name')->get();

        return Inertia::render('Lookups/Index', [
            'title' => 'Naturezas de ocorrência',
            'items' => $natures,
            'fields' => $this->fields(),
            'routes' => [
                'index' => 'index-nature',
                'create' => 'create-nature',
                'store' => 'store-nature',
                'show' => 'show-nature',
                'edit' => 'edit-nature',
                'update' => 'update-nature',
                'destroy' => 'destroy-nature',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Lookups/Form', [
            'title' => 'Criar natureza de operação',
            'mode' => 'create',
            'backRoute' => 'index-nature',
            'submitRoute' => 'store-nature',
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Nature::create($request->validate($this->rules()));

        return redirect()->route('index-nature');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $nature = Nature::withCount(['types', 'occurrences'])->findOrFail($id);

        return Inertia::render('Lookups/Show', [
            'title' => "Natureza de operação {$nature->name}",
            'backRoute' => 'index-nature',
            'routes' => ['edit' => 'edit-nature', 'destroy' => 'destroy-nature'],
            'item' => $nature,
            'desc' => $nature->desc,
            'stats' => [
                ['label' => 'Tipos de ocorrência com essa natureza', 'value' => $nature->types_count],
                ['label' => 'Ocorrências com essa natureza', 'value' => $nature->occurrences_count],
            ],
            'related' => [
                'label' => 'Tipos de ocorrência',
                'items' => $nature->types()->get(['id', 'name'])->map(fn ($type) => [
                    'id' => $type->id,
                    'name' => $type->name,
                    'route' => 'show-type',
                ]),
            ],
            'createdAt' => $nature->created_at,
            'updatedAt' => $nature->updated_at,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $nature = Nature::findOrFail($id);

        return Inertia::render('Lookups/Form', [
            'title' => 'Alterar natureza de operação',
            'mode' => 'edit',
            'backRoute' => 'show-nature',
            'backRouteParams' => $nature->id,
            'submitRoute' => 'update-nature',
            'submitRouteParams' => $nature->id,
            'item' => $nature,
            'confirmLabel' => $nature->name,
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $nature = Nature::findOrFail($id);
        $nature->update($request->validate($this->rules()));

        return redirect()->route('index-nature')->with(
            'message',
            'Natureza alterada com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $nature = Nature::findOrFail($id);

        if ($nature->types()->exists()) {
            return back()->withErrors(['error' => 'Há tipos utilizando esse elemento']);
        }

        $nature->delete();

        return redirect(route('index-nature'))->with(
            'message',
            'Natureza excluída com sucesso'
        );
    }
}
