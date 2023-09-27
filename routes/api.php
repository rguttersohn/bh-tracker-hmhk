<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiskyQuestionAPI;
use App\Http\Controllers\TrevorCategoryAPI;


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

/** cdc yrbss data endpoints 
 * The first endpoint returns all questions.
 * The second endpoint returns a question with the matching id,
 *  the questions responses, and the avialable filters for that question based on production env
*/

Route::get('/1/{env}/yrbss/questions/', [RiskyQuestionAPI::class, 'getQuestions']);

Route::get('/1/{env}/yrbss/questions/{id}', [RiskyQuestionAPI::class, 'getQuestion']);

/** trevor project end points */

Route::get('/1/{env}/trevor/categories', [TrevorCategoryAPI::class, 'getCategories']);

Route::get('/1/{env}/trevor/categories/{id}', [TrevorCategoryAPI::class, 'getCategory']);