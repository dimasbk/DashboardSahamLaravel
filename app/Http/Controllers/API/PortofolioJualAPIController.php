<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PortofolioJualModel;
use App\Models\JenisSahamModel;
use App\Models\SahamModel;
use Illuminate\Support\Facades\Auth;

class PortofolioJualAPIController extends Controller
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
        return response()->json(['messsage'=>'Berhasil', 'data'=>$dataporto ]);

    }

    public function getdata($user_id){
        $dataporto = PortofolioJualModel::where('user_id', $user_id)->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')->get();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();

        $data = compact(['dataporto'],['emiten'],['jenis_saham']);
        //dd($data);
        return response()->json(['messsage'=>'Berhasil', 'data'=>$dataporto ]);
    }
    public function insertData(Request $request){

        $id = Auth::id();        

        $insert = PortofolioJualModel::create([
            'id_saham' => $request->id_saham,
            'user_id' => $id,
            'jenis_saham' => $request->id_jenis_saham,
            'volume' => $request->volume,
            'tanggal_jual' => $request->tanggal_jual,
            'harga_jual' => $request->harga_jual,
            'fee_jual_persen' => $request->fee_jual_persen,
        ]);

        //$insert->save();
        //dd($data);
        //dd($request);
        //$this->PortofolioJualModel->insertData($data);
        if($insert){
            $insert->save();
            return response()->json(['messsage'=>'Berhasil', 'data'=>$insert ]);
        }
    }
}
