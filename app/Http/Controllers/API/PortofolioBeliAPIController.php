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
    public function allData()
    {

        $id_user = Auth::id();
        $dataporto = PortofolioBeliModel::join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
        ->join('tb_sekuritas', 'tb_portofolio_beli.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
        ->where('user_id', $id_user)
        ->orderBy('tanggal_beli', 'desc')
        ->get();

        return response()->json(['messsage'=>'Berhasil', 'data'=>$dataporto]);
    }

    public function getdata($user_id)
    {
        $dataporto = PortofolioBeliModel::where('user_id', $user_id)->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')->get();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();

        $data = compact(['dataporto'], ['emiten'], ['jenis_saham']);
        //dd($data);
        return response()->json(['messsage' => 'Berhasil', 'data' => $data]);
    }

    public function insertData(Request $request)
    {

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
        if ($insert) {
            //$insert->save();
            return response()->json(['messsage' => 'Berhasil', 'data' => $insert]);
        }
    }

    public function updateData(Request $request)
    {

        $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $request->id_portofolio_beli)->firstOrFail();
        $id = Auth::id();

        $dataporto->volume = $request->volume;
        $dataporto->tanggal_beli = $request->tanggal_beli;
        $dataporto->harga_beli = $request->harga_beli;
        $dataporto->save();


        return response()->json(['messsage' => 'Data Berhasil di Update']);
    }


    public function  editData(Request $request)
    {

        $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $request->id_portofolio_beli)->firstOrFail();
        $id = Auth::id();
        //dd($dataporto);


        // $dataporto->id_saham = $request->id_saham;
        // $dataporto->user_id = $id;
        // $dataporto->jenis_saham = $request->id_jenis_saham;
        $dataporto->volume = $request->volume;
        $dataporto->tanggal_beli = $request->tanggal_beli;
        $dataporto->harga_beli = $request->harga_beli;
        // $dataporto->fee_beli_persen = $request->fee_beli_persen;
        $dataporto->save();


        return response()->json(['messsage' => 'Data Berhasil di Update']);
    }

    public function deleteData($id_portofolio_jual)
    {
        $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $id_portofolio_jual)->firstOrFail();
        $dataporto->delete();
        $id = Auth::id();
        return response()->json(['messsage' => 'Data Berhasil di Delete']);
    }
}
