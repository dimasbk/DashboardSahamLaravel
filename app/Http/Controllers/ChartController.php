<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChartController extends Controller
{
    public function __construct(){
        
        $this->middleware('auth');
    }

    public function chart($ticker){

        $response = Http::acceptJson()
        ->withHeaders([
            'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
        ])->get('https://api.goapi.id/v1/stock/idx/'.$ticker.'/historical', [
            'to' => '2023-01-07',
            'from' => '2022-12-07' 
        ])->json();

        $data = $response['data']['results'];
        $data_historical = array_reverse($data);
        //dd($databaru);
        return view('chartdetail', ['data'=>$data_historical]);
    }
}
