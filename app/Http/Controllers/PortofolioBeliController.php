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

    public function getdata($user_id){
        $dataporto = PortofolioBeliModel::where('user_id', $user_id)->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')->get();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();

        $data = compact(['dataporto'],['emiten'],['jenis_saham']);
        //dd($data);
        return view('portofoliobeli', $data);
    }

    public function insertData(Request $request){

        $id = Auth::id();
        $insert = PortofolioBeliModel::create([
            'id_saham' => $request->id_saham,
            'user_id' => $id,
            'jenis_saham' => $request->id_jenis_saham,
            'volume' => $request->volume,
            'tanggal_beli' => $request->tanggal_beli,
            'harga_beli' => $request->harga_beli,
            'fee_beli_persen' => $request->fee_beli_persen,
        ]);

        dd($insert);
        //dd($request);

        if($insert){
            return redirect()->action(
            [PortofolioBeliController::class, 'getData'], ['user_id' => $id]
        );
        }
    }

    public function getEdit($id_portofolio_beli){
        $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $id_portofolio_beli)->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')->get();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();

        $data = compact(['dataporto'],['emiten'],['jenis_saham']);
        //dd($data);
        return view('editportofoliobeli', $data);
    }

    public function editData(Request $request){

        $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $request->id_portofolio_beli)->firstOrFail();
        $id = Auth::id();
        //dd($dataporto);
        
        
        $dataporto->id_saham = $request->id_saham;
        $dataporto->user_id = $id;
        $dataporto->jenis_saham = $request->id_jenis_saham;
        $dataporto->volume = $request->volume;
        $dataporto->tanggal_beli = $request->tanggal_beli;
        $dataporto->harga_beli = $request->harga_beli;
        $dataporto->fee_beli_persen = $request->fee_beli_persen;
        $dataporto->save();
        

        return redirect()->to('portofoliobeli/'.$id);
    }

}
