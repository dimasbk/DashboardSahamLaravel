<?php

use App\Http\Controllers\PlanController;
use App\Http\Controllers\SekuritasController;
use App\Http\Controllers\TechnicalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortofolioBeliController;
use App\Http\Controllers\PortofolioJualController;
use App\Http\Controllers\ReportBeliController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportJualController;
use App\Http\Controllers\FundamentalController;
use App\Http\Controllers\StockAPIController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AnalystController;





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
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/portofoliobeli', [PortofolioBeliController::class, 'getDataAdmin']);
    Route::get('/portofoliobeli/edit/{id_portofolio_beli}', [PortofolioBeliController::class, 'getEditAdmin']);
    Route::post('/portofoliobeli/editbeli', [PortofolioBeliController::class, 'editDataAdmin']);
    Route::get('/portofoliobeli/delete/{id_portofolio_beli}', [PortofolioBeliController::class, 'deleteDataAdmin']);

    Route::get('/portofoliojual', [PortofolioJualController::class, 'getDataAdmin']);
    Route::get('/portofoliojual/edit/{id_portofolio_jual}', [PortofolioJualController::class, 'getEditAdmin']);
    Route::post('/portofoliojual/editjual', [PortofolioJualController::class, 'editDataAdmin']);
    Route::get('/portofoliojual/delete/{id_portofolio_jual}', [PortofolioJualController::class, 'deleteDataAdmin']);

    Route::get('/emiten', [StockAPIController::class, 'getDataAdmin']);
    Route::get('/emiten/update', [StockAPIController::class, 'updateStock']);
    Route::get('/emiten/delete/{emiten}', [StockAPIController::class, 'delete']);

    Route::get('/post', [PostController::class, 'getuserPostAdmin']);
    Route::get('/post/edit/{id}', [PostController::class, 'editPostAdmin']);
    Route::post('/post/edit', [PostController::class, 'editAdmin']);
    Route::get('/post/delete/{id}', [PostController::class, 'deletePostAdmin']);

    Route::get('/sekuritas', [SekuritasController::class, 'index']);
    Route::post('/sekuritas/create', [SekuritasController::class, 'create']);
    Route::get('/sekuritas/edit/{id}', [SekuritasController::class, 'edit']);
    Route::post('/sekuritas/update', [SekuritasController::class, 'update']);
    Route::get('/sekuritas/delete/{id}', [SekuritasController::class, 'delete']);

    Route::get('/fundamental/{emiten}', [FundamentalController::class, 'index']);
    Route::get('/fundamental/edit/{id_input}', [FundamentalController::class, 'edit']);
    Route::get('/fundamental/delete/{id_input}', [FundamentalController::class, 'delete']);
    Route::post('/fundamental/insert', [FundamentalController::class, 'insert']);
    Route::post('/fundamental/update', [FundamentalController::class, 'update']);

    Route::get('/request', [AnalystController::class, 'adminRequest']);
    Route::get('/request/{id_request}/accept', [AnalystController::class, 'accept']);
    Route::get('/request/{id_request}/reject', [AnalystController::class, 'reject']);
});

Route::get('/analyst', [AnalystController::class, 'index']);

Route::get('/portofoliobeli/analyst/{user_id}', [PortofolioBeliController::class, 'getdataAnalyst']);
Route::get('/portofoliojual/analyst/{user_id}', [PortofolioJualController::class, 'getdataAnalyst']);

Route::get('/portofoliojual', [PortofolioJualController::class, 'getdata']);
Route::get('/portofoliojual/create', [PortofolioJualController::class, 'create']);
Route::post('/portofoliojual/addjual', [PortofolioJualController::class, 'insertData']);
Route::get('/portofoliojual/edit/{id_portofolio_jual}', [PortofolioJualController::class, 'getEdit']);
Route::post('/portofoliojual/editjual', [PortofolioJualController::class, 'editData']);
Route::get('/portofoliojual/delete/{id_portofolio_jual}', [PortofolioJualController::class, 'deleteData']);

Route::get('/portofoliobeli', [PortofolioBeliController::class, 'getData']);
Route::get('/portofoliobeli/create', [PortofolioBeliController::class, 'create']);
Route::post('/portofoliobeli/addbeli', [PortofolioBeliController::class, 'insertData']);
Route::get('/portofoliobeli/edit/{id_portofolio_beli}', [PortofolioBeliController::class, 'getEdit']);
Route::post('/portofoliobeli/editbeli', [PortofolioBeliController::class, 'editData']);
Route::get('/portofoliobeli/delete/{id_portofolio_beli}', [PortofolioBeliController::class, 'deleteData']);

Route::get('/report/{year}', [ReportController::class, 'report']);
Route::get('/portosemua', [ReportController::class, 'portosemua']);
Route::get('/report', [ReportController::class, 'getYear']);
Route::get('/reportporto/range', [ReportController::class, 'reportRange']);
Route::get('/reportporto', [ReportController::class, 'range']);
Route::get('/report/{year}/{emiten}', [ReportController::class, 'detailReport']);

Route::get('/stock', [StockAPIController::class, 'index']);
Route::get('/chart/{ticker}', [ChartController::class, 'index']);
Route::get('/chart/oneWeek/{ticker}', [ChartController::class, 'oneWeek']);
Route::get('/chart/oneMonth/{ticker}', [ChartController::class, 'oneMonth']);
Route::get('/chart/oneYear/{ticker}', [ChartController::class, 'oneYear']);
Route::get('/chart/threeYear/{ticker}', [ChartController::class, 'threeYear']);
Route::get('/technical/{ticker}', [ChartController::class, 'technical']);

Route::get('/technical', [TechnicalController::class, 'index']);
Route::get('/trend', [TechnicalController::class, 'trend']);
Route::get('/search/technical', [TechnicalController::class, 'technical']);

Route::get('/plan/manage', [PlanController::class, 'index']);
Route::get('/plan/create', [PlanController::class, 'create']);
Route::post('/plan/insert', [PlanController::class, 'insert']);
Route::get('/plan/edit/{id}', [PlanController::class, 'edit']);
Route::get('/plan/delete/{id}', [PlanController::class, 'delete']);



Route::post('/plan', [AnalystController::class, 'plan']);
Route::post('/subscribe', [AnalystController::class, 'subscribe']);
Route::get('/subscribe/update/{id}', [AnalystController::class, 'update']);
Route::get('/subscribe/delete/{id}', [AnalystController::class, 'delete']);
Route::get('/getPaymentToken', [AnalystController::class, 'pay']);
Route::post('/profile/mini', [AnalystController::class, 'profileMini']);
Route::get('/profile/{id}', [AnalystController::class, 'profile']);
Route::get('/profile', [UserController::class, 'index']);
Route::post('/profile/update', [UserController::class, 'update']);
Route::get('/profile/request/analyst', [UserController::class, 'request']);
Route::get('/delete-photo', [UserController::class, 'deletePhoto']);

Route::get('/post/analyst/{id}', [PostController::class, 'analystPost']);
Route::get('/post/view/{id}', [PostController::class, 'view']);

Route::get('/post/view', [PostController::class, 'getPost']);
Route::get('/post/manage', [PostController::class, 'getuserPost']);
Route::get('/post/create', [PostController::class, 'create']);
Route::post('/post/add', [PostController::class, 'addPost']);
Route::get('/post/edit/{id}', [PostController::class, 'editPost']);
Route::post('/post/edit', [PostController::class, 'edit']);
Route::get('/post/delete/{id}', [PostController::class, 'deletePost']);


Route::get('/reportbeli/detail/{user_id}/{tahun}', [ReportBeliController::class, 'getData']);
Route::get('/reportbeli/{user_id}', [ReportBeliController::class, 'getYear']);

Route::get('/reportjual/detail/{user_id}/{tahun}', [ReportJualController::class, 'getData']);
Route::get('/reportjual/{user_id}', [ReportJualController::class, 'getYear']);


Route::get('/updatestock', [StockAPIController::class, 'updateStock']);


Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/abc', [LandingPageController::class, 'technical']);
Route::get('/landing-page', [LandingPageController::class, 'index']);
Route::get('/post', [LandingPageController::class, 'post']);
Route::get('/search', [LandingPageController::class, 'emitenSearch']);
Route::get('/search/data', [LandingPageController::class, 'emitenList']);
Route::get('/emiten/{emiten}', [LandingPageController::class, 'emitenData']);
Route::get('/emiten/technical/{emiten}', [TechnicalController::class, 'getChartData']);
Route::get('/emiten/technical/chart/get', [TechnicalController::class, 'technicalChart']);
Route::get('/emiten/fundamental/chart/get', [LandingPageController::class, 'getFundamental']);
Route::get('/emiten/{emiten}/fundamental', [LandingPageController::class, 'fundamental']);
Route::get('/news', [LandingPageController::class, 'news']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index']);
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index']);