<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SurveyController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

   Route::group(['prefix' => 'users'], function () {
        Route::post('signup',[UserController::class, 'signup']); 
   });

   Route::post('create/survey',[SurveyController::class, 'survey']); 
   Route::post('edit-survey',[SurveyController::class, 'edit_survey']);  
   Route::get('respondent-survey-list',[SurveyController::class, 'respondent_survey_list']);   