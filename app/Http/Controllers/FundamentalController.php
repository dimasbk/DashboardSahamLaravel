<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InputFundamentalModel;
use App\Models\OutputFundamentalModel;
use App\Models\DetailInputFundamentalModel;
use App\Models\DetailOutputFundamentalModel;
use App\Models\SahamModel;

class FundamentalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($emiten)
    {
        $idEmiten = SahamModel::where('nama_saham', $emiten)->value('id_saham');
        $id = Auth::id();
        $input = InputFundamentalModel::where('user_id', $id)
            ->where('tb_input.id_saham', $idEmiten)
            ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
            ->orderBy('tahun', 'ASC')
            ->get();
        //dd($input);
        $check = SahamModel::where('nama_saham', $emiten)->value('id_jenis_fundamental');
        return view('fundamentalbank', compact(['input'], ['emiten'], ['check']));
    }
    public function insertBank(Request $request)
    {

        $check = SahamModel::where('nama_saham', $request->emiten)->value('id_jenis_fundamental');
        if ($check === 1) {
            $simpanan = $request->simpanan;
            $pinjaman = $request->pinjaman;
            $hutang_obligasi = 0;
        } else {
            $hutang_obligasi = $request->hutang_obligasi;
            $simpanan = 0;
            $pinjaman = 0;
        }

        $aset = $request->aset;
        $saldo_laba = $request->saldo_laba;
        $ekuitas = $request->ekuitas;
        $jml_saham_edar = $request->jumlah_saham_beredar;
        $pendapatan = $request->pendapatan;
        $laba_kotor = $request->laba_kotor;
        $laba_bersih = $request->laba_bersih;
        $harga_saham = $request->harga_saham;
        $operating_cash_flow = $request->operating_cash_flow;
        $investing_cash_flow = $request->investing_cash_flow;
        $total_dividen = $request->total_dividen;
        $stock_split = $request->stock_split;
        $eps = $request->eps;
        $tahun = $request->tahun;
        $emiten = $request->emiten;
        $idEmiten = SahamModel::where('nama_saham', $emiten)->value('id_saham');

        $insertDetailInput = DetailInputFundamentalModel::insertGetId([
            'aset' => $aset,
            'hutang_obligasi' => $hutang_obligasi,
            'simpanan' => $simpanan,
            'pinjaman' => $pinjaman,
            'saldo_laba' => $saldo_laba,
            'ekuitas' => $ekuitas,
            'jml_saham_edar' => $jml_saham_edar,
            'pendapatan' => $pendapatan,
            'laba_kotor' => $laba_kotor,
            'laba_bersih' => $laba_bersih,
            'harga_saham' => $harga_saham,
            'operating_cash_flow' => $operating_cash_flow,
            'investing_cash_flow' => $investing_cash_flow,
            'total_dividen' => $total_dividen,
            'stock_split' => $stock_split,
            'eps' => $eps,
            'tahun' => $tahun
        ]);


        $insertInput = InputFundamentalModel::insertGetId([
            'id_detail_input' => $insertDetailInput,
            'id_saham' => $idEmiten,
            'user_id' => Auth::id(),
        ]);


        $last_year = $tahun - 1;
        $eps_last_year = DetailInputFundamentalModel::where('tahun', '=', $last_year)->where('tb_saham.id_saham', '=', $idEmiten)
            ->join('tb_input', 'tb_detail_input.id_detail_input', '=', 'tb_input.id_detail_input')
            ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
            ->value('eps');

        $market_cap = $harga_saham * $jml_saham_edar * $stock_split;
        if ($simpanan === 0) {
            $loan_to_depo_ratio = 0;
            $der = round($hutang_obligasi / $ekuitas, 4);
        } else {
            $loan_to_depo_ratio = round($pinjaman / $simpanan, 4);
            $der = 0;
        }

        if ($ekuitas === 0) {
            $annualized_roe = 0;
            $eer = 0;
            $pbv = 0;
        } else {
            $annualized_roe = round($laba_bersih / $ekuitas, 4);
            $eer = round($saldo_laba / $ekuitas, 4);
            $pbv = round($market_cap / $ekuitas, 4);
        }

        if ($jml_saham_edar === 0 or $stock_split === 0) {
            $dividen = 0;
        } else {
            $dividen = round($total_dividen / $jml_saham_edar / $stock_split, 4);
        }

        if ($harga_saham === 0) {
            $dividen_yield = 0;
        } else {
            $dividen_yield = round($dividen / $harga_saham, 4);
        }

        if ($laba_bersih === 0) {
            $dividen_payout_ratio = 0;
        } else {
            $dividen_payout_ratio = round($total_dividen / $laba_bersih, 4);
        }

        if ($eps === 0) {
            $annualized_per = 0;
        } else {
            $annualized_per = round($harga_saham / $eps, 4);
        }

        if ($aset === 0) {
            $annualized_roa = 0;
            $ear = 0;
            $market_cap_asset_ratio = 0;
        } else {
            $annualized_roa = round($investing_cash_flow / $aset, 4);
            $ear = round($ekuitas / $aset, 4);
            $market_cap_asset_ratio = round($market_cap / $aset, 4);
        }

        if ($pendapatan === 0) {
            $gpm = 0;
            $npm = 0;
            $cfo_sales_ratio = 0;
        } else {
            $gpm = round($laba_kotor / $pendapatan, 4);
            $npm = round($laba_bersih / $pendapatan, 4);
            $cfo_sales_ratio = round($operating_cash_flow / $pendapatan, 4);
        }

        if ($operating_cash_flow === 0) {
            $capex_cfo_ratio = 0;
            $market_cap_cfo_ratio = 0;
        } else {
            $capex_cfo_ratio = round($investing_cash_flow / $operating_cash_flow, 4);
            $market_cap_cfo_ratio = round($market_cap / $operating_cash_flow, 4);
        }

        $harga_saham_sum_dividen = $harga_saham + $dividen;

        if ($eps_last_year) {
            $percentage_eps = ($eps - $eps_last_year) / $eps_last_year;
            $peg = round($annualized_per / ($percentage_eps * 100), 4);
        } else {
            $peg = 0;
        }

        $insertDetailOutput = DetailOutputFundamentalModel::insertGetId([
            'der' => $der,
            'loan_to_depo_ratio' => $loan_to_depo_ratio,
            'annualized_roe' => $annualized_roe,
            'dividen' => $dividen,
            'dividen_yield' => $dividen_yield,
            'dividen_payout_ratio' => $dividen_payout_ratio,
            'pbv' => $pbv,
            'annualized_per' => $annualized_per,
            'annualized_roa' => $annualized_roa,
            'gpm' => $gpm,
            'npm' => $npm,
            'eer' => $eer,
            'ear' => $ear,
            'market_cap' => $market_cap,
            'market_cap_asset_ratio' => $market_cap_asset_ratio,
            'cfo_sales_ratio' => $cfo_sales_ratio,
            'capex_cfo_ratio' => $capex_cfo_ratio,
            'market_cap_cfo_ratio' => $market_cap_cfo_ratio,
            'peg' => $peg,
            'harga_saham_sum_dividen' => $harga_saham_sum_dividen,
            'tahun' => $tahun,
        ]);

        $insertOutput = OutputFundamentalModel::create([
            'id_detail_output' => $insertDetailOutput,
            'id_input' => $insertInput,
            'user_id' => Auth::id()
        ]);


        return ("Berhasil");
        //$insert->save();

    }
}