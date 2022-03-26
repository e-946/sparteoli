<?php

namespace App\Http\Controllers;

use App\Models\Fireprotection;
use App\Helpers\VictimDestroyer;
use App\Models\Meanused;
use App\Models\Nature;
use App\Models\Occurrence;
use App\Models\Placefreature;
use App\Models\Placeuse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class OccurrenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $occurrences = Occurrence::query()->orderBy('created_at', 'DESC')->paginate(10);
        return response(view('occurrence.index', compact('occurrences')), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $means = Meanused::all();
        $uses = Placeuse::all();
        $freatures = Placefreature::all();
        $natures = Nature::all();
        $protections = Fireprotection::all();

        $fillers = Occurrence::select(['filler_register', 'filler_name', 'filler_patent', 'created_at'])->distinct()->orderBy('created_at', 'desc')->get();

        return response(
            view(
                'occurrence.create',
                compact('means', 'uses', 'freatures', 'natures', 'protections', 'fillers')
            ),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $data = $request->except('protectionsForSave');
        $data['address'] = $data['street'] . ', Nº ' . $data['number'];
        unset($data['street'], $data['number']);
        $occurrence = Occurrence::create($data);
        if (isset($request->protectionsForSave)) {
            $occurrence->fireprotections()->attach($request->protectionsForSave);
        }

        return response(redirect()->route('show-occurrence', $occurrence->id));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $occurrence = Occurrence::find($id);

        return response(view('occurrence.one', compact('occurrence')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $means = Meanused::all();
        $uses = Placeuse::all();
        $freatures = Placefreature::all();
        $natures = Nature::all();
        $protections = Fireprotection::all();
        $occurrence = Occurrence::find($id);

        $fillers = Occurrence::select(['filler_register', 'filler_name', 'filler_patent', 'created_at'])->distinct()->orderBy('created_at', 'desc')->get();

        return response(view(
            'occurrence.update',
            compact('occurrence', 'means', 'uses', 'freatures', 'natures', 'protections', 'fillers')
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $occurrence = Occurrence::find($id);
        $data = $request->except('protectionsForSave');
        $data['address'] = $data['street'] . ', Nº ' . $data['number'];
        unset($data['street'], $data['number']);
        if (isset($request->protectionsForSave)) {
            $occurrence->fireprotections()->sync($request->protectionsForSave);
        }
        $occurrence->update($data);


        return response(redirect()->route('show-occurrence', $occurrence->id)->with(
            'message',
            "Ocorrência alterada com sucesso"
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        $occurrence = Occurrence::find($id);

        foreach ($occurrence->victims as $victim) {
            new VictimDestroyer($victim->id);
        }
        foreach ($occurrence->resources as $resource) {
            $resource->delete();
        }

        $occurrence->fireprotections()->detach();

        $occurrence->delete();

        return response(redirect(route('index-occurrence'))->with(
            'message',
            "Ocorrência excluída com sucesso"
        ));
    }

    /**
     * Generate PDF for resource
     * @param int $id
     *
     * @return BinaryFileResponse
     */
    public function toPdf(int $id)
    {
        $occurrence = Occurrence::find($id);

        Storage::put('occurrence.html', view('occurrence.pdf', compact('occurrence')));

        return response()->file(storage_path('app/occurrence.html'))->deleteFileAfterSend();
    }
}
