<?php

namespace App\Http\Controllers;

use App\Fireprotection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FireprotectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $protections = Fireprotection::query()->orderBy('name')->get();
        return response(view('fireprotection.index', compact('protections')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response(view('fireprotection.create'), 200);
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
        Fireprotection::create($request->all());

        return response(redirect()->route('index-fireprotection'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $protection = Fireprotection::find($id);
        return response(view('fireprotection.one', compact('protection')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $protection = Fireprotection::find($id);
        return response(view('fireprotection.update', compact('protection')));
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
        $protection = Fireprotection::find($id);
        $protection->update($request->all());

        return response(redirect()->route('show-fireprotection', $protection->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function destroy(int $id): Response
    {
        $protection = Fireprotection::find($id);

        if ($protection->occurrences()->exists()) {
            return back()->withErrors(['error' => 'Há ocorrências utilizando esse elemento']);
        }

        $protection->delete();

        return response(redirect(route('index-fireprotection')));
    }
}
