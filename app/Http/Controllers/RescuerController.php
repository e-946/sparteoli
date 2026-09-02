<?php

namespace App\Http\Controllers;

use App\Models\Rescuer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RescuerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $rescuers = Rescuer::query()->orderBy('name')->get();

        return response(view('rescuer.index', compact('rescuers')), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response(view('rescuer.create'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Rescuer::create($request->all());

        return redirect()->route('index-rescuer')->with(
            'message',
            'Socorrista criado com sucesso'
        );
    }

    /**
     * Display the specified resource.
     *
    public function show($id)
    {
        $rescuer = Rescuer::find($id);
        return response(view('rescuer.one', compact('rescuer')));
    }
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $rescuer = Rescuer::find($id);

        return response(view('rescuer.update', compact('rescuer')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $rescuer = Rescuer::find($id);
        $rescuer->update($request->all());

        return redirect()->route('index-rescuer', $rescuer->id)->with(
            'message',
            'Socorrista alterado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response|RedirectResponse
    {
        $rescuer = Rescuer::find($id);

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
