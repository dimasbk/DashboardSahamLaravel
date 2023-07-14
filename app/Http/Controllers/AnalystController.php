<?php

namespace App\Http\Controllers;

use App\Models\PortofolioBeliModel;
use App\Models\PortofolioJualModel;
use App\Models\PostModel;
use App\Models\PriceModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubscriberModel;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Timer\Duration;

class AnalystController extends Controller
{
    public function index()
    {
        $notToFollow = SubscriberModel::where('id_subscriber', Auth::id())->where('status', 'subscribed')->pluck('id_analyst')->toArray();
        array_push($notToFollow, Auth::id());
        $toFollow = User::where('id_roles', 2)->whereNotIn('id', $notToFollow)->get()->toArray();
        $existing = SubscriberModel::where('id_subscriber', Auth::id())
            ->join('users', 'tb_subscription.id_analyst', '=', 'users.id')
            ->get()->toArray();

        $data = compact(['toFollow', 'existing']);

        //dd($existing);
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $data
        // ], 200);
       return view('landingPage/analyst', $data);
    }

    public function plan(Request $request)
    {
        $analystData = User::where('id', $request->id)->first();
        $prices = PriceModel::where('id_analyst', $request->id)->get();
        $data = compact(['analystData', 'prices']);

        // return response()->json([
        //     'status' => 'success',
        //     'data' => $data
        // ], 200);

        //dd($analystData);
       return view('landingPage/plan', compact(['analystData', 'prices']));
    }

    public function subscribe(Request $request)
    {
        $analystData = User::where('id', $request->id)->first();
        $prices = PriceModel::where('id_price', $request->id_price)->first();

        //dd($analystData);
        return view('landingPage/subscribe', compact(['analystData', 'prices']));
    }

    public function pay(Request $request)
    {
        $grossAmount = $request->price * $request->duration;
        $expired = Carbon::today()->addMonths($request->duration)->toDateString();
        //return $expired;
        $subscribe = SubscriberModel::create([
            'id_subscriber' => Auth::id(),
            'id_analyst' => $request->id,
            'expired' => $expired,
            'status' => 'pending'
        ]);
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $subscribe->id_subscription,
                'gross_amount' => $grossAmount,
            ),
            'customer_details' => array(
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ),
        );

        $subscribeID = $subscribe->id_subscription;
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return compact(['snapToken', 'subscribeID']);
    }

    public function update($id)
    {
        $subscribe = SubscriberModel::where('id_subscription', $id)->first();
        $subscribe->update([
            'status' => 'subscribed'
        ]);

        return redirect('/analyst');
    }

    public function paymentCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture') {
                $subscribe = SubscriberModel::where('id_subsscription', $request->order_id)->first();
                $subscribe->update([
                    'status' => 'subscribed'
                ]);
            }
        }
    }

    public function follow(Request $request)
    {
        $analystId = $request->userId;
        $userId = Auth::id();

        $insert = SubscriberModel::create([
            'id_subscriber' => $userId,
            'id_analyst' => $analystId,
            'status' => 'pending'
        ]);
        //dd($insert);
        return $insert;
    }

    public function profileMini(Request $request)
    {
        $userId = $request->userId;

        $userData = User::where('id', $userId)
            ->join('tb_analyst_price', 'users.id', '=', 'tb_analyst_price.id_analyst')
            ->first()->toArray();

        $followers = SubscriberModel::where('id_analyst', $userId)->get()->count();

        $post = PostModel::where('id_user', $userId)->get()->count();

        $pushToArray = ["followers" => $followers, "post" => $post];

        $data = array_merge($userData, $pushToArray);

        return $data;
    }

    public function profile($id)
    {
        $isSubscribed = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', $id)->where('status', 'subscribed')->first();

        if ($isSubscribed || Auth::id() == $id) {
            $followers = SubscriberModel::where('id_analyst', $id)->get()->count();
            $profileData = User::where('id', $id)
                ->join('tb_analyst_price', 'users.id', '=', 'tb_analyst_price.id_analyst')
                ->first()->toArray();
            $post = PostModel::where('id_user', $id)->take(3)->get()->toArray();
            $postCount = PostModel::where('id_user', $id)->get()->count();
            $portoBeli = PortofolioBeliModel::where('user_id', $id)->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')->get()->toArray();
            $portoJual = PortofolioJualModel::where('user_id', $id)->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')->get()->toArray();
            //dd($portoBeli);
            $porto = [];
            foreach ($portoBeli as $beli) {
                $data = [
                    'nama_saham' => $beli['nama_saham'],
                    'harga' => $beli['harga_beli'],
                    'tanggal' => $beli['tanggal_beli'],
                    'time' => Carbon::parse($beli['tanggal_beli'])->diffForHumans(),
                    'status' => 'buy'
                ];

                array_push($porto, $data);
            }

            foreach ($portoJual as $jual) {
                $data = [
                    'nama_saham' => $jual['nama_saham'],
                    'harga' => $jual['harga_jual'],
                    'tanggal' => $jual['tanggal_jual'],
                    'time' => Carbon::parse($jual['tanggal_jual'])->diffForHumans(),
                    'status' => 'sell'
                ];

                array_push($porto, $data);
            }

            usort($porto, function ($a, $b) {
                return strtotime($a['tanggal']) <=> strtotime($b['tanggal']);
            });

            $porto = array_reverse($porto);
            $porto = array_slice($porto, 0, 5);

            $data = compact(['followers', 'profileData', 'post', 'postCount', 'porto']);
            //dd($data);

            return view('userProfile')->with('data', $data);
        } else {
            return redirect('/');
        }
    }
}
