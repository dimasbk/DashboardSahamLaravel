<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailOutputFundamentalModel;
use App\Models\InputFundamentalModel;
use App\Models\OutputFundamentalModel;
use App\Models\SahamModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TechnicalAPIController extends Controller
{
    public function technical(Request $request)
    {
        $trends = [];
        $year = explode('-', '2068-06-15');
        $output = DetailOutputFundamentalModel::where($request->param, $request->comparison, $request->num / 100)->where('tahun', 2018)->pluck('id_output');
        $input = OutputFundamentalModel::whereIn('id_detail_output', $output)->pluck('id_input');
        $id_emiten = InputFundamentalModel::whereIn('id_input', $input)->pluck('id_saham');
        $stocks = SahamModel::whereIn('id_saham', $id_emiten)->pluck('nama_saham');
        //$stocks = ['BBCA', 'BRIS', 'GOTO', 'ANTM', 'ACES', 'ROTI'];
        foreach ($stocks as $stock) {
            //$today = date("Y-m-d");
            $end = $request->end;
            $start = $request->start;
            $response = Http::acceptJson()
                ->withHeaders([
                    'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
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

            if ($endPrice > $startPrice) {
                $change = $endPrice / $startPrice;
                $array = ["ticker" => "{$stock}", "trend" => "uptrend", "change" => "{$change}", "der" => "{$der}", "ldr" => "{$ldr}"];
                array_push($trends, $array);
            } else if ($endPrice < $startPrice) {
                $array = ["ticker" => "{$stock}", "trend" => "downtrend", "change" => "{$change}", "der" => "{$der}", "ldr" => "{$ldr}"];
                $change = $endPrice / $startPrice;
                array_push($trends, $array);
            } else {
                $array = ["ticker" => "{$stock}", "trend" => "sideways", "change" => "{0", "der" => "{$der}", "ldr" => "{$ldr}"];
                array_push($trends, $array);
            }

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

        return response()->json([
            'status' => 'success',
            'data' => $filteredData
        ], 200);
    }
}