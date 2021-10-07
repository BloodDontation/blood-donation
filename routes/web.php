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

Route::prefix(LaravelLocalization::setLocale())->group(function () {

    // register
    Route::get('registration', [\App\Http\Controllers\RegisterDonorController::class, 'register_form'])->name('donor-register-form');

    Route::post('register', [\App\Http\Controllers\RegisterDonorController::class, 'register'])->name('donor-register');

    Route::get('cancel-registration', function () {

        return "<pre>
                cancel the registration by entering cpr,
            </pre>
        ";

    });

    // ->middleware(['auth:sanctum', 'verified'])

    Route::prefix('admin')->group(function () {
//    Route::prefix('admin')->middleware(['auth:sanctum', 'verified'])->group(function() {

        Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin-dashboard');

        Route::prefix('campaign/')->group(function () {

            Route::get('/', [\App\Http\Controllers\Admin\CampaignController::class, 'index'])->name('admin-campaigns-index');

            Route::get('/create', [\App\Http\Controllers\Admin\CampaignController::class, 'create'])->name('admin-campaigns-create');

            Route::get('/{id}/edit', [\App\Http\Controllers\Admin\CampaignController::class, 'edit'])->name('admin-campaigns-edit');

            Route::post('/store', [\App\Http\Controllers\Admin\CampaignController::class, 'store'])->name('admin-campaigns-store');

            Route::post('/update', [\App\Http\Controllers\Admin\CampaignController::class, 'update'])->name('admin-campaigns-update');

        });

        Route::prefix('stages/')->group(function () {

            Route::get('/', [\App\Http\Controllers\Admin\StagesController::class, 'index'])->name('admin-stages-index');

            Route::get('/create', [\App\Http\Controllers\Admin\StagesController::class, 'create'])->name('admin-stages-create');

            Route::get('/{id}/edit', [\App\Http\Controllers\Admin\StagesController::class, 'edit'])->name('admin-stages-edit');

            Route::post('/store', [\App\Http\Controllers\Admin\StagesController::class, 'store'])->name('admin-stages-store');

            Route::get('/insert-donor', [\App\Http\Controllers\Admin\StagesController::class, 'interStage'])->name('admin-insert-donor-store');

        });

        Route::get('donor-lists', function () {

            return "<pre>
                Listing donors and search and action to approve/reject
            </pre>";

        });

        Route::get('donors-list-register', function () {

            return "<pre>
                Listing donors and search
                button to enter register of donor information (edit)
            </pre>";

        });

        Route::get('donor-edit/{id}', function ($id) {

            return "<pre>
                form have all donor data to update
                button to go to {} with donor-id
                * Taher *
            </pre>";
        });

        Route::prefix('plans/')->group(function () {

            Route::get('/', [\App\Http\Controllers\Admin\PlanController::class, 'index'])->name('admin-plan-index');

            Route::get('/create', [\App\Http\Controllers\Admin\PlanController::class, 'create'])->name('admin-plan-create');

            Route::post('/create', [\App\Http\Controllers\Admin\PlanController::class, 'store'])->name('admin-plan-store');

            Route::get('/{id}/edit', [\App\Http\Controllers\Admin\PlanController::class, 'edit'])->name('admin-plan-edit');
            Route::put('/{id}/update-position', [\App\Http\Controllers\Admin\PlanController::class, 'position'])->name('admin-position-edit');

        });

        Route::prefix('donors/')->group(function () {
            Route::get('/{cpr}/print', [\App\Http\Controllers\Admin\donorsController::class, 'print_form'])->name('admin-donors-print');


        });
    });

});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

//     return Inertia::render('Dashboard');

// })->name('dashboard')
