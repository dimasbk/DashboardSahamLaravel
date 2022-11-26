<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\PortofolioBeliModel;

class ReportBeliController extends Controller
{
    public function __construct(){
        $this->PortofolioBeliModel = new PortofolioBeliModel;
        $this->middleware('auth');
    }

    public function getData($user_id){
        $beli = PortofolioBeliModel::where('user_id', $user_id)
            ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->get()
            ->sum();
        //$saham = $dataporto->id_saham;
        
        
        dd($beli);
    }   
}
