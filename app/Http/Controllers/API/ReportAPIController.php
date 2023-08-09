<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SahamModel;
use DateTime;
//use Http;
use Illuminate\Http\Request;
use App\Models\PortofolioBeliModel;
use App\Models\PortofolioJualModel;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SubscriberModel;
use Illuminate\Support\Facades\Http;
use App\Models\PostModel;

class ReportAPIController extends Controller
{

    public function getAnalyst(Request $request)
    {
        $id_user = Auth::id();
        $notToFollow = SubscriberModel::where('id_subscriber', $id_user)->where('status', 'subscribed')->pluck('id_analyst')->toArray();
        array_push($notToFollow, $id_user);
        $toFollow = User::where('id_roles', 2)->whereNotIn('id', $notToFollow)->get()->toArray();
        $existing = SubscriberModel::where('id_subscriber', $id_user)
            ->join('users', 'tb_subscription.id_analyst', '=', 'users.id')
            ->get()->toArray();

        $data = compact(['toFollow', 'existing']);

        //dd($existing);
        return response()->json([
            'status' => 'success',
            'data' => $toFollow
        ], 200);


        //return view('landingPage/analyst', $data);
    }

    public function reportHistory($year)
    {
        // $currentYear = date('Y');
        // $year = $currentYear;
       // $year = 2023;
        $id_user = Auth::id();
        //$id_user = 12;
        $data = PortofolioBeliModel::join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->select('tb_portofolio_beli.id_saham', 'tb_saham.nama_saham', DB::raw('SUM(tb_portofolio_beli.volume) AS total_volume_beli'), DB::raw('AVG(tb_portofolio_beli.harga_beli) AS avg_harga_beli'))
            ->where('tb_portofolio_beli.user_id', '=', $id_user)
            ->whereYear('tanggal_beli', $year)
            ->groupBy('tb_portofolio_beli.id_saham', 'tb_saham.nama_saham')
            ->get()->toArray();

        for ($i = 0; $i < count($data); $i++) {
            $id = $data[$i]['id_saham'];
            $saham = $data[$i]['nama_saham'];
            $beforeDate = date('Y-m-d', strtotime("-1 day", strtotime(date("Y-m-d"))));
           // $yearBefore = date('Y-m-d', strtotime($beforeDate . ' -1 year'));
            $jualReport = PortofolioJualModel::join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
                ->select('tb_portofolio_jual.id_saham', 'tb_saham.nama_saham', DB::raw('SUM(tb_portofolio_jual.volume) AS total_volume_jual'), DB::raw('AVG(tb_portofolio_jual.harga_jual) AS avg_harga_jual'))
                ->where('tb_portofolio_jual.user_id', '=', $id_user)
                ->where('tb_portofolio_jual.id_saham', '=', $id)
                ->whereYear('tanggal_jual', $year)
                ->groupBy('tb_portofolio_jual.id_saham', 'tb_saham.nama_saham')
                ->get()->toArray();

            $untung = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => '1hzlCQzlW2UqjegV5GFoiS78vaW9tF'
            ])->get('https://api.goapi.id/v1/stock/idx/' . $saham . '/historical', [
                'to' => $beforeDate,
                'from' => $beforeDate
            ])->json();
            $hargaclose = $untung['data']['results'][0]['close'];
               // return $untung;


            if (!$jualReport) {
                $data[$i]['total_volume_jual'] = 0;
                //$data[$i]['total_volume_beli'] = 0;
                $data[$i]['avg_harga_jual'] = 0;
                $data[$i]['total_volume'] = $data[$i]['total_volume_beli'];
                $data[$i]['keuntungan'] = 100 * (($data[$i]['total_volume']*$data[$i]['avg_harga_beli'])-($data[$i]['total_volume']*$hargaclose ));
                $data[$i]['sisa_aset'] = 100*$data[$i]['total_volume']*$data[$i]['avg_harga_beli'];
                $data[$i]['harga_close'] = $hargaclose;
                $data[$i]['year'] = $year;
                // $data[$i]['keuntungan'] = (string)$data[$i]['keuntungan'];

            } else {
                $data[$i]['total_volume_jual'] = $jualReport[0]['total_volume_jual'];
               // $data[$i]['total_volume_beli'] = $jualReport[0]['total_volume_beli'];
                $data[$i]['avg_harga_jual'] = round($jualReport[0]['avg_harga_jual']);
                $data[$i]['total_volume'] = $data[$i]['total_volume_beli']-$jualReport[0]['total_volume_jual'];
                //$data[$i]['keuntungan'] = 0;
                $data[$i]['keuntungan'] = round(100*(($data[$i]['total_volume'] *$data[$i]['avg_harga_beli'] ) - ($data[$i]['total_volume'] *$hargaclose))) ;
                $data[$i]['sisa_aset'] = round(100*($data[$i]['total_volume']*$data[$i]['avg_harga_beli']));
                $data[$i]['harga_close'] = $hargaclose;

                $data[$i]['total_volume_jual'] = (string)$data[$i]['total_volume_jual'];
               // $data[$i]['total_volume_beli'] = (string)$data[$i]['total_volume_beli'];
                $data[$i]['avg_harga_jual'] = (string)$data[$i]['avg_harga_jual'];
                $data[$i]['total_volume'] = (string)$data[$i]['total_volume'];
                $data[$i]['keuntungan'] = (string)$data[$i]['keuntungan'];
                $data[$i]['year'] = $year;
               // $data[$i]['sisa_aset'] = (string)$data[$i]['sisa_aset'];
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
        $returnData = compact(['data', 'tahun']);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function reportt(Request $request)
    {
        $currentYear = date('Y');
        $year = $currentYear;
       // $year = 2023;
        $id_user = Auth::id();
        //$id_user = 12;
        $data = PortofolioBeliModel::join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->select('tb_portofolio_beli.id_saham', 'tb_saham.nama_saham', DB::raw('SUM(tb_portofolio_beli.volume) AS total_volume_beli'), DB::raw('AVG(tb_portofolio_beli.harga_beli) AS avg_harga_beli'))
            ->where('tb_portofolio_beli.user_id', '=', $id_user)
            ->whereYear('tanggal_beli', $year)
            ->groupBy('tb_portofolio_beli.id_saham', 'tb_saham.nama_saham')
            ->get()->toArray();

        for ($i = 0; $i < count($data); $i++) {
            $id = $data[$i]['id_saham'];
            $saham = $data[$i]['nama_saham'];
            $beforeDate = date('Y-m-d', strtotime("-1 day", strtotime(date("Y-m-d"))));
           // $yearBefore = date('Y-m-d', strtotime($beforeDate . ' -1 year'));
            $jualReport = PortofolioJualModel::join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
                ->select('tb_portofolio_jual.id_saham', 'tb_saham.nama_saham', DB::raw('SUM(tb_portofolio_jual.volume) AS total_volume_jual'), DB::raw('AVG(tb_portofolio_jual.harga_jual) AS avg_harga_jual'))
                ->where('tb_portofolio_jual.user_id', '=', $id_user)
                ->where('tb_portofolio_jual.id_saham', '=', $id)
                ->whereYear('tanggal_jual', $year)
                ->groupBy('tb_portofolio_jual.id_saham', 'tb_saham.nama_saham')
                ->get()->toArray();

            $untung = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => '1hzlCQzlW2UqjegV5GFoiS78vaW9tF'
            ])->get('https://api.goapi.id/v1/stock/idx/' . $saham . '/historical', [
                'to' => $beforeDate,
                'from' => $beforeDate
            ])->json();
            $hargaclose = $untung['data']['results'][0]['close'];
               // return $untung;


            if (!$jualReport) {
                $data[$i]['total_volume_jual'] = 0;
                $data[$i]['avg_harga_jual'] = 0;
                $data[$i]['total_volume'] = $data[$i]['total_volume_beli'];
                $data[$i]['keuntungan'] = 100 * (($data[$i]['total_volume']*$data[$i]['avg_harga_beli'])-($data[$i]['total_volume']*$hargaclose ));
                $data[$i]['sisa_aset'] = 100*$data[$i]['total_volume']*$data[$i]['avg_harga_beli'];
                $data[$i]['harga_close'] = $hargaclose;
                $data[$i]['year'] = $year;
                // $data[$i]['keuntungan'] = (string)$data[$i]['keuntungan'];

            } else {
                $data[$i]['total_volume_jual'] = $jualReport[0]['total_volume_jual'];
                $data[$i]['avg_harga_jual'] = ($jualReport[0]['avg_harga_jual']);
                $data[$i]['total_volume'] = $data[$i]['total_volume_beli']-$jualReport[0]['total_volume_jual'] ;
                //$data[$i]['keuntungan'] = 0;
                $data[$i]['keuntungan'] = (100*(($data[$i]['total_volume'] *$data[$i]['avg_harga_beli'] ) - ($data[$i]['total_volume'] *$hargaclose))) ;
                $data[$i]['sisa_aset'] = (100*($data[$i]['total_volume']*$data[$i]['avg_harga_beli']) - ($data[$i]['total_volume']*$data[$i]['avg_harga_jual']));
                $data[$i]['harga_close'] = $hargaclose;

                $data[$i]['total_volume_jual'] = (string)$data[$i]['total_volume_jual'];
                $data[$i]['avg_harga_jual'] = (string)$data[$i]['avg_harga_jual'];
                $data[$i]['total_volume'] = (string)$data[$i]['total_volume'];
                $data[$i]['keuntungan'] = (string)$data[$i]['keuntungan'];
                $data[$i]['year'] = $year;
               // $data[$i]['sisa_aset'] = (string)$data[$i]['sisa_aset'];
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
        $returnData = compact(['data', 'tahun']);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function reportRange(Request $request)
    {

        $from = $request->from;

        $to = $request->to;

        $beli = PortofolioBeliModel::where('user_id', $request->user_id)
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
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function DetailReport($year, $emiten, $function = null) //(Request $request)
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
        $lastDayOfYear = new DateTime("{$year}-12-31");

        // Loop backwards from the last day of the year until a working day is found
        while ($lastDayOfYear->format('N') > 5) {
            $lastDayOfYear->modify('-1 day');
        }

        $lastWorkingDay = $lastDayOfYear->format('Y-m-d');

        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('goapi.apikey')
            ])->get('https://api.goapi.id/v1/stock/idx/' . $emiten . '/historical', [
                    'to' => $lastWorkingDay,
                    'from' => $lastWorkingDay
                ])->json();

        $totalLot = ($beli_total - $jual_total) * 100;
        $hargaclose = $response['data']['results'][0]['close'];
        $avgBeli = $dataReport[0]['avg_harga_beli'];
        $avgJual = $dataReport[0]['avg_harga_jual'];
        $keuntungan = ($totalLot * $avgBeli) - ($totalLot * $hargaclose);



        //$keuntungandetail = (object)$keuntungan;
        $keuntungann = (string)$keuntungan;


        $realisasi = ($totalLot * $avgBeli) - ($totalLot * $avgJual);
        if ($function === 1) {
            return compact(['keuntungan', 'realisasi']);
        }
        // $realisasidetail = (object)$realisasi;

        // foreach ($keuntungandetail as &$item) {
        //     $item['keuntungan'] = $keuntungan;
        // }

        // foreach ($realisasidetail as &$item) {
        //     $item['keuntungan'] = $realisasi;
        // }
        $realisasii = (string)$realisasi;

        $returnData = compact(['data', 'keuntungann', 'realisasii', 'hargaclose']);

        return response()->json([
            'status' => 'success',
            'data' => $returnData
        ], 200);
    }


    public function DetailReportt($year, $emiten, $function = null) //($emiten)
    {
        $currentYear = date('Y');
        $year = $currentYear;
        // $emiten = $request->emiten;
        $id_user = Auth::id();
        $idEmiten = SahamModel::where('nama_saham', $emiten)->value('id_saham');
        $beli = PortofolioBeliModel::where('user_id', $id_user)
            ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_beli.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->where('tb_portofolio_beli.id_saham', $idEmiten)
            ->whereYear('tanggal_beli', $year)
            ->get()->toArray();

        $jual = PortofolioJualModel::where('user_id', $id_user)
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->where('tb_portofolio_jual.id_saham', $idEmiten)
            ->whereYear('tanggal_jual', $year)
            ->get()->toArray();

        $dataReport = PortofolioBeliModel::join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->select('tb_portofolio_beli.id_saham', 'tb_saham.nama_saham', DB::raw('SUM(tb_portofolio_beli.volume) AS total_volume_beli'), DB::raw('AVG(tb_portofolio_beli.harga_beli) AS avg_harga_beli'))
            ->where('tb_portofolio_beli.user_id', '=', $id_user)
            ->where('tb_portofolio_beli.id_saham', '=', $idEmiten)
            ->whereYear('tanggal_beli', $year)
            ->groupBy('tb_portofolio_beli.id_saham', 'tb_saham.nama_saham')
            ->get()->toArray();

        for ($i = 0; $i < count($dataReport); $i++) {
            $id = $dataReport[$i]['id_saham'];
            $saham = $dataReport[$i]['nama_saham'];
            $jualReport = PortofolioJualModel::join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
                ->select('tb_portofolio_jual.id_saham', 'tb_saham.nama_saham', DB::raw('SUM(tb_portofolio_jual.volume) AS total_volume_jual'), DB::raw('AVG(tb_portofolio_jual.harga_jual) AS avg_harga_jual'))
                ->where('tb_portofolio_jual.user_id', '=', $id_user)
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

        $beli_total = null;
        $jual_total = null;
        foreach ($data as $item) {
            if ($item["tag"] == "beli") {
                $beli_total += $item["volume"];
            } else if ($item["tag"] == "jual") {
                $jual_total += $item["volume"];
            }
        }
        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => '1hzlCQzlW2UqjegV5GFoiS78vaW9tF'
            ])->get('https://api.goapi.id/v1/stock/idx/prices', [
                    'symbols' => $emiten
                ])->json();

        $totalLot = ($beli_total - $jual_total) * 100;
        $hargaclose = $response['data']['results'][0]['close'];
        $avgBeli = $dataReport[0]['avg_harga_beli'];
        $avgJual = $dataReport[0]['avg_harga_jual'];
        $keuntungan = ($totalLot * $avgBeli) - ($totalLot * $hargaclose);
        //dd($keuntungan);
        $keuntungann = (string)$keuntungan;

        $realisasi = ($totalLot * $avgBeli) - ($totalLot * $avgJual);
        if ($function === 1) {
            return compact(['keuntungan', 'realisasi']);
        }
        $realisasii = (string)$realisasi;

        $returnData = compact(['data', 'keuntungann', 'realisasii']);

        return response()->json([
            'status' => 'success',
            'data' => $returnData
        ], 200);
    }

    public function getYear($user_id)
    {
        $tahun = PortofolioBeliModel::selectRaw('EXTRACT(YEAR FROM tanggal_beli) as tahun')
            ->where('tb_portofolio_beli.user_id', $user_id)
            ->groupBy(DB::raw('EXTRACT(YEAR FROM tanggal_beli)'))
            ->get()->toArray();

        $years = [];

        foreach ($tahun as $year) {
            $keuntungan = [];
            $realisasi = [];
            $dataReport = PortofolioBeliModel::whereYear('tanggal_beli', $year)
                ->where('user_id', $user_id)
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

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }



    public function getYearr(Request $request)
    {
        $id_user = Auth::id();
        $tahun = PortofolioBeliModel::selectRaw('EXTRACT(YEAR FROM tanggal_beli) as tahun')
            ->where('tb_portofolio_beli.user_id', Auth::id())
            ->groupBy(DB::raw('EXTRACT(YEAR FROM tanggal_beli)'))
            ->get()->toArray();

        $currentYear = date('Y'); // Get the current year

        $filteredArray = array_filter($tahun, function ($item) use ($currentYear) {
            return $item['tahun'] != $currentYear;
        });

        $filteredArray = array_values($filteredArray);
        $tahun = $filteredArray;

        //dd($tahun);

        $years = [];

        $isSubscribed = SubscriberModel::where('id_subscriber', $id_user)->where('id_analyst', $id_user)->where('status', 'subscribed')->first();
        if ($isSubscribed || $id_user == $id_user) {
            $followers = SubscriberModel::where('id_analyst', $id_user)->get()->count();
            $existing = SubscriberModel::where('id_analyst', $id_user)
            ->join('users', 'tb_subscription.id_subscriber', '=', 'users.id')
            ->get()->toArray();
            $postCount = PostModel::where('id_user', $id_user)->get()->count();
       // $followers = SubscriberModel::get()->count();
        }

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
                    $report = $this->detailReport($year['tahun'], $data->nama_saham, 1);
                    array_push($keuntungan, $report['keuntungan']);
                    array_push($realisasi, $report['realisasi']);
                }
            }
            $pushedData = [
                'year' => $year['tahun'],
                'keuntungan' => array_sum($keuntungan) / count($keuntungan),
                'realisasi' => array_sum($realisasi) / count($realisasi),
                // 'followers' => $followers,
                // 'postCount' => $postCount,
            ];
            array_push($years, $pushedData);
        }

        //dd($years);

        $profitPercentage = 0;

        for ($i = 1; $i < count($years); $i++) {
            $previousYearProfit = $years[$i - 1]['keuntungan'];
            $previousYearRealisasi = $years[$i - 1]['realisasi'];
            $currentYearProfit = $years[$i]['keuntungan'];
            $currentYearRealisasi = $years[$i]['realisasi'];

            if ($previousYearProfit == 0) {
                $previousYearProfit = 1;
            }

            $profitPercentage = (($currentYearProfit - $previousYearProfit) / abs($previousYearProfit)) * 100;
            $realisasiOercentage = (($currentYearRealisasi - $previousYearRealisasi) / abs($previousYearRealisasi)) * 100;


            // $years[$i]['year'] =$profitPercentage;
            // $years[$i]['keuntungan'] =$profitPercentage;
            // $years[$i]['realisasi'] =$profitPercentage;
            $years[$i]['keuntunganPercent'] = $profitPercentage;
            $years[$i]['realisasiPercent'] = $realisasiOercentage;
            $years[$i]['followers'] = $followers;
            $years[$i]['postCount'] = $postCount;
            $years[$i]['existing'] = $existing;
        }

        // $years[0]['year'] = 0;
        // $years[0]['keuntungan'] = 0;
        // $years[0]['realisasi'] = 0;
        $years[0]['keuntunganPercent'] = 0;
        $years[0]['realisasiPercent'] = 0;
        $years[0]['followers'] = $followers;
        $years[0]['postCount'] = $postCount;
        $years[0]['existing'] = $existing;
        // foreach ($years as $key => $year) {
        //     $percent = 0;
        //     if ($key != 0) {
        //         //$percent = $years[$key]['keuntungan'] / $years[$key - 1]['keuntungan'];
        //         $percent = $percent == 0 ? 0 : ($years[$key]['keuntungan'] / $years[$key - 1]['keuntungan']);
        //     }

        //     $arr = [
        //         'year' => $years[$key]['year'],
        //         'keuntungan' => $years[$key]['keuntungan'],
        //         'realisasi' => $years[$key]['realisasi'],
        //         'keuntunganPercent' => $percent
        //     ];

        //     array_push($data, $arr);
        // }

        $data = $years;

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function getYearTahunIni(Request $request)
    {
        $id_user = Auth::id();
        $tahun = PortofolioBeliModel::selectRaw('EXTRACT(YEAR FROM tanggal_beli) as tahun')
            ->where('tb_portofolio_beli.user_id', $id_user)
            ->groupBy(DB::raw('EXTRACT(YEAR FROM tanggal_beli)'))
            ->get()->toArray();

            $currentYear = date('Y'); // Get the current year

            $filteredArray = array_filter($tahun, function ($item) use ($currentYear) {
                return $item['tahun'] == $currentYear;
            });

            $filteredArray = array_values($filteredArray);
            $tahun = $filteredArray;


        $years = [];
        $isSubscribed = SubscriberModel::where('id_subscriber', $id_user)->where('id_analyst', $id_user)->where('status', 'subscribed')->first();
        if ($isSubscribed || $id_user == $id_user) {
            $followers = SubscriberModel::where('id_analyst', $id_user)->get()->count();
            $postCount = PostModel::where('id_user', $id_user)->get()->count();
       // $followers = SubscriberModel::get()->count();
        }

        foreach ($tahun as $year) {
            $keuntungan = [];
            $realisasi = [];
            $dataReport = PortofolioBeliModel::whereYear('tanggal_beli', $year)
                ->where('user_id', $id_user)
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
                'keuntungan' => $years[$key]['keuntungan'] ,
                'realisasi' => $years[$key]['realisasi'] ,
                'keuntunganPercent' => $percent,
                'followers' => $followers,
                'postCount' => $postCount
            ];

            array_push($data, $arr);
           // $data = compact(['data', 'arr']);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }




}
