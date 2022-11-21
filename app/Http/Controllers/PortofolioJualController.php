<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PortofolioJualModel;


class PortofolioJualController extends Controller
{

    public function __construct(){
        $this->PortofolioJualModel = new PortofolioJualModel;
        $this->middleware('auth');
    }

    public function index(){

        $dataporto = [
            'portojual'=>$this->PortofolioJualModel->allData(),
        ];
        return view('portofoliojual', $dataporto);

    }
}
