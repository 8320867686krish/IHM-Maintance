<?php

use App\Http\Controllers\ClientCompanyController;
use App\Http\Controllers\dashobardController;
use App\Http\Controllers\HazmatCompanyController;
use App\Http\Controllers\HelpCente;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\MakeModelContoller;
use App\Http\Controllers\POOrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VscpController;
use Illuminate\Support\Facades\Auth;

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
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::get('/dashboard', [dashobardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/shipwisepo/{ship_id}', [dashobardController::class, 'shipwiseData'])->middleware(['auth', 'verified'])->name('shipwiseData');

Route::middleware('auth')->group(function () {
    Route::post('/import', [POOrderController::class, 'import'])->name('import');
    Route::get('poOrderSample',[POOrderController::class,'poOrderSample'])->name('poOrderSample');
    Route::get('ships/po-order/add/{ship_id}/{po_order_id?}', [POOrderController::class, 'add'])->name('po.add');
    Route::get('po-order/po-item/relevant/{poiteam_id}', [POOrderController::class, 'viewReleventItem'])->name('po.relevent');
    Route::post('po-order/save', [POOrderController::class, 'store'])->name('po.store');
    Route::delete('po-order/delete/{po_id}', [POOrderController::class, 'poDelete'])->name('po.delete');
    Route::post('po-item/hazmat/save', [POOrderController::class, 'poItemsHazmatSave'])->name('poItems.hazmat');
    Route::get('equipment/{hazmat_id}',[POOrderController::class, 'getEquipMent'])->name('equipment');
    Route::get('manufacturer/{hazmat_id}/{equipment}',[POOrderController::class, 'getManufacturer'])->name('getManufacturer');
    Route::get('model/{hazmat_id}/{equipment}/{manufacturer}',[POOrderController::class, 'getmodel'])->name('getmodel');
    Route::get('document/{id}',[POOrderController::class, 'getPartBasedDocumentFile'])->name('getPartBasedDocumentFile');
    Route::post('send/mail',[POOrderController::class, 'sendMail'])->name('send.mail');

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
            Route::get('hazmatCompany', 'index')->name('hazmatCompany')->middleware('can:hazmatCompany');
            Route::get('hazmatCompany/add', 'create')->name('hazmatCompany.add')->middleware('can:hazmatCompany.add');
            Route::post('hazmatCompany', 'store')->name('hazmatCompany.store');
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
    Route::get('/portal-guide', [ShipController::class, 'portalGuide'])->name('portal.guide');
    Route::get('/summeryReport/{ship_id}', [VscpController::class, 'summeryReport'])->name('summeryReport');


    Route::middleware('can:ships')->group(function () {
        Route::controller(ShipController::class)->group(function () {
            Route::get('ships', 'index')->name('ships')->middleware('can:ships');
            Route::get('ships/add', 'create')->name('ships.add')->middleware('can:ships.add');
            Route::post('ships', 'store')->name('ships.store');
            Route::get('ships/{id}/delete', 'destroy')->name('ships.delete')->middleware('can:ships.remove');
            Route::get('ship/view/{ship_id}', 'shipView')->name('ships.view');
            Route::post('ship/assignProject', 'assignShip')->name('ships.assign');

        });
        Route::controller(TrainingController::class)->group(function () {
            Route::get('training', 'index')->name('training');
            Route::get('training/add', 'add')->name('training.add');
            Route::get('training/{id}/edit','editTraining')->name('training.edit');
            Route::post('training/save','trainingSave')->name('training.save');
            Route::post('assigntraining','assigntraining')->name('assigntraining');


        });
        Route::controller(VscpController::class)->group(function () {
            Route::get('ship/vscp/{ship_id}/{amended?}', 'index')->name('vscp')->middleware('can:ships');          
            Route::post('upload/GaPlan','uploadGaPlan');
            Route::get('ship/deleteDeck/{id}', 'deleteDeck')->name('deleteDeck');
            Route::post('ship/updateDeckDetails','updateDeckDetails')->name('updateDeckDetails');
            Route::get('ship/deck/{id}/check/{amended?}', 'check')->name('deck.check');
            Route::post('check/save','checkSave')->name('check.save');
            Route::post('ship/check/{id}', 'deleteCheck')->name('check.delete');
            Route::get('check/{id}/hazmat/{amended?}', 'checkHazmat')->name('check.hazmat');
            Route::post('partManual', 'partManual')->name('partManual');
            Route::delete('part/remove/{id}', 'partManualDelete')->name('partManualDelete');
            Route::post('summary', 'summary')->name('summary');
            Route::delete('summary/remove/{id}', 'summaryDelete')->name('summaryDelete');
            Route::post('unlockVscp', 'unlockVscp')->name('unlockVscp');
            Route::post('amended', 'startamended')->name('amended');


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
        Route::controller(MakeModelContoller::class)->group(function () {
            Route::get('documentdeclaration', 'index')->name('documentdeclaration')->middleware('can:documentdeclaration');
            Route::get('documentdeclaration/add', 'create')->name('documentdeclaration.add')->middleware('can:documentdeclaration.add');
            Route::post('documentdeclaration', 'store')->name('documentdeclaration.store')->middleware('can:documentdeclaration.add');
            Route::get('documentdeclaration/{id}/delete', 'destroy')->name('documentdeclaration.delete');
            Route::get('documentdeclaration/{id}/edit', 'edit')->name('documentdeclaration.edit');
        });
    });
});

require __DIR__ . '/auth.php';
