<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'handleAdmin'])->name('admin.route')->middleware('admin');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/user/{userId}', [App\Http\Controllers\HomeController::class, 'getUser'])->name('admin.getUser')->middleware('admin');
Route::post('/user/{userId}', [App\Http\Controllers\HomeController::class, 'updateUser'])->name('admin.user.update')->middleware('admin');
Route::delete('/user/{userId}', [App\Http\Controllers\HomeController::class, 'deleteUser'])->name('admin.user.destroy')->middleware('admin');
