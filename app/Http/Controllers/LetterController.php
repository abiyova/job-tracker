<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LetterGeneratorService;
use App\Models\{Job, LetterTemplate, GeneratedLetter};

class LetterController extends Controller
{
    public function index()
    {
        $jobs      = auth()->user()->jobs()->latest()->get();
        $templates = auth()->user()->letterTemplates()->orderBy('name')->get();
        return view('letters.index', compact('jobs','templates'));
    }

    public function generate(Request $request, LetterGeneratorService $service)
    {
        $request->validate([
            'job_id'         => 'required|exists:job_applications,id',
            'template_id'    => 'required|exists:letter_templates,id',
            'font_family'    => 'required|string',
            'font_size'      => 'required|integer|between:10,24',
            'line_spacing'   => 'required|string',
            'edited_content' => 'nullable|string',
        ]);

        $job      = Job::findOrFail($request->job_id);
        $template = LetterTemplate::findOrFail($request->template_id);
        
        // Use user relationship profile
        $profile  = auth()->user()->profile;

        abort_if(!$profile, 400, 'Lengkapi profil Anda terlebih dahulu!');

        $fontSize = (int) $request->font_size;
        $fontFamily = $request->font_family;
        $editedContent = $request->filled('edited_content') ? $request->edited_content : null;

        $lineSpacing = $request->input('line_spacing');
        if ($lineSpacing === 'custom') {
            $lineSpacing = (float) $request->input('custom_line_spacing', 1.5);
        } else {
            $lineSpacing = (float) $lineSpacing;
        }
        
        // Enforce minimum 1.0
        if ($lineSpacing < 1.0) {
            $lineSpacing = 1.0;
        }

        $path = $service->generateDocx($job, $template, $profile, $fontSize, $editedContent, $lineSpacing, $fontFamily);

        return \Storage::download($path);
    }

    public function preview(Request $request, LetterGeneratorService $service)
    {
        $request->validate([
            'job_id'      => 'required|exists:job_applications,id',
            'template_id' => 'required|exists:letter_templates,id',
        ]);

        $job      = Job::findOrFail($request->job_id);
        $template = LetterTemplate::findOrFail($request->template_id);
        $profile  = auth()->user()->profile;

        if (!$profile) {
            return response()->json(['error' => 'Lengkapi profil Anda terlebih dahulu!'], 400);
        }

        $content  = $service->replacePlaceholders($template->content, $job, $profile);
        return response()->json(['content' => $content]);
    }

    public function history()
    {
        $letters = GeneratedLetter::whereHas('job', fn($q) =>
            $q->where('user_id', auth()->id())
        )->with('job','template')->orderByDesc('generated_at')->paginate(20);

        return view('letters.history', compact('letters'));
    }

    public function download(string $id)
    {
        $letter = GeneratedLetter::whereHas('job', fn($q) =>
            $q->where('user_id', auth()->id())
        )->findOrFail($id);

        if (!\Storage::exists($letter->file_path)) {
            abort(404, 'File surat tidak ditemukan.');
        }

        return \Storage::download($letter->file_path, $letter->file_name);
    }

    public function destroy(string $id)
    {
        $letter = GeneratedLetter::whereHas('job', fn($q) =>
            $q->where('user_id', auth()->id())
        )->findOrFail($id);

        if (\Storage::exists($letter->file_path)) {
            \Storage::delete($letter->file_path);
        }
        
        $letter->delete();

        return back()->with('success', 'Riwayat surat lamaran berhasil dihapus.');
    }

    public function destroyMass(Request $request)
    {
        $request->validate([
            'delete_type' => 'required|in:all,range',
            'start_date'  => 'required_if:delete_type,range|nullable|date',
            'end_date'    => 'required_if:delete_type,range|nullable|date|after_or_equal:start_date',
        ]);

        $query = GeneratedLetter::whereHas('job', fn($q) =>
            $q->where('user_id', auth()->id())
        );

        if ($request->delete_type === 'range') {
            $query->whereBetween('created_at', [
                \Carbon\Carbon::parse($request->start_date)->startOfDay(),
                \Carbon\Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        $letters = $query->get();
        $count = $letters->count();

        foreach ($letters as $letter) {
            if (\Storage::exists($letter->file_path)) {
                \Storage::delete($letter->file_path);
            }
            $letter->delete();
        }

        return back()->with('success', "$count riwayat surat lamaran beserta filenya berhasil dihapus.");
    }
}
