<?php

use App\Http\Controllers\DashboardController;
use App\Livewire\Admin\WasteTypeManager;
use App\Livewire\WasteCalculator;
use Illuminate\Support\Facades\Route;

Route::get('/', WasteCalculator::class)->name('home');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'admin'])->group(function (): void {
    Route::get('/admin/waste-types', WasteTypeManager::class)->name('admin.waste-types');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
