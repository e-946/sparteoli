<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    private const MONTH_REFERENCE = [
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
    ];

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
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $natures = Nature::all();
        $types = Type::all();

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
                return $item->date;
            }
        );

        $groupCount = $grouped->map(
            function ($item, $key) {
                return $item->count();
            }
        );

        $months = new Collection();

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
                return $item->name;
            }
        );

        $groupCount = $grouped->map(
            function ($item, $key) {
                return $item->count();
            }
        );

        $bairros = new Collection();

        foreach ($groupCount as $key => $total) {
            $bairros->push(['name' => $key, 'total' => $total]);
        }

        $colors  = [
            '#03318C',
            '#F2CB05',
            '#D96704',
            '#D91414',
            '#0D0D0D',
        ];

        return view('home', compact('natures', 'months', 'types', 'bairros', 'colors'));
    }
}
