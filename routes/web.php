<?php

// use App\Http\Controllers\ProfileController;
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    JobController,
    StatusHistoryController,
    CvController,
    ProfileController,
    LetterTemplateController,
    LetterController,
    ImportController,
    ExportController,
};
use App\Http\Controllers\Admin\{UserController, SettingController};
use App\Http\Controllers\Auth\ForceChangePasswordController;

// ── Auth (Breeze) ──────────────────────────────────────
require __DIR__.'/auth.php';

// ── Force Change Password ──────────────────────────────
Route::middleware(['auth','force.change.password'])->group(function () {

    Route::get('/password/change', [ForceChangePasswordController::class, 'showForm'])
         ->name('password.change.form');
    Route::post('/password/change', [ForceChangePasswordController::class, 'update'])
         ->name('password.change');

    // ── Authenticated Routes ───────────────────────────
    Route::middleware('auth')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Lamaran
        Route::resource('jobs', JobController::class);
        Route::delete('jobs-destroy-all', [JobController::class, 'destroyAll'])->name('jobs.destroy-all');
        Route::post('jobs-check-followup', [JobController::class, 'checkFollowUp'])->name('jobs.check-followup');

        // Riwayat Status
        Route::get('status-histories', [StatusHistoryController::class, 'index'])
             ->name('status-histories.index');
        Route::delete('status-histories', [StatusHistoryController::class, 'destroyMass'])
             ->name('status-histories.destroy-mass');

        // CV
        Route::resource('cvs', CvController::class);
        Route::get('cvs/{cv}/download', [CvController::class, 'download'])->name('cvs.download');
        Route::post('cvs/{cv}/default', [CvController::class, 'setDefault'])->name('cvs.set-default');

        // Profil
        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('profile', [ProfileController::class, 'store'])->name('profile.store');

        // Template Surat
        Route::resource('templates', LetterTemplateController::class);

        // Generator Surat
        Route::get('letters', [LetterController::class, 'index'])->name('letters.index');
        Route::post('letters/generate', [LetterController::class, 'generate'])->name('letters.generate');
        Route::get('letters/preview', [LetterController::class, 'preview'])->name('letters.preview');
        Route::get('letters/history', [LetterController::class, 'history'])->name('letters.history');
        Route::delete('letters/destroy-mass', [LetterController::class, 'destroyMass'])->name('letters.destroy-mass');
        Route::get('letters/{letter}/download', [LetterController::class, 'download'])->name('letters.download');
        Route::delete('letters/{letter}', [LetterController::class, 'destroy'])->name('letters.destroy');

        // Import / Export
        Route::get('import', [ImportController::class, 'index'])->name('import.index');
        Route::post('import', [ImportController::class, 'store'])->name('import.store');
        Route::get('export', [ExportController::class, 'index'])->name('export.index');
        Route::post('export/download', [ExportController::class, 'download'])->name('export.download');

        // ── Admin Only ─────────────────────────────────
        Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
            Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);
            Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])
                 ->name('users.reset-password');
            Route::post('users/{user}/toggle-active', [UserController::class, 'toggleActive'])
                 ->name('users.toggle-active');
            Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
            Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        });
    });
});