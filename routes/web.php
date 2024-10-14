<?php

use App\Http\Controllers\ClientCompanyController;
use App\Http\Controllers\HazmatCompanyController;
use App\Http\Controllers\HelpCente;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
  
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/helpcenter', [HelpCenterController::class, 'index'])->name('helpcenter.list');
    Route::middleware('can:roles')->group(function () {
        Route::controller(RoleController::class)->group(function () {
            Route::get('roles', 'index')->name('roles')->middleware('can:roles');
            Route::get('roles/add', 'create')->name('roles.add')->middleware('can:roles.add');
            Route::post('roles', 'store')->name('roles.store');
            Route::get('roles/{id}/edit', 'edit')->name('roles.edit')->middleware('can:roles.edit');
            Route::get('roles/{id}/delete', 'destroy')->name('roles.delete')->middleware('can:roles.remove');
        });
    });

    Route::middleware('can:hazmatCompany')->group(function () {
        Route::controller(HazmatCompanyController::class)->group(function () {
            Route::get('hazmatCompany','index')->name('hazmatCompany')->middleware('can:hazmatCompany');
            Route::get('hazmatCompany/add','create')->name('hazmatCompany.add')->middleware('can:hazmatCompany.add');
            Route::post('hazmatCompany','store')->name('hazmatCompany.store');
            Route::get('hazmatCompany/{id}/edit', 'edit')->name('hazmatCompany.edit')->middleware('can:hazmatCompany.edit');
            Route::get('hazmatCompany/{id}/delete', 'destroy')->name('hazmatCompany.delete')->middleware('can:hazmatCompany.remove');
        });
    });


    Route::middleware('can:clientCompany')->group(function () {
        Route::controller(ClientCompanyController::class)->group(function () {
            Route::get('clientCompany', 'index')->name('clientCompany')->middleware('can:clientCompany');
            Route::get('clientCompany/add', 'create')->name('clientCompany.add')->middleware('can:clientCompany.add');
            Route::post('clientCompany', 'store')->name('clientCompany.store');
            Route::get('clientCompany/{id}/edit', 'edit')->name('clientCompany.edit')->middleware('can:clientCompany.edit');
            Route::get('clientCompany/{id}/delete', 'destroy')->name('clientCompany.delete')->middleware('can:clientCompany.remove');
        });
    });


    Route::middleware('can:ships')->group(function () {
        Route::controller(ShipController::class)->group(function () {
            Route::get('ships', 'index')->name('ships')->middleware('can:ships');
            Route::get('ships/add', 'create')->name('ships.add')->middleware('can:ships.add');
            Route::post('ships', 'store')->name('ships.store');
            Route::get('ships/{id}/delete', 'destroy')->name('ships.delete')->middleware('can:ships.remove');
            Route::get('ship/view/{ship_id}', 'shipView')->name('ships.view');
            Route::post('ship/assignProject', 'assignShip')->name('ships.assign');


        });
    });

    Route::middleware('can:users')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('users', 'index')->name('users')->middleware('can:users');
            Route::get('users/add', 'create')->name('users.add')->middleware('can:users.add');
            Route::post('users', 'store')->name('users.store');
            Route::get('users/{id}/edit', 'edit')->name('users.edit')->middleware('can:users.edit');
            Route::get('users/{id}/delete', 'destroy')->name('users.delete')->middleware('can:users.remove');
        });
    });

    Route::middleware('can:documentdeclaration')->group(function () {
        // Route::resource('makemodel', MakeModelContoller::class);
        Route::controller(MakeModelContoller::class)->group(function () {
            Route::get('documentdeclaration', 'index')->name('documentdeclaration')->middleware('can:documentdeclaration');
            Route::get('documentdeclaration/add', 'create')->name('documentdeclaration.add')->middleware('can:documentdeclaration.add');
            Route::post('documentdeclaration', 'store')->name('documentdeclaration.store')->middleware('can:documentdeclaration.add');
            Route::get('documentdeclaration/{id}/delete', 'destroy')->name('documentdeclaration.delete');
            Route::get('documentdeclaration/{id}/edit', 'edit')->name('documentdeclaration.edit');
        });
    });
});

require __DIR__.'/auth.php';
