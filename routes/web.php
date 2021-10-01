<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix(LaravelLocalization::setLocale())->group(function() {

    // ->middleware(['auth:sanctum', 'verified'])

    Route::prefix('admin')->group(function() {

        Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin-dashboard');

        Route::prefix('campaign/')->group(function() {

            Route::get('/', [\App\Http\Controllers\Admin\CampaignController::class, 'index'])->name('admin-campaigns-index');

            Route::get('/create', [\App\Http\Controllers\Admin\CampaignController::class, 'create'])->name('admin-campaigns-create');

            Route::get('/{id}/edit', [\App\Http\Controllers\Admin\CampaignController::class, 'edit'])->name('admin-campaigns-edit');

            Route::post('/store', [\App\Http\Controllers\Admin\CampaignController::class, 'store'])->name('admin-campaigns-store');

            Route::post('/update', [\App\Http\Controllers\Admin\CampaignController::class, 'update'])->name('admin-campaigns-update');

        });


    });

});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    return Inertia::render('Dashboard');

})->name('dashboard');
