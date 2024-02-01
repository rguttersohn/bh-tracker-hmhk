<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiskyQuestionAPI;
use App\Http\Controllers\TrevorCategoryAPI;
use App\Http\Controllers\PulseQuestionAPI;
use App\Http\Controllers\RiskyFilterAPI;
use App\Http\Controllers\RiskyResponseAPI;
use App\Http\Controllers\OMHDataAPI;


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


/***
 * 
 *omh data endpoints
 *
 * first returns omh data at the state level by year
 * second returns omh data at the regional level. can be filtered by year and region
 * third returns omh data at the county level. can be filtered by year and county
 * 
 */

Route::get('app/1/{env}/omh/datasets', [OMHDataAPI::class, 'getDatasets']);
Route::get('app/1/{env}/omh/datasets/{dataset_id}', [OMHDataAPI::class, 'getData']);
Route::get('app/1/{env}/omh/datasets/{dataset_id}/state', [OMHDataAPI::class, 'getStateData']);
Route::get('app/1/{env}/omh/datasets/{dataset_id}/regions', [OMHDataAPI::class, 'getRegionsData']);
Route::get('app/1/{env}/omh/datasets/{dataset_id}/regions/{region_id}', [OMHDataAPI::class, 'getRegionData']);
Route::get('app/1/{env}/omh/datasets/{dataset_id}/counties', [OMHDataAPI::class, 'getCountiesData'] );
Route::get('app/1/{env}/omh/datasets/{dataset_id}/counties/{county_id}', [OMHDataAPI::class, 'getCountyData'] );
Route::get('app/1/{env}/omh/datasets/{dataset_id}/map/{year}', [OMHDataAPI::class, 'getCountyMapData'] );

