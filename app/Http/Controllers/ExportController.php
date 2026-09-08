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
        $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
            'status'     => ['nullable', 'string'],
            'format'     => ['nullable', 'in:xlsx,csv'],
        ]);

        $filters = $request->only(['status', 'start_date', 'end_date']);
        $format  = $request->format ?? 'xlsx';

        // Build descriptive filename with date range
        $nameParts = ['lamaran'];
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $nameParts[] = str_replace('-', '', $filters['start_date']);
            $nameParts[] = str_replace('-', '', $filters['end_date']);
        } elseif (!empty($filters['start_date'])) {
            $nameParts[] = 'dari_' . str_replace('-', '', $filters['start_date']);
        } elseif (!empty($filters['end_date'])) {
            $nameParts[] = 'sd_' . str_replace('-', '', $filters['end_date']);
        } else {
            $nameParts[] = date('Ymd');
        }

        $filename = implode('_', $nameParts) . '.' . $format;

        return Excel::download(new JobsExport($filters), $filename);
    }
}
