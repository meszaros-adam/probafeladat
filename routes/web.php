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



Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout']);


Route::get('/get_projects', [App\Http\Controllers\ProjectController::class, 'get']);
Route::get('/get_single_project', [App\Http\Controllers\ProjectController::class, 'getSingle']);
Route::post('/create_project', [App\Http\Controllers\ProjectController::class, 'add']);
Route::post('/edit_project', [App\Http\Controllers\ProjectController::class, 'edit']);
Route::post('/delete_project', [App\Http\Controllers\ProjectController::class, 'delete']);

Route::get('/', function () {
    return view('welcome');
});
