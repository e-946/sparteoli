<?php

namespace App\Http\Controllers;

use App\Problem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseBase;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $problems = Problem::query()->orderBy('name')->get();
        return response(view('problem.index', compact('problems')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response(view('problem.create'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        if (empty($request)) {
            return response('Formulário vazio');
        }
        Problem::create($request->all());

        return response(redirect()->route('index-problem'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $problem = Problem::find($id);
        return response(view('problem.one', compact('problem')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $problem = Problem::find($id);
        return response(view('problem.update', compact('problem')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $problem = Problem::find($id);
        $problem->update($request->all());

        return response(redirect()->route('show-problem', $problem->id)->with(
            'message',
            "Problema alterado com sucesso"
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function destroy(int $id): ResponseBase
    {
        $problem = Problem::find($id);

        if ($problem->occurrences()->exists()) {
            return back()->withErrors(['error' => 'Há vítimas utilizando esse elemento']);
        }

        $problem->delete();

        return response(redirect(route('index-problem'))->with(
            'message',
            "Problema excluído com sucesso"
        ));
    }
}
