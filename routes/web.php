<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengunjung\HomeController;
use App\Http\Controllers\Pengunjung\ProductController;
use App\Http\Controllers\AuthController;

// Halaman cetak laporan
Route::get('/dashboard-seller/cetaklaporan', function () {
    return view('seller.cetaklaporan');
})->name('seller.cetaklaporan');

// Halaman tambah produk
Route::get('/dashboard-seller/tambahproduk', function () {
    return view('seller.tambahproduk');
})->name('seller.tambahproduk');


// Route ke halaman Home Pengunjung (via controller)
Route::get('/', [HomeController::class, 'index']);

// Product listing / search page
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Product detail page
Route::get('/detailproduk/{id}', [ProductController::class, 'show'])->name('products.show');

// Route ke halaman Home Pengunjung
Route::get('/detailproduk', function () {
    // Artinya: Buka file "home" yang ada di dalam folder "pengunjung"
    return view('pengunjung.detailproduk');
});

Route::get('/login-seller', [AuthController::class, 'showLogin']);

// Login / Logout
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/register-seller', function () {
    // Artinya: Buka file "register" yang ada di dalam folder "pengunjung"
    return view('pengunjung.register');
});

// Seller Dashboard
Route::get('/dashboard-seller', function () {
    return view('seller.dashboard');
})->name('seller.dashboard');

Route::get('/dashboard-seller/statistics', function () {
    return view('seller.statistics');
})->name('seller.statistics');

Route::get('/dashboard-seller/produk', function () {
    return view('seller.produk');
})->name('seller.produk');

// Halaman tambah produk
Route::get('/dashboard-seller/tambahproduk', function () {
    return view('seller.tambahproduk');
})->name('seller.tambahproduk');

// Halaman cetak laporan
Route::get('/dashboard-seller/cetaklaporan', function () {
    return view('seller.cetaklaporan');
})->name('seller.cetaklaporan');

// Admin Dashboard
Route::get('/dashboard-admin', function () {
    return view('admin.dashboard');
});

// Admin Verification Routes
Route::prefix('dashboard-admin/verifikasi')->name('admin.verification.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\VerificationController::class, 'index'])->name('index');
    Route::get('/{id}', [App\Http\Controllers\Admin\VerificationController::class, 'show'])->name('show');
    Route::post('/{id}/approve', [App\Http\Controllers\Admin\VerificationController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [App\Http\Controllers\Admin\VerificationController::class, 'reject'])->name('reject');
});

Route::get('/dashboard-admin/seller-data', function () {
    return view('admin.penjual.seller_data');
});

Route::get('/dashboard-admin/reports', function () {
    return view('admin.laporan.laporan');
});

// Demo product detail (frontend-only) - no DB required
Route::get('/detailproduk/demo', function () {
    return view('pengunjung.detailproduk', compact('product', 'relatedProducts', 'reviews'));
});
