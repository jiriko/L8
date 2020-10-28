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

Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index']);
Route::get('/api/tasks', [App\Http\Controllers\Api\TaskController::class, 'index']);
Route::post('/api/tasks', [App\Http\Controllers\Api\TaskController::class, 'store']);
Route::get('/api/tasks/burndown', [App\Http\Controllers\Api\TaskBurndownController::class, 'index']);
Route::post('/api/tasks/{task}/complete', [App\Http\Controllers\Api\TaskCompleteController::class, 'store']);
