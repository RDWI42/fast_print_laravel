<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('Home_v');
// });
Route::get('/',[ProductController::class, 'index']);
Route::get('/getData',[ProductController::class, 'getData']);
Route::post('/addData',[ProductController::class, 'AddData']);
Route::put('/editData/{id}',[ProductController::class, 'EditData']);
Route::put('/hapusData/{id}',[ProductController::class, 'HapusData']);
Route::get('/call-api', [ProductController::class, 'callApi'])->name('callApi');
