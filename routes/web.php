<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortofolioBeliController;
use App\Http\Controllers\PortofolioJualController;
use App\Http\Controllers\ReportBeliController;
use App\Http\Controllers\ReportJualController;
use App\Http\Controllers\FundamentalController;
use App\Http\Controllers\StockAPIController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::resource('portobeli',PortofolioBeliController::class);
Route::get('/portofoliobeli/{user_id}', [PortofolioBeliController::class, 'getData']);
Route::post('/portofoliobeli/addbeli', [PortofolioBeliController::class, 'insertData']);
Route::get('/portofoliobeli/edit/{id_portofolio_beli}', [PortofolioBeliController::class, 'getEdit']);
Route::post('/portofoliobeli/editbeli', [PortofolioBeliController::class, 'editData']);
Route::get('/portofoliobeli/delete/{id_portofolio_beli}', [PortofolioBeliController::class, 'deleteData']);


Route::get('/portofoliojual/{user_id}', [PortofolioJualController::class, 'getdata']);
Route::post('/portofoliojual/addjual', [PortofolioJualController::class, 'insertData']);
Route::get('/portofoliojual/edit/{id_portofolio_jual}', [PortofolioJualController::class, 'getEdit']);
Route::post('/portofoliojual/editjual', [PortofolioJualController::class, 'editData']);
Route::get('/portofoliojual/delete/{id_portofolio_jual}', [PortofolioJualController::class, 'deleteData']);


Route::get('/reportbeli/detail/{user_id}/{tahun}', [ReportBeliController::class, 'getData']);
Route::get('/reportbeli/{user_id}', [ReportBeliController::class, 'getYear']);

Route::get('/reportjual/detail/{user_id}/{tahun}', [ReportJualController::class, 'getData']);
Route::get('/reportjual/{user_id}', [ReportJualController::class, 'getYear']);


Route::get('/fundamental', [StockAPIController::class, 'index']);
Route::get('/fundamental/{emiten}', [StockAPIController::class, 'stock']);


Route::get('/testreg', function () {
    return view('auth/register1');
});

Route::get('/testlogin', function () {
    return view('auth/login1');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
