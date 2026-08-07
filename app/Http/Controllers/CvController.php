<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    public function index()
    {
        $cvs = auth()->user()->cvs()->latest()->paginate(10);
        return view('cvs.index', compact('cvs'));
    }

    public function create()
    {
        return view('cvs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'version'     => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'file_pdf'    => 'required|file|mimes:pdf|max:5120',
            'file_docx'   => 'nullable|file|mimes:doc,docx|max:5120',
        ]);

        $path_pdf = $request->file('file_pdf')->store('cvs/'.auth()->id(), 'local');
        $path_docx = null;
        if ($request->hasFile('file_docx')) {
            $path_docx = $request->file('file_docx')->store('cvs/'.auth()->id(), 'local');
        }

        if ($request->boolean('is_default')) {
            Cv::where('user_id', auth()->id())->update(['is_default' => false]);
        }

        auth()->user()->cvs()->create([
            'name'           => $request->name,
            'description'    => $request->description,
            'version'        => $request->version,
            'file_path'      => $path_pdf,
            'file_path_docx' => $path_docx,
            'is_default'     => $request->boolean('is_default'),
        ]);

        return redirect()->route('cvs.index')->with('success', 'CV berhasil diupload!');
    }

    public function download(Request $request, Cv $cv)
    {
        abort_if($cv->user_id !== auth()->id(), 403);
        
        if ($request->query('type') === 'docx' && $cv->file_path_docx) {
            $extension = pathinfo($cv->file_path_docx, PATHINFO_EXTENSION) ?: 'docx';
            return Storage::download($cv->file_path_docx, $cv->name.'.'.$extension);
        }
        
        $extension = pathinfo($cv->file_path, PATHINFO_EXTENSION) ?: 'pdf';
        return Storage::download($cv->file_path, $cv->name.'.'.$extension);
    }

    public function show(Cv $cv)
    {
        abort_if($cv->user_id !== auth()->id(), 403);
        
        if (!Storage::disk('local')->exists($cv->file_path)) {
            abort(404, 'File CV PDF tidak ditemukan.');
        }

        $file = Storage::disk('local')->get($cv->file_path);
        $mimeType = Storage::disk('local')->mimeType($cv->file_path);
        
        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $cv->name . '.pdf"');
    }

    public function setDefault(Cv $cv)
    {
        abort_if($cv->user_id !== auth()->id(), 403);
        Cv::where('user_id', auth()->id())->update(['is_default' => false]);
        $cv->update(['is_default' => true]);
        return back()->with('success', 'CV default berhasil diubah.');
    }

    public function edit(Cv $cv)
    {
        abort_if($cv->user_id !== auth()->id(), 403);
        return view('cvs.edit', compact('cv'));
    }

    public function update(Request $request, Cv $cv)
    {
        abort_if($cv->user_id !== auth()->id(), 403);

        $request->validate([
            'name'        => 'required|string|max:100',
            'version'     => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'file_pdf'    => 'nullable|file|mimes:pdf|max:5120',
            'file_docx'   => 'nullable|file|mimes:doc,docx|max:5120',
        ]);

        if ($request->boolean('is_default')) {
            Cv::where('user_id', auth()->id())->where('id', '!=', $cv->id)->update(['is_default' => false]);
        }

        $data = [
            'name'        => $request->name,
            'description' => $request->description,
            'version'     => $request->version,
            'is_default'  => $request->boolean('is_default'),
        ];

        if ($request->hasFile('file_pdf')) {
            if ($cv->file_path) Storage::disk('local')->delete($cv->file_path);
            $data['file_path'] = $request->file('file_pdf')->store('cvs/'.auth()->id(), 'local');
        }
        
        if ($request->hasFile('file_docx')) {
            if ($cv->file_path_docx) Storage::disk('local')->delete($cv->file_path_docx);
            $data['file_path_docx'] = $request->file('file_docx')->store('cvs/'.auth()->id(), 'local');
        }

        $cv->update($data);

        return redirect()->route('cvs.index')->with('success', 'Informasi CV berhasil diperbarui!');
    }

    public function destroy(Cv $cv)
    {
        abort_if($cv->user_id !== auth()->id(), 403);
        
        if ($cv->file_path) Storage::disk('local')->delete($cv->file_path);
        if ($cv->file_path_docx) Storage::disk('local')->delete($cv->file_path_docx);
        $cv->delete();

        return redirect()->route('cvs.index')->with('success', 'CV berhasil dihapus.');
    }
}
