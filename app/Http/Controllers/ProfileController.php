<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profile;
        return view('profiles.index', compact('profile'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'   => 'required|string|max:150',
            'birth_place' => 'nullable|string|max:100',
            'birth_date'  => 'nullable|date',
            'address'     => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email',
            'linkedin'    => 'nullable|url',
            'github'      => 'nullable|url',
            'portfolio'   => 'nullable|url',
            'education'   => 'nullable|string|max:255',
            'summary'     => 'nullable|string',
        ]);

        auth()->user()->profile()->updateOrCreate(
            ['user_id' => auth()->id()],
            $data
        );

        return back()->with('success', 'Profil berhasil disimpan!');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
