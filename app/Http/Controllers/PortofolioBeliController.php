<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PortofolioBeliModel;
use App\Models\JenisSahamModel;
use App\Models\SahamModel;
use Illuminate\Support\Facades\Auth;



class PortofolioBeliController extends Controller
{

    public function __construct(){
        $this->PortofolioBeliModel = new PortofolioBeliModel;
        $this->JenisSahamModel = new JenisSahamModel;
        $this->SahamModel = new SahamModel;
        $this->middleware('auth');
    }

    public function allData(){

        $dataporto = [
            'portobeli'=>$this->PortofolioBeliModel->allData(),
        ];
        return view('portofoliobeli', $dataporto);

    }

    public function getData($user_id){

        $dataporto = [
            'portobeli'=>$this->PortofolioBeliModel->getData($user_id),
        ];
        $emiten = [
            'emiten'=>$this->SahamModel->allData(),
        ];
        $jenis_saham = [
            'jenis_saham'=>$this->JenisSahamModel->allData(),
        ];
        $data = compact(['dataporto'],['emiten'],['jenis_saham']);
        //dd($data);

        return view('portofoliobeli', $data);
        //return view('portofoliobeli', compact(['dataporto'=>$dataporto],['emiten'=>$emiten],['jenis_saham'=>$jenis_saham])); 

    }

    public function insertData(Request $request){

        $id = Auth::id();
        $data = [
            'id_saham' => $request->id_saham,
            'user_id' => $id,
            'jenis_saham' => $request->id_jenis_saham,
            'volume' => $request->volume,
            'tanggal_beli' => $request->tanggal_beli,
            'harga_beli' => $request->harga_beli,
            'fee_beli_persen' => $request->fee_beli_persen,

        ]; 

        //dd($data);
        //dd($request);
        $this->PortofolioBeliModel->insertData($data);
        if($data){
            return redirect()->action(
            [PortofolioBeliController::class, 'getData'], ['user_id' => $id]
        );
        }
    }
}
