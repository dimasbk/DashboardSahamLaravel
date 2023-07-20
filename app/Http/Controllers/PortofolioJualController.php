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

    public function create()
    {
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();
        $sekuritas = SekuritasModel::all();
        $data = compact(['emiten'], ['jenis_saham'], ['sekuritas']);
        //dd($data);
        return view('createPortofolioJual', $data);
    }

    public function getdata()
    {
        $dataporto = PortofolioJualModel::where('user_id', Auth::id())
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->paginate(25);
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
            ->paginate(25);

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
                ->paginate(25);
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

        $validated = $request->validate([
            'emitenSaham' => 'required',
            'jenisSaham' => 'required',
            'volume' => 'required',
            'tanggalJual' => 'required',
            'hargaJual' => 'required',
            'sekuritas' => 'required'
        ]);

        //dd($validated['sekuritas']);

        $id = Auth::id();

        $getEmiten = SahamModel::select('nama_saham')
            ->where('id_saham', $request->emitenSaham)
            ->first();
        $emiten = $getEmiten->nama_saham;

        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('goapi.apikey')
            ])->get('https://api.goapi.id/v1/stock/idx/' . $emiten)->json();

        $data = $response['data']['last_price'];
        $closeprice = $response['data']['last_price']['close'];
        $harga_jual = $request->hargaJual;
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
            'id_saham' => $validated['emitenSaham'],
            'user_id' => $id,
            'jenis_saham' => $validated['jenisSaham'],
            'volume' => $validated['volume'],
            'tanggal_jual' => $validated['tanggalJual'],
            'harga_jual' => $validated['hargaJual'],
            'id_sekuritas' => $validated['sekuritas'],
            'close_persen' => $close_persen

        ]);

        if ($data) {
            return redirect('portofoliojual')->with('status', 'Data berhasil dibuat');
        }
    }

    public function getEdit($id_portofolio_jual, PortofolioJualModel $portoJual)
    {

        $dataporto = PortofolioJualModel::where('id_portofolio_jual', $id_portofolio_jual)
            ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')->first();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();
        $sekuritas = SekuritasModel::all();

        $data = compact(['dataporto'], ['emiten'], ['jenis_saham'], ['sekuritas']);
        //dd($dataporto);
        if ($dataporto->user_id == Auth::id()) {
            return view('editportofoliojual', $data);
        }
        return redirect('/portofoliojual');
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

        $validated = $request->validate([
            'emitenSaham' => 'required',
            'jenisSaham' => 'required',
            'volume' => 'required',
            'tanggal_jual' => 'required',
            'harga_jual' => 'required',
            'sekuritas' => 'required'
        ]);
        $dataporto = PortofolioJualModel::where('id_portofolio_jual', $request->id_portofolio_jual)->first();
        //dd($dataporto);

        $id = Auth::id();
        //dd($dataporto);
        $getEmiten = SahamModel::select('nama_saham')
            ->where('id_saham', $request->emitenSaham)
            ->first();
        $emiten = $getEmiten->nama_saham;

        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('goapi.apikey')
            ])->get('https://api.goapi.id/v1/stock/idx/' . $emiten . '/historical', [
                    'to' => $request->tanggal_jual,
                    'from' => $request->tanggal_jual
                ])->json();

        $closeprice = $response['data']['results'][0]['close'];
        $harga_jual = $request->harga_jual;
        $close_persen = round((($harga_jual - $closeprice) / $harga_jual) * 100);

        $dataporto->id_saham = $request->emitenSaham;
        $dataporto->user_id = $id;
        $dataporto->jenis_saham = $request->jenisSaham;
        $dataporto->volume = $request->volume;
        $dataporto->tanggal_jual = $request->tanggal_jual;
        $dataporto->harga_jual = $harga_jual;
        $dataporto->id_sekuritas = $request->id_sekuritas;
        $dataporto->close_persen = $close_persen;
        $dataporto->save();


        return redirect()->to('portofoliojual/')->with('status', 'Data berhasil diubah');

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
                    'X-API-KEY' => config('goapi.apikey')
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


            return redirect()->to('admin/portofoliojual/')->with('status', 'Data berhasil dihapus');
        }
        abort(403);

    }

    public function deleteData($id_portofolio_jual, PortofolioJualModel $portoJual)
    {
        $dataporto = PortofolioJualModel::where('id_portofolio_jual', $id_portofolio_jual)->firstOrFail();
        if ($dataporto->user_id == Auth::id()) {
            $dataporto->delete();
            $id = Auth::id();
            return redirect()->to('portofoliojual/')->with('status', 'Data berhasil dihapus');
        }
        abort(403);
    }

    public function deleteDataAdmin($id_portofolio_jual)
    {
        if (Auth::user()->id_roles == 1) {
            $dataporto = PortofolioJualModel::where('id_portofolio_jual', $id_portofolio_jual)->firstOrFail();
            $dataporto->delete();
            return redirect()->to('admin/portofoliojual')->with('status', 'Data berhasil dihapus');
        }
        abort(403);
    }
}