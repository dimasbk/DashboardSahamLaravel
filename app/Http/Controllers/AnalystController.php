<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubscriberModel;
use Illuminate\Support\Facades\Auth;

class AnalystController extends Controller
{
    public function index()
    {
        $notToFollow = SubscriberModel::where('id_subscriber', Auth::id())->pluck('id_analyst')->toArray();
        array_push($notToFollow, Auth::id());
        $toFollow = User::where('id_roles', 2)->whereNotIn('id', $notToFollow)->get()->toArray();
        $existing = SubscriberModel::where('id_subscriber', Auth::id())
            ->join('users', 'tb_subscription.id_analyst', '=', 'users.id')
            ->get()->toArray();

        $data = compact(['toFollow', 'existing']);

        //dd($existing);
        return view('landingPage/analyst', $data);
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
}