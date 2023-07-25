<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\SahamModel;

class StockAPIController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('goapi.apikey')
            ])->get('https://api.goapi.id/v1/stock/idx/companies')->json();


        $data = $response['data']['results'];
        //dd($response['data']['results']);

        return view('chart', ['data' => $data]);
    }

    public function getDataAdmin()
    {
        $data = SahamModel::paginate(25);
        //dd($data);

        return view('admin/emiten', ['data' => $data]);
    }

    public function stock($emiten)
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('goapi.apikey')
            ])->get('https://api.goapi.id/v1/stock/idx/' . $emiten)->json();

        dd($response);
    }

    public function updateStock()
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => config('goapi.apikey')
            ])->get('https://api.goapi.id/v1/stock/idx/companies')->json();

        $data = $response['data']['results'];

        foreach ($data as $item) {
            $insert = SahamModel::updateOrCreate(
                [
                    'nama_saham' => $item['ticker']
                ],
                [
                    'nama_saham' => $item['ticker'],
                    'nama_perusahaan' => $item['name'],
                    'pic' => $item['logo']
                ]
            );
        }

        return redirect('/admin/emiten')->with('status', 'Data emiten berhasil di update');

    }

    public function delete($emiten)
    {
        $ticker = $emiten;
        $delete = SahamModel::where('nama_saham', $emiten)->delete();

        return redirect('/admin/emiten')->with('deleted', 'Data emiten berhasil di hapus');
    }
}