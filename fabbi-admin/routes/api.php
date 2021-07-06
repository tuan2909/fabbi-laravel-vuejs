<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\TypePatientController;
use App\Http\Controllers\Api\SpecimenController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\HealPatientController;
use App\Http\Controllers\Api\QuarantinePatientController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
    Route::post('signup', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);
});
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::resource('cities', CityController::class);
    Route::resource('type_patients', TypePatientController::class);
    Route::resource('specimens', SpecimenController::class);
    Route::resource('users', UserController::class);
    Route::resource('patients', PatientController::class);
    Route::get('patients/{id}/parents', [PatientController::class, 'getParentPatientByType']);
    Route::resource('quarantines', QuarantinePatientController::class);
    Route::get('patient_not_quarantine', [QuarantinePatientController::class, 'getListPatientNotQuarantine']);
    Route::post('logout', [LogoutController::class, 'logout']);
    Route::get('/heal_patients/{id}', [HealPatientController::class, 'getHealPatientByIdPatient']);
});
//Route::middleware('jwt.refresh')->get('/token/refresh', [LogoutController::class, 'refresh']);
