<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PortofolioBeliModel;
use App\Models\JenisSahamModel;
use App\Models\SahamModel;
use Illuminate\Support\Facades\Auth;

class PortofolioBeliAPIController extends Controller
{
    public function __construct(){
        $this->PortofolioBeliModel = new PortofolioBeliModel;
        $this->JenisSahamModel = new JenisSahamModel;
        $this->SahamModel = new SahamModel;
        $this->middleware('auth');
    }

    public function allData(){

        $dataporto = PortofolioBeliModel::all();
        return response()->json(['messsage'=>'Berhasil', 'data'=>$dataporto ]);

    }

    public function getdata($user_id){
        $dataporto = PortofolioBeliModel::where('user_id', $user_id)->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')->get();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();

        $data = compact(['dataporto'],['emiten'],['jenis_saham']);
        //dd($data);
        return response()->json(['messsage'=>'Berhasil', 'data'=>$data]);
    }

    public function insertData(Request $request){

        $id = Auth::id();        
        $insert = PortofolioBeliModel::create([
            'id_saham' => $request->id_saham,
            'user_id' => $id,
            'jenis_saham' => $request->id_jenis_saham,
            'volume' => $request->volume,
            'tanggal_jual' => $request->tanggal_beli,
            'harga_jual' => $request->harga_beli,
            'fee_jual_persen' => $request->fee_beli_persen,
        ]);

        //dd($data);
        //dd($request);
        if($insert){
            //$insert->save();
            return response()->json(['messsage'=>'Berhasil', 'data'=>$insert ]);
        }
    }
}
