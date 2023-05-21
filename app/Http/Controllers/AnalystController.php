<?php

namespace App\Http\Controllers;

use App\Models\PortofolioBeliModel;
use App\Models\PortofolioJualModel;
use App\Models\PostModel;
use Carbon\Carbon;
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

    public function profileMini(Request $request)
    {
        $userId = $request->userId;

        $userData = User::where('id', $userId)->first()->toArray();

        $followers = SubscriberModel::where('id_analyst', $userId)->get()->count();

        $post = PostModel::where('id_user', $userId)->get()->count();

        $pushToArray = ["followers" => $followers, "post" => $post];

        $data = array_merge($userData, $pushToArray);

        return $data;
    }

    public function profile($id)
    {
        $isSubscribed = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', $id)->where('status', 'subscribed')->first();

        if ($isSubscribed) {
            $followers = SubscriberModel::where('id_analyst', $id)->get()->count();
            $profileData = User::where('id', $id)->first()->toArray();
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