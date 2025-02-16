<?php

use App\Http\Controllers\AdminManageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerManageController;
use App\Http\Controllers\CustomerMenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [LoginController::class, 'showLoginForm']);

Auth::routes();

// 🔹 Rute Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('home.admin');
    
    // 🔹 Kategori
    Route::resource('categories', CategoryController::class);
    // Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // 🔹 Menu
    Route::resource('menu', MenuController::class)->except(['create', 'edit', 'show', 'delete']);
    Route::patch('menu/available/{menu}', [MenuController::class, 'available'])->name('menu.available');
    Route::patch('menu/unavailable/{menu}', [MenuController::class, 'unavailable'])->name('menu.unavailable');

    // 🔹 Manajemen Pesanan & Pelanggan
    Route::get('pending', [AdminManageController::class, 'pending'])->name('pending');
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('history', [AdminManageController::class, 'done'])->name('done');
    Route::put('order/{order}/pay', [OrderController::class, 'pay'])->name('order.pay');

    // 🔹 Laporan Penjualan
    Route::get('laporan/penjualan', [LaporanController::class, 'done'])->name('laporan.show');  
    Route::get('laporan/cetak', [LaporanController::class, 'laporanPenjualan'])->name('laporan.download');
});

// 🔹 Rute Customer
Route::prefix('customer')->middleware(['auth', 'role:customer'])->name('customer.')->group(function () {
    Route::get('menu', [CustomerMenuController::class, 'index'])->name('menu');
    Route::get('order', [CustomerMenuController::class, 'order'])->name('order');
    Route::post('order', [OrderController::class, 'store'])->name('order.store');
    Route::get('pending', [CustomerManageController::class, 'pending'])->name('pending');
    Route::get('history', [CustomerManageController::class, 'done'])->name('done');
});

// 🔹 Halaman Customer Umum
Route::middleware(['auth'])->group(function () {
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
});

// 🔹 Pending & History Order
Route::get('pending/{order}', [OrderController::class, 'show'])->name('pending.show');
Route::get('history/{order}', [OrderController::class, 'show'])->name('history.show');

// 🔹 Profile User
Route::middleware('auth')->group(function () {
    Route::get('profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [UserController::class, 'update'])->name('profile.update');
});
