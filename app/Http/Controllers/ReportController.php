<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\PortofolioBeliModel;
use App\Models\PortofolioJualModel;
use App\Models\SahamModel;
use DB;
use DateTime;

class ReportController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function report($year)
    {


        $data = PortofolioBeliModel::join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->select('tb_portofolio_beli.id_saham', 'tb_saham.nama_saham', DB::raw('SUM(tb_portofolio_beli.volume) AS total_volume_beli'), DB::raw('AVG(tb_portofolio_beli.harga_beli) AS avg_harga_beli'))
            ->where('tb_portofolio_beli.user_id', '=', Auth::id())
            ->whereYear('tanggal_beli', $year)
            ->groupBy('tb_portofolio_beli.id_saham', 'tb_saham.nama_saham')
            ->get()->toArray();

        for ($i = 0; $i < count($data); $i++) {
            $id = $data[$i]['id_saham'];
            $saham = $data[$i]['nama_saham'];
            $jualReport = PortofolioJualModel::join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
                ->select('tb_portofolio_jual.id_saham', 'tb_saham.nama_saham', DB::raw('SUM(tb_portofolio_jual.volume) AS total_volume_jual'), DB::raw('AVG(tb_portofolio_jual.harga_jual) AS avg_harga_jual'))
                ->where('tb_portofolio_jual.user_id', '=', Auth::id())
                ->where('tb_portofolio_jual.id_saham', '=', $id)
                ->whereYear('tanggal_jual', $year)
                ->groupBy('tb_portofolio_jual.id_saham', 'tb_saham.nama_saham')
                ->get()->toArray();

            if (!$jualReport) {
                $data[$i]['total_volume_jual'] = 0;
                $data[$i]['avg_harga_jual'] = 0;
            } else {
                $data[$i]['total_volume_jual'] = $jualReport[0]['total_volume_jual'];
                $data[$i]['avg_harga_jual'] = $jualReport[0]['avg_harga_jual'];
            }
        }

        $beli = PortofolioBeliModel::select('id_portofolio_beli as id', 'id_saham', 'user_id', 'jenis_saham', 'volume', 'tanggal_beli', 'harga_beli', 'id_sekuritas')
            ->addSelect(DB::raw('NULL as close_persen, "beli" as tag'))
            ->where('user_id', Auth::id())
            ->get()->toArray();

        $jual = PortofolioJualModel::select('id_portofolio_jual as id', 'id_saham', 'user_id', 'jenis_saham', 'volume', 'tanggal_jual', 'harga_jual', 'id_sekuritas', 'close_persen')
            ->addSelect(DB::raw('"jual" as tag'))
            ->where('user_id', Auth::id())
            ->get()->toArray();

        $result = array_merge($beli, $jual);
        $tahun = $year;
        //dd($data);

        return view('report', compact(['data', 'tahun']));

    }

    public function range()
    {
        $data = [];
        return view('reportrange', compact(['data']));
    }

    public function reportRange(Request $request)
    {

        $from = $request->from;

        $to = $request->to;

        $beli = PortofolioBeliModel::where('user_id', Auth::id())
            ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_beli.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->whereBetween('tanggal_beli', [$from, $to])
            ->get()->toArray();

        $jual = PortofolioJualModel::where('user_id', Auth::id())
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->whereBetween('tanggal_jual', [$from, $to])
            ->get()->toArray();

        foreach ($beli as &$item) {
            $tanggal_beli = new DateTime($item['tanggal_beli']);
            $tanggal = $tanggal_beli->format('d-m-Y');
            $item['tanggal'] = $tanggal;
            $item["harga"] = $item["harga_beli"];
            $item["tag"] = 'beli';
            unset($item['harga_beli']);
            unset($item['tanggal_beli']);
        }

        foreach ($jual as &$item) {
            $tanggal_jual = new DateTime($item['tanggal_jual']);
            $tanggal = $tanggal_jual->format('d-m-Y');
            $item['tanggal'] = $tanggal;
            $item["harga"] = $item["harga_jual"];
            $item["tag"] = 'jual';
            unset($item['harga_jual']);
            unset($item['tanggal_jual']);
        }
        $data = array_merge($beli, $jual);

        usort($data, function ($a, $b) {
            $tanggal_a = strtotime($a['tanggal']);
            $tanggal_b = strtotime($b['tanggal']);

            if ($tanggal_a == $tanggal_b) {
                return 0;
            }

            return ($tanggal_a < $tanggal_b) ? -1 : 1;
        });

        //dd($data);

        return view('reportrange', compact(['data']));
    }

    public function detailReport($year, $emiten, $function = null)
    {
        $idEmiten = SahamModel::where('nama_saham', $emiten)->value('id_saham');
        $beli = PortofolioBeliModel::where('user_id', Auth::id())
            ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_beli.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->where('tb_portofolio_beli.id_saham', $idEmiten)
            ->whereYear('tanggal_beli', $year)
            ->get()->toArray();

        $jual = PortofolioJualModel::where('user_id', Auth::id())
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->where('tb_portofolio_jual.id_saham', $idEmiten)
            ->whereYear('tanggal_jual', $year)
            ->get()->toArray();

        $dataReport = PortofolioBeliModel::join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->select('tb_portofolio_beli.id_saham', 'tb_saham.nama_saham', DB::raw('SUM(tb_portofolio_beli.volume) AS total_volume_beli'), DB::raw('AVG(tb_portofolio_beli.harga_beli) AS avg_harga_beli'))
            ->where('tb_portofolio_beli.user_id', '=', Auth::id())
            ->where('tb_portofolio_beli.id_saham', '=', $idEmiten)
            ->whereYear('tanggal_beli', $year)
            ->groupBy('tb_portofolio_beli.id_saham', 'tb_saham.nama_saham')
            ->get()->toArray();

        for ($i = 0; $i < count($dataReport); $i++) {
            $id = $dataReport[$i]['id_saham'];
            $saham = $dataReport[$i]['nama_saham'];
            $jualReport = PortofolioJualModel::join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
                ->select('tb_portofolio_jual.id_saham', 'tb_saham.nama_saham', DB::raw('SUM(tb_portofolio_jual.volume) AS total_volume_jual'), DB::raw('AVG(tb_portofolio_jual.harga_jual) AS avg_harga_jual'))
                ->where('tb_portofolio_jual.user_id', '=', Auth::id())
                ->where('tb_portofolio_jual.id_saham', '=', $idEmiten)
                ->whereYear('tanggal_jual', $year)
                ->groupBy('tb_portofolio_jual.id_saham', 'tb_saham.nama_saham')
                ->get()->toArray();

            if (!$jualReport) {
                $dataReport[$i]['total_volume_jual'] = 0;
                $dataReport[$i]['avg_harga_jual'] = 0;
            } else {
                $dataReport[$i]['total_volume_jual'] = $jualReport[0]['total_volume_jual'];
                $dataReport[$i]['avg_harga_jual'] = $jualReport[0]['avg_harga_jual'];
            }
        }


        foreach ($beli as &$item) {
            $tanggal_beli = new DateTime($item['tanggal_beli']);
            $tanggal = $tanggal_beli->format('d-m-Y');
            $item["tanggal"] = $tanggal;
            $item["harga"] = $item["harga_beli"];
            $item["tag"] = 'beli';
            unset($item['harga_beli']);
            unset($item['tanggal_beli']);
        }

        foreach ($jual as &$item) {
            $tanggal_jual = new DateTime($item['tanggal_jual']);
            $tanggal = $tanggal_jual->format('d-m-Y');
            $item['tanggal'] = $tanggal;
            $item["harga"] = $item["harga_jual"];
            $item["tag"] = 'jual';
            unset($item['harga_jual']);
            unset($item['tanggal_jual']);
        }

        $data = array_merge($beli, $jual);

        usort($data, function ($a, $b) {
            $tanggalA = DateTime::createFromFormat('d-m-Y', $a['tanggal']);
            $tanggalB = DateTime::createFromFormat('d-m-Y', $b['tanggal']);

            return $tanggalA <=> $tanggalB;
        });

        $beli_total = 0;
        $jual_total = 0;
        foreach ($data as $rep) {
            if ($rep["tag"] == "beli") {
                $beli_total += $rep["volume"];
            }
        }
        foreach ($data as $rep) {
            if ($rep["tag"] == "jual") {
                $jual_total += $rep["volume"];
            }
        }
        //dd($data);
        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
            ])->get('https://api.goapi.id/v1/stock/idx/prices', [
                    'symbols' => $emiten
                ])->json();

        $totalLot = ($beli_total - $jual_total) * 100;
        $hargaclose = $response['data']['results'][0]['close'];
        $avgBeli = $dataReport[0]['avg_harga_beli'];
        $avgJual = $dataReport[0]['avg_harga_jual'];
        $keuntungan = ($totalLot * $avgBeli) - ($totalLot * $hargaclose);
        $realisasi = ($totalLot * $avgBeli) - ($totalLot * $avgJual);

        if ($function === 1) {
            return compact(['keuntungan', 'realisasi']);
        }
        return view('reportDetail', compact(['data', 'keuntungan', 'realisasi']));
    }

    public function getYear()
    {
        $tahun = PortofolioBeliModel::selectRaw('EXTRACT(YEAR FROM tanggal_beli) as tahun')
            ->where('tb_portofolio_beli.user_id', Auth::id())
            ->groupBy(DB::raw('EXTRACT(YEAR FROM tanggal_beli)'))
            ->get()->toArray();

        $years = [];

        foreach ($tahun as $year) {
            $keuntungan = [];
            $realisasi = [];
            $dataReport = PortofolioBeliModel::whereYear('tanggal_beli', $year)
                ->where('user_id', Auth::id())
                ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
                ->get();
            //dd($dataReport);
            if ($dataReport) {
                foreach ($dataReport as $data) {
                    $report = $this->detailReport($year, $data->nama_saham, 1);
                    array_push($keuntungan, $report['keuntungan']);
                    array_push($realisasi, $report['realisasi']);
                }
            }
            $pushedData = [
                'year' => $year['tahun'],
                'keuntungan' => array_sum($keuntungan) / count($keuntungan),
                'realisasi' => array_sum($realisasi) / count($realisasi)
            ];
            array_push($years, $pushedData);
        }

        //dd($years);

        $data = [];

        foreach ($years as $key => $year) {
            $percent = 0;
            if ($key != 0) {
                $percent = $years[$key]['keuntungan'] / $years[$key - 1]['keuntungan'];
            }

            $arr = [
                'year' => $years[$key]['year'],
                'keuntungan' => $years[$key]['keuntungan'],
                'realisasi' => $years[$key]['realisasi'],
                'keuntunganPercent' => $percent
            ];

            array_push($data, $arr);
        }

        return view('reportYear', compact(['data']));
    }

}