<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testController;
use App\Http\Controllers\crudController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get', [testController::class,'test']);
Route::post('/add', [testController::class,'add']);
Route::get('/get/{id}', [testController::class,'getbyid']);


Auth::routes();
Route::post('login',[testController::class,'login']);
Route::post('logout',[testController::class,'destroy']);
Route::post('create',[crudController::class,'create']);
Route::get('getcrud',[crudController::class,'get']);