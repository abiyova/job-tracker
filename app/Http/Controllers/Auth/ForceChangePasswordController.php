<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForceChangePasswordController extends Controller
{
    public function showForm() {
        return view('auth.force-change-password');
    }

    public function update(Request $request) {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        auth()->user()->update([
            'password'              => bcrypt($request->password),
            'force_password_change' => false,
        ]);
        return redirect()->route('dashboard')->with('success', 'Password berhasil diubah.');
    }
}
