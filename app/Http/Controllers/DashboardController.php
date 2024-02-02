<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Summary;

class DashboardController extends Controller
{
    public function index()
    {
        $summary = Summary::all();
        $data = Summary::selectRaw('tanggal,SUM(CASE WHEN status=1 THEN total ELSE 0 END) AS active,SUM(CASE WHEN status=0 THEN total ELSE 0 END) AS nonactive')
        ->orderBy('tanggal')->groupBy('tanggal')->get();
        $xAxis = $data->pluck('tanggal')->toArray();
        $yAxisActive = $data->pluck('active')->toArray();
        $yAxisNonActive = $data->pluck('nonactive')->toArray();

        return view('dashboard', [
            'summary'           => $summary,
            'xAxis'             => $xAxis,
            'yAxisActive'       => $yAxisActive,
            'yAxisNonActive'    => $yAxisNonActive
        ]);
    }
}
