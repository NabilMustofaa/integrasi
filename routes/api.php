<?php

use App\Http\Controllers\ExpectedAnswerApiController;
use App\Http\Controllers\QualityAssuranceTeamApiController;
use App\Http\Controllers\QuestionOptionApiController;
use App\Http\Controllers\SalesTeamApiController;
use App\Http\Controllers\StoreApiController;
use App\Http\Controllers\SurveyApiController;
use App\Http\Controllers\SurveyPlanApiController;
use App\Http\Controllers\SurveyQuestionApiController;
use App\Models\QualityAssuranceTeam;
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
    // survey
    Route::get('/', [SurveyApiController::class, 'index'])->name('survey.index');
    Route::post('/', [SurveyApiController::class, 'store'])->name('survey.store');
    Route::get('/{survey}', [SurveyApiController::class, 'show'])->name('survey.show');
    Route::put('/{survey}', [SurveyApiController::class, 'update'])->name('survey.update');
    Route::delete('/{survey}', [SurveyApiController::class, 'destroy'])->name('survey.destroy');

    // survey question
    Route::get('/{survey}/question', [SurveyQuestionApiController::class, 'index'])->name('survey.question.index');
    Route::post('/{survey}/question', [SurveyQuestionApiController::class, 'store'])->name('survey.question.store');
    Route::get('/{survey}/question/{surveyQuestion}', [SurveyQuestionApiController::class, 'show'])->name('survey.question.show');
    Route::put('/{survey}/question/{surveyQuestion}', [SurveyQuestionApiController::class, 'update'])->name('survey.question.update');
    Route::delete('/{survey}/question/{surveyQuestion}', [SurveyQuestionApiController::class, 'destroy'])->name('survey.question.destroy');
});

Route::prefix('question')->group(function () {
    // question option
    Route::get('/{surveyQuestion}/option', [QuestionOptionApiController::class, 'index'])->name('question.option.index');
    Route::post('/{surveyQuestion}/option', [QuestionOptionApiController::class, 'store'])->name('question.option.store');
    Route::get('/option/{questionOption}', [QuestionOptionApiController::class, 'show'])->name('question.option.show');
    Route::put('/option/{questionOption}', [QuestionOptionApiController::class, 'update'])->name('question.option.update');
    Route::delete('/option/{questionOption}', [QuestionOptionApiController::class, 'destroy'])->name('question.option.destroy');

    // expected answer
    Route::get('/{surveyQuestion}/expected', [ExpectedAnswerApiController::class, 'index'])->name('question.expected.index');
    Route::post('/{surveyQuestion}/expected', [ExpectedAnswerApiController::class, 'store'])->name('question.expected.store');
});

Route::prefix('store')->group(function () {
    Route::get('/', [StoreApiController::class, 'index'])->name('store.index');
    
});

Route::prefix('qa')->group(function () {
    Route::get('/', [QualityAssuranceTeamApiController::class, 'index'])->name('qa.index');
    Route::post('/', [QualityAssuranceTeamApiController::class, 'store'])->name('qa.store');
    Route::get('/{qualityAssuranceTeam}', [QualityAssuranceTeamApiController::class, 'show'])->name('qa.show');
    Route::put('/{qualityAssuranceTeam}', [QualityAssuranceTeamApiController::class, 'update'])->name('qa.update');
    Route::delete('/{qualityAssuranceTeam}', [QualityAssuranceTeamApiController::class, 'destroy'])->name('qa.destroy');

});

Route::prefix('sales')->group(function () {
    Route::get('/', [SalesTeamApiController::class, 'index'])->name('sales.index');
    Route::post('/', [SalesTeamApiController::class, 'store'])->name('sales.store');
    Route::get('/{salesTeam}', [SalesTeamApiController::class, 'show'])->name('sales.show');
    Route::put('/{salesTeam}', [SalesTeamApiController::class, 'update'])->name('sales.update');
    Route::delete('/{salesTeam}', [SalesTeamApiController::class, 'destroy'])->name('sales.destroy');
});

Route::prefix('plans')->group(function () {
    Route::get('/', [SurveyPlanApiController::class, 'index'])->name('plan.index');
    Route::post('/', [SurveyPlanApiController::class, 'store'])->name('plan.store');
});

