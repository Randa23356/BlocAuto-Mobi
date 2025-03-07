<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

// Rute untuk kendaraan
Route::get('/vehicle', [VehicleController::class, 'index'])->name('vehicle.index');
Route::get('/vehicle/create', [VehicleController::class, 'create'])->name('vehicle.create');
Route::get('/vehicle/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicle.edit');
Route::put('/vehicle/{vehicle}', [VehicleController::class, 'update'])->name('vehicle.update');
Route::post('/vehicle', [VehicleController::class, 'store'])->name('vehicle.store');
Route::delete('/vehicle/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicle.destroy');

// Rute untuk pelanggan
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::get('/customer/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
Route::delete('/customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');

// Rute untuk suku cadang
Route::get('/sparepart', [SparePartController::class, 'index'])->name('spare_part.index');
Route::get('/sparepart/create', [SparePartController::class, 'create'])->name('spare_part.create');
Route::get('/sparepart/{sparePart}/edit', [SparePartController::class, 'edit'])->name('spare_part.edit');
Route::put('/sparepart/{sparePart}', [SparePartController::class, 'update'])->name('spare_part.update');
Route::post('/sparepart', [SparePartController::class, 'store'])->name('spare_part.store');
Route::delete('/sparepart/{sparePart}', [SparePartController::class, 'destroy'])->name('spare_part.destroy');

// Rute untuk transaksi
Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transaction.create');
Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transaction.edit');
Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transaction.update');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transaction.store');
Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transaction.destroy');

// Rute untuk history
Route::get('/history', [TransactionController::class, 'history'])->name('history.index');
