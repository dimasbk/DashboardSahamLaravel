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

class AnalystAPIController extends Controller
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


    }
