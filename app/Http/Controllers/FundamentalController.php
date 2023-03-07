<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InputFundamentalModel;
use App\Models\DetailInputFundamentalModel;
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
        $id = $id = Auth::id();
        $input = InputFundamentalModel::where('user_id', $id)
            ->where('tb_input.id_saham', $idEmiten)
            ->join('tb_saham', 'tb_input.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_detail_input', 'tb_input.id_detail_input', '=', 'tb_detail_input.id_detail_input')
            ->orderBy('tahun', 'DESC')
            ->get();
        //dd($input);
        return view('fundamentalbank1', compact(['input'], ['emiten']));
    }
}