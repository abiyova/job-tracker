<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{


    public function index()
    {
        $users = User::withCount('jobs')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|unique:users',
            'role'     => 'required|in:admin,user',
            'password' => 'required|min:8|confirmed',
        ]);
        User::create(['password' => bcrypt($data['password'])] + $data);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function resetPassword(User $user)
    {
        $tempPass = 'Temp@' . Str::random(6);
        $user->update([
            'password'              => bcrypt($tempPass),
            'force_password_change' => true,
        ]);
        // Kirim email password sementara (opsional)
        return back()->with('success', "Password direset. Password sementara: $tempPass");
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Status user diperbarui.');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|in:admin,user',
            'limit_type' => 'required|in:unlimited,limited',
            'application_limit' => 'nullable|integer|min:1|required_if:limit_type,limited',
        ]);

        $user->update([
            'role' => $data['role'],
            'application_limit' => $data['limit_type'] === 'unlimited' ? null : $data['application_limit'],
        ]);

        return back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Delete related data first or rely on cascade/onDelete triggers.
        // Assuming database is handling cascades or we manually delete some sensitive files if needed.
        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}