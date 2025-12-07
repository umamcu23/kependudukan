<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index']);
// Route::get('/dashboard/data/summary', [DashboardController::class, 'summary']);
Route::get('/dashboard/data/summary', 
    [DashboardController::class, 'genderSummary']
)->name('dashboard.gender');

Route::get('/dashboard/data/by-provinsi', [DashboardController::class, 'byProvinsi']);
Route::get('/dashboard/data/by-umur', [DashboardController::class, 'byUmur']);
Route::get('/dashboard/data/trend', [DashboardController::class, 'trend']);
Route::get('/dashboard/data/detail-gender/{gender}', [DashboardController::class, 'detailByGender']);

Route::get('/dashboard/data/detail-gender-table/{gender}', 
    [DashboardController::class, 'detailByGenderTable']
);


Route::get('/dashboard/data/kpi', [DashboardController::class, 'kpi']);

Route::get(
    '/dashboard/data/detail-provinsi-table/{provinsi}',
    [DashboardController::class, 'detailByProvinsiTable']
)->where('provinsi', '.*');

Route::get(
    '/dashboard/data/detail-provinsi-pivot/{provinsi}',
    [DashboardController::class, 'detailProvinsiPivot']
)->where('provinsi','.*');

Route::get(
    '/dashboard/data/detail-gender-pivot/{gender}',
    [DashboardController::class, 'detailGenderPivot']
);

Route::get(
    '/dashboard/data/umur-by-gender',
    [DashboardController::class, 'umurByGender']
);

Route::prefix('dashboard/data')->group(function () {
    Route::get('/map-provinsi', [DashboardController::class, 'mapProvinsi']);
});


