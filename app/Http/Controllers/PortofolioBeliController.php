<?php

namespace App\Http\Controllers;

use App\Models\SubscriberModel;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PortofolioBeliModel;
use App\Models\JenisSahamModel;
use App\Models\SahamModel;
use App\Models\SekuritasModel;
use Illuminate\Support\Facades\Auth;

class PortofolioBeliController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }


    public function create()
    {
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();
        $sekuritas = SekuritasModel::all();
        $data = compact(['emiten'], ['jenis_saham'], ['sekuritas']);
        //dd($data);
        return view('createPortofoliobeli', $data);
    }

    public function getdata(PortofolioBeliModel $portoBeli)
    {
        $dataporto = PortofolioBeliModel::where('user_id', Auth::id())
            ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_beli.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->get();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();
        $sekuritas = SekuritasModel::all();

        $data = compact(['dataporto'], ['emiten'], ['jenis_saham'], ['sekuritas']);
        //dd($data);
        return view('portofoliobeli', $data);
    }

    public function getDataAdmin()
    {
        $dataporto = PortofolioBeliModel::join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_beli.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->join('users', 'tb_portofolio_beli.user_id', '=', 'users.id')
            ->orderBy('user_id', 'asc')
            ->get();

        $data = compact(['dataporto']);
        //dd($data);
        return view('admin/portofoliobeli', $data);
    }

    public function getdataAnalyst($user_id)
    {
        $isSubscribed = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', $user_id)->where('status', 'subscribed')->first();
        if ($isSubscribed) {
            $dataporto = PortofolioBeliModel::where('user_id', $user_id)
                ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
                ->join('tb_sekuritas', 'tb_portofolio_beli.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
                ->get();
            $emiten = SahamModel::all();
            $jenis_saham = JenisSahamModel::all();
            $sekuritas = SekuritasModel::all();
            $userData = User::where('id', $user_id)->first();

            $data = compact(['dataporto'], ['emiten'], ['jenis_saham'], ['sekuritas'], ['userData']);
            //dd($data);
            return view('portofoliobeliAnalyst', $data);
        } else {
            return redirect('/');
        }
    }

    public function insertData(Request $request)
    {

        $id = Auth::id();
        dd($request);
        $insert = PortofolioBeliModel::create([
            'id_saham' => $request->emitenSaham,
            'user_id' => $id,
            'jenis_saham' => $request->jenisSaham,
            'volume' => $request->volume,
            'tanggal_beli' => $request->tanggalBeli,
            'harga_beli' => $request->hargaBeli,
            'id_sekuritas' => $request->sekuritas,
        ]);

        if ($insert) {
            return redirect()->action([PortofolioBeliController::class, 'getData'], ['user_id' => $id]);
        }
    }

    public function getEdit($id_portofolio_beli, PortofolioBeliModel $portoBeli)
    {
        $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $id_portofolio_beli)->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')->get();
        $emiten = SahamModel::all();
        $jenis_saham = JenisSahamModel::all();
        $sekuritas = SekuritasModel::all();

        $data = compact(['dataporto'], ['emiten'], ['jenis_saham'], ['sekuritas']);
        //dd($data);
        return view('editportofoliobeli', $data);
    }

    public function getEditAdmin($id_portofolio_beli, PortofolioBeliModel $portoBeli)
    {
        if (Auth::user()->id_roles == 1) {
            $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $id_portofolio_beli)->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')->get();
            $emiten = SahamModel::all();
            $jenis_saham = JenisSahamModel::all();
            $sekuritas = SekuritasModel::all();

            $data = compact(['dataporto'], ['emiten'], ['jenis_saham'], ['sekuritas']);
            //dd($data);
            return view('admin/editportofoliobeli', $data);
        } else {
            abort(403);
        }
    }

    public function editData(Request $request, PortofolioBeliModel $portoBeli)
    {

        $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $request->id_portofolio_beli)->firstOrFail();
        $id = Auth::id();
        //dd($dataporto);
        $dataporto->id_saham = $request->id_saham;
        $dataporto->user_id = $id;
        $dataporto->jenis_saham = $request->id_jenis_saham;
        $dataporto->volume = $request->volume;
        $dataporto->tanggal_beli = $request->tanggal_beli;
        $dataporto->harga_beli = $request->harga_beli;
        $dataporto->id_sekuritas = $request->sekuritas;
        $dataporto->save();


        return redirect()->to('/portofoliobeli');
    }

    public function editDataAdmin(Request $request, PortofolioBeliModel $portoBeli)
    {
        if (Auth::user()->id_roles == 1) {
            $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $request->id_portofolio_beli)->firstOrFail();
            $id = Auth::id();
            //dd($dataporto);
            $dataporto->id_saham = $request->id_saham;
            $dataporto->jenis_saham = $request->id_jenis_saham;
            $dataporto->volume = $request->volume;
            $dataporto->tanggal_beli = $request->tanggal_beli;
            $dataporto->harga_beli = $request->harga_beli;
            $dataporto->id_sekuritas = $request->sekuritas;
            $dataporto->save();


            return redirect()->to('admin/portofoliobeli');
        }

        abort(403);
    }

    public function deleteData($id_portofolio_beli, PortofolioBeliModel $portoBeli)
    {
        if (!Gate::allows('update-delete-portobeli', $portoBeli)) {
            abort(403);
        }
        $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $id_portofolio_beli)->firstOrFail();
        $dataporto->delete();
        $id = Auth::id();
        return redirect()->to('portofoliobeli/' . $id);
    }

    public function deleteDataAdmin($id_portofolio_beli)
    {
        if (Auth::user()->id_roles == 1) {
            $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $id_portofolio_beli)->firstOrFail();
            $dataporto->delete();
            $id = Auth::id();
            return redirect()->to('admin/portofoliobeli');
        }
        abort(403);
    }

}