<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SellingController;
use App\Http\Controllers\Admin\TimController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Reseller\DashboardController as ResellerDashboardController;
use App\Http\Controllers\Reseller\ResellerController as ResellerResellerController;
use App\Http\Controllers\Reseller\ProfileController as ResellerProfileController;

use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Http\Controllers\Agent\TimController as AgentTimController;
use App\Http\Controllers\Agent\ProfileController as AgentProfileController;
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
        } else if (auth()->user()->role == '1') {
            return redirect()->route('reseller.dashboard.index');
        } else if (auth()->user()->role == '2') {
            return redirect()->route('agent.dashboard.index');
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

    Route::prefix('banner')->name('banner.')->group(function () {
        Route::get('', [BannerController::class, 'index'])->name('index');
        Route::post('store', [BannerController::class, 'store'])->name('store');
        Route::put('update', [BannerController::class, 'update'])->name('update');
        Route::delete('delete', [BannerController::class, 'delete'])->name('delete');
    });

    Route::prefix('product')->name('product.')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::put('update', [ProductController::class, 'update'])->name('update');
        Route::delete('delete', [ProductController::class, 'delete'])->name('delete');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::put('update', [UserController::class, 'update'])->name('update');
        Route::delete('delete', [UserController::class, 'delete'])->name('delete');
    });
    Route::prefix('tim')->name('tim.')->group(function () {
        Route::get('', [TimController::class, 'index'])->name('index');
        Route::post('storeAgent', [TimController::class, 'storeAgent'])->name('storeAgent');
        Route::get('detail/{id}', [TimController::class, 'detail'])->name('detail');
        Route::post('storeReseller', [TimController::class, 'storeReseller'])->name('storeReseller');
        Route::put('updateAgent', [TimController::class, 'updateAgent'])->name('updateAgent');
        Route::put('updateReseller', [TimController::class, 'updateReseller'])->name('updateReseller');
        Route::get('detail/{agent}/detailReseller/{reseller}', [TimController::class, 'detailReseller'])->name('detailReseller');
        Route::delete('delete', [TimController::class, 'delete'])->name('delete');
        Route::post('resetPassword', [TimController::class, 'resetPassword'])->name('resetPassword');
    });

    Route::prefix('selling')->name('selling.')->group(function () {
        Route::get('', [SellingController::class, 'index'])->name('index');
        Route::post('store', [SellingController::class, 'store'])->name('store');
        Route::delete('delete', [SellingController::class, 'delete'])->name('delete');
    });
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('changePassword', [ProfileController::class, 'changePassword'])->name('changePassword');
        Route::put('savePassword/{id}', [ProfileController::class, 'savePassword'])->name('savePassword');
    });
});

//bagian reseller
Route::prefix('reseller')->name('reseller.')->middleware(['auth', 'isReseller'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('', [ResellerDashboardController::class, 'index'])->name('index');
    });

    Route::prefix('reseller')->name('reseller.')->group(function () {
        Route::get('', [ResellerResellerController::class, 'index'])->name('index');
    });
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('changePassword', [ResellerProfileController::class, 'changePassword'])->name('changePassword');
        Route::put('savePassword/{id}', [ResellerProfileController::class, 'savePassword'])->name('savePassword');
    });
});

//bagian agent
Route::prefix('agent')->name('agent.')->middleware(['auth', 'isAgent'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('', [AgentDashboardController::class, 'index'])->name('index');
    });

    Route::prefix('tim')->name('tim.')->group(function () {
        Route::get('', [AgentTimController::class, 'index'])->name('index');
        Route::get('detail/{agent}/detailReseller/{reseller}', [AgentTimController::class, 'detailReseller'])->name('detailReseller');
    });
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('changePassword', [AgentProfileController::class, 'changePassword'])->name('changePassword');
        Route::put('savePassword/{id}', [AgentProfileController::class, 'savePassword'])->name('savePassword');
    });
});

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
