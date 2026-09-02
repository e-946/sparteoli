<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ResourceController extends Controller
{
    private function rules(): array
    {
        return [
            'who' => ['required', 'string', 'max:255'],
            'where' => ['required', 'string', 'max:255'],
            'how' => ['required', 'string', 'max:255'],
            'what' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $occurrence_id): Response
    {
        $resources = Resource::query()
            ->where('occurrence_id', '=', $occurrence_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Resources/Index', [
            'resources' => $resources,
            'occurrence_id' => $occurrence_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $occurrence_id): Response
    {
        return Inertia::render('Resources/Form', [
            'mode' => 'create',
            'occurrence_id' => $occurrence_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $occurrence_id): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        Resource::create([
            ...$validated,
            'occurrence_id' => $occurrence_id,
        ]);

        return redirect()->route('index-resource', $occurrence_id)->with(
            'message',
            'Recurso criado com sucesso'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $occurrence_id, int $id): Response
    {
        $resource = Resource::findOrFail($id);

        return Inertia::render('Resources/Show', [
            'resource' => $resource,
            'occurrence_id' => $occurrence_id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $occurrence_id, int $id): Response
    {
        $resource = Resource::findOrFail($id);

        return Inertia::render('Resources/Form', [
            'mode' => 'edit',
            'occurrence_id' => $occurrence_id,
            'resource' => $resource,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $occurrence_id, int $id): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $resource = Resource::find($id);
        $resource->update([
            ...$validated,
            'occurrence_id' => $occurrence_id,
        ]);

        return redirect()
            ->route('show-resource', ['occurrence_id' => $occurrence_id, 'id' => $resource->id])
            ->with(
                'message',
                'Recurso alterado com sucesso'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $occurrence_id, int $id): RedirectResponse
    {
        $resource = Resource::find($id);
        $resource->delete();

        return redirect(route('index-resource', $occurrence_id))->with(
            'message',
            'Recurso excluído com sucesso'
        );
    }
}
