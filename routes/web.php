<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Models\Employee;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;

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
Route::get('/',  [HomeController::class, 'home'])->name('home');
Route::get('/dashboard',  [HomeController::class, 'dashboard'])->name('dashboard');
Auth::routes(['register' => false]);

Route::resource("/employee", EmployeeController::class);

Route::put('/employee', [EmployeeController::class,'index'])->name('searchEmployee');

// Route::get('/dropzone', 'EmployeeController@dropzone');
Route::post('/document_upload', [EmployeeController::class, 'document_upload']);
Route::post('/remove_tempfile', [EmployeeController::class, 'remove_tempfile']);
Route::resource("/project", ProjectController::class);
Route::put('/project', [ProjectController::class,'index'])->name('searchProject');




