<?php

use App\Http\Controllers\QualityAssuranceTeamController;
use App\Http\Controllers\SalesTeamController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SurveyController; 
use App\Http\Controllers\SurveyPlanController;
use App\Http\Controllers\SurveyNewController;
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
    Route::get('/new', [SurveyNewController::class, 'index'])->name('survey.new.index');
    Route::get('/new/{survey}/edit', [SurveyNewController::class, 'edit'])->name('survey.new.show');
});

Route::prefix('store')->group(function () {
    Route::get('/', [StoreController::class, 'index'])->name('store.index');
    Route::get('/create', [StoreController::class, 'create'])->name('store.create');
    Route::post('/', [StoreController::class, 'store'])->name('store.store');
});

Route::prefix('qa')->group(function () {
    Route::get('/', [QualityAssuranceTeamController::class, 'index'])->name('qa.index');
});

Route::prefix('sales')->group(function () {
    Route::get('/', [SalesTeamController::class, 'index'])->name('sales.index');
});

Route::prefix('plan')->group(function () {
    Route::get('/', [SurveyPlanController::class, 'index'])->name('plan.index');
    Route::get('/create', [SurveyPlanController::class, 'create'])->name('plan.create');
    Route::get('/{plan}', [SurveyPlanController::class, 'show'])->name('plan.show');
});

