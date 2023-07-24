<?php

namespace App\Http\Controllers;

use App\Models\SubscriberModel;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PortofolioJualModel;
use App\Models\JenisSahamModel;
use App\Models\SahamModel;
use App\Models\SekuritasModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class PortofolioJualController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index()
    {



    }


    public function getdata($user_id)
    {
        $dataporto = PortofolioJualModel::where('user_id', $user_id)
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->get();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();
        $sekuritas = SekuritasModel::all();

        $data = compact(['dataporto'], ['emiten'], ['jenis_saham'], ['sekuritas']);
        //dd($dataporto);
        return view('portofoliojual', $data);
    }

    public function getDataAdmin()
    {
        $dataporto = PortofolioJualModel::join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->join('users', 'tb_portofolio_jual.user_id', '=', 'users.id')
            ->orderBy('user_id', 'asc')
            ->get();

        $data = compact(['dataporto']);
        //dd($data);
        return view('admin/portofoliojual', $data);
    }
    public function getdataAnalyst($user_id)
    {
        $isSubscribed = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', $user_id)->where('status', 'subscribed')->first();
        if ($isSubscribed) {
            $dataporto = PortofolioJualModel::where('user_id', $user_id)
                ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
                ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
                ->get();
            $emiten = SahamModel::all();
            $jenis_saham = JenisSahamModel::all();
            $sekuritas = SekuritasModel::all();
            $userData = User::where('id', $user_id)->first();

            $data = compact(['dataporto'], ['emiten'], ['jenis_saham'], ['sekuritas'], ['userData']);
            //dd($dataporto);
            return view('portofoliojualAnalyst', $data);
        } else {
            return redirect('/');
        }
    }
    public function insertData(Request $request)
    {

        $id = Auth::id();
        $getEmiten = SahamModel::select('nama_saham')
            ->where('id_saham', $request->id_saham)
            ->first();
        $emiten = $getEmiten->nama_saham;

        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
            ])->get('https://api.goapi.id/v1/stock/idx/' . $emiten)->json();

        $data = $response['data']['last_price'];
        $closeprice = $response['data']['last_price']['close'];
        $harga_jual = $request->harga_jual;
        $close_persen = round((($harga_jual - $closeprice) / $harga_jual) * 100);
        // /dd(compact(['closeprice'], ['harga_jual'], ['close_persen']) );
        /*
        $data = [
        'id_saham' => $request->id_saham,
        'user_id' => $id,
        'jenis_saham' => $request->id_jenis_saham,
        'volume' => $request->volume,
        'tanggal_jual' => $request->tanggal_jual,
        'harga_jual' => $request->harga_jual,
        'fee_jual_persen' => $request->fee_jual_persen,
        'close_persen' => $request->fee_jual_persen,
        ];
        */


        $insert = PortofolioJualModel::create([
            'id_saham' => $request->id_saham,
            'user_id' => $id,
            'jenis_saham' => $request->id_jenis_saham,
            'volume' => $request->volume,
            'tanggal_jual' => $request->tanggal_jual,
            'harga_jual' => $request->harga_jual,
            'fee_jual_persen' => $request->fee_jual_persen,
            'close_persen' => $close_persen

        ]);

        $insert->save();
        //dd($data);
        //dd($request);
        //$this->PortofolioJualModel->insertData($data);
        if ($data) {
            return redirect()->action(
                [PortofolioJualController::class, 'getdata'],
                ['user_id' => $id]
            );
        }
    }

    public function getEdit($id_portofolio_jual, PortofolioJualModel $portoJual)
    {
        if (!Gate::allows('update-delete-portojual', $portoJual)) {
            abort(403);
        }
        $dataporto = PortofolioJualModel::where('id_portofolio_jual', $id_portofolio_jual)
            ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')->get();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();
        $sekuritas = SekuritasModel::all();

        $data = compact(['dataporto'], ['emiten'], ['jenis_saham'], ['sekuritas']);
        //dd($data);
        return view('editportofoliojual', $data);
    }

    public function getEditAdmin($id_portofolio_jual)
    {
        if (Auth::user()->id_roles == 1) {
            $dataporto = PortofolioJualModel::where('id_portofolio_jual', $id_portofolio_jual)->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')->get();
            $emiten = SahamModel::all();
            $jenis_saham = JenisSahamModel::all();
            $sekuritas = SekuritasModel::all();

            $data = compact(['dataporto'], ['emiten'], ['jenis_saham'], ['sekuritas']);
            //dd($data);
            return view('admin/editportofoliojual', $data);
        } else {
            abort(403);
        }
    }

    public function editData(Request $request, PortofolioJualModel $portoJual)
    {
        if (!Gate::allows('update-delete-portojual', $portoJual)) {
            abort(403);
        }
        $dataporto = PortofolioJualModel::where('id_portofolio_jual', $request->id_portofolio_jual)->first();
        //dd($dataporto);

        $id = Auth::id();
        //dd($dataporto);
        $getEmiten = SahamModel::select('nama_saham')
            ->where('id_saham', $request->id_saham)
            ->first();
        $emiten = $getEmiten->nama_saham;


        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
            ])->get('https://api.goapi.id/v1/stock/idx/' . $emiten . '/historical', [
                'to' => $request->tanggal_jual,
                'from' => $request->tanggal_jual
            ])->json();

        $closeprice = $response['data']['results'][0]['close'];
        $harga_jual = $request->harga_jual;
        $close_persen = round((($harga_jual - $closeprice) / $harga_jual) * 100);

        $dataporto->id_saham = $request->id_saham;
        $dataporto->user_id = $id;
        $dataporto->jenis_saham = $request->id_jenis_saham;
        $dataporto->volume = $request->volume;
        $dataporto->tanggal_jual = $request->tanggal_jual;
        $dataporto->harga_jual = $harga_jual;
        $dataporto->id_sekuritas = $request->id_sekuritas;
        $dataporto->close_persen = $close_persen;
        $dataporto->save();


        return redirect()->to('portofoliojual/' . $id);

    }

    public function editDataAdmin(Request $request, PortofolioJualModel $portoJual)
    {
        if (Auth::user()->id_roles == 1) {
            $dataporto = PortofolioJualModel::where('id_portofolio_jual', $request->id_portofolio_jual)->first();
            //dd($dataporto);

            $id = Auth::id();
            //dd($dataporto);
            $getEmiten = SahamModel::select('nama_saham')
                ->where('id_saham', $request->id_saham)
                ->first();
            $emiten = $getEmiten->nama_saham;

            $response = Http::acceptJson()
                ->withHeaders([
                    'X-API-KEY' => 'pCIjZsjxh8So9tFQksFPlyF6FbrM49'
                ])->get('https://api.goapi.id/v1/stock/idx/' . $emiten . '/historical', [
                    'to' => $request->tanggal_jual,
                    'from' => $request->tanggal_jual
                ])->json();

            //dd($response);
            $closeprice = $response['data']['results'][0]['close'];
            $harga_jual = $request->harga_jual;
            $close_persen = round((($harga_jual - $closeprice) / $harga_jual) * 100);

            $dataporto->id_saham = $request->id_saham;
            $dataporto->jenis_saham = $request->id_jenis_saham;
            $dataporto->volume = $request->volume;
            $dataporto->tanggal_jual = $request->tanggal_jual;
            $dataporto->harga_jual = $harga_jual;
            $dataporto->id_sekuritas = $request->id_sekuritas;
            $dataporto->close_persen = $close_persen;
            $dataporto->save();


            return redirect()->to('admin/portofoliojual/');
        }
        abort(403);

    }

    public function deleteData($id_portofolio_jual, PortofolioJualModel $portoJual)
    {
        if (!Gate::allows('update-delete-portojual', $portoJual)) {
            abort(403);
        }
        $dataporto = PortofolioJualModel::where('id_portofolio_jual', $id_portofolio_jual)->firstOrFail();
        $dataporto->delete();
        $id = Auth::id();
        return redirect()->to('portofoliojual/' . $id);
    }

    public function deleteDataAdmin($id_portofolio_jual)
    {
        if (Auth::user()->id_roles == 1) {
            $dataporto = PortofolioJualModel::where('id_portofolio_jual', $id_portofolio_jual)->firstOrFail();
            $dataporto->delete();
            return redirect()->to('admin/portofoliojual');
        }
        abort(403);
    }
}
