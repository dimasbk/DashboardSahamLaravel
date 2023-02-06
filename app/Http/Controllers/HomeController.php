<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $response = Http::acceptJson()
        ->withHeaders([
            'X-API-KEY' => 'fe4bd0445ab2472281d6ac636d5d426d'
        ])->get('https://newsapi.org/v2/everything', [
            'q' => 'saham OR IHSG OR ekonomi NOT showbiz',
            'sortBy' => 'publishedAt',
            'language' => 'id',
            'searchIn'=> 'content',
            'pageSize' => '25'
        ])->json();

        $berita = $response['articles'];
        //dd($berita);

        return view('home', ['data'=>$berita]);
    }
}
