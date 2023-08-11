<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\InputFundamentalModel;
use App\Models\OutputFundamentalModel;
use App\Models\PostModel;
use App\Models\SahamModel;
use App\Models\SubscriberModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FundamentalAPIController extends Controller
{
    public function emitenData(Request $request)
    {
        $ticker = $request->ticker;
        $id_user = Auth::id();
        $laporan = SubscriberModel::where('id_subscriber', $id_user)->where('id_analyst', 7)->where('status', 'subscribed')->first();
        $emiten = SahamModel::where('nama_saham', $ticker)->value('id_saham');
        $input = InputFundamentalModel::where('tb_input.id_saham', $emiten)
            ->where('user_id', $id_user)
            ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
            ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
            ->latest('tahun')->first();

        $subscribed = SubscriberModel::where('id_subscriber', $id_user)->pluck('id_analyst')->toArray();
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
        //dd($analystPost);

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
            //dd($data);

            return view('landingPage/chart', $data);


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
            $outputData = array(
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
            );

            $check = SahamModel::where('nama_saham', $ticker)->value('id_jenis_fundamental');
            $data = compact(['inputData'], ['outputData'], ['ticker'], ['check'], ['post'], ['laporan']);

            //dd($data);
            //return view('landingPage/chart', $data);

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        }
    }

    public function emitenDataa($ticker)
    {
        //$ticker = $request->ticker;
       // $id_user = Auth::id();
       $laporan = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', 7)->where('status', 'subscribed')->first();
      // if $laporan == null {$laporan = array("status" => kosong)};
     //  $laporan = "subscribed"
       $emiten = SahamModel::where('nama_saham', $ticker)->value('id_saham');
       $input = InputFundamentalModel::where('tb_input.id_saham', $emiten)
         //  ->where('user_id', Auth::id())
           ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
           ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
           ->latest('tahun')->first();

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
       //dd($analystPost);

       if(!$laporan){

        $laporan = array("status" => 'blmsubs', "ayam" => "iniayam");
        // $obj = (object) $laporan;
        // $abc = json_encode($obj);
       // $arrayData = json_decode($laporan, true);
       // $laporan = json_decode($data, true);
       }



    // if(!$laporan){
    //     $laporan = json(['status' => 'blmsubs']);
    //    }



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
           $data = compact(['inputData'], ['outputData'], ['laporan'],['ticker'], ['check'], ['post'], );

            //dd($data);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        }else {
            $inputData = $input->toArray();
            $output = OutputFundamentalModel::where('id_input', $input->id_input)
                ->join('tb_detail_output', 'tb_output.id_detail_output', '=', 'tb_detail_output.id_output')
                ->first();

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

            if ($inputData->hutang_obligasi == null) {
                $hutang_obligasi = 0;
            } else {
                $hutang_obligasi = $inputData->hutang_obligasi;
            }


            $outputData = array(
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
            );

            // if(!$inputData){

            //     $inputData = array("nama_saham" => 'blmsubs', "ayam" => "iniayam");
            //     // $obj = (object) $laporan;
            //     // $abc = json_encode($obj);
            //    // $arrayData = json_decode($laporan, true);
            //    // $laporan = json_decode($data, true);
            //    }

            $check = SahamModel::where('nama_saham', $ticker)->value('id_jenis_fundamental');
            $data = compact(['inputData'], ['outputData'],['laporan'], ['ticker'], ['check'], ['post']);

            //dd($data);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
          //  return view('landingPage/chart', $data);

        }
    }

    public function trend()
    {
        $trends = [];
        $stocks = ['BBCA', 'BRIS', 'GOTO', 'ANTM', 'ACES', 'ROTI'];
        foreach ($stocks as $stock) {
            //$today = date("Y-m-d");
            $todayDate = '2023-04-01';
            $yearBefore = date('Y-m-d', strtotime($todayDate . ' -1 year'));
            $response = Http::acceptJson()
                ->withHeaders([
                    'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
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
                $array = ["ticker" => "{$stock}", "trend" => "downtrend", "change" => "-{$change}"];
                array_push($trends, $array);
            } else {
                $array = ["ticker" => "{$stock}", "trend" => "sideways", "change" => "0"];
                array_push($trends, $array);
            }

        }
        // return $trends;

        return response()->json([
            'status' => 'success',
            'data' => $trends
        ], 200);
        //return response()->json(['messsage'=>'Berhasil', 'data'=>$trends]);
    }
}
