<?php

namespace App\Http\Controllers;

use App\Rescuer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseBase;

class RescuerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $rescuers = Rescuer::query()->orderBy('name')->get();
        return response(view('rescuer.index', compact('rescuers')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response(view('rescuer.create'), 200);
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
        Rescuer::create($request->all());

        return response(redirect()->route('index-rescuer'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response

    public function show($id)
    {
        $rescuer = Rescuer::find($id);
        return response(view('rescuer.one', compact('rescuer')));
    }
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $rescuer = Rescuer::find($id);
        return response(view('rescuer.update', compact('rescuer')));
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
        $rescuer = Rescuer::find($id);
        $rescuer->update($request->all());

        return response(redirect()->route('index-rescuer', $rescuer->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function destroy( int $id): ResponseBase
    {
        $rescuer = Rescuer::find($id);

        if ($rescuer->victims()->exists()) {
            return back()->withErrors(['error' => 'Há vítimas utilizando esse elemento']);
        }

        $rescuer->delete();

        return response(redirect(route('index-rescuer')));
    }
}
