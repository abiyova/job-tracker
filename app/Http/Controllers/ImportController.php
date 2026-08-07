<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\JobsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        Excel::import(new JobsImport, $request->file('file'));
        return redirect()->route('jobs.index')->with('success', 'Data berhasil diimport!');
    }
}