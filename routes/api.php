<?php

use App\Http\Controllers\API\FundamentalAPIController;
use App\Http\Controllers\API\PostAPIController;
use App\Http\Controllers\API\TechnicalAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortofolioJualController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PortofolioJualAPIController;
use App\Http\Controllers\API\PortofolioBeliAPIController;
use App\Http\Controllers\API\ReportAPIController;
use App\Http\Controllers\API\SekuritasController;
use App\Http\Controllers\API\PortofolioAPIController;
use App\Http\Controllers\API\AnalystAPIController;
use App\Http\Controllers\API\LandingPageController;

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


Route::get('/subscribe/callback', [AnalystController::class, 'paymentCallback']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::get('/coba', [ReportAPIController::class, 'coba']);
Route::get('/luar', [ReportAPIController::class, 'luar']);


Route::get('trends', [LandingPageController::class, 'trendSaham']);

Route::post('/register', [AuthController::class, 'register']);
//API route for login user
Route::post('/login', [AuthController::class, 'login']);

//contoh param request = {'param' => 'ldr', 'comparison' => '>', 'num' => 5, 'start' => yyyy-mm-dd, 'end' => yyyy-mm-dd}
Route::get('/search/technical/saham', [TechnicalAPIController::class, 'technical']);
Route::get('/search/technicallama/saham', [TechnicalAPIController::class, 'technical_lama']);


Route::get('/report/{user_id}', [ReportAPIController::class, 'getYear']);

//contoh param request = {'from' => yyyy-mm-dd, 'to' => yyyy-mm-dd, 'user_id' => id}
Route::get('/reportporto/range', [ReportAPIController::class, 'reportRange']);


Route::get('/post/analyst/{id}', [PostAPIController::class, 'analystPost']);
Route::get('/post/view/{id}', [PostAPIController::class, 'view']);
Route::get('/postt', [PostAPIController::class, 'post']);




Route::get('/emiten/fundamental/{emiten}', [TechnicalAPIController::class, 'fundamentall']);
Route::get('/emiten/fundatabel/{emiten}', [TechnicalAPIController::class, 'fundamentaltabel']);

Route::get('/porto/semua/ya', [ReportAPIController::class, 'reporttkuloh']);




//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    Route::post('/request', [AnalystAPIController::class, 'requestAnalyst']);
    Route::get('/requestuser', [AnalystAPIController::class, 'checkUserRequest']);

    Route::get('/report/{year}/{emiten}', [ReportAPIController::class, 'DetailReportt']);

    Route::get('/portosemuaa/{year}/{emiten}', [ReportAPIController::class, 'DetailReport']);
    Route::get('/analystExisting', [AnalystAPIController::class, 'getAnalystExisting']);
    Route::get('/analyst', [AnalystAPIController::class, 'getAnalyst']);
    Route::get('/admin', [AnalystAPIController::class, 'getAdmin']);

    Route::get('/profile/{id}', [AnalystAPIController::class, 'profile']);
    Route::get('/profile/portobeli/{user_id}', [AnalystAPIController::class, 'getdataAnalystBeli']);
    Route::get('/profile/portojual/{user_id}', [AnalystAPIController::class, 'getdataAnalystJual']);



    Route::get('/detailsubscribe/{id}', [AnalystAPIController::class, 'subscribe']);
    Route::get('/nama/userku', [AnalystAPIController::class, 'namaUser']);
    // Route::get('/plan', [AnalystAPIController::class, 'plan']);
    Route::post('/plan/{id}', [AnalystAPIController::class, 'planApi']);

    Route::get('/plan/manage', [AnalystAPIController::class, 'index']);
    //Route::get('/plan/create', [AnalystAPIController::class, 'create']);
    Route::post('/addPlan', [PortofolioAPIController::class, 'insertPlan']);
    Route::post('/editPlanSendiri', [AnalystAPIController::class, 'editPlan']);
    Route::post('/editProfile', [AnalystAPIController::class, 'editProfile']);
    Route::get('/plan/delete/{id_price}', [AnalystAPIController::class, 'delete']);

    Route::post('/createPayment', [AnalystAPIController::class, 'pay']);
    Route::post('/subscribed/setPaid/{id}', [AnalystAPIController::class, 'setSubscribedUser']);

    // Route::get('/reportdetail/{year}', [ReportAPIController::class, 'reportt']);

    Route::get('/post/delete/{id_post}', [PostAPIController::class, 'deletePostt']);

    Route::get('/post/managee', [PostAPIController::class, 'getuserPostt']);
    //baru ditambahin api, blm jadi
    Route::post('/post/add', [PostAPIController::class, 'addPost']);

    Route::get('/post/delete/{id_post}', [PostAPIController::class, 'deletePostt']);

    Route::get('/post/managee', [PostAPIController::class, 'getuserPostt']);
    //baru ditambahin api, blm jadi
    Route::post('/post/add', [PostAPIController::class, 'addPost']);

    Route::get('/post/view/', [PostAPIController::class, 'vieww']);

    Route::get('/post', [PostAPIController::class, 'postt']);


    Route::post('/post/edit', [PostAPIController::class, 'edit']);



    //Route::get('/emiten/{emiten}', [FundamentalAPIController::class, 'emitenDataa']);

    //Route::get('/emiten/{emiten}', [FundamentalAPIController::class, 'emitenDataa']);
    Route::get('/emiten/{emiten}', [FundamentalAPIController::class, 'emitenDataa']);
    Route::get('/emiten/technical/{emiten}', [TechnicalAPIController::class, 'getChartData']);
    Route::get('/emiten/technical/chart/get', [TechnicalAPIController::class, 'technicalChart']);
    Route::get('/emiten/fundamental/chart/get', [TechnicalAPIController::class, 'getFundamental']);




    Route::get('/trending', [FundamentalAPIController::class, 'trend']);

   // Route::get('/report', [ReportAPIController::class, 'getYearr']);

    Route::get('/porto/semua', [ReportAPIController::class, 'reporttku']);
    Route::get('/reporthistory/{year}', [ReportAPIController::class, 'reportHistory']);



    Route::get('/emiten', [FundamentalAPIController::class, 'emitenDataa']);

    Route::get('/trending', [FundamentalAPIController::class, 'trend']);

    Route::get('/report', [ReportAPIController::class, 'getYearr']);
    Route::get('/this/year', [ReportAPIController::class, 'luar']);


   // Route::get('/portosemua', [ReportAPIController::class, 'reportt']);

    Route::get('/portosemuaa', [ReportAPIController::class, 'DetailReportt']);


    Route::get('/portofolio/beli', [PortofolioAPIController::class, 'getPortoBeli']);

    Route::get('/technical/jenistrend', [PortofolioAPIController::class, 'getJenisTrend']);

    Route::get('/company', [PortofolioAPIController::class, 'company']);

    Route::post('/notifsubs', [PortofolioAPIController::class, 'getSubscribe']);


    Route::get('/requestt', [AnalystAPIController::class, 'request']);

    Route::post('/history/subscribe', [PortofolioAPIController::class, 'getSubs']);


    Route::get('/portofoliojual/analyst/{user_id}', [AnalystAPIController::class, 'getdataAnalystJual']);


    Route::post('/portofolio/paytagihan', [PortofolioAPIController::class, 'payTagihan']);
    Route::post('/portofolio/tagihan', [PortofolioAPIController::class, 'getTagihan']);
    Route::get('/portofolio/paymentchannel', [PortofolioAPIController::class, 'getPaymentChannels']);
    Route::get('/portofolio/sekuritas', [PortofolioAPIController::class, 'getSekuritas']);
    Route::get('/portofolio/jenis', [PortofolioAPIController::class, 'getAllJenisSaham']);
    Route::get('/portofolio', [PortofolioAPIController::class, 'allData']);
    Route::get('/portofolioo', [PortofolioAPIController::class, 'PortoJual']);
    Route::post('/portofolio/subs', [PortofolioAPIController::class, 'getAnalystData']);
    Route::post('/portofolio/subscribe', [PortofolioAPIController::class, 'subscribe']);
    Route::post('/portofolio/unsubscribe', [PortofolioAPIController::class, 'unsubscribe']);
    Route::post('/portofolio/analystporto', [PortofolioAPIController::class, 'getAnalystPorto']);
    Route::get('/portofolio/subuser', [PortofolioAPIController::class, 'getSubUser']);
    Route::get('/portofolio/analyst', [PortofolioAPIController::class, 'getAnalyst']);
    Route::post('/portofolio/checksubcription', [PortofolioAPIController::class, 'checkSubscription']);
    // Route::post('/portofolio/buy', [PortofolioAPIController::class, 'buyData']);
    // Route::get('/portofolio/sell', [PortofolioAPIController::class, 'sellData']);
    // Route::get('/portofolio/{user_id}', [PortofolioAPIController::class, 'getData']);
    Route::post('/portofolio/add', [PortofolioAPIController::class, 'insertData']);
    Route::post('/portofolio/editbeli', [PortofolioAPIController::class, 'editDataBeli']);
    Route::post('/portofolio/editjual', [PortofolioAPIController::class, 'editDataJual']);
    Route::post('/portofolio/delete', [PortofolioAPIController::class, 'deleteData']);
    Route::post('/berita', [HomeController::class, 'index']);



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

    Route::get('/reportbeli/detail/{user_id}/{tahun}', [ReportAPIController::class, 'getBelireport']);

    Route::get('/reportjual/detail/{user_id}/{tahun}', [ReportAPIController::class, 'getJualreport']);

    Route::get('/belireport', [ReportAPIController::class, 'getReportBeli']);
    Route::get('/report/{user_id}/{tahun}', [ReportAPIController::class, 'getReport']);

    Route::get('/portofolio/sekuritas', [SekuritasController::class, 'getSekuritas']);
    Route::get('/portofolio/jenis', [SekuritasController::class, 'getAllJenisSaham']);


    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::get('/my/route', function () {
    return 'hello';
});
