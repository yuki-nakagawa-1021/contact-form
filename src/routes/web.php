<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;


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

Route::get('/', [ContactController::class, 'index'])->name('contact.index');
Route::get('/confirm', function () {
    return redirect()->route('contact.index');
});
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/thanks', [ContactController::class, 'store']);

Route::post('/register', [AuthController::class, 'store']);
Route::middleware('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'store']);
});