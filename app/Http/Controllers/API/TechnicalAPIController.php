<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailOutputFundamentalModel;
use App\Models\InputFundamentalModel;
use App\Models\OutputFundamentalModel;
use App\Models\SubscriberModel;
use App\Models\SahamModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TechnicalAPIController extends Controller
{
    public function trend($prices)
    {
        /*
        $stock = 'ACES';
        $start = '2023-03-01';
        $end = '2023-06-01';

        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
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
        $dataArray = compact(['percentage', 'trendString']);

        return $dataArray;
    }

    public function technical(Request $request )
    {
        $trends = [];
        $year = explode('-', '2068-06-15');
       // echo(int)$num;
        // settype($num, 'integer');
        // parseInt(num);
        $start = $request->start;
        $carbonDate = Carbon::parse($start);
        $start = $carbonDate->year;

        $end = $request->end;

        $carbonDate1 = Carbon::parse($end);
        $end = $carbonDate1->year;
        $tahunArray = range($start, $end);


        $output = null;

        if(isset($request->param_der)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_der, $request->comparison_der, intval($request->num_der) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_der, $request->comparison_der, intval($request->num_der) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }

        if(isset($request->param_ldr)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_ldr, $request->comparison_ldr, intval($request->num_ldr) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_ldr, $request->comparison_ldr, intval($request->num_ldr) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }

        if(isset($request->param_annualized_roe)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_annualized_roe, $request->comparison_annualized_roe, intval($request->num_annualized_roe) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_annualized_roe, $request->comparison_annualized_roe, intval($request->num_annualized_roe) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }

        if(isset($request->param_dividen)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_dividen, $request->comparison_dividen, intval($request->num_dividen) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_dividen, $request->comparison_dividen, intval($request->num_dividen) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }

        if(isset($request->param_dividen_yield)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_dividen_yield, $request->comparison_dividen_yield, intval($request->num_dividen_yield) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_dividen_yield, $request->comparison_dividen_yield, intval($request->num_dividen_yield) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }

        if(isset($request->param_dividen_payout_ratio)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_dividen_payout_ratio, $request->comparison_dividen_payout_ratio, intval($request->num_dividen_payout_ratio) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_dividen_payout_ratio, $request->comparison_dividen_payout_ratio, intval($request->num_dividen_payout_ratio) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }

        if(isset($request->param_pbv)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_pbv, $request->comparison_pbv, intval($request->num_pbv) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_pbv, $request->comparison_pbv, intval($request->num_pbv) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }

        if(isset($request->param_annualized_roa)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_annualized_roa, $request->comparison_annualized_roa, intval($request->num_annualized_roa) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_annualized_roa, $request->comparison_annualized_roa, intval($request->num_annualized_roa) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }

        if(isset($request->param_gpm)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_gpm, $request->comparison_gpm, intval($request->num_gpm) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_gpm, $request->comparison_gpm, intval($request->num_gpm) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }

        if(isset($request->param_npm)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_npm, $request->comparison_npm, intval($request->num_npm) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_npm, $request->comparison_npm, intval($request->num_npm) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }

        if(isset($request->param_eer)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_eer, $request->comparison_eer, intval($request->num_eer) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_eer, $request->comparison_eer, intval($request->num_eer) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }

        if(isset($request->param_ear)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_ear, $request->comparison_ear, intval($request->num_ear) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_ear, $request->comparison_ear, intval($request->num_ear) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }
        if(isset($request->param_market_cap)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_market_cap, $request->comparison_market_cap, intval($request->num_market_cap) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_market_cap, $request->comparison_market_cap, intval($request->num_market_cap) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }
        if(isset($request->param_market_cap_asset_ratio)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_market_cap_asset_ratio, $request->comparison_market_cap_asset_ratio, intval($request->num_market_cap_asset_ratio) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_market_cap_asset_ratio, $request->comparison_market_cap_asset_ratio, intval($request->num_market_cap_asset_ratio) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }
        if(isset($request->param_cfo_sales_ratio)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_cfo_sales_ratio, $request->comparison_cfo_sales_ratio, intval($request->num_cfo_sales_ratio) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_cfo_sales_ratio, $request->comparison_cfo_sales_ratio, intval($request->num_cfo_sales_ratio) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }
        if(isset($request->param_capex_cfo_ratio)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_capex_cfo_ratio, $request->comparison_capex_cfo_ratio, intval($request->num_capex_cfo_ratio) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_capex_cfo_ratio, $request->comparison_capex_cfo_ratio, intval($request->num_capex_cfo_ratio) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }
        if(isset($request->param_market_cap_cfo_ratio)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_market_cap_cfo_ratio, $request->comparison_market_cap_cfo_ratio, intval($request->num_market_cap_cfo_ratio) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_market_cap_cfo_ratio, $request->comparison_market_cap_cfo_ratio, intval($request->num_market_cap_cfo_ratio) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }
        if(isset($request->param_peg)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_peg, $request->comparison_peg, intval($request->num_peg) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_peg, $request->comparison_peg, intval($request->num_peg) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }
        if(isset($request->param_harga_saham_sum_dividen)){
            if(isset($output)){
                $output = DetailOutputFundamentalModel::where($request->param_harga_saham_sum_dividen, $request->comparison_harga_saham_sum_dividen, intval($request->num_harga_saham_sum_dividen) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->whereIn('id_output_detail', $output)
                    ->pluck('id_output');
            }else{
                $output = DetailOutputFundamentalModel::where($request->param_harga_saham_sum_dividen, $request->comparison_harga_saham_sum_dividen, intval($request->num_harga_saham_sum_dividen) / 100)
                    ->whereIn('tahun', $tahunArray)
                    ->where('type', $request->type)
                    ->pluck('id_output');
            }
        }


        // if(isset($request->param_div)){
        //     $output = DetailOutputFundamentalModel::where($request->param_der, $request->comparison_der, intval($request->num_der) / 100)
        //     ->whereIn('tahun', $tahunArray)
        //     ->whereIn('id_output_detail', $output)
        //     ->pluck('id_output');
        // }
         //   return $output;
        //$output = DetailOutputFundamentalModel::where($request->param, $request->comparison, intval($request->num) / 100)->whereIn('tahun', $tahunArray)->pluck('id_output');
        $input = OutputFundamentalModel::whereIn('id_detail_output', $output)->pluck('id_input');
        $id_emiten = InputFundamentalModel::whereIn('id_input', $input)->pluck('id_saham');
        $stocks = SahamModel::whereIn('id_saham', $id_emiten)->pluck('nama_saham');
        //dd($stocks);
        //return $input;
        //$stocks = ['BBCA', 'BRIS', 'GOTO', 'ANTM', 'ACES', 'ROTI'];
        foreach ($stocks as $stock) {
            Log::info("1");
            //$today = date("Y-m-d");
            $end = $request->end;
            $start = $request->start;
            $response = Http::acceptJson()
                ->withHeaders([
                    'X-API-KEY' => '1hzlCQzlW2UqjegV5GFoiS78vaW9tF'
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
                ->whereIn('tb_input.id_input',$input)->get();

            foreach($input_id as $id){
                $output = OutputFundamentalModel::where('id_input', $id->id_input)
                ->join('tb_detail_output', 'tb_output.id_detail_output', '=', 'tb_detail_output.id_output')
                ->where('type', $request->type)
                ->first();

            $der = $output->der * 100;
            $ldr = $output->loan_to_depo_ratio * 100;
            $annualized_roe = $output->annualized_roe * 100;
            $dividen = $output->dividen;
            $dividen_yield = $output->dividen_yield * 100;
            $dividen_payout_ratio = $output->dividen_payout_ratio * 100;
            $pbv = $output->pbv * 100;
            $annualized_roa = $output->annualized_roa * 100;
            $gpm = $output->gpm * 100;
            $npm = $output->npm * 100;
            $eer = $output->eer * 100;
            $ear = $output->ear * 100;
            $market_cap = $output->market_cap;
            $market_cap_asset_ratio = $output->market_cap_asset_ratio * 100;
            $cfo_sales_ratio = $output->cfo_sales_ratio * 100;
            $capex_cfo_ratio = $output->capex_cfo_ratio * 100;
            $market_cap_cfo_ratio = $output->market_cap_cfo_ratio * 100;
            $peg = $output->peg * 100;
            $harga_saham_sum_dividen = $output->harga_saham_sum_dividen;
            $tahun = $output->tahun;

            $trend = $this->trend($data);
            Log::info($trend);
            $array = ["ticker" => "{$stock}",
             "MAPercentage" => "{$trend['percentage']}",
             "trend" => "{$trend['trendString']}",
             "change" => "{$trend['percentage']}",
             "der" => "{$der}",
             "ldr" => "{$ldr}",
             "annualized_roe" => "{$annualized_roe}",
             "dividen" => "{$dividen}",
             "dividen_yield" => "{$dividen_yield}",
             "dividen_payout_ratio" => "{$dividen_payout_ratio}",
             "pbv" => "{$pbv}",
             "annualized_roa" => "{$annualized_roa}",
             "gpm" => "{$gpm}",
             "npm" => "{$npm}",
             "eer" => "{$eer}",
             "ear" => "{$ear}",
             "market_cap" => "{$market_cap}",
             "market_cap_asset_ratio" => "{$market_cap_asset_ratio}",
             "cfo_sales_ratio" => "{$cfo_sales_ratio}",
             "capex_cfo_ratio" => "{$capex_cfo_ratio}",
             "market_cap_cfo_ratio" => "{$market_cap_cfo_ratio}",
             "peg" => "{$peg}",
             "harga_saham_sum_dividen" => "{$harga_saham_sum_dividen}",
             "startdate"=>"{$start}",
             "enddate"=>"{$end}",
             "tahun"=>"{$tahun}"];
            array_push($trends, $array);
            }



        }
        $filteredData = [];
        if ($request->trend == 'uptrend') {
            Log::info("2");
            foreach ($trends as $item) {
                Log::info("3");
                if ($item['trend'] === 'uptrend') {
                    Log::info("4");
                    $filteredData[] = $item;
                }
            }
        } else if ($request->trend == 'downtrend') {
            Log::info("5");
            foreach ($trends as $item) {
                Log::info("6");
                if ($item['trend'] === 'downtrend') {
                    Log::info("7");
                    $filteredData[] = $item;
                }
            }
        } else if ($request->trend == 'empty') {
            Log::info("5");
           // $filteredData[] = $trends;
            foreach ($trends as $item) {
                // Log::info("6");
                // if ($item['trend'] === 'uptrend',$item1['trend'] === 'uptrend') {
                //     Log::info("7");
                    $filteredData[] = $item;
              //  }
            }
        } else {
            foreach ($trends as $item) {
                Log::info("8");
                if ($item['trend'] === 'sideways') {
                    Log::info("9");
                    $filteredData[] = $item;
                }
            }
        }
        Log::info($filteredData);

        //return $filteredData;
        //dd(compact(['filteredData']));
        // return view('landingPage/technical', compact(['filteredData']));

        return response()->json([
            'status' => 'success',
            'data' => $filteredData,
            'tahun' => $tahunArray
        ], 200);
        //Log::info(filteredData);
    }


    public function technical_lama(Request $request )
    {
        $trends = [];
        $year = explode('-', '2068-06-15');
       // echo(int)$num;
        // settype($num, 'integer');
        // parseInt(num);
        $start = $request->start;
        $carbonDate = Carbon::parse($start);
        $start = $carbonDate->year;

        $end = $request->end;

        $carbonDate1 = Carbon::parse($end);
        $end = $carbonDate1->year;
        $tahunArray = range($start, $end);

        $output = DetailOutputFundamentalModel::where($request->param, $request->comparison, intval($request->num) / 100)->whereIn('tahun', $tahunArray)->pluck('id_output');
        $input = OutputFundamentalModel::whereIn('id_detail_output', $output)->pluck('id_input');
        $id_emiten = InputFundamentalModel::whereIn('id_input', $input)->pluck('id_saham');
        $stocks = SahamModel::whereIn('id_saham', $id_emiten)->pluck('nama_saham');
        //dd($stocks);
        //$stocks = ['BBCA', 'BRIS', 'GOTO', 'ANTM', 'ACES', 'ROTI'];
        foreach ($stocks as $stock) {
            Log::info("1");
            //$today = date("Y-m-d");
            $end = $request->end;
            $start = $request->start;
            $response = Http::acceptJson()
                ->withHeaders([
                    'X-API-KEY' => '1hzlCQzlW2UqjegV5GFoiS78vaW9tF'
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
                ->whereIn('tb_detail_input.tahun',$tahunArray)->get();

            foreach($input_id as $id){
                $output = OutputFundamentalModel::where('id_input', $id->id_input)->where('type', $request->type)
                ->join('tb_detail_output', 'tb_output.id_detail_output', '=', 'tb_detail_output.id_output')

                ->first();

            $der = $output->der * 100;
            $ldr = $output->loan_to_depo_ratio * 100;
            $annualized_roe = $output->annualized_roe * 100;
            $dividen = $output->dividen;
            $dividen_yield = $output->dividen_yield * 100;
            $dividen_payout_ratio = $output->dividen_payout_ratio * 100;
            $pbv = $output->pbv * 100;
            $annualized_roa = $output->annualized_roa * 100;
            $gpm = $output->gpm * 100;
            $npm = $output->npm * 100;
            $eer = $output->eer * 100;
            $ear = $output->ear * 100;
            $market_cap = $output->market_cap;
            $market_cap_asset_ratio = $output->market_cap_asset_ratio * 100;
            $cfo_sales_ratio = $output->cfo_sales_ratio * 100;
            $capex_cfo_ratio = $output->capex_cfo_ratio * 100;
            $market_cap_cfo_ratio = $output->market_cap_cfo_ratio * 100;
            $peg = $output->peg * 100;
            $harga_saham_sum_dividen = $output->harga_saham_sum_dividen;
            $tahun = $output->tahun;

            $trend = $this->trend($data);
            Log::info($trend);
            $array = ["ticker" => "{$stock}",
             "MAPercentage" => "{$trend['percentage']}",
             "trend" => "{$trend['trendString']}",
             "change" => "{$trend['percentage']}",
             "der" => "{$der}",
             "ldr" => "{$ldr}",
             "annualized_roe" => "{$annualized_roe}",
             "dividen" => "{$dividen}",
             "dividen_yield" => "{$dividen_yield}",
             "dividen_payout_ratio" => "{$dividen_payout_ratio}",
             "pbv" => "{$pbv}",
             "annualized_roa" => "{$annualized_roa}",
             "gpm" => "{$gpm}",
             "npm" => "{$npm}",
             "eer" => "{$eer}",
             "ear" => "{$ear}",
             "market_cap" => "{$market_cap}",
             "market_cap_asset_ratio" => "{$market_cap_asset_ratio}",
             "cfo_sales_ratio" => "{$cfo_sales_ratio}",
             "capex_cfo_ratio" => "{$capex_cfo_ratio}",
             "market_cap_cfo_ratio" => "{$market_cap_cfo_ratio}",
             "peg" => "{$peg}",
             "harga_saham_sum_dividen" => "{$harga_saham_sum_dividen}",
             "startdate"=>"{$start}",
             "enddate"=>"{$end}",
             "tahun"=>"{$tahun}"];
            array_push($trends, $array);
            }



        }
        $filteredData = [];
        if ($request->trend == 'uptrend') {
            Log::info("2");
            foreach ($trends as $item) {
                Log::info("3");
                if ($item['trend'] === 'uptrend') {
                    Log::info("4");
                    $filteredData[] = $item;
                }
            }
        } else if ($request->trend == 'downtrend') {
            Log::info("5");
            foreach ($trends as $item) {
                Log::info("6");
                if ($item['trend'] === 'downtrend') {
                    Log::info("7");
                    $filteredData[] = $item;
                }
            }
        } else if ($request->trend == 'empty') {
            Log::info("5");
           // $filteredData[] = $trends;
            foreach ($trends as $item) {
                // Log::info("6");
                // if ($item['trend'] === 'uptrend',$item1['trend'] === 'uptrend') {
                //     Log::info("7");
                    $filteredData[] = $item;
              //  }
            }
        } else {
            foreach ($trends as $item) {
                Log::info("8");
                if ($item['trend'] === 'sideways') {
                    Log::info("9");
                    $filteredData[] = $item;
                }
            }
        }
        Log::info($filteredData);

        //return $filteredData;
        //dd(compact(['filteredData']));
        // return view('landingPage/technical', compact(['filteredData']));

        return response()->json([
            'status' => 'success',
            'data' => $filteredData,
            'tahun' => $tahunArray
        ], 200);
        //Log::info(filteredData);
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

    public function fundamentall($ticker)
    {
        $laporan = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', 7)->where('status', 'subscribed')->first();
        $emiten = SahamModel::where('nama_saham', $ticker)->value('id_saham');
        $input = InputFundamentalModel::where('tb_input.id_saham', $emiten)
            ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
            ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
            ->latest('tahun')->get();

        $inputData = $input->toArray();
        $outputData = [];
        $dataFundamental = [];
        $dataFundamentalSingkat = [];

        // if(!$laporan){

        //     $laporan = array("status" => 'blmsubs', "ayam" => "iniayam");
        //     // $obj = (object) $laporan;
        //     // $abc = json_encode($obj);
        //    // $arrayData = json_decode($laporan, true);
        //    // $laporan = json_decode($data, true);
        //    }


        foreach ($input as $data) {
            $output = OutputFundamentalModel::where('id_input', $data->id_input)
                ->join('tb_detail_output', 'tb_output.id_detail_output', '=', 'tb_detail_output.id_output')
                ->first();

            if ($output->peg == null) {
                $peg = 0;
            } else {
                $peg = $output->peg;
            }

            // if ($output->type == null) {
            //     $type = "dwdw";
            // } else {
            //     $type = $output->type;
            // }

            if ($output->der == null) {
                $der = 0;
            } else {
                $der = $output->der;
            }

            if ($output->simpanan == null) {
                $simpanan = 0;
            } else {
                $simpanan = $output->simpanan;
            }

            if ($output->pinjaman == null) {
                $pinjaman = 0;
            } else {
                $pinjaman = $output->pinjaman;
            }

            if ($output->id_jenis_fundamental == null) {
                $id_jenis_fundamental = 2;
            } else {
                $id_jenis_fundamental = $output->id_jenis_fundamental;
            }


            if ($output->loan_to_depo_ratio == null) {
                $loan_to_depo_ratio = 0;
            } else {
                $loan_to_depo_ratio = $output->loan_to_depo_ratio;
            }

            // if ($type == null) {
            //     $type = 0;
            // } else {
            //     $type = $output->type;
            // }
            $dataOutput = array(
              //  $der => (string)$der * 100,
                "der" => round($der * 100),
               // implode(" ",$request->education)
                //"tahun" => $inputData -> tahun,
                "loan_to_depo_ratio" => round($loan_to_depo_ratio * 100),
                "annualized_roe" => round($output->annualized_roe * 100),
                "dividen" => round($output->dividen),
               // "id_jenis_fundamental" => $output->id_jenis_fundamental + 1,
                "dividen_yield" => round($output->dividen_yield * 100),
                "dividen_payout_ratio" => round($output->dividen_payout_ratio * 100),
                "pbv" => round($output->pbv * 100),
                "annualized_per" => $output->annualized_per,
                "annualized_roa" => round($output->annualized_roa * 100),
                "gpm" => round($output->gpm * 100),
                "npm" => round($output->npm * 100),
                "eer" => round($output->eer * 100),
                "ear" => round($output->ear * 100),
                "market_cap" => round($output->market_cap),
                "market_cap_asset_ratio" => round($output->market_cap_asset_ratio * 100),
                "cfo_sales_ratio" => round($output->cfo_sales_ratio * 100),
                "capex_cfo_ratio" => round($output->capex_cfo_ratio * 100),
                "market_cap_cfo_ratio" => round($output->market_cap_cfo_ratio * 100),
                "peg" => round($peg * 100),
                "harga_saham_sum_dividen" => $output->harga_saham_sum_dividen,
               // "tahun" => "2022"




            );
           // $dataOutput = implode("''",$dataOutput);
            $fundamental = [$dataOutput, $data->toArray()];
           // $fundamental = implode("''",$fundamental);
            //dd($fundamental);
            array_push($dataFundamental, $fundamental);
            array_push($dataFundamentalSingkat, $inputData);
        }


        $check = SahamModel::where('nama_saham', $ticker)->value('id_jenis_fundamental');
        $data = compact(['dataFundamental'], ['ticker'], ['laporan'], ['check'],['dataFundamentalSingkat'],['fundamental']);
       // $data = implode(" ",$data);
        //dd($data);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
      //  return view('landingPage/fundamental', $data);
    }

    public function fundamentaltabel($ticker)
    {
        $laporan = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', 7)->where('status', 'subscribed')->first();
        $emiten = SahamModel::where('nama_saham', $ticker)->value('id_saham');
        $input = InputFundamentalModel::where('tb_input.id_saham', $emiten)
            ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
            ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
            ->latest('tahun')->get();

        $inputData = $input->toArray();
        $outputData = [];
        $dataFundamental = [];
        $dataFundamentalSingkat = [];

        // if(!$laporan){

        //     $laporan = array("status" => 'blmsubs', "ayam" => "iniayam");
        //     // $obj = (object) $laporan;
        //     // $abc = json_encode($obj);
        //    // $arrayData = json_decode($laporan, true);
        //    // $laporan = json_decode($data, true);
        //    }


        foreach ($input as $data) {
            $output = OutputFundamentalModel::where('id_input', $data->id_input)
                ->join('tb_detail_output', 'tb_output.id_detail_output', '=', 'tb_detail_output.id_output')
                ->first();

            if ($output->peg == null) {
                $peg = 0;
            } else {
                $peg = $output->peg;
            }

            // if ($output->type == null) {
            //     $type = "dwdw";
            // } else {
            //     $type = $output->type;
            // }

            if ($output->der == null) {
                $der = 0;
            } else {
                $der = $output->der;
            }

            if ($output->simpanan == null) {
                $simpanan = 0;
            } else {
                $simpanan = $output->simpanan;
            }

            if ($output->pinjaman == null) {
                $pinjaman = 0;
            } else {
                $pinjaman = $output->pinjaman;
            }

            if ($output->id_jenis_fundamental == null) {
                $id_jenis_fundamental = 2;
            } else {
                $id_jenis_fundamental = $output->id_jenis_fundamental;
            }


            if ($output->loan_to_depo_ratio == null) {
                $loan_to_depo_ratio = 0;
            } else {
                $loan_to_depo_ratio = $output->loan_to_depo_ratio;
            }

            // if ($type == null) {
            //     $type = 0;
            // } else {
            //     $type = $output->type;
            // }
            $dataOutput = array(
              //  $der => (string)$der * 100,
                "der" => round($der * 100),
               // implode(" ",$request->education)
                //"tahun" => $inputData -> tahun,
                "loan_to_depo_ratio" => round($loan_to_depo_ratio * 100),
                "annualized_roe" => round($output->annualized_roe * 100),
                "dividen" => round($output->dividen),
               // "id_jenis_fundamental" => $output->id_jenis_fundamental + 1,
                "dividen_yield" => round($output->dividen_yield * 100),
                "dividen_payout_ratio" => round($output->dividen_payout_ratio * 100),
                "pbv" => round($output->pbv * 100),
                "annualized_per" => $output->annualized_per,
                "annualized_roa" => round($output->annualized_roa * 100),
                "gpm" => round($output->gpm * 100),
                "npm" => round($output->npm * 100),
                "eer" => round($output->eer * 100),
                "ear" => round($output->ear * 100),
                "market_cap" => round($output->market_cap),
                "market_cap_asset_ratio" => round($output->market_cap_asset_ratio * 100),
                "cfo_sales_ratio" => round($output->cfo_sales_ratio * 100),
                "capex_cfo_ratio" => round($output->capex_cfo_ratio * 100),
                "market_cap_cfo_ratio" => round($output->market_cap_cfo_ratio * 100),
                "peg" => round($peg * 100),
                "harga_saham_sum_dividen" => $output->harga_saham_sum_dividen,




            );
           // $dataOutput = implode("''",$dataOutput);
            $fundamental = [$dataOutput, $data->toArray()];
           // $fundamental = implode("''",$fundamental);
            //dd($fundamental);
            array_push($dataFundamental, $fundamental);
            array_push($dataFundamentalSingkat, $inputData);
        }


        $check = SahamModel::where('nama_saham', $ticker)->value('id_jenis_fundamental');
        $data = compact(['dataFundamental']);
       // $data = implode(" ",$data);
        //dd($data);
        return response()->json([
            'status' => 'success',
            'data' => $dataFundamental
        ], 200);
      //  return view('landingPage/fundamental', $data);
    }
}
