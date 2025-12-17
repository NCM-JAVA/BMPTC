	<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\Location\LocationController;
use App\Http\Controllers\Api\V1\Hazards\HazardController;
use App\Http\Controllers\Api\V1\MobileAppContent\MobileAppContentController;
use App\Http\Controllers\Api\V1\Coords\CoordinatesController;
use App\Http\Controllers\Api\V1\Feedback\FeedbackController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/greet_users', UserController::class);

Route::get('/hazards', [HazardController::class, 'getHazards']);

//States and District on the basis of hazards
//Route::get('/hazard-states/{hazard_id}', [HazardController::class, 'getHazardStates']);
//Route::get('/hazard-district/{hazard_id}/{state_id}', [HazardController::class, 'getHazardDistrict']);
Route::post('/hazard-states', [HazardController::class, 'getHazardStates']); 
Route::post('/hazard-district', [HazardController::class, 'getHazardDistrict']);
Route::post('/hazard-district/pdf', [HazardController::class, 'district_pdf']);

//Coordinates
Route::post('/v1/hazard-state-coordinates', [CoordinatesController::class, 'getHazardStateCoordinates']);
Route::post('/v1/hazard-district-coordinates', [CoordinatesController::class, 'getHazardDistrictCoordinates']);

//States and district for dropdown only
Route::get('/states', [LocationController::class, 'getStates']);
Route::get('/districts/{state_id}', [LocationController::class, 'getDistricts']);

Route::get('/mobile-app-content', [MobileAppContentController::class, 'getMobileContent']);

Route::post('/v1/feedback-form', [FeedbackController::class, 'feedbackForm']);