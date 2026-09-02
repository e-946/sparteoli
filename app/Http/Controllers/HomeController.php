<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use App\Models\Type;
use Carbon\Carbon;
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

        $since = Carbon::today()->subMonths(15)->format('Y-m-d');

        $months = DB::table('occurrences')
            ->selectRaw("DATE_FORMAT(date, '%m') as month, DATE_FORMAT(date, '%Y') as year, COUNT(*) as total")
            ->where('date', '>=', $since)
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get(['month', 'year', 'total']);

        $bairros = DB::table('occurrences')
            ->selectRaw('neighborhood, city, COUNT(*) as total')
            ->where('date', '>=', $since)
            ->groupBy('neighborhood', 'city')
            ->orderBy('city')
            ->orderBy('neighborhood')
            ->get(['neighborhood', 'city', 'total']);

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
