<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiskyQuestionAPI;
use App\Http\Controllers\TrevorCategoryAPI;
use App\Http\Controllers\PulseQuestionAPI;
use App\Http\Controllers\RiskyFilterAPI;
use App\Http\Controllers\RiskyResponseAPI;


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

/** CDC YRBSS RESPONSES 
 * The first endpoint returns all questions.
 * The second endpoint returns a question with the matching id,
 * The questions responses, and the avialable filters for that question based on production env
 * The third endpoint returns filters for the question
 * The fourth endpoint returns returns responses for the question
*/

Route::get('/1/{env}/yrbss/questions/', [RiskyQuestionAPI::class, 'getQuestions']);

Route::get('/1/{env}/yrbss/questions/{id}', [RiskyQuestionAPI::class, 'getQuestion']);

Route::get('/1/{env}/yrbss/questions/{id}/filters', [RiskyFilterAPI::class, 'getFilters']);

Route::get('/1/{env}/yrbss/questions/{id}/responses', [RiskyResponseAPI::class, 'getResponses']);


/** trevor project end points */

Route::get('/1/{env}/trevor/categories', [TrevorCategoryAPI::class, 'getCategories']);

Route::get('/1/{env}/trevor/categories/{id}', [TrevorCategoryAPI::class, 'getCategory']);

/** pulse survey api endpoints
 * the first endpoint returns all pulse questions
 * the second endpoint gets the pulse question and its results
 */

Route::get('/1/{env}/pulse/questions', [PulseQuestionAPI::class, 'getPulseQuestions']);

Route::get('/1/{env}/pulse/questions/{id}', [PulseQuestionAPI::class, 'getPulseQuestion']);