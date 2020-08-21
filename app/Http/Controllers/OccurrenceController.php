<?php

namespace App\Http\Controllers;

use App\Fireprotection;
use App\Helpers\VictimDestroyer;
use App\Meanused;
use App\Nature;
use App\Occurrence;
use App\Placefreature;
use App\Placeuse;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Ilovepdf\Ilovepdf;

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

        return response(view('occurrence.create', compact('means', 'uses', 'freatures', 'natures', 'protections')), 200);
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
        $occurrence->fireprotections()->attach($request->protectionsForSave);
        $data['occurrence_id'] = $occurrence->id;

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
        return response(view('occurrence.update', compact('occurrence','means', 'uses', 'freatures', 'natures', 'protections')));
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
        $occurrence->fireprotections()->sync($request->protectionsForSave);
        $occurrence->update($data);

        return response(redirect()->route('show-occurrence', $occurrence->id));
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

        foreach($occurrence->victims as $victim) {
            new VictimDestroyer($victim->id);
        }
        foreach($occurrence->resources as $resource) {
            $resource->delete();
        }

        $occurrence->fireprotections()->detach();

        $occurrence->delete();

        return response(redirect(route('index-occurrence')));
    }

    /**
     * Generate PDF for resource
     * @param int $id
     *
     */
    public function toPdf(int $id)
    {
        $occurrence = Occurrence::find($id);

        Storage::put('occurrence.html', view('occurrence.pdf', compact('occurrence')));

        return response()->file(storage_path('app/occurrence.html'))->deleteFileAfterSend();
    }
}
