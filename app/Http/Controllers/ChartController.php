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

    public function index($ticker){

        return view('chartdetail', ['ticker' => $ticker]);
    }

    public function oneWeek($ticker){
            
        $today = date("Y-m-d");
        $monthBefore = date('Y-m-d', strtotime($today. ' -1 week')); 
        $response = Http::acceptJson()
        ->withHeaders([
            'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
        ])->get('https://api.goapi.id/v1/stock/idx/'.$ticker.'/historical', [
            'to' => $today,
            'from' => $monthBefore 
        ])->json();

        $data = $response['data']['results'];
        $data_historical = array_reverse($data);
        //dd($monthBefore);
        return $data_historical;
    }

    public function oneMonth($ticker){
            
        $today = date("Y-m-d");
        $monthBefore = date('Y-m-d', strtotime($today. ' -1 month')); 
        $response = Http::acceptJson()
        ->withHeaders([
            'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
        ])->get('https://api.goapi.id/v1/stock/idx/'.$ticker.'/historical', [
            'to' => $today,
            'from' => $monthBefore 
        ])->json();

        $data = $response['data']['results'];
        $data_historical = array_reverse($data);
        //dd($monthBefore);
        return $data_historical;
    }

    public function oneYear($ticker){
            
        $today = date("Y-m-d");
        $monthBefore = date('Y-m-d', strtotime($today. ' -1 year')); 
        $response = Http::acceptJson()
        ->withHeaders([
            'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
        ])->get('https://api.goapi.id/v1/stock/idx/'.$ticker.'/historical', [
            'to' => $today,
            'from' => $monthBefore 
        ])->json();

        $data = $response['data']['results'];
        $data_historical = array_reverse($data);
        //dd($monthBefore);
        return $data_historical;
    }

    public function threeYear($ticker){
            
        $today = date("Y-m-d");
        $monthBefore = date('Y-m-d', strtotime($today. ' -3 year')); 
        $response = Http::acceptJson()
        ->withHeaders([
            'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
        ])->get('https://api.goapi.id/v1/stock/idx/'.$ticker.'/historical', [
            'to' => $today,
            'from' => $monthBefore 
        ])->json();

        $data = $response['data']['results'];
        $data_historical = array_reverse($data);
        //dd($monthBefore);
        return $data_historical;
    }
}
