<?php

namespace App\Http\Controllers;

use App\Models\DetailOutputFundamentalModel;
use App\Models\InputFundamentalModel;
use App\Models\OutputFundamentalModel;
use App\Models\SahamModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TechnicalController extends Controller
{
    public function index()
    {
        $filteredData = [];
        return view('landingPage/technical', compact(['filteredData']));
    }

    public function trend($prices = null)
    {
        /*
        $stock = 'ACES';
        $start = '2023-03-01';
        $end = '2023-06-01';

        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('midtrans.server_key')
            ])->get('https://api.goapi.id/v1/stock/idx/' . $stock . '/historical', [
                    'to' => $end,
                    'from' => $start
                ])->json();

        $historical = $response['data']['results'];
                */
        $historical = $prices;

        $fridayData = array_filter($historical, function ($entry) {
            $date = Carbon::parse($entry['date']); // Parse the date using Carbon
            return $date->isFriday();
        });

        $closePrice = [];
        $trends = [];

        foreach ($fridayData as $data) {
            array_push($closePrice, $data['close']);
        }

        $longPeriod = $closePrice;
        $shortPeriod = array_splice(
            $longPeriod,
            -count($longPeriod) / 2
        );

        $longPeriod = array_sum($longPeriod) / count($longPeriod);
        $shortPeriod = array_sum($shortPeriod) / count($shortPeriod);

        //dd(compact(['firstHalf', 'secondHalf']));

        for ($i = 0; $i < count($closePrice); $i++) {
            if ($i + 1 != count($closePrice)) {
                if ($closePrice[$i] > $closePrice[$i + 1]) {
                    array_push($trends, 'uptrend');
                } elseif ($closePrice[$i] < $closePrice[$i + 1]) {
                    array_push($trends, 'downtrend');
                } else {
                    array_push($trends, 'sideways');
                }
            }
        }

        $num = [];
        for ($i = 0; $i < count($trends); $i++) {
            if ($trends[$i] === $trends[$i + 1]) {
                array_push($num, $i);
            } else {
                break;
            }
        }

        $percentage = round(((count($num) + 1) / count($trends)), 2) * 100;
        $trendString = $trends[0];
        $MAPercentage = round(((($longPeriod - $shortPeriod) / $shortPeriod) * 100), 2);
        $dataArray = compact(['percentage', 'MAPercentage', 'trendString']);

        return $dataArray;
    }

    public function technical(Request $request)
    {
        $trends = [];
        $year = explode('-', '2068-06-15');
        $output = DetailOutputFundamentalModel::where($request->param, $request->comparison, $request->num / 100)->where('tahun', 2018)->pluck('id_output');
        $input = OutputFundamentalModel::whereIn('id_detail_output', $output)->pluck('id_input');
        $id_emiten = InputFundamentalModel::whereIn('id_input', $input)->pluck('id_saham');
        $stocks = SahamModel::whereIn('id_saham', $id_emiten)->pluck('nama_saham');
        //dd($stocks);
        //$stocks = ['BBCA', 'BRIS', 'GOTO', 'ANTM', 'ACES', 'ROTI'];
        foreach ($stocks as $stock) {
            //$today = date("Y-m-d");
            $end = $request->end;
            $start = $request->start;
            $response = Http::acceptJson()
                ->withHeaders([
                    'X-API-KEY' => config('goapi.apikey')
                ])->get('https://api.goapi.id/v1/stock/idx/' . $stock . '/historical', [
                        'to' => $end,
                        'from' => $start
                    ])->json();

            $data = $response['data']['results'];
            $startPrice = $data[count($data) - 1]['close'];
            $endPrice = $data[0]['close'];

            $id_stock = SahamModel::where('nama_saham', $stock)->value('id_saham');

            $input_id = InputFundamentalModel::where('tb_input.id_saham', $id_stock)
                ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
                ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
                ->latest('tahun')->first();

            $output = OutputFundamentalModel::where('id_input', $input_id->id_input)
                ->join('tb_detail_output', 'tb_output.id_detail_output', '=', 'tb_detail_output.id_output')
                ->first();

            $der = $output->der * 100;
            $ldr = $output->loan_to_depo_ratio * 100;

            $trend = $this->trend($data);
            $array = ["ticker" => "{$stock}", "MAPercentage" => "{$trend['MAPercentage']}", "trend" => "{$trend['trendString']}", "change" => "{$trend['percentage']}", "der" => "{$der}", "ldr" => "{$ldr}", "start" => $start, "end" => $end];
            array_push($trends, $array);

        }
        $filteredData = [];
        if ($request->trend == 'uptrend') {
            foreach ($trends as $item) {
                if ($item['trend'] === 'uptrend') {
                    $filteredData[] = $item;
                }
            }
        } else if ($request->trend == 'downtrend') {
            foreach ($trends as $item) {
                if ($item['trend'] === 'downtrend') {
                    $filteredData[] = $item;
                }
            }
        } else {
            foreach ($trends as $item) {
                if ($item['trend'] === 'sideways') {
                    $filteredData[] = $item;
                }
            }
        }

        //return $filteredData;
        //dd(compact(['filteredData']));
        //return view('landingPage/technical', compact(['filteredData']));

        return response()->json([
            'status' => 'success',
            'data' => $filteredData
        ], 200);
    }

    public function getChartData(Request $request, $emiten)
    {
        $start = $request->start;
        $end = $request->end;

        return view('landingPage/technicalChart', compact(['start', 'end', 'emiten']));
    }
    public function technicalChart(Request $request)
    {

        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('goapi.apikey')
            ])->get('https://api.goapi.id/v1/stock/idx/' . $request->emiten . '/historical', [
                    'to' => $request->end,
                    'from' => $request->start
                ])->json();

        $historical = $response['data']['results'];

        $fridayData = array_filter($historical, function ($entry) {
            $date = Carbon::parse($entry['date']); // Parse the date using Carbon
            return $date->isFriday();
        });

        $closePrice = [];

        foreach ($fridayData as $data) {
            array_push($closePrice, $data);
        }

        $closePrice = array_reverse($closePrice);

        return $closePrice;


    }
}
