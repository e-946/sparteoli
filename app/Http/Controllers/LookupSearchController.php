<?php

namespace App\Http\Controllers;

use App\Models\Fireprotection;
use App\Models\Meanused;
use App\Models\Nature;
use App\Models\Placefreature;
use App\Models\Placeuse;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Generic search + quick-create JSON endpoints backing the searchable
 * comboboxes used to pick "pre-defined" lookup values inline from other
 * forms (e.g. the occurrence form), without a full page navigation.
 */
class LookupSearchController extends Controller
{
    private const MODELS = [
        'nature' => Nature::class,
        'meanused' => Meanused::class,
        'placefreature' => Placefreature::class,
        'placeuse' => Placeuse::class,
        'fireprotection' => Fireprotection::class,
        'type' => Type::class,
    ];

    public function search(Request $request, string $resource): JsonResponse
    {
        $model = $this->resolveModel($resource);

        $query = $model::query()->orderBy('name')->limit(20);

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->string('q') . '%');
        }

        if ($resource === 'type') {
            $query->with('nature:id,name');

            return response()->json(
                $query->get(['id', 'name', 'nature_id'])->map(fn (Type $type) => [
                    'id' => $type->id,
                    'name' => $type->name,
                    'nature_name' => $type->nature->name,
                ])
            );
        }

        return response()->json($query->get(['id', 'name']));
    }

    public function store(Request $request, string $resource): JsonResponse
    {
        $modelClass = $this->resolveModel($resource);

        $data = $request->validate($this->rulesFor($resource));

        $record = $modelClass::create($data);

        return response()->json([
            'id' => $record->id,
            'name' => $record->name,
            'nature_name' => $resource === 'type' ? $record->nature->name : null,
        ]);
    }

    private function resolveModel(string $resource): string
    {
        if (! array_key_exists($resource, self::MODELS)) {
            throw new NotFoundHttpException();
        }

        return self::MODELS[$resource];
    }

    private function rulesFor(string $resource): array
    {
        return match ($resource) {
            'nature', 'meanused', 'placefreature', 'placeuse' => [
                'name' => ['required', 'string', 'max:255'],
            ],
            'fireprotection' => [
                'name' => ['required', 'string', 'max:255'],
                'desc' => ['nullable', 'string'],
            ],
            'type' => [
                'name' => ['required', 'string', 'max:255'],
                'desc' => ['nullable', 'string'],
                'nature_id' => ['required', Rule::exists('natures', 'id')],
            ],
            default => throw new NotFoundHttpException(),
        };
    }
}
