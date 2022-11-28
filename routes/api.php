<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortofolioJualController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PortofolioJualAPIController;
use App\Http\Controllers\API\PortofolioBeliAPIController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
//API route for login user
Route::post('/login', [AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::get('/portofoliobeli', [PortofolioBeliAPIController::class, 'allData']);
    Route::get('/portofoliobeli/{user_id}', [PortofolioBeliAPIController::class, 'getData']);
    Route::post('/portofoliobeli/addbeli', [PortofolioBeliAPIController::class, 'insertData']);
    Route::post('/portofoliobeli/editbeli', [PortofolioBeliAPIController::class, 'editData']);
    Route::get('/portofoliobeli/delete/{id_portofolio_beli}', [PortofolioBeliAPIController::class, 'deleteData']);

    Route::get('/portofoliojual', [PortofolioJualAPIController::class, 'index']);
    Route::get('/portofoliojual/{user_id}', [PortofolioJualAPIController::class, 'getdata']);
    Route::post('/portofoliojual/addjual', [PortofolioJualAPIController::class, 'insertData']);
    Route::post('/portofoliojual/editjual', [PortofolioJualAPIController::class, 'editData']);
    Route::get('/portofoliojual/delete/{id_portofolio_jual}', [PortofolioJualAPIController::class, 'deleteData']);

    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::get('/my/route', function () {
    return 'hello';
});
