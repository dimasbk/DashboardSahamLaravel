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
use App\Models\PortofolioJualModel;
use App\Models\PortofolioBeliModel;
use App\Models\RequestModel;
use App\Models\JenisSahamModel;
use App\Models\SekuritasModel;
use Carbon\Carbon;
use SebastianBergmann\Timer\Duration;

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

    public function getdataAnalystBeli($user_id)
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

            $data = compact(['dataporto'], ['jenis_saham'], ['sekuritas'], ['userData']);
            //dd($data);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
            //return view('portofoliobeliAnalyst', $data);
        } else {
            //print();
         //   return redirect('/');
        }
    }

    public function getdataAnalystJual($user_id)
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

            $data = compact(['dataporto'],  ['jenis_saham'], ['sekuritas'], ['userData']);
            //dd($data);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
            //return view('portofoliobeliAnalyst', $data);
        } else {
            //print();
         //   return redirect('/');
        }
    }

    // public function getdataAnalystJual($user_id)
    // {
    //     // $isSubscribed = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', $user_id)->where('status', 'subscribed')->first();
    //     // if ($isSubscribed) {
    //         $dataportojual = PortofolioJualModel::where('user_id', $user_id)
    //             ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
    //             ->join('tb_sekuritas', 'tb_portofolio_jual.id_sekuritas', '=', 'tb_sekuritas.id_sekuritas')
    //             ->get();
    //         $emiten = SahamModel::all();
    //         $jenis_saham = JenisSahamModel::all();
    //         $sekuritas = SekuritasModel::all();
    //         $userData = User::where('id', $user_id)->first();

    //         $data = compact(['dataportojual'],['emiten'],['jenis_saham'], ['sekuritas'], ['userData']);
    //         //dd($dataporto);
    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $data
    //         ], 200);
    //        // return view('portofoliojualAnalyst', $data);
    //     // } else {
    //     //     return redirect('/');
    //    // }
    // }

    public function requestAnalyst(){
    //try{

        //$id = Auth::id();

        // $validator = Validator::make([
        //    // 'name' => 'required|string|max:255',
        //     'user_id' => 'unique:users',
        //    // 'password' => 'required|string|min:8'
        // ]);

        // if($validator->fails()){
        //     return response()->json(['message'=> 'anda sudah request menjadi analyst']);
        // }


        $insert = RequestModel::create([
            //'id_saham' => $request->id_saham,
            'user_id' => Auth::id(),
            'status' => "pending",

        ]);

        return response()->json(['messsage'=>'Berhasil', 'data'=>$insert ]);

        //dd($data);
        // dd($request);
        // dd($insert);
        // if ($insert) {
        //     $insert->save();
        //     return response()->json(['messsage' => 'Berhasil', 'data' => $insert]);
        // }
    // }catch (\Exception $e) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => $e
    //     ]);}
    }

    public function checkUserRequest(Request $request)
    {
        $id_user = Auth::id();
        // $notToFollow = SubscriberModel::where('id_subscriber', $id_user)->where('status', 'subscribed')->pluck('id_analyst')->toArray();
        // array_push($notToFollow, $id_user);
        // $toFollow = User::where('id_roles', 2)->whereNotIn('id', $notToFollow)->get()->toArray();
        // $existing = SubscriberModel::where('id_subscriber', $id_user)
        //     ->join('users', 'tb_subscription.id_analyst', '=', 'users.id')
        //     ->get()->toArray();
        $existing = SubscriberModel::where('id_subscriber', $id_user)
            ->join('users', 'tb_subscription.id_analyst', '=', 'users.id')
            ->get()->toArray();


            $pending = RequestModel::where('user_id', $id_user)->get()->toArray();
           // ->join('users', 'tb_subscription.id_analyst', '=', 'users.id')


        $data = compact(['pending', 'existing']);

        //dd($existing);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);

    }



    public function request()
    {

        $request = RequestModel::createOrUpdate([
            'user_id' => Auth::id(),
        ], [
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'data' => "sukese"
        ], 200);

        //return redirect()->back()->with('status', 'Request berhasil dibuat mohon menunggu konfirmasi admin');
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

    public function setSubscribedUser($id)
    {

        $subscribe = SubscriberModel::where('id_subscription', $id)->first();
       // $expired = Carbon::today()->addMonths($request->duration)->toDateString();
        $subscribe->update([
            'status' => 'subscribed',
           // 'expired' => $expired,
           // 'subscribe_fee' => $request->price
        ]);
        return $subscribe;
    }

    // public function setSubscribedUser($id)
    // {
    //     $id = Auth::id();
    //     $subscribe = SubscriberModel::where('id_subscription', $id)->first();
    //     $subscribe->update([
    //         'status' => 'subscribed'
    //     ]);
    //     $subscribe->save();
    //     return $subscribe;

    //    // return redirect('/analyst');
    // }

    public function pay(Request $request)
    {
        //\Log::info("asjdhsf");
        $grossAmount = $request->price;
        $today = Carbon::today();
        $expired = $today->addMonths($request->duration)->toDateString();
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

    public function index()
    {
        $id_user = Auth::id();
        $data = PriceModel::where('id_analyst', $id_user)->get();


        // $id_user = Auth::id();
        // if (Auth::user()->id_roles == 2) {
        //     $postData = PostModel::where('id_user', $id_user)
        //         ->join('users', 'tb_post.id_user', '=', 'id_analyst')
        //         ->get();

        //     $saham = SahamModel::all();

        //     $mine =  compact(['postData', 'saham']);


        // }
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);

        // return response()->json([
        //     'status' => 'success',
        //     'data' => $prices
        // ], 200);

       // return view('plan', compact(['prices']));
    }

    // public function create()
    // {
    //     return view('createPlan');
    // }

    public function delete($id_price)
    {
        $price = PriceModel::where('id_price', $id_price)->firstOrFail();
        $price->delete();
        $id = Auth::id();
        return response()->json(['messsage' => 'Data Berhasil di Delete']);
        //return redirect('/plan/manage');
    }


    public function editPlan(Request $request)
    {
        //$price = PriceModel::where('id_price', $id)->firstOrFail();
      //  return view('editPlan', compact(['price']));

        $Edit = PriceModel::where('id_price', $request->id_price)->firstOrFail();
        $id = Auth::id();
       // dd($Edit);


        // $price->id_saham = $request->id_saham;
        // $price->user_id = $id;
        // $price->jenis_saham = $request->id_jenis_saham;
      //  $price->user_id = $id;
        $Edit->price = $request->price;
        $Edit->month = $request->month;
       // $price->harga_beli = $request->harga_beli;
        // $price->fee_beli_persen = $request->fee_beli_persen;
        $Edit->save();


        return response()->json(['messsage' => 'Data Berhasil di Update']);
    }

    public function editProfile(Request $request)
    {
        //$price = PriceModel::where('id_price', $id)->firstOrFail();
      //  return view('editPlan', compact(['price']));
        $user_id = Auth::id();
       // $Edit = User::where('id', Auth::id())->firstOrFail();

        $Edit = User::where('id', $request->user_id)->firstOrFail();
        $id = Auth::id();
       // dd($Edit);


        // $price->id_saham = $request->id_saham;
        // $price->user_id = $id;
        // $price->jenis_saham = $request->id_jenis_saham;
      //  $price->user_id = $id;
        $Edit->name = $request->name;
       // $Edit->month = $request->month;
       // $price->harga_beli = $request->harga_beli;
        // $price->fee_beli_persen = $request->fee_beli_persen;
        $Edit->save();


        return response()->json(['messsage' => 'Profile Berhasil di Update']);
    }

    public function insertPlan(Request $request)
    {
        // $id = Auth::id();
     //   Log::info("message");($request->all);
        // $id_analyst = PriceModel::where('id_analyst', $id)->first();

        $price = $request->input('price');
        $month = $request->input('month');

        $insert = PriceModel::create([

            'price' => $price,
            'month' => $month,
            'id_analyst' => Auth::id()

        ]);
        //$insert->save();
        $insert->save();
        return response()->json([
            'status' => 'success',
            'data' => $insert
        ], 200);
        // if ($insert) {
        //   //  $insert->save();
        //     //Log::info($request);
        //     return response()->json(['messsage' => 'Berhasil', 'data' => $insert]);

        // }


       // return redirect('/plan/manage')->with('status', 'Plan berhasil dibuat/diubah');
    }




    // public function subscribe(Request $request)
    // {
    //     $analystData = User::where('id', $request->id)->first();
    //     $prices = PriceModel::where('id_price', $request->id_price)->first();
    //     $data = compact(['analystData', 'prices']);

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $data
    //     ], 200);

    //     //dd($analystData);
    //     //return view('landingPage/subscribe', compact(['analystData', 'prices']));
    // }

    // public function setSubscribed($id)
    // {
    //     $subscribe = SubscriberModel::where('id_subscription', $id)->first();
    //     $subscribe->update([
    //         'status' => 'subscribed'
    //     ]);
    //     return $subscribe;
    // }

    // public function pay(Request $request)
    // {
    //  //   \Log::info("asjdhsf");
    //     $grossAmount = $request->price;
    //     $expired = Carbon::today()->addMonths($request->duration)->toDateString();
    //     //return $expired;
    //     $subscribe = SubscriberModel::create([
    //         'id_subscriber' => Auth::id(),
    //         'id_analyst' => $request->id_analyst,
    //         'expired' => $expired,
    //         'status' => 'pending'
    //     ]);
    //     // Set your Merchant Server Key
    //     \Midtrans\Config::$serverKey = config('midtrans.server_key');
    //     // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    //     \Midtrans\Config::$isProduction = false;
    //     // Set sanitization on (default)
    //     \Midtrans\Config::$isSanitized = true;
    //     // Set 3DS transaction for credit card to true
    //     \Midtrans\Config::$is3ds = true;

    //     $params = array(
    //         'transaction_details' => array(
    //             'order_id' => $subscribe->id_subscription,
    //             'gross_amount' => $grossAmount,
    //         ),
    //         'customer_details' => array(
    //             'name' => auth()->user()->name,
    //             'email' => auth()->user()->email,
    //         ),
    //     );

    //     $subscribeID = $subscribe->id_subscription;
    //     $paymentUrl = \Midtrans\Snap::createTransaction($params);
    //     // \Log::info($paymentUrl->redirect_url);

    //     return array(
    //         "redirect_url" => $paymentUrl->redirect_url
    //     );
    // }


}
