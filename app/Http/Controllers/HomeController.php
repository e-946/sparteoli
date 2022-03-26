<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use App\Models\Type;
use Illuminate\Contracts\Support\Renderable;
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

        $months = DB::table('occurrences')
            ->select(DB::raw('MONTH(date) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('MONTH(date)'))
            ->get();

        foreach ($months as $month) {
            $month->name = self::MONTH_REFERENCE[$month->month - 1];
        }

        $months = $months->sortBy(function ($month) {
            return $month->total;
        });

        $bairros = DB::table('occurrences')
            ->select(['neighborhood as name', DB::raw('COUNT(*) as total')])
            ->groupBy('neighborhood')
            ->orderBy('total')
            ->get();

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
