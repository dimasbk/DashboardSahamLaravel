<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\PortofolioBeliModel;
use DB;

class ReportBeliController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getData1($user_id)
    {
        $beli = PortofolioBeliModel::selectRaw("COUNT(tb_portofolio_beli.`id_portofolio_beli`) AS jumlah_beli , tb_saham.`nama_saham`")
            ->where('tb_portofolio_beli.user_id', $user_id)
            ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->groupBy("tb_saham.nama_saham")
            ->get();

        dd($beli);

    }

    public function getYear($user_id)
    {
        $tahun = PortofolioBeliModel::selectRaw('EXTRACT(YEAR FROM tanggal_beli) as tahun')
            ->where('tb_portofolio_beli.user_id', $user_id)
            ->groupBy(DB::raw('EXTRACT(YEAR FROM tanggal_beli)'))
            ->get();

        $data = compact(['tahun']);
        //dd($data);
        return view('reportbeli', $data);
    }

    public function getData($user_id, $tahun)
    {
        $beli = PortofolioBeliModel::selectRaw("SUM(tb_portofolio_beli.`harga_beli` - (tb_portofolio_beli.`harga_beli`*tb_portofolio_beli.`fee_beli_persen`/100)) AS beli_bersih")
            ->selectRaw('SUM(tb_portofolio_beli.`volume`) AS total_volume')
            ->selectRaw('tb_saham.`nama_saham`')
            ->where('tb_portofolio_beli.user_id', $user_id)
            ->whereRaw('YEAR(tb_portofolio_beli.`tanggal_beli`) = ' . $tahun)
            ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->groupBy("tb_saham.nama_saham")
            ->get();

        //dd($beli);
        $data = compact(['beli']);

        return view('detailreportbeli', $data);

    }
}