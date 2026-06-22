<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusHistoryController extends Controller
{
    public function index(Request $request)
    {
        $histories = \App\Models\StatusHistory::whereHas('job', fn($q) =>
            $q->where('user_id', auth()->id())
        )->with('job')->orderByDesc('changed_at')->paginate(20);

        return view('status-histories.index', compact('histories'));
    }
    public function destroyMass(Request $request)
    {
        $request->validate([
            'delete_type' => 'required|in:all,range',
            'start_date'  => 'required_if:delete_type,range|nullable|date',
            'end_date'    => 'required_if:delete_type,range|nullable|date|after_or_equal:start_date',
        ]);

        $query = \App\Models\StatusHistory::whereHas('job', fn($q) =>
            $q->where('user_id', auth()->id())
        );

        if ($request->delete_type === 'range') {
            $query->whereDate('changed_at', '>=', $request->start_date)
                  ->whereDate('changed_at', '<=', $request->end_date);
        }

        $count = $query->count();
        $query->delete();

        return back()->with('success', "Berhasil menghapus {$count} data riwayat status.");
    }
}
