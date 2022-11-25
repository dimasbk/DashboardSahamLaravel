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

    public function getData1($user_id){

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
        dd($data);

        //return view('portofoliojual', $data);
        //return view('portofoliobeli', compact(['dataporto'=>$dataporto],['emiten'=>$emiten],['jenis_saham'=>$jenis_saham])); 

    }

    public function getdata($user_id){
        $dataporto = PortofolioJualModel::where('user_id', $user_id)->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')->get();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();

        $data = compact(['dataporto'],['emiten'],['jenis_saham']);
        //dd($data);
        return view('portofoliojual', $data);
    }
    public function insertData(Request $request){

        $id = Auth::id();
        $data = [
            'id_saham' => $request->id_saham,
            'user_id' => $id,
            'jenis_saham' => $request->id_jenis_saham,
            'volume' => $request->volume,
            'tanggal_jual' => $request->tanggal_jual,
            'harga_jual' => $request->harga_jual,
            'fee_jual_persen' => $request->fee_jual_persen,

        ]; 

        

        $insert = PortofolioJualModel::create([
            'id_saham' => $request->id_saham,
            'user_id' => $id,
            'jenis_saham' => $request->id_jenis_saham,
            'volume' => $request->volume,
            'tanggal_jual' => $request->tanggal_jual,
            'harga_jual' => $request->harga_jual,
            'fee_jual_persen' => $request->fee_jual_persen,
        ]);

        $insert->save();
        //dd($data);
        //dd($request);
        //$this->PortofolioJualModel->insertData($data);
        if($data){
            return redirect()->action(
                [PortofolioJualController::class, 'getdata'], ['user_id' => $id]
            );
        }
    }
}
