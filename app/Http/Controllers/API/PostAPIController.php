<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PostModel;
use App\Models\SubscriberModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostAPIController extends Controller
{
    public function view($id)
    {
        $postData = PostModel::where('id_post', $id)->first();
        if ($postData->tag == 'private') {
            $isSubscribed = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', $postData->id_user)->where('status', 'subscribed')->first();
            if ($isSubscribed) {
                //dd('test1');
                return response()->json([
                    'status' => 'success',
                    'data' => $postData
                ], 200);
            } else {
                return response()->json([
                    'status' => 'data not found',
                ], 404);
            }
        } else {
            //dd('test3');
            return response()->json([
                'status' => 'success',
                'data' => $postData
            ], 200);
        }
    }

    public function vieww($id)
    {
        $postData = PostModel::where('id_post', $id)->first();
        if ($postData->tag == 'private') {
            $isSubscribed = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', $postData->id_user)->where('status', 'subscribed')->first();
            if ($isSubscribed) {
                //dd('test1');
                return response()->json([
                    'status' => 'success',
                    'data' => $postData
                ], 200);
            } else {
                return response()->json([
                    'status' => 'data not found',
                ], 404);
            }
        } else {
            //dd('test3');
            return response()->json([
                'status' => 'success',
                'data' => $postData
            ], 200);
        }
    }

    public function analystPost($id)
    {
        $isSubscribed = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', $id)->where('status', 'subscribed')->first();
        if ($isSubscribed) {
            $postData = PostModel::where('id_user', $id)->join('users', 'tb_post.id_user', '=', 'users.id')->get();

            return response()->json([
                'status' => 'success',
                'data' => $postData
            ], 200);
        } else {
            return response()->json([
                'status' => 'data not found',
            ], 404);
        }
    }

    public function post()
    {
        $postData = PostModel::where('tag', 'public')->where('id_saham', null)->join('users', 'tb_post.id_user', '=', 'users.id')->get();

        if (Auth::check()) {
            $analystId = [];
            $analyst = SubscriberModel::where('id_subscriber', Auth::id())->where('status', 'subscribed')->get();

            foreach ($analyst as $analysts) {
                array_push($analystId, $analysts->id_analyst);
            }

            $postSub = PostModel::where('tag', 'private')->whereIn('id_user', $analystId)->join('users', 'tb_post.id_user', '=', 'users.id')->get();

            $postData = $postData->merge($postSub);
            //dd($postData);

            return response()->json([
                'status' => 'success',
                'data' => $postData
            ], 200);
        } else {

            return response()->json([
                'status' => 'success',
                'data' => $postData
            ], 200);
        }
    }

    public function postt()
    {
        $id_user = Auth::id();
        $postData = PostModel::where('tag', 'public')->where('id_saham', null)->join('users', 'tb_post.id_user', '=', 'users.id')->get();

        if (Auth::check()) {
            $analystId = [];
            $analyst = SubscriberModel::where('id_subscriber', $id_user)->where('status', 'subscribed')->get();

            foreach ($analyst as $analysts) {
                array_push($analystId, $analysts->id_analyst);
            }

            $postSub = PostModel::where('tag', 'private')->whereIn('id_user', $analystId)->join('users', 'tb_post.id_user', '=', 'users.id')->get();

            $postData = $postData->merge($postSub);
            //dd($postData);

            return response()->json([
                'status' => 'success',
                'data' => $postData
            ], 200);
        } else {

            return response()->json([
                'status' => 'success',
                'data' => $postData
            ], 200);
        }
    }
}
