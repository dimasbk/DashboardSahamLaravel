<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostModel;
use App\Models\SahamModel;
use App\Models\InputFundamentalModel;
use App\Models\OutputFundamentalModel;
use Http;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index()
    {
        $post = PostModel::where('tag', 'public')
            ->orderBy('created_at', 'DESC')
            ->take(3)->get()->toArray();
        //dd($post);
        return view('landingPage/landing_page', compact(['post']));
    }

    public function post()
    {
        if (Auth::check()) {
            $postData = PostModel::get();

            return view('landingPage/post', compact(['postData']));
        } else {
            $postData = PostModel::where('tag', 'public')->get();

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
        $emiten = SahamModel::get('nama_saham')->toArray();

        $array = [];

        for ($i = 0; $i < count($emiten); $i++) {
            array_push($array, $emiten[$i]['nama_saham']);
        }

        return $array;
    }

    public function emitenSearch()
    {

        return view('landingPage/emitenSearch');
    }

    public function emitenData($ticker)
    {
        $emiten = SahamModel::where('nama_saham', $ticker)->value('id_saham');
        $input = InputFundamentalModel::where('tb_input.id_saham', $emiten)
            ->where('user_id', Auth::id())
            ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
            ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
            ->latest('tahun')->first();

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

            return view('landingPage/chart', $data);
        }
    }
}