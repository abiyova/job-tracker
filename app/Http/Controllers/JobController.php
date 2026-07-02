<?php

namespace App\Http\Controllers;

use App\Models\{Job, StatusHistory};
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->jobs();

        // Search
        if ($s = $request->search) {
            $query->where(fn($q) =>
                $q->where('company_name','like',"%$s%")
                  ->orWhere('position','like',"%$s%")
            );
        }
        // Filter status
        if ($status = $request->status) {
            $query->where('status', $status);
        }
        // Filter sumber
        if ($source = $request->source) {
            $query->where('source', $source);
        }
        // Sort
        $sort = 'created_at';
        $dir  = $request->dir  ?? 'desc';
        $query->orderBy($sort, $dir);

        // Per page
        $perPage = $request->per_page ?? 15;

        if ($perPage === 'all') {
            $jobs = $query->get();
        } else {
            $jobs = $query->paginate((int) $perPage)->withQueryString();
        }
        $statuses = Job::$statuses;

        $user = auth()->user();
        $totalJobs = $user->jobs()->count();
        $limitStatus = [
            'has_limit' => $user->application_limit !== null,
            'limit' => $user->application_limit,
            'current' => $totalJobs,
            'can_add' => $user->application_limit === null || $totalJobs < $user->application_limit,
        ];

        return view('jobs.index', compact('jobs','statuses','perPage', 'limitStatus'));
    }

    public function create()
    {
        $user = auth()->user();
        if ($user->application_limit !== null && $user->jobs()->count() >= $user->application_limit) {
            return redirect()->route('jobs.index')->with('error', 'Anda telah mencapai batas maksimum pembuatan lamaran (' . $user->application_limit . ').');
        }

        $statuses = Job::$statuses;
        return view('jobs.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->application_limit !== null && $user->jobs()->count() >= $user->application_limit) {
            return redirect()->route('jobs.index')->with('error', 'Anda telah mencapai batas maksimum pembuatan lamaran (' . $user->application_limit . ').');
        }

        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'position'     => 'required|string|max:255',
            'location'     => 'nullable|string|max:255',
            'publish_date' => 'nullable|date',
            'source'       => 'nullable|string|max:100',
            'job_url'      => 'nullable|url',
            'apply_date'   => 'nullable|date',
            'status'       => 'required|in:'.implode(',', array_keys(Job::$statuses)),
            'notes'        => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();
        $job = Job::create($data);

        // Catat riwayat status awal
        StatusHistory::create([
            'job_id'     => $job->id,
            'old_status' => null,
            'new_status' => $job->status,
            'note'       => 'Lamaran ditambahkan.',
        ]);

        return redirect()->route('jobs.index')->with('success', 'Lamaran berhasil ditambahkan!');
    }

    public function show(Job $job)
    {
        $this->authorize('view', $job);
        $histories = $job->statusHistories()->orderByDesc('changed_at')->get();
        return view('jobs.show', compact('job','histories'));
    }

    public function edit(Job $job)
    {
        $this->authorize('update', $job);
        $statuses = Job::$statuses;
        return view('jobs.edit', compact('job','statuses'));
    }

    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'position'     => 'required|string|max:255',
            'location'     => 'nullable|string|max:255',
            'publish_date' => 'nullable|date',
            'source'       => 'nullable|string|max:100',
            'job_url'      => 'nullable|url',
            'apply_date'   => 'nullable|date',
            'status'       => 'required|in:'.implode(',', array_keys(Job::$statuses)),
            'notes'        => 'nullable|string',
        ]);

        $oldStatus = $job->status;
        $job->update($data);

        // Catat perubahan status
        if ($oldStatus !== $data['status']) {
            StatusHistory::create([
                'job_id'     => $job->id,
                'old_status' => $oldStatus,
                'new_status' => $data['status'],
                'note'       => $request->status_note ?? null,
            ]);
        }

        return redirect()->route('jobs.show', $job)->with('success', 'Lamaran berhasil diperbarui!');
    }

    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Lamaran berhasil dihapus.');
    }

    public function destroyAll()
    {
        $count = Job::where('user_id', auth()->id())->count();
        Job::where('user_id', auth()->id())->delete();
        return redirect()->route('jobs.index')->with('success', "Berhasil menghapus {$count} data lamaran.");
    }

    public function checkFollowUp()
    {
        \Illuminate\Support\Facades\Artisan::call('jobs:check-followup');
        $output = \Illuminate\Support\Facades\Artisan::output();
        return redirect()->route('jobs.index')->with('success', 'Pengecekan status selesai! ' . $output);
    }
}