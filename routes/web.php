<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KameraController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[HomeController::class, 'index'])->name('home');
Route::post('/login',[AuthController::class, 'authenticate']);

Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.admin');
    });
});

Route::get('/dashboard', function () {
    return view('member');
})->middleware('auth');

Route::get('/logout',[AuthController::class, 'logout']);
