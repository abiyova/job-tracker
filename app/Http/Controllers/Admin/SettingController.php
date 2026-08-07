<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = \App\Models\SystemSetting::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->only(['app_name', 'mail_from', 'default_application_limit']) as $key => $value) {
            \App\Models\SystemSetting::set($key, $value);
        }
        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('logo', 'public');
            \App\Models\SystemSetting::set('app_logo', $path);
        }
        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}