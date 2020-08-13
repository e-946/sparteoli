<?php

namespace App\Http\Controllers;

use App\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $occurrence_id
     * @return Response
     */
    public function index(int $occurrence_id)
    {
        $resources = Resource::query()->orderBy('created_at', 'DESC')->get();
        return response(view('resource.index', compact('resources', 'occurrence_id')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $occurrence_id
     * @return Response
     */
    public function create(int $occurrence_id)
    {
        return response(view('resource.create', compact('occurrence_id')), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param int $occurrence_id
     * @return Response
     */
    public function store(Request $request, int $occurrence_id)
    {
        if (empty($request)) {
            return response('Formulário vazio');
        }
        Resource::create([
            'who' => $request->who,
            'where' => $request->where,
            'how' => $request->how,
            'what' => $request->what,
            'occurrence_id' => $occurrence_id,
        ]);

        return response(redirect()->route('index-resource', $occurrence_id));
    }

    /**
     * Display the specified resource.
     *
     * @param int $occurrence_id
     * @param int $id
     * @return Response
     */
    public function show(int $occurrence_id, int $id)
    {
        $resource = Resource::find($id);
        return response(view('resource.one', compact('resource', 'occurrence_id')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $occurrence_id
     * @param int $id
     * @return Response
     */
    public function edit(int $occurrence_id, int $id)
    {
        $resource = Resource::find($id);
        return response(view('resource.update', compact('resource', 'occurrence_id')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $occurrence_id
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $occurrence_id, int $id)
    {
        $resource = Resource::find($id);
        $resource->update([
            'who' => $request->who,
            'where' => $request->where,
            'how' => $request->how,
            'what' => $request->what,
            'occurrence_id' => $occurrence_id,
        ]);

        return response(redirect()->route('show-resource', ['occurrence_id' => $occurrence_id, 'id' => $resource->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $occurrence_id
     * @param int $id
     * @return Response
     */
    public function destroy(int $occurrence_id, int $id)
    {
        $resource = Resource::find($id);
        $resource->delete();

        return response(redirect(route('index-resource', $occurrence_id)));
    }
}
