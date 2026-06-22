<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LetterTemplate;

class LetterTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = auth()->user()->letterTemplates()->orderBy('name')->paginate(10);
        return view('templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'content'     => 'required|string',
        ]);

        auth()->user()->letterTemplates()->create([
            'name'        => $request->name,
            'description' => $request->description,
            'content'     => $request->content,
        ]);

        return redirect()->route('templates.index')->with('success', 'Template berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = auth()->user()->letterTemplates()->findOrFail($id);
        return view('templates.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $template = auth()->user()->letterTemplates()->findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'content'     => 'required|string',
        ]);

        $template->update([
            'name'        => $request->name,
            'description' => $request->description,
            'content'     => $request->content,
        ]);

        return redirect()->route('templates.index')->with('success', 'Template berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $template = auth()->user()->letterTemplates()->findOrFail($id);
        $template->delete();

        return redirect()->route('templates.index')->with('success', 'Template berhasil dihapus!');
    }
}
