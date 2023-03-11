<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/', [LoginController::class, 'formLogin'])->name('login');
    Route::post('/', [LoginController::class, 'postLogin']);

    // Register
    Route::get('/register', [RegisterController::class, 'formRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'postRegister']);
});

Route::middleware(['auth'])->group(function () {
    // Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/store', [TransactionController::class, 'store'])->name('transaction.store');
    Route::get('/show/{id}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::post('/update', [TransactionController::class, 'update'])->name('transaction.update');
    Route::get('/delete/{id}', [TransactionController::class, 'delete'])->name('transaction.delete');
});
