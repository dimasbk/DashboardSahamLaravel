<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PostModel;
use App\Models\SekuritasModel;
use App\Models\JenisSahamModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SekuritasController extends Controller
{
    public function getSekuritas(Request $request){
        try {
            $sekuritas = SekuritasModel::all();
            return response()->json(['message'=>'Berhasil','data'=>$sekuritas]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal fetch'
            ]);
        }
    }

    public function getAllJenisSaham() {
        $jenisSaham = JenisSahamModel::all();

        if ($jenisSaham->isEmpty()) {
            return response()->json(['message' => 'No jenis saham found'], 404);
        }

        return response()->json(['message' => 'Success', 'data' => $jenisSaham]);
    }

}
