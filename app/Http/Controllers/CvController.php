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
            'file'        => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $path = $request->file('file')->store('cvs/'.auth()->id(), 'local');

        // Jika set default, reset yang lain
        if ($request->boolean('is_default')) {
            Cv::where('user_id', auth()->id())->update(['is_default' => false]);
        }

        auth()->user()->cvs()->create([
            'name'        => $request->name,
            'description' => $request->description,
            'version'     => $request->version,
            'file_path'   => $path,
            'is_default'  => $request->boolean('is_default'),
        ]);

        return redirect()->route('cvs.index')->with('success', 'CV berhasil diupload!');
    }

    public function download(Cv $cv)
    {
        abort_if($cv->user_id !== auth()->id(), 403);
        $extension = pathinfo($cv->file_path, PATHINFO_EXTENSION) ?: 'pdf';
        return Storage::download($cv->file_path, $cv->name.'.'.$extension);
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
            'file'        => 'nullable|file|mimes:pdf,doc,docx|max:5120',
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

        if ($request->hasFile('file')) {
            Storage::disk('local')->delete($cv->file_path);
            $data['file_path'] = $request->file('file')->store('cvs/'.auth()->id(), 'local');
        }

        $cv->update($data);

        return redirect()->route('cvs.index')->with('success', 'Informasi CV berhasil diperbarui!');
    }

    public function destroy(Cv $cv)
    {
        abort_if($cv->user_id !== auth()->id(), 403);
        
        Storage::disk('local')->delete($cv->file_path);
        $cv->delete();

        return redirect()->route('cvs.index')->with('success', 'CV berhasil dihapus.');
    }
}
