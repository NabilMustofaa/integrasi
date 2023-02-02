<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('survey')->group(function () {
    Route::get('/', [SurveyApiController::class, 'index'])->name('survey.index');
    Route::post('/', [SurveyApiController::class, 'store'])->name('survey.store');
    Route::get('/{survey}', [SurveyApiController::class, 'show'])->name('survey.show');
    Route::put('/{survey}', [SurveyApiController::class, 'update'])->name('survey.update');
    Route::delete('/{survey}', [SurveyApiController::class, 'destroy'])->name('survey.destroy');
});
