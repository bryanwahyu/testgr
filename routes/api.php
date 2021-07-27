<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\CompanyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your AP
});
*/


Route::post('v1/login',[AuthController::class,'login']);
Route::post('v1/register',[AuthController::class,'registerAdmin']);
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('v1/auth',[AuthController::class,'get_data']);
    Route::post('v1/auth/user',[AuthController::class,'change_it_self']);
    Route::post('v1/auth/pass',[AuthController::class,'change_password']);

    Route::resource('v1/company', CompanyController::class);
    Route::resource('v1/employees', EmployeesController::class);
});
