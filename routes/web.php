<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\ResellerController as MemberResellerController;
use Illuminate\Support\Facades\Auth;

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
    if (Auth::user()) {   // Check is user logged in
        if (auth()->user()->role == '0') {
            return redirect()->route('admin.dashboard.index');
        } else {
            return redirect()->route('member.dashboard.index');
        }
    } else {
        return view('auth.login');
    }

});

//BAGIAN ADMIN
Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('', [DashboardController::class, 'index'])->name('index');
    });

    Route::prefix('product')->name('product.')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::put('update', [ProductController::class, 'update'])->name('update');
        Route::delete('delete', [ProductController::class, 'delete'])->name('delete');
    });
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('', [MemberController::class, 'index'])->name('index');
        Route::post('store', [MemberController::class, 'store'])->name('store');
        Route::get('detail/{id}', [MemberController::class, 'detail'])->name('detail');
        Route::get('detail/{agent}/detailReseller/{reseller}', [MemberController::class, 'detailReseller'])->name('detailReseller');
        Route::put('update', [MemberController::class, 'update'])->name('update');
        Route::put('updateReseller', [MemberController::class, 'updateReseller'])->name('updateReseller');
        Route::post('addReseller', [MemberController::class, 'addReseller'])->name('addReseller');
        Route::delete('delete', [MemberController::class, 'delete'])->name('delete');
        Route::post('saleStore', [MemberController::class, 'saleStore'])->name('saleStore');
        Route::post('resetPassword', [MemberController::class, 'resetPassword'])->name('resetPassword');
    });
    Route::prefix('sale')->name('sale.')->group(function () {
        Route::get('', [SaleController::class, 'index'])->name('index');
        Route::delete('delete', [SaleController::class, 'delete'])->name('delete');
    });
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('changePassword', [ProfileController::class, 'changePassword'])->name('changePassword');
        Route::put('savePassword/{id}', [ProfileController::class, 'savePassword'])->name('savePassword');
    });
});


//BAGIAN MEMBER
Route::prefix('member')->name('member.')->middleware(['auth', 'isMember'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('', [MemberDashboardController::class, 'index'])->name('index');
    });

    Route::prefix('reseller')->name('reseller.')->group(function () {
        Route::get('', [MemberResellerController::class, 'index'])->name('index');
        Route::get('detail/{agent}/detailReseller/{reseller}', [MemberResellerController::class, 'detailReseller'])->name('detailReseller');
    });
});

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
