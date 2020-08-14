<?php

namespace App\Http\Controllers;

use App\Nature;
use App\Occurrence;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

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
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $natures = Nature::all();
        $occurrences = Occurrence::all();
        $months = DB::table('occurrences')
            ->select(DB::raw('MONTHNAME(date) name'), DB::raw('count(*) as total'))
            ->groupBy('name')
            ->orderBy('name', 'DESC')
            ->get();

        return view('home', compact('occurrences', 'natures', 'months'));
    }
}
