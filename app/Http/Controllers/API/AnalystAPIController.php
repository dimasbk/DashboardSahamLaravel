<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PostModel;
use App\Models\SahamModel;
use App\Models\SubscriberModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PriceModel;
use App\Models\PortofolioBeliModel;
use App\Models\PortofolioJualModel;
use Carbon\Carbon;

class AnalystAPIController extends Controller
{

    public function profile($id)
    {
       // $id = $request->id;
        $id_user = Auth::id();
        $isSubscribed = SubscriberModel::where('id_subscriber', $id_user)->where('id_analyst', $id)->where('status', 'subscribed')->first();

        if ($isSubscribed || $id_user == $id) {
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

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

            //return view('userProfile')->with('data', $data);
        } else {
            //return redirect('/');
        }
    }

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
            'data' => $data
        ], 200);


        //return view('landingPage/analyst', $data);
    }

    public function getAdmin(Request $request)
    {
        $id_user = Auth::id();
        $notToFollow = SubscriberModel::where('id_subscriber', $id_user)->where('status', 'subscribed')->pluck('id_analyst')->toArray();
        array_push($notToFollow, $id_user);
        $toFollow = User::where('id_roles', 1)->whereNotIn('id', $notToFollow)->get()->toArray();
        $existing = SubscriberModel::where('id_subscriber', $id_user)
            ->join('users', 'tb_subscription.id_analyst', '=', 'users.id')
            ->get()->toArray();

        $data = compact(['toFollow', 'existing']);

        //dd($existing);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);


        //return view('landingPage/analyst', $data);
    }

    public function getAnalystExisting(Request $request)
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
            'data' => $data
        ], 200);


        //return view('landingPage/analyst', $data);
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


       return view('landingPage/plan', compact(['analystData', 'prices']));
    }



    public function planApi(Request $request)
    {
        $analystData = User::where('id', $request->id)->first();
        $prices = PriceModel::where('id_analyst', $request->id)->get();
        $data = compact(['analystData', 'prices']);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);


       // return view('landingPage/plan', compact(['analystData', 'prices']));
    }
    public function subscribe(Request $request)
    {
        $analystData = User::where('id', $request->id)->first();
        $prices = PriceModel::where('id_price', $request->id_price)->first();
        $data = compact(['analystData', 'prices']);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);

        //dd($analystData);
        //return view('landingPage/subscribe', compact(['analystData', 'prices']));
    }

    public function setSubscribed($id)
    {
        $subscribe = SubscriberModel::where('id_subscription', $id)->first();
        $subscribe->update([
            'status' => 'subscribed'
        ]);
        return $subscribe;
    }

    public function pay(Request $request)
    {
        \Log::info("asjdhsf");
        $grossAmount = $request->price;
        $expired = Carbon::today()->addMonths($request->duration)->toDateString();
        //return $expired;
        $subscribe = SubscriberModel::create([
            'id_subscriber' => Auth::id(),
            'id_analyst' => $request->id_analyst,
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
        $paymentUrl = \Midtrans\Snap::createTransaction($params);
        // \Log::info($paymentUrl->redirect_url);

        return array(
            "redirect_url" => $paymentUrl->redirect_url
        );
    }


    }
