<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index(): Response
    {
        $natures = Nature::withCount('occurrences')->get();
        $types = Type::withCount('occurrences')->get();

        $today = Carbon::today();
        $today->subMonths(15);

        $dates = DB::table('occurrences')
            ->select('date')
            ->whereYear('date', '>=', $today->format('Y-m-d'))
            ->orderBy('date')
            ->get();

        foreach ($dates as $date) {
            $dateObject = Carbon::createFromFormat('Y-m-d', $date->date);
            $date->date = $dateObject->format('m/Y');
        }

        $grouped = $dates->groupBy(
            function ($item, $key) {
                return (string) $item->date;
            }
        );

        $groupCount = $grouped->map(
            function ($item, $key) {
                return $item->count();
            }
        );

        $months = new Collection;

        foreach ($groupCount as $key => $total) {
            $months->push(['name' => $key, 'total' => $total]);
        }

        $neighborhoods = DB::table('occurrences')
            ->select(['neighborhood', 'city', 'state'])
            ->whereYear('date', '>=', $today->format('Y-m-d'))
            ->orderBy('state')
            ->orderBy('city')
            ->orderBy('neighborhood')
            ->get();

        foreach ($neighborhoods as $neighborhood) {
            $neighborhood->name = sprintf('%s / %s-%s', $neighborhood->neighborhood, $neighborhood->city, $neighborhood->state);
        }

        $grouped = $neighborhoods->groupBy(
            function ($item, $key) {
                return (string) $item->name;
            }
        );

        $groupCount = $grouped->map(
            function ($item, $key) {
                return $item->count();
            }
        );

        $bairros = new Collection;

        foreach ($groupCount as $key => $total) {
            $bairros->push(['name' => $key, 'total' => $total]);
        }

        $colors = [
            '#03318C',
            '#F2CB05',
            '#D96704',
            '#D91414',
            '#0D0D0D',
        ];

        return Inertia::render('Dashboard', [
            'months' => $months,
            'bairros' => $bairros,
            'colors' => $colors,
            'natures' => $natures->map(fn (Nature $nature) => [
                'name' => $nature->name,
                'occurrences_count' => $nature->occurrences_count,
            ]),
            'types' => $types->map(fn (Type $type) => [
                'name' => $type->name,
                'occurrences_count' => $type->occurrences_count,
            ]),
        ]);
    }
}
