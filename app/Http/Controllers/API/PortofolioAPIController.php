<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PortofolioModel;
use App\Models\PortofolioBeliModel;
use App\Models\PortofolioJualModel;
use App\Models\SubscribeModel;
use App\Models\SahamModel;
use App\Models\SekuritasModel;
use App\Models\PaymentChannelModel;
use App\Models\JenisSahamModel;
use App\Models\TechnicalModel;
use App\Models\User;
use App\Models\TagihanModel;
use App\Models\SubscriberModel;
use Illuminate\Support\Facades\Auth;

class PortofolioAPIController extends Controller
{
    public function __construct()
    {
        $this->PortofolioModel = new PortofolioModel;
        $this->PortofolioBeliModel = new PortofolioBeliModel;
        $this->PortofolioJualModel = new PortofolioJualModel;
        $this->middleware('auth');
    }

    public function getAnalyst(Request $request)
    {

        try {
            $analyst = User::where('id_roles', 2)->get();
            return response()->json(['messsage' => 'Berhasil', 'data' => $analyst]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal fetch'
            ]);
        }
    }

    public function getSekuritas(Request $request)
    {
        try {
            $sekuritas = SekuritasModel::all();
            return response()->json(['message' => 'Berhasil', 'data' => $sekuritas]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal fetch'
            ]);
        }
    }

    public function getSubUser(Request $request)
    {
        try {
            $id = Auth::id();
            $datasubs = SubscribeModel::where('id_user', $id)->get();
            return response()->json(['messsage' => 'Berhasil', 'data' => $datasubs]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal fetch'
            ]);
        }
    }

    public function getData(Request $request)
    {
        $reqType = $request->type;
        try {
            $id = Auth::id();
            if ($request->type == '') {
                $dataporto = PortofolioModel::where('user_id', $id)->get();
            } else {
                $dataporto = PortofolioModel::where('type', $reqType)->where('user_id', $id)->get();
            }

            return response()->json(['messsage' => 'Berhasil', 'data' => $dataporto]);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Insert data gagal'
            ]);
        }

    }

    public function getDataPortoBeli(Request $request)
    {
        $reqType = $request->type;
        try {
            $id = Auth::id();
            if ($request->type == '') {
                $dataportobeli = PortofolioBeliModel::where('user_id', $id)->get();
            } else {
                $dataportobeli = PortofolioBeliModel::where('type', $reqType)->where('user_id', $id)->get();
            }

            return response()->json(['messsage' => 'Berhasil', 'data' => $dataportobeli]);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Insert data gagal'
            ]);
        }

    }

    public function checkSubscription(Request $request)
    {
        $id_user = Auth::id();
        $id_analyst = $request->id_analyst;
        try {
            $status = SubscribeModel::where('id_user', $id_user)->where('id_analyst', $id_analyst)->first();
            if ($status !== null) {
                return response()->json(['messsage' => 'Berhasil', 'status' => 'true']);
            } else {
                return response()->json(['messsage' => 'Berhasil', 'status' => 'false']);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Insert data gagal'
            ]);
        }
    }

    public function getAnalystPorto(Request $request)
    {
        $reqType = $request->type;
        $id_analyst = $request->id_analyst;
        try {

            if ($request->type == '') {
                $dataporto = PortofolioModel::where('user_id', $id_analyst)->get();
            } else {
                $dataporto = PortofolioModel::where('type', $reqType)->where('user_id', $id_analyst)->get();
            }

            return response()->json(['messsage' => 'Berhasil', 'data' => $dataporto]);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Insert data gagal'
            ]);
        }

    }

    public function getSubscription(Request $request)
    {
        $reqType = $request->type;
        try {
            $id = Auth::id();
            if ($request->type == '') {
                $dataporto = PortofolioModel::where('user_id', $id)->get();
            } else {
                $dataporto = PortofolioModel::where('type', $reqType)->where('user_id', $id)->get();
            }

            return response()->json(['messsage' => 'Berhasil', 'data' => $dataporto]);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Insert data gagal'
            ]);
        }

    }

    public function getTagihan(Request $request)
    {
        $id = Auth::id();
        $status = $request->status;

        try {
            $tagihan = TagihanModel::where('status', $status)->where('user_id', $id)->get();
            return response()->json(['messsage' => 'Berhasil', 'data' => $tagihan]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th
            ]);
        }
    }

    public function getSubscribe(Request $request)
    {
        $id = Auth::id();
        $status = $request->status;

        try {
            $subs = SubscriberModel::where('status', $status)->where('user_id', $id)->get();
            return response()->json(['messsage' => 'Berhasil', 'data' => $subs]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th
            ]);
        }
    }


    public function getAnalystData(Request $request)
    {
        $reqType = $request->type;
        $analyst_id = explode(',', $request->input('analyst_id'));
        try {
            $id = Auth::id();

            if ($request->type == '') {
                $dataporto = PortofolioModel::whereIn('user_id', $analyst_id)->get();
            } else {
                $dataporto = PortofolioModel::where('type', $reqType)->whereIn('user_id', $analyst_id)->get();
            }

            return response()->json(['messsage' => 'Berhasil', 'data' => $dataporto]);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th
            ]);
        }

    }

    public function buyData(Request $request)
    {

        try {
            $dataporto = PortofolioModel::where('type', $request->id_portofolio)->all();
            return response()->json(['messsage' => 'Berhasil', 'data' => $dataporto]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Insert data gagal'
            ]);
        }

    }

    public function getPaymentChannels()
    {
        try {
            $paymentChannels = PaymentChannelModel::all(['payment_id', 'payment_name']);
            return response()->json(['message' => 'Success', 'data' => $paymentChannels]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve payment channels'
            ]);
        }
    }


    public function unsubscribe(Request $request)
    {
        try {
            $id_user = Auth::id();
            $id_analyst = $request->id_analyst;


            $unsubscribe = SubscribeModel::where('id_user', $id_user)
                ->where('id_analyst', $id_analyst)
                ->delete();

            if ($unsubscribe) {
                return response()->json(['message' => 'Berhasil']);
            } else {
                return response()->json(['message' => 'User not subscribed or already unsubscribed']);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update data'
            ]);
        }
    }

    public function payTagihan(Request $request)
    {
        $id = Auth::id();
        $idTagihan = $request->id_tagihan;
        $metodeBayar = $request->metode_pembayaran;
        $status = $request->status;

        try {
            $tagihan = TagihanModel::where('id_tagihan', $idTagihan)->update(['status' => 'Lunas', 'metode_pembayaran' => $metodeBayar]);
            return response()->json(['message' => 'Berhasil', 'data' => $tagihan]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th
            ]);
        }
    }



    public function subscribe(Request $request)
    {
        try {
            $id_user = Auth::id();
            $unique_id = uniqid('', true);
            $id_analyst = $request->id_analyst;
            $user = User::find($id_analyst);
            $fee = $user->subscribe_fee;
            $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
            $insert = SubscribeModel::create([
                'id_user' => $id_user,
                'id_analyst' => intval($id_analyst),
                'subscribe_date' => $currentDateTime,
                'subscribe_fee' => $fee
            ]);
            $tagihan = TagihanModel::create([
                'reference' => strtoupper($unique_id),
                'tgl_tagihan' => $currentDateTime,
                'nama_tagihan' => 'Subscribe',
                'jumlah' => $fee,
                'status' => 'Menunggu Pembayaran',
                'user_id' => $id_user,
            ]);
            return response()->json(['messsage' => 'Berhasil', 'data' => $insert]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Insert data gagal'
            ]);
        }

    }

    public function allData()
    {
        $beliData = PortofolioBeliModel::select('id_portofolio_beli as id_portofolio', 'nama_saham', DB::raw("'Beli' as status"), 'user_id', 'jenis_saham', 'volume', 'tanggal_beli as tanggal', 'nama_sekuritas', 'harga_beli as harga', 'fee_beli as fee')

            ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_beli.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->selectRaw("'Beli' as status");

        $jualData = PortofolioJualModel::select('id_portofolio_jual as id_portofolio', 'nama_saham', DB::raw("'Jual' as status"), 'user_id', 'jenis_saham', 'volume', 'tanggal_jual as tanggal', 'nama_sekuritas', 'harga_jual as harga', 'fee_jual as fee')
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->selectRaw("'Jual' as status");




        $mergedData = $beliData->union($jualData)->get();

        return response()->json(['message' => 'Berhasil', 'data' => $mergedData]);
    }

    public function PortoJual()
    {



        $PortojualData = PortofolioJualModel::select('id_portofolio_jual as id_portofolio', 'nama_saham', DB::raw("'Jual' as status"), 'user_id', 'jenis_saham', 'volume', 'tanggal_jual as tanggal', 'nama_sekuritas', 'harga_jual as harga', 'fee_jual as fee')
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
            ->selectRaw("'Jual' as status");

        //$mergedData = $beliData->union($jualData)->get();

        return response()->json(['message' => 'Berhasil', 'data' => $PortojualData]);
    }


    public function getAllJenisSaham()
    {
        $jenisSaham = JenisSahamModel::all();

        if ($jenisSaham->isEmpty()) {
            return response()->json(['message' => 'No jenis saham found'], 404);
        }

        return response()->json(['message' => 'Success', 'data' => $jenisSaham]);
    }

    public function company()
    {
        $namaCompany = SahamModel::all();

        if ($namaCompany->isEmpty()) {
            return response()->json(['message' => 'No jenis saham found'], 404);
        }

        return response()->json(['message' => 'Success', 'data' => $namaCompany]);
    }

    public function getJenisTrend()
    {
        $jenisTrend = TechnicalModel::all();

        if ($jenisTrend->isEmpty()) {
            return response()->json(['message' => 'No jenis trend found'], 404);
        }

        return response()->json(['message' => 'Success', 'data' => $jenisTrend]);
    }




    public function getPortoBeli()
    {
        return response()->json(['messsage' => 'Berhasil']);
    }



    public function insertData(Request $request)
    {
        try {
            $id = Auth::id();
            $unique_id = uniqid('', true);
            $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
            $reqType = $request->type;
            $idSekuritas = $request->id_sekuritas;
            $fee = $request->fee;
            $saham = SahamModel::where('nama_saham', $request->id_saham)->first();
            if ($reqType == 'beli') {
                $insert = PortofolioBeliModel::create([
                    'id_saham' => $saham->id_saham,
                    'user_id' => $id,
                    'jenis_saham' => $request->id_jenis_saham,
                    'volume' => $request->volume,
                    'tanggal_beli' => $request->tanggal,
                    'harga_beli' => $request->harga,
                    'fee_beli_persen' => $fee,
                    'id_sekuritas' => $idSekuritas

                ]);
                $total = (($request->volume * $request->harga) * $request->fee) + ($request->volume * $request->harga);
                $tagihan = TagihanModel::create([
                    'reference' => strtoupper($unique_id),
                    'nama_tagihan' => 'Transaksi Saham',
                    'tgl_tagihan' => $currentDateTime,
                    'jumlah' => $total,
                    'status' => 'Menunggu Pembayaran',
                    'user_id' => $id,
                ]);
            } else if ($reqType == 'jual') {
                $insert = PortofolioJualModel::create([
                    'id_saham' => $saham->id_saham,
                    'user_id' => $id,
                    'jenis_saham' => $request->jenis,
                    'volume' => $request->volume,
                    'tanggal_jual' => $request->tanggal,
                    'harga_jual' => $request->harga,
                    'id_sekuritas' => $idSekuritas,
                    'close_persen' => $fee,
                ]);
            }


            // $insert = PortofolioModel::create([
            //     'id_portofolio' => strtoupper($unique_id),
            //     'id_saham' => $request->id_saham,
            //     'type' => $request->type,
            //     'jenis' => $request->jenis,
            //     'volume' => $request->volume,
            //     'tanggal' => $request->tanggal,
            //     'harga' => $request->harga,
            //     'fee' => $request->fee,
            //     'user_id' => $id,
            //     'comment' => $request->comment
            // ]);

            return response()->json(['messsage' => 'Berhasil', 'data' => $insert]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }

    }


    public function editData(Request $request)
    {
        try {
            $dataporto = PortofolioBeliModel::where('id_portofolio_beli', $request->id_portofolio_beli)->firstOrFail();
            // $id = Auth::id();

            $dataporto->volume = $request->volume;
            $dataporto->tanggal_beli = $request->tanggal_beli;
            $dataporto->harga_beli = $request->harga_beli;
            $dataporto->save();



            return response()->json(['messsage' => 'Data Berhasil di Update']);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }


    }

    public function editDataJual(Request $request)
    {
        try {
            $dataporto = PortofolioJualModel::where('id_portofolio_jual', $request->id_portofolio_jual)->firstOrFail();
            // $id = Auth::id();

            $dataporto->volume = $request->volume;
            $dataporto->tanggal_jual = $request->tanggal_jual;
            $dataporto->harga_jual = $request->harga_jual;
            $dataporto->save();


            return response()->json(['messsage' => 'Data Berhasil di Update']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }


    }

    public function deleteDataBeli(Request $request)
    {


        try {
            $dataporto = PortofolioModelBeli::where('id_portofolio_beli', $request->id_portofolio_beli)->firstOrFail();
            $dataporto->delete();

            return response()->json(['success' => true, 'messsage' => 'Data Berhasil di Delete']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delete data gagal'
            ]);
        }


    }

    public function deleteDataJual(Request $request)
    {

        try {
            $dataporto = PortofolioModelJual::where('id_portofolio_jual', $request->id_portofolio_jual)->firstOrFail();
            $dataporto->delete();


            return response()->json(['success' => true, 'messsage' => 'Data Berhasil di Delete']);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delete data gagal'
            ]);
        }


    }

    // public function deleteData(Request $request){
    //     $dataporto = PortofolioModel::where('id_portofolio', $request->$id_portofolio)->firstOrFail();
    //     $dataporto->delete();
    //     $id = Auth::id();
    //     return response()->json(['messsage'=>'Data Berhasil di Delete' ]);
    // }
}