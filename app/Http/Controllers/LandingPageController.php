<?php

namespace App\Http\Controllers;

use App\Models\SubscriberModel;
use Illuminate\Http\Request;
use App\Models\PostModel;
use App\Models\SahamModel;
use App\Models\InputFundamentalModel;
use App\Models\OutputFundamentalModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index()
    {
        $post = PostModel::where('tag', 'public')
            ->orderBy('created_at', 'DESC')
            ->take(3)->get()->toArray();

        $topGainers = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('goapi.apikey')
            ])->get('https://api.goapi.id/v1/stock/idx/top_gainer')->json();

        $topGainers = array_splice($topGainers['data']['results'], 0, 10);

        $topLosers = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('goapi.apikey')
            ])->get('https://api.goapi.id/v1/stock/idx/top_loser')->json();

        $topLosers = array_splice($topLosers['data']['results'], 0, 10);

        $trends = $this->technical();
        return view('landingPage/landing_page', compact(['post', 'topGainers', 'topLosers', 'trends']));
        //return view('landingPage/landing_page', compact(['post']));
    }

    public function technical()
    {
        $trends = [];
        $stocks = ['BBCA', 'BRIS', 'GOTO', 'ANTM', 'ACES', 'ROTI'];
        foreach ($stocks as $stock) {
            //$today = date("Y-m-d");
            $todayDate = '2023-04-01';
            $yearBefore = date('Y-m-d', strtotime($todayDate . ' -1 year'));
            $response = Http::acceptJson()
                ->withHeaders([
                    'X-API-KEY' => config('goapi.apikey')
                ])->get('https://api.goapi.id/v1/stock/idx/' . $stock . '/historical', [
                        'to' => $todayDate,
                        'from' => $yearBefore
                    ])->json();

            $data = $response['data']['results'];
            $data_historical = array_reverse($data);
            $prices50 = [];
            $prices200 = [];
            $prices14 = [];

            for ($i = 0; $i < 50; $i++) {
                array_push($prices50, $data[$i]['close']);
            }

            for ($i = 0; $i < 200; $i++) {
                array_push($prices200, $data[$i]['close']);
            }

            for ($i = 0; $i < 14; $i++) {
                array_push($prices14, $data[$i]['close']);
            }

            $ma50 = array_sum($prices50) / 50;
            $ma200 = array_sum($prices200) / 200;

            if ($ma50 > $ma200) {
                $change = $ma50 / $ma200;
                $array = ["ticker" => "{$stock}", "trend" => "uptrend", "change" => "{$change}"];
                array_push($trends, $array);
            } else if ($ma50 < $ma200) {
                $change = $ma200 / $ma50;
                $array = ["ticker" => "{$stock}", "trend" => "downtrend", "change" => "{$change}"];
                array_push($trends, $array);
            } else {
                $array = ["ticker" => "{$stock}", "trend" => "sideways", "change" => "0"];
                array_push($trends, $array);
            }

        }
        return $trends;
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $trends
        // ], 200);
        //return response()->json(['messsage'=>'Berhasil', 'data'=>$trends]);
    }

    public function post()
    {
        $postData = PostModel::where('tag', 'public')->join('users', 'tb_post.id_user', '=', 'users.id')->get();

        if (Auth::check()) {
            $analystId = [];
            $analyst = SubscriberModel::where('id_subscriber', Auth::id())->where('status', 'subscribed')->get();

            foreach ($analyst as $analysts) {
                array_push($analystId, $analysts->id_analyst);
            }

            $postSub = PostModel::where('tag', 'private')->whereIn('id_user', $analystId)->join('users', 'tb_post.id_user', '=', 'users.id')->get();

            $postData = $postData->merge($postSub);
            //dd($postData);

            return view('landingPage/post', compact(['postData']));
        } else {

            return view('landingPage/post', compact(['postData']));
        }
    }

    public function news()
    {

        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => 'fe4bd0445ab2472281d6ac636d5d426d'
            ])->get('https://newsapi.org/v2/everything', [
                    'q' => 'saham OR IHSG OR emiten OR IPO OR shareholder NOT Bola ',
                    'sortBy' => 'publishedAt',
                    'language' => 'id',
                    'searchIn' => 'content',
                    'pageSize' => '25'
                ])->json();

        $berita = $response['articles'];
        //dd($berita);

        return view('landingPage/news', ['data' => $berita]);
    }

    public function emitenList()
    {
        $emiten = SahamModel::pluck('nama_saham');


        return $emiten;
    }

    public function emitenSearch()
    {
        $data = SahamModel::paginate(25);
        return view('landingPage/emitenSearch', compact(['data']));
    }

    public function getFundamental(Request $request)
    {
        $ticker = $request->ticker;
        $emiten = SahamModel::where('nama_saham', $ticker)->value('id_saham');
        $input = InputFundamentalModel::where('tb_input.id_saham', $emiten)
            ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
            ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
            ->latest('tahun')->get();

        $inputData = $input->toArray();
        $outputData = [];
        $dataFundamental = [];
        $simpanan = [];

        foreach ($input as $data) {
            $output = OutputFundamentalModel::where('id_input', $data->id_input)
                ->join('tb_detail_output', 'tb_output.id_detail_output', '=', 'tb_detail_output.id_output')
                ->first();

            $inputLoop = InputFundamentalModel::where('tb_input.id_input', $data->id_input)
                ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
                ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
                ->latest('tahun')->first();

            if ($output->peg == null) {
                $peg = 0;
            } else {
                $peg = $output->peg;
            }

            if ($output->der == null) {
                $der = 0;
            } else {
                $der = $output->der;
            }

            if ($simpanan == null) {
                $simpanan = 0;
            } else {
                $simpanan = $simpanan;
            }

            // if ($output->pinjaman == null) {
            //     $pinjaman = 0;
            // } else {
            //     $pinjaman = $output->pinjaman;
            // }

            // if ($output->id_jenis_fundamental == null) {
            //     $id_jenis_fundamental = 0;
            // } else {
            //     $id_jenis_fundamental = $output->id_jenis_fundamental;
            // }

            if ($output->loan_to_depo_ratio == null) {
                $loan_to_depo_ratio = 0;
            } else {
                $loan_to_depo_ratio = $output->loan_to_depo_ratio;
            }
            $dataOutput = array(
                "der" => $der * 100,
                "loan_to_depo_ratio" => $loan_to_depo_ratio * 100,
                "annualized_roe" => $output->annualized_roe * 100,
                "dividen" => $output->dividen,
                "dividen_yield" => $output->dividen_yield * 100,
                "dividen_payout_ratio" => $output->dividen_payout_ratio * 100,
                "pbv" => $output->pbv * 100,
                "annualized_per" => $output->annualized_per,
                "annualized_roa" => $output->annualized_roa * 100,
                "gpm" => $output->gpm * 100,
                "npm" => $output->npm * 100,
                "eer" => $output->eer * 100,
                "ear" => $output->ear * 100,
                "market_cap" => $output->market_cap,
                "market_cap_asset_ratio" => $output->market_cap_asset_ratio * 100,
                "cfo_sales_ratio" => $output->cfo_sales_ratio * 100,
                "capex_cfo_ratio" => $output->capex_cfo_ratio * 100,
                "market_cap_cfo_ratio" => $output->market_cap_cfo_ratio * 100,
                "peg" => $peg * 100,
                "harga_saham_sum_dividen" => $output->harga_saham_sum_dividen,
                "tahun" => $output->tahun,
                'eps' => $inputLoop->eps
            );
            $fundamental = [$dataOutput, $data->toArray()];
            //dd($fundamental);
            array_push($dataFundamental, $fundamental);

        }

        $laporan = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', 7)->where('status', 'subscribed')->first();
        $check = SahamModel::where('nama_saham', $ticker)->value('id_jenis_fundamental');


        $keuangan = [];
        foreach ($dataFundamental as $input) {
            array_push($keuangan, $input[1]);
        }
        $keuangan = array_reverse($keuangan);

        $fundamentalEmiten = [];
        foreach ($dataFundamental as $input) {
            array_push($fundamentalEmiten, $input[0]);
        }
        $fundamentalEmiten = array_reverse($fundamentalEmiten);

        $data = compact(['keuangan'], ['fundamentalEmiten'], ['ticker'], ['laporan'], ['check']);

        return $data;
    }

    public function fundamental($ticker)
    {

        return view('landingPage/fundamental', compact(['ticker']));
    }

    public function emitenData($ticker)
    {
        $laporan = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', 7)->where('status', 'subscribed')->first();
        $emiten = SahamModel::where('nama_saham', $ticker)->value('id_saham');
        $input = InputFundamentalModel::where('tb_input.id_saham', $emiten)
            ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
            ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
            ->latest('tahun')->get();

        $subscribed = SubscriberModel::where('id_subscriber', Auth::id())->pluck('id_analyst')->toArray();
        $postData = PostModel::where('id_saham', $emiten)->where('tag', 'public')
            ->join('users', 'tb_post.id_user', '=', 'users.id')
            ->get()->toArray();
        $includedID = PostModel::where('id_saham', $emiten)->where('tag', 'public')->pluck('id_post')->toArray();
        $analystPost = PostModel::where('id_saham', $emiten)->where('tag', 'private')
            ->whereIn('id_user', $subscribed)
            ->whereNotIn('id_post', $includedID)
            ->join('users', 'tb_post.id_user', '=', 'users.id')
            ->get()->toArray();

        $post = array_merge($postData, $analystPost);
        //dd($input);

        if (!$input) {
            $inputData = array(
                "id_input" => 0,
                "id_detail_input" => 0,
                "id_saham" => 0,
                "user_id" => 0,
                "aset" => 0,
                "hutang_obligasi" => 0,
                "simpanan" => 0,
                "pinjaman" => 0,
                "saldo_laba" => 0,
                "ekuitas" => 0,
                "jml_saham_edar" => 0,
                "pendapatan" => 0,
                "laba_kotor" => 0,
                "laba_bersih" => 0,
                "harga_saham" => 0,
                "operating_cash_flow" => 0,
                "investing_cash_flow" => 0,
                "total_dividen" => 0,
                "stock_split" => 0,
                "eps" => 0,
                "tahun" => "N/A",
                "nama_saham" => $ticker,
                "id_jenis_fundamental" => 0,
            );

            $outputData = array(
                "der" => 0,
                "loan_to_depo_ratio" => 0,
                "annualized_roe" => 0,
                "dividen" => 0,
                "dividen_yield" => 0,
                "dividen_payout_ratio" => 0,
                "pbv" => 0,
                "annualized_per" => 0,
                "annualized_roa" => 0,
                "gpm" => 0,
                "npm" => 0,
                "eer" => 0,
                "ear" => 0,
                "market_cap" => 0,
                "market_cap_asset_ratio" => 0,
                "cfo_sales_ratio" => 0,
                "capex_cfo_ratio" => 0,
                "market_cap_cfo_ratio" => 0,
                "peg" => 0,
                "harga_saham_sum_dividen" => 0,
            );

            $check = SahamModel::where('nama_saham', $ticker)->value('id_jenis_fundamental');
            $data = compact(['inputData'], ['outputData'], ['ticker'], ['check'], ['post'], ['laporan']);
            return view('landingPage/chart', $data);

        } else {
            $inputData = $input->toArray();
            $inputID = [];
            foreach ($input as $id) {
                array_push($inputID, $id->id_input);
            }
            $output = OutputFundamentalModel::whereIn('id_input', $inputID)
                ->join('tb_detail_output', 'tb_output.id_detail_output', '=', 'tb_detail_output.id_output')
                ->get();
            //dd($output);
            $outputData = [];
            foreach ($output as $data) {
                if ($data->peg == null) {
                    $peg = 0;
                } else {
                    $peg = $data->peg;
                }

                if ($data->der == null) {
                    $der = 0;
                } else {
                    $der = $data->der;
                }

                if ($data->loan_to_depo_ratio == null) {
                    $loan_to_depo_ratio = 0;
                } else {
                    $loan_to_depo_ratio = $data->loan_to_depo_ratio;
                }
                $push = array(
                    "der" => $der * 100,
                    "loan_to_depo_ratio" => $loan_to_depo_ratio * 100,
                    "annualized_roe" => $data->annualized_roe * 100,
                    "dividen" => $data->dividen,
                    "dividen_yield" => $data->dividen_yield * 100,
                    "dividen_payout_ratio" => $data->dividen_payout_ratio * 100,
                    "pbv" => $data->pbv * 100,
                    "annualized_per" => $data->annualized_per,
                    "annualized_roa" => $data->annualized_roa * 100,
                    "gpm" => $data->gpm * 100,
                    "npm" => $data->npm * 100,
                    "eer" => $data->eer * 100,
                    "ear" => $data->ear * 100,
                    "market_cap" => $data->market_cap,
                    "market_cap_asset_ratio" => $data->market_cap_asset_ratio * 100,
                    "cfo_sales_ratio" => $data->cfo_sales_ratio * 100,
                    "capex_cfo_ratio" => $data->capex_cfo_ratio * 100,
                    "market_cap_cfo_ratio" => $data->market_cap_cfo_ratio * 100,
                    "peg" => $peg * 100,
                    "harga_saham_sum_dividen" => $data->harga_saham_sum_dividen,
                    "tahun" => $data->tahun,
                    "kuartal" => $data->type
                );

                array_push($outputData, $push);
            }

            $check = SahamModel::where('nama_saham', $ticker)->value('id_jenis_fundamental');
            $data = compact(['inputData'], ['outputData'], ['laporan'], ['ticker'], ['check'], ['post'], );

            // return response()->json([
            //     'status' => 'success',
            //     'data' => $data
            // ], 200);

            //dd($data);
            // return response()->json([
            //     'status' => 'success',
            //     'data' => $data
            // ], 200);
            return view('landingPage/chart', $data);

        }
    }
}
// uccess',
//             //     'data' => $data
//             // ], 200);

//             //dd($data);
//           return view('landingPage/chart', $data);

//         }
//     }
// }
