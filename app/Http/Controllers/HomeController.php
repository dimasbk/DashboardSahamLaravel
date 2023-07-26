<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $response = Http::acceptJson()
            ->withHeaders([
                'X-API-KEY' => 'fe4bd0445ab2472281d6ac636d5d426d'
            ])->get('https://newsapi.org/v2/everything', [
                'q' => 'saham OR IHSG OR emiten OR IPO OR shareholder NOT Bola ',
                'sortBy' => 'publishedAt',
                'language' => 'id',
                'searchIn' => 'content',
                'pageSize' => '25'
            ])->json();

        $berita = $response['articles'];
        //dd($berita);

        return view('home1', ['data' => $berita]);
    }

    public function saveToken(Request $request)
    {
        auth()->user()->update(['fcm_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }

    public function sendNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAAMYjYyEA:APA91bFu5Wm9N3O2GYoCyCh4CZtyHdV3kPPJ6Fmt50gSZMblhTrZT3wCLuG7NTd6vkVXjrgRIFWJCwWAp2S26SI0rUoM8FOnimt68c-WYxQIoGtVaGXgkFhuUioByWPE1SVzeT5ZpGc7';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        dd($response);
    }
}
