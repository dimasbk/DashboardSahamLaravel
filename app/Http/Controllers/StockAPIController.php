<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\SahamModel;

class StockAPIController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $response = Http::acceptJson()
        ->withHeaders([
            'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
        ])->get('https://api.goapi.id/v1/stock/idx/companies')->json();


        $data = $response['data']['results'];
        //dd($response['data']['results']);

        return view('chart', ['data'=>$data]);
    }

    public function stock($emiten)
    {
        $response = Http::acceptJson()
        ->withHeaders([
            'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
        ])->get('https://api.goapi.id/v1/stock/idx/'.$emiten)->json();

        dd($response);
    }

    public function updateStock(){
        $response = Http::acceptJson()
        ->withHeaders([
            'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
        ])->get('https://api.goapi.id/v1/stock/idx/companies')->json();

        $data = $response['data']['results'];

        $newData = array_column($data, 'ticker');

        foreach($newData as $item){
            $insert = SahamModel::updateOrCreate([
                'nama_saham' => $item
            ]);
        }

        
    }
}
