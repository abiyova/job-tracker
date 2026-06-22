<?php

namespace App\Http\Controllers;

use App\Models\{Job, User, Cv, GeneratedLetter, LoginLog};
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }
        return $this->userDashboard($user);
    }

    private function adminDashboard()
    {
        $stats = [
            'total_user'  => User::count(),
            'active_user' => User::where('is_active', true)->count(),
            'admin_user'  => User::where('role', 'admin')->count(),
            'regular_user'=> User::where('role', 'user')->count(),
        ];

        return view('dashboard.admin', compact('stats'));
    }

    private function userDashboard($user)
    {
        $stats = [
            'total_lamaran'  => $user->jobs()->count(),
            'interview'      => $user->jobs()->where('status','interview')->count(),
            'tes'            => $user->jobs()->where('status','tes')->count(),
            'offering'       => $user->jobs()->where('status','offering')->count(),
            'ditolak'        => $user->jobs()->where('status','ditolak')->count(),
            'diterima'       => $user->jobs()->where('status','diterima')->count(),
        ];

        $recentJobs = $user->jobs()->latest()->take(5)->get();

        $lamaranPerStatus = $user->jobs()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->get();

        $lamaranPerBulan = $user->jobs()
            ->select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')->orderBy('bulan')->get();

        return view('dashboard.user', compact('stats','recentJobs','lamaranPerStatus','lamaranPerBulan'));
    }
}
