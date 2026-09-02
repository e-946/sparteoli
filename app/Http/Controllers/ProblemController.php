<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProblemController extends Controller
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
        $problems = Problem::query()->orderBy('name')->get();

        return Inertia::render('Lookups/Index', [
            'title' => 'Tipos de problemas',
            'items' => $problems,
            'fields' => $this->fields(),
            'routes' => [
                'index' => 'index-problem',
                'create' => 'create-problem',
                'store' => 'store-problem',
                'show' => 'show-problem',
                'edit' => 'edit-problem',
                'update' => 'update-problem',
                'destroy' => 'destroy-problem',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Lookups/Form', [
            'title' => 'Adicionar tipo de problema',
            'mode' => 'create',
            'backRoute' => 'index-problem',
            'submitRoute' => 'store-problem',
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Problem::create($request->validate($this->rules()));

        return redirect()->route('index-problem');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $problem = Problem::findOrFail($id);

        return Inertia::render('Lookups/Show', [
            'title' => "Tipo de problema {$problem->name}",
            'backRoute' => 'index-problem',
            'routes' => ['edit' => 'edit-problem', 'destroy' => 'destroy-problem'],
            'item' => $problem,
            'desc' => $problem->desc,
            'createdAt' => $problem->created_at,
            'updatedAt' => $problem->updated_at,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $problem = Problem::findOrFail($id);

        return Inertia::render('Lookups/Form', [
            'title' => 'Alterar tipo de problema',
            'mode' => 'edit',
            'backRoute' => 'show-problem',
            'backRouteParams' => $problem->id,
            'submitRoute' => 'update-problem',
            'submitRouteParams' => $problem->id,
            'item' => $problem,
            'confirmLabel' => $problem->name,
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $problem = Problem::find($id);
        $problem->update($request->validate($this->rules()));

        return redirect()->route('index-problem')->with(
            'message',
            'Problema alterado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $problem = Problem::find($id);

        if ($problem->victims()->exists()) {
            return back()->withErrors(['error' => 'Há vítimas utilizando esse elemento']);
        }

        $problem->delete();

        return redirect(route('index-problem'))->with(
            'message',
            'Problema excluído com sucesso'
        );
    }
}
