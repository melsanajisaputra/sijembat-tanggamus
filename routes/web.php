<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BridgeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/jembatan', [PublicController::class, 'index'])->name('public.jembatan');
Route::get('/jembatan/{id}', [PublicController::class, 'show'])->name('public.jembatan.show');

/*
|--------------------------------------------------------------------------
| Halaman Dashboard & Admin (Login wajib)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Data Jembatan
    Route::resource('/admin/bridges', BridgeController::class)->names([
        'index' => 'bridges.index',
        'create' => 'bridges.create',
        'store' => 'bridges.store',
        'edit' => 'bridges.edit',
        'update' => 'bridges.update',
        'destroy' => 'bridges.destroy',
        'show' => 'bridges.show'
    ]);

    // ✅ Import dan Export
    Route::get('/bridges/import', function () {
        return view('admin.import');
    })->name('bridges.import.view');

    Route::post('/bridges/import', [BridgeController::class, 'import'])->name('bridges.import');
    Route::get('/export-data', function () {return view('admin.export');})->name('export.data');

    Route::get('/admin/bridges/export/excel', [BridgeController::class, 'exportExcel'])->name('bridges.export.excel');
    Route::get('/admin/bridges/export/pdf', [BridgeController::class, 'exportPDF'])->name('bridges.export.pdf');

    // Profil Admin
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
