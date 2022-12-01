<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\PortofolioJualModel;
use DB;

class ReportJualController extends Controller
{
    public function __construct(){
        $this->PortofolioJualModel = new PortofolioJualModel;
        $this->middleware('auth');
    }

    public function getData1($user_id){
        $jual = PortofolioJualModel::selectRaw("COUNT(tb_portofolio_jual.`id_portofolio_jual`) AS jumlah_jual , tb_saham.`nama_saham`")
            ->where('tb_portofolio_jual.user_id', $user_id)
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->groupBy("tb_saham.nama_saham")
            ->get();
            
        dd($jual);
        
    }   

    public function getYear($user_id){
        $tahun = PortofolioJualModel::selectRaw('EXTRACT(YEAR FROM tanggal_jual) as tahun')
        ->where('tb_portofolio_jual.user_id', $user_id)
        ->groupBy(DB::raw('EXTRACT(YEAR FROM tanggal_jual)'))
        ->get();
        
        $data = compact(['tahun']);
        //dd($data);
        return view('reportjual', $data);
    }

    public function getData($user_id, $tahun){
        $jual = PortofolioJualModel::selectRaw("SUM(tb_portofolio_jual.`harga_jual` - (tb_portofolio_jual.`harga_jual`*tb_portofolio_jual.`fee_jual_persen`/100)) AS jual_bersih")
            ->selectRaw('SUM(tb_portofolio_jual.`volume`) AS total_volume')
            ->selectRaw('tb_saham.`nama_saham`')
            ->where('tb_portofolio_jual.user_id', $user_id)
            ->whereRaw('YEAR(tb_portofolio_jual.`tanggal_jual`) = ' . $tahun)
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->groupBy("tb_saham.nama_saham")
            ->get();
            
        //dd($jual);
        $data = compact(['jual']);
        //dd($data);

        return view('detailreportjual', $data);
        
    }  
}
