<?php

namespace App\Http\Controllers;

use App\Meanused;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseBase;

class MeanusedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $means = Meanused::query()->orderBy('name')->get();
        return response(view('meanused.index', compact('means')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response(view('meanused.create'), 200);
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
        Meanused::create($request->all());

        return response(redirect()->route('index-meanused'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     *
     * public function show(int $id)
    * {
        * $mean = Meanused::find($id);
        * return response(view('meanused.one', compact('mean')));
    * }
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $mean = Meanused::find($id);
        return response(view('meanused.update', compact('mean')));
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
        $mean = Meanused::find($id);
        $mean->update($request->all());

        return response(redirect()->route('index-meanused', $mean->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function destroy(int $id): ResponseBase
    {
        $mean = Meanused::find($id);

        if ($mean->occurrences()->exists()) {
            return back()->withErrors(['error' => 'Há ocorrências utilizando esse elemento']);
        }

        $mean->delete();

        return response(redirect(route('index-meanused')));
    }
}
