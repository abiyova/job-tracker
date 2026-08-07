<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\JobsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function index()
    {
        return view('export.index');
    }

    public function download(Request $request)
    {
        $filters = $request->only(['status', 'source']);
        $format  = $request->format ?? 'xlsx';
        return Excel::download(new JobsExport($filters), 'lamaran_' . date('Ymd') . '.' . $format);
    }
}
