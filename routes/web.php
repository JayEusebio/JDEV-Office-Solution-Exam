<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\CustomerTypeController;

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

Route::prefix('/customerType')->group( function() {
    Route::get('index', [CustomerTypeController::class, 'index']);
});

Route::prefix('/customer')->group( function() {
    Route::get('index', [CustomersController::class, 'index']);
    Route::post('store', [CustomersController::class, 'store']);
    Route::post('update/{id}', [CustomersController::class, 'update']);
    Route::post('delete/{id}', [CustomersController::class, 'destroy']);
});


