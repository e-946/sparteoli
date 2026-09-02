<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class TypeController extends Controller
{
    private function natureOptions(): Collection
    {
        return Nature::all()->map(fn (Nature $nature) => ['value' => $nature->id, 'label' => $nature->name]);
    }

    private function fields(): array
    {
        return [
            ['key' => 'name', 'label' => 'Nome', 'type' => 'text', 'required' => true],
            [
                'key' => 'nature_id',
                'label' => 'Natureza',
                'type' => 'select',
                'options' => $this->natureOptions(),
                'required' => true,
            ],
            ['key' => 'desc', 'label' => 'Descrição do tipo de ocorrência', 'type' => 'textarea'],
        ];
    }

    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'nature_id' => ['required', 'exists:natures,id'],
            'desc' => ['nullable', 'string'],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $types = Type::query()->with('nature')->orderBy('nature_id')->get();

        return Inertia::render('Lookups/Index', [
            'title' => 'Tipos de ocorrência',
            'items' => $types->map(fn (Type $type) => [
                'id' => $type->id,
                'name' => $type->name,
                'subtitle' => 'Natureza: ' . $type->nature->name,
                'nature_id' => $type->nature_id,
                'desc' => $type->desc,
            ]),
            'fields' => $this->fields(),
            'routes' => [
                'index' => 'index-type',
                'create' => 'create-type',
                'store' => 'store-type',
                'show' => 'show-type',
                'edit' => 'edit-type',
                'update' => 'update-type',
                'destroy' => 'destroy-type',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Lookups/Form', [
            'title' => 'Criar tipo de operação',
            'mode' => 'create',
            'backRoute' => 'index-type',
            'submitRoute' => 'store-type',
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Type::create($request->validate($this->rules()));

        return redirect()->route('index-type');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $type = Type::with('nature')->findOrFail($id);

        return Inertia::render('Lookups/Show', [
            'title' => "Tipo de operação {$type->name}",
            'backRoute' => 'index-type',
            'routes' => ['edit' => 'edit-type', 'destroy' => 'destroy-type'],
            'item' => $type,
            'desc' => $type->desc,
            'related' => [
                'label' => 'Natureza',
                'items' => [[
                    'id' => $type->nature->id,
                    'name' => $type->nature->name,
                    'route' => 'show-nature',
                ]],
            ],
            'createdAt' => $type->created_at,
            'updatedAt' => $type->updated_at,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $type = Type::findOrFail($id);

        return Inertia::render('Lookups/Form', [
            'title' => 'Alterar tipo de operação',
            'mode' => 'edit',
            'backRoute' => 'show-type',
            'backRouteParams' => $type->id,
            'submitRoute' => 'update-type',
            'submitRouteParams' => $type->id,
            'item' => $type,
            'confirmLabel' => $type->name,
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $type = Type::findOrFail($id);
        $type->update($request->validate($this->rules()));

        return redirect()->route('index-type')->with(
            'message',
            'Tipo alterado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $type = Type::findOrFail($id);

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
