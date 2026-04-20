<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Models\Transaksi;
use App\Models\Customer;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| DASHBOARD (ROLE BASED)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    $user = auth()->user();

    if ($user->role === 'customer') {

        $customer = Customer::where('user_id', $user->id)->first();

        $transaksis = collect();

        if ($customer) {
            $transaksis = Transaksi::with('service')
                ->where('customer_id', $customer->id)
                ->latest()
                ->get();
        }

        return view('dashboard.customer', compact('transaksis'));
    }

    return match ($user->role) {
        'superadmin' => view('dashboard.superadmin'),
        'admin'      => view('dashboard.admin'),
        default      => abort(403),
    };

})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| SUPERADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:superadmin'])->group(function () {

    Route::resource('user', UserController::class);

});

/*
|--------------------------------------------------------------------------
| ADMIN + SUPERADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:superadmin,admin'])->group(function () {

    Route::resource('customer', CustomerController::class);
    Route::resource('member', MemberController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('transaksi', TransaksiController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

});

/*
|--------------------------------------------------------------------------
| CUSTOMER ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->prefix('my')->group(function () {

    Route::get('/transaksi/create', [TransaksiController::class, 'create'])
        ->name('customer.transaksi.create');

    Route::post('/transaksi', [TransaksiController::class, 'store'])
        ->name('customer.transaksi.store');

});

/*
|--------------------------------------------------------------------------
| PROFILE (SEMUA USER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

});