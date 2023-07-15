<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use App\Models\SubscriberModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\InputFundamentalModel;
use App\Models\OutputFundamentalModel;
use App\Models\DetailInputFundamentalModel;
use App\Models\DetailOutputFundamentalModel;
use App\Models\SahamModel;

class ChartController extends Controller
{

    public function index($ticker)
    {

        $emiten = SahamModel::where('nama_saham', $ticker)->value('id_saham');
        $input = InputFundamentalModel::where('tb_input.id_saham', $emiten)
            ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
            ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
            ->latest('tahun')->first();

        $post = [];
        $subscribed = SubscriberModel::where('id_subscriber', Auth::id())->pluck('id_analyst')->toArray();
        $postData = PostModel::where('id_saham', $emiten)->get();
        //dd($subscribed);

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

            $data = compact(['inputData'], ['outputData'], ['ticker'], ['check']);
            //dd($data);

            return view('chartdetailBank', $data);

        } else {
            $inputData = $input->toArray();
            $output = OutputFundamentalModel::where('id_input', $input->id_input)
                ->join('tb_detail_output', 'tb_output.id_detail_output', '=', 'tb_detail_output.id_output')
                ->first();

            if ($output->peg == null) {
                $peg = 0;
            } else {
                $peg = $output->peg;
            }
            $outputData = array(
                "der" => $output->der * 100,
                "loan_to_depo_ratio" => $output->loan_to_depo_ratio * 100,
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
            );

            $check = SahamModel::where('nama_saham', $ticker)->value('id_jenis_fundamental');
            $data = compact(['inputData'], ['outputData'], ['ticker'], ['check']);

            return view('chartdetailBank', $data);
        }

    }

    public function oneWeek($ticker)
    {

        $today = date("Y-m-d");
        //$today = '2023-05-01';
        $weekBefore = date('Y-m-d', strtotime($today . ' -1 week'));
        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('midtrans.server_key')
            ])->get('https://api.goapi.id/v1/stock/idx/' . $ticker . '/historical', [
                    'to' => $today,
                    'from' => $weekBefore
                ])->json();

        //dd($response);
        $data = $response['data']['results'];
        $data_historical = array_reverse($data);
        //dd($response);
        return $data_historical;
    }

    public function oneMonth($ticker)
    {

        $today = date("Y-m-d");
        //$today = '2023-05-01';
        $monthBefore = date('Y-m-d', strtotime($today . ' -1 month'));
        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('midtrans.server_key')
            ])->get('https://api.goapi.id/v1/stock/idx/' . $ticker . '/historical', [
                    'to' => $today,
                    'from' => $monthBefore
                ])->json();

        $data = $response['data']['results'];
        $data_historical = array_reverse($data);
        //dd($data);
        return $data_historical;
    }

    public function oneYear($ticker)
    {

        $today = date("Y-m-d");
        //$today = '2023-05-01';
        $yearBefore = date('Y-m-d', strtotime($today . ' -1 year'));
        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('midtrans.server_key')
            ])->get('https://api.goapi.id/v1/stock/idx/' . $ticker . '/historical', [
                    'to' => $today,
                    'from' => $yearBefore
                ])->json();

        $data = $response['data']['results'];
        $data_historical = array_reverse($data);
        //dd($monthBefore);
        return $data_historical;
    }

    public function threeYear($ticker)
    {

        $today = date("Y-m-d");
        //$today = '2023-05-01';
        $monthBefore = date('Y-m-d', strtotime($today . ' -3 year'));
        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('midtrans.server_key')
            ])->get('https://api.goapi.id/v1/stock/idx/' . $ticker . '/historical', [
                    'to' => $today,
                    'from' => $monthBefore
                ])->json();

        $data = $response['data']['results'];
        $data_historical = array_reverse($data);
        //dd($monthBefore);
        return $data_historical;
    }

    public function technical($ticker)
    {
        $trends = [];
        $stocks = ['BBCA', 'BRIS', 'GOTO', 'ANTM', 'ACES', 'ROTI'];
        foreach ($stocks as $stock) {
            //$today = date("Y-m-d");
            $todayDate = '2023-04-01';
            $yearBefore = date('Y-m-d', strtotime($todayDate . ' -1 year'));
            $response = Http::acceptJson()
                ->withHeaders([
                    'X-API-KEY' => config('midtrans.server_key')
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
                $array = ["ticker" => "{$stock}", "trend" => "uptrend"];
                array_push($trends, $array);
            } else if ($ma50 < $ma200) {
                $array = ["ticker" => "{$stock}", "trend" => "downtrend"];
                array_push($trends, $array);
            } else {
                $array = ["ticker" => "{$stock}", "trend" => "sideways"];
                array_push($trends, $array);
            }

        }
        return $trends;
    }

    private function countSMA($data, $period)
    {
        $sma = array();
        for ($i = $period; $i < count($data); $i++) {
            $sum = 0;
            for ($j = $i - $period; $j < $i; $j++) {
                $sum += $data[$j];
            }
            $sma[$i] = $sum / $period;
        }
        return $sma;
    }

    private function countRSI($data, $period)
    {
        $rsi = array();
        for ($i = $period; $i < count($data); $i++) {
            $up = 0;
            $down = 0;
            for ($j = $i - $period; $j < $i; $j++) {
                if ($data[$j] > $data[$j - 1]) {
                    $up += $data[$j] - $data[$j - 1];
                } else {
                    $down += $data[$j - 1] - $data[$j];
                }
            }
            $rs = ($up / $period) / ($down / $period);
            $rsi[$i] = 100 - (100 / (1 + $rs));
        }
        return $rsi;
    }

}