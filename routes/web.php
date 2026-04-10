<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PetugasPembelianController;
use Illuminate\Http\Request;
use App\Models\Order;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // PRODUK
    Route::get('/produk', [ProductController::class, 'index']);
    Route::post('/produk', [ProductController::class, 'store']);
    Route::put('/produk/{id}', [ProductController::class, 'update']);
    Route::delete('/produk/{id}', [ProductController::class, 'destroy']);
    Route::put('/produk/stock/{id}', [ProductController::class, 'updateStock']);

    // PEMBELIAN
    Route::get('/pembelian', [OrderController::class, 'index']);
    Route::get('/pembelian/{id}', [OrderController::class, 'show']);
    Route::get('/pembelian-export', [OrderController::class, 'export']);

    // USER
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
});

// petugas
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->group(function () {

    Route::get('/dashboard', [PetugasController::class, 'dashboard']);
    Route::get('/produk', [PetugasController::class, 'produk']);

    Route::get('/pembelian/create', [PetugasPembelianController::class, 'create']);
    Route::post('/checkout', [PetugasPembelianController::class, 'checkout']);
    Route::post('/pembelian', [PetugasPembelianController::class, 'store']);

    Route::get('/pembelian/{id}', [PetugasPembelianController::class, 'show']);
    Route::get('/pembelian-export', [OrderController::class, 'export']);

    Route::get('/struk/{id}', [PetugasPembelianController::class, 'struk']);

    Route::get('/checkout', function () {
        return redirect('/petugas/pembelian/create');
    });

    Route::get('/pembelian', [PetugasPembelianController::class, 'index']);
    Route::get('/cek-member', function (Request $r) {

        $count = Order::where('phone', $r->phone)->count();

        $totalPoints = Order::where('phone', $r->phone)->sum('points_earned')
            - Order::where('phone', $r->phone)->sum('points_used');

        return response()->json([
            'is_member_old' => $count > 0,
            'points' => $totalPoints
        ]);
    });
});

require __DIR__ . '/auth.php';
