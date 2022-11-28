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
        return response()->json(['messsage'=>'Berhasil', 'data'=>$dataporto ]);

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
                [PortofolioJualController::class, 'getdata'], ['user_id' => $insert]
            );
        }
    }

    public function getEdit($id_portofolio_jual){
        $dataporto = PortofolioJualModel::where('id_portofolio_jual', $id_portofolio_jual)->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')->get();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();

        $data = compact(['dataporto'],['emiten'],['jenis_saham']);
        //dd($data);
        return view('editportofoliojual', $data);
    }

    public function editData(Request $request){

        $dataporto = PortofolioJualModel::where('id_portofolio_jual', $request->id_portofolio_jual)->firstOrFail();
        $id = Auth::id();
        //dd($dataporto);
        
        
        $dataporto->id_saham = $request->id_saham;
        $dataporto->user_id = $id;
        $dataporto->jenis_saham = $request->id_jenis_saham;
        $dataporto->volume = $request->volume;
        $dataporto->tanggal_jual = $request->tanggal_jual;
        $dataporto->harga_jual = $request->harga_jual;
        $dataporto->fee_jual_persen = $request->fee_jual_persen;
        $dataporto->save();
        

        return redirect()->to('portofoliojual/'.$id);
    }

    public function deleteData($id_portofolio_jual){
        $dataporto = PortofolioJualModel::where('id_portofolio_jual', $id_portofolio_jual)->firstOrFail();
        $dataporto->delete();
        $id = Auth::id();
        return redirect()->to('portofoliojual/'.$id);
    }
}
