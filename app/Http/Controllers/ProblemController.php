<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $problems = Problem::query()->orderBy('name')->get();

        return response(view('problem.index', compact('problems')), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response(view('problem.create'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Problem::create($request->all());

        return redirect()->route('index-problem');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $problem = Problem::find($id);

        return response(view('problem.one', compact('problem')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $problem = Problem::find($id);

        return response(view('problem.update', compact('problem')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $problem = Problem::find($id);
        $problem->update($request->all());

        return redirect()->route('show-problem', $problem->id)->with(
            'message',
            'Problema alterado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response|RedirectResponse
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
