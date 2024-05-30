<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::controller(ExpenseController::class)->prefix('expenses')->group(function () {
        Route::get('/', 'index')->name('expenses.index');
        Route::get('/show/{expense}', 'show')->name('expenses.show');
        Route::get('/create', 'create')->name('expenses.create');
        Route::post('/store', 'store')->name('expenses.store');
        Route::get('/edit/{expenseDetails}', 'edit')->name('expenses.edit');
        Route::put('/update/{expenseDetails}', 'update')->name('expenses.update');
        Route::delete('/destroy/{expense}', 'destroy')->name('expenses.destroy');
        Route::delete('destroy/details/{expenseDetails}', 'destroyExpenseDetails')->name('expenses.details.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
