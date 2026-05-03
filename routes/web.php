<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/foods');

Route::get('/locale/{locale}', function (string $locale) {
    abort_unless(in_array($locale, config('app.supported_locales', ['en', 'ru', 'kk']), true), 404);

    session(['locale' => $locale]);

    return back();
})->name('locale.switch');

Route::get('/login-as/{userId}', function ($userId) {
    Auth::loginUsingId($userId);
    return redirect('/foods');
})->name('login-as');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/foods');
})->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.perform');
});

Route::get('/foods', [FoodController::class, 'index']);

Route::middleware(['auth', 'permission:food-create'])->group(function () {
    Route::get('/foods/create', [FoodController::class, 'create']);
    Route::post('/foods', [FoodController::class, 'store']);
});

Route::middleware(['auth', 'permission:food-edit'])->group(function () {
    Route::get('/foods/{id}/edit', [FoodController::class, 'edit']);
    Route::put('/foods/{id}', [FoodController::class, 'update']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::delete('/foods/{id}', [FoodController::class, 'destroy']);
});


Route::middleware(['auth', 'permission:order-create'])->group(function () {
    Route::post('/orders/{foodId}', [OrderController::class, 'store']);
});

Route::middleware(['auth', 'permission:order-list-own'])->group(function () {
    Route::get('/my-orders', [OrderController::class, 'myOrders']);
});

Route::middleware(['auth', 'permission:order-list-all'])->group(function () {
    Route::get('/orders', [OrderController::class, 'allOrders']);
});

Route::middleware(['auth', 'permission:order-status-update'])->group(function () {
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
});
