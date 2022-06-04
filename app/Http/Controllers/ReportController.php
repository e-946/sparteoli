<?php

namespace App\Http\Controllers;

use App\Models\Occurrence;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportView(Request $request)
    {
        $occurrences = Occurrence::paginate(4);
        return response(view('report.index', compact('occurrences')));
    }
}

