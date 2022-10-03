<?php

use Illuminate\Support\Facades\Route;
use App\Models\Project;
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
Route::get('/projects', [\App\Http\Controllers\ProjectController::class,'index']);
Route::get('/projects/{project}', [\App\Http\Controllers\ProjectController::class,'show']);

Route::post('/projects',[\App\Http\Controllers\ProjectController::class,'store']);
