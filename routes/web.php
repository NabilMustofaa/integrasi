<?php

use App\Http\Controllers\StoreController;
use App\Http\Controllers\SurveyController;
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

Route::prefix('survey')->group(function () {
    Route::get('/', [SurveyController::class, 'index'])->name('survey.index');
    Route::get('/create', [SurveyController::class, 'create'])->name('survey.create');
});

Route::prefix('store')->group(function () {
    Route::get('/', [StoreController::class, 'index'])->name('store.index');
    Route::get('/create', [StoreController::class, 'create'])->name('store.create');
});

