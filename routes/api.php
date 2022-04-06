<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [HomeController::class, 'login']);
Route::get('dashboard',  [HomeController::class, 'dashboard'])->middleware('protectedPage');
Route::post('logout', [HomeController::class, 'logout']);

Route::get('employees', [EmployeeController::class, 'index'])->middleware('protectedPage');
// Route::get('users', [EmployeeController::class, 'index'])->middleware('protectedPage');
Route::get('employee/{id}', [EmployeeController::class, 'show'])->middleware('protectedPage');
Route::post('employee', [EmployeeController::class, 'store'])->middleware('protectedPage');
Route::post('employee/{id}', [EmployeeController::class, 'update'])->middleware('protectedPage');
Route::delete('employee/{id}', [EmployeeController::class, 'destroy'])->middleware('protectedPage');
Route::post('searchEmployee', [EmployeeController::class, 'search'])->middleware('protectedPage');

Route::get('projects', [ProjectController::class, 'index'])->middleware('protectedPage');
Route::post('project', [ProjectController::class, 'store'])->middleware('protectedPage');
Route::post('project/{id}', [ProjectController::class, 'update'])->middleware('protectedPage');
Route::get('project/{id}', [ProjectController::class, 'show'])->middleware('protectedPage');
Route::delete('project/{id}', [ProjectController::class, 'destroy'])->middleware('protectedPage');
Route::post('searchProject', [ProjectController::class, 'search'])->middleware('protectedPage');