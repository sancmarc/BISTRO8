<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewHistoryController;
use App\Http\Controllers\BistroMenuController;
use App\Http\Controllers\ReturnItemController;
use App\Http\Controllers\TransferInventoryController;
use Illuminate\Support\Facades\Route;
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
    return view('welcome');
});

Route::get('menu',[BistroMenuController::class,'index'])->name('bistro.menu');
Route::post('inquire',[ViewHistoryController::class,'inquire'])->name('bistro.inquire');
Auth::routes([
    'login'    => true,
    'logout'   => true,
    'register' => false,
    'reset'    => false,   // for resetting passwords
    'confirm'  => false,  // for additional password confirmations
    'verify'   => false,  // for email verification
]);

Route::group(['middleware' => 'auth'], function () {


    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::get('show-inventory', [InventoryController::class, 'show'])->name('show.inventory');
    Route::post('store-inventory', [InventoryController::class, 'store'])->name('store.inventory');
    Route::post('get-inventory', [InventoryController::class, 'edit'])->name('get.inventory');
    Route::post('update-inventory', [InventoryController::class, 'update'])->name('update.inventory');
    Route::post('delete-inventory', [InventoryController::class, 'destroy'])->name('delete.inventory');
    Route::post('update-price',[InventoryController::class,'updatePrice'])->name('update.price');

    Route::post('process-billing', [BillingController::class, 'create'])->name('process.billing');
    Route::get('billing', [BillingController::class, 'index'])->name('billing');
    Route::get('get-billing',[BillingController::class,'edit'])->name('get.billing');
    Route::get('show-billing', [BillingController::class, 'show'])->name('list.billing');
    Route::get('history/{inventory_id}', [ViewHistoryController::class, 'index'])->name('view.history');
    Route::get('print/{billedID}', [ViewHistoryController::class, 'print'])->name('print.history');

    // user management

    Route::get('user-management', [UserController::class, 'index'])->name('user.management');
    Route::post('insert-user', [UserController::class, 'create'])->name('insert.new.user');
    Route::get('user-list', [UserController::class, 'show'])->name('user.list.management');
    Route::get('get-user', [UserController::class, 'edit'])->name('get.user');
    Route::post('update-user', [UserController::class, 'update'])->name('update.user');
    Route::post('delete-user', [UserController::class, 'destroy'])->name('delete.user');

    Route::get('check-barcode', [ViewHistoryController::class, 'checkBarcode'])->name('check.barcode');

    Route::get('bistro8-menu', [BistroMenuController::class,'create'])->name('admin.bistro.menu');
    Route::post('store-bistro8-menu',[BistroMenuController::class,'store'])->name('insert.new.menu');

    Route::get('all-menu-list',[BistroMenuController::class,'fetchMenu'])->name('fetch.menu.list');
    Route::post('delete-menu',[BistroMenuController::class,'destroy'])->name('delete.menu');
    Route::get('get-menu',[BistroMenuController::class,'edit'])->name('get.edit.menu');
    Route::post('update-menu',[BistroMenuController::class,'update'])->name('update.menu');


    Route::post('return-items',[ReturnItemController::class,'create'])->name('return.items');
    Route::post('Transfer-items',[TransferInventoryController::class,'create'])->name('transfer.items');
    Route::get('search-inventory',[InventoryController::class,'searchInventory'])->name('search.inventory');
});