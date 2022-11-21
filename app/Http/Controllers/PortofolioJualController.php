<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PortofolioJualModel;
use App\Models\JenisSahamModel;
use App\Models\SahamModel;
use Illuminate\Support\Facades\Auth;


class PortofolioJualController extends Controller
{

    public function __construct(){
        $this->PortofolioJualModel = new PortofolioJualModel;
        $this->JenisSahamModel = new JenisSahamModel;
        $this->SahamModel = new SahamModel;
        $this->middleware('auth');
    }

    public function index(){

        $dataporto = [
            'portojual'=>$this->PortofolioJualModel->allData(),
        ];
        return view('portofoliojual', $dataporto);

    }

    public function getData($user_id){

        $dataporto = [
            'portojual'=>$this->PortofolioJualModel->getData($user_id),
        ];
        $emiten = [
            'emiten'=>$this->SahamModel->allData(),
        ];
        $jenis_saham = [
            'jenis_saham'=>$this->JenisSahamModel->allData(),
        ];
        $data = compact(['dataporto'],['emiten'],['jenis_saham']);
        //dd($data);

        return view('portofoliojual', $data);
        //return view('portofoliobeli', compact(['dataporto'=>$dataporto],['emiten'=>$emiten],['jenis_saham'=>$jenis_saham])); 

    }
}
