<?php

namespace App\Http\Controllers;

use App\Models\SekuritasModel;
use Illuminate\Http\Request;

class SekuritasController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
        $data = SekuritasModel::paginate(10);

        return view('admin/sekuritas', compact(['data']));
    }

    public function create(Request $request)
    {
        //dd($request->namaSekuritas);
        $data = SekuritasModel::create([
            'nama_sekuritas' => strtoupper($request->namaSekuritas),
            'fee_beli' => $request->feeBeli / 100,
            'fee_jual' => $request->feeJual / 100
        ]);

        return redirect('/admin/sekuritas')->with('status', 'Data sekuritas berhasil dibuat');
    }

    public function edit($id)
    {
        $data = SekuritasModel::where('id_sekuritas', $id)->first();

        return view('admin/sekuritasEdit', compact(['data']));
    }

    public function update(Request $request)
    {
        $data = SekuritasModel::where('id_sekuritas', $request->idSekuritas)
            ->update([
                'nama_sekuritas' => strtoupper($request->namaSekuritas),
                'fee_beli' => $request->feeBeli / 100,
                'fee_jual' => $request->feeJual / 100
            ]);

        return redirect('/admin/sekuritas')->with('status', 'Data sekuritas berhasil diperbarui');
    }

    public function delete($id)
    {
        $data = SekuritasModel::where('id_sekuritas', $id)->delete();

        return redirect('/admin/sekuritas')->with('deleted', 'Data sekuritas berhasil dihapus');
    }
}