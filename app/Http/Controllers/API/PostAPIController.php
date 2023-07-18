<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PostModel;
use App\Models\SahamModel;
use App\Models\SubscriberModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostAPIController extends Controller
{

    public function  edit(Request $request)
    {

        $dataPost = PostModel::where('id_post', $request->id_post)->firstOrFail();
        $id = Auth::id();
        //dd($dataPost);


        // $dataPost->id_saham = $request->id_saham;
        // $dataPost->user_id = $id;
        // $dataPost->jenis_saham = $request->id_jenis_saham;
        $dataPost->title = $request->title;
        $dataPost->content = $request->content;
       // $dataPost->harga_beli = $request->harga_beli;
        // $dataPost->fee_beli_persen = $request->fee_beli_persen;
        $dataPost->save();


        return response()->json(['messsage' => 'Data Berhasil di Update']);
    }


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

    public function getUserPostt()
    {
        $id_user = Auth::id();
        if (Auth::user()->id_roles == 2) {
            $postData = PostModel::where('id_user', $id_user)
                ->join('users', 'tb_post.id_user', '=', 'users.id')
                ->get();

            $saham = SahamModel::all();

            $mine =  compact(['postData', 'saham']);

            return response()->json([
                'status' => 'success',
                'data' => $postData
            ], 200);

            //return view('postmanage', compact(['postData', 'saham']));
        } else {


            // return response()->json([
            //     'status' => 'success',
            //     'data' => $mine
            // ], 200);
          //  return redirect('/');
        }
    }

    public function deletePostt($id_post)
    {
        // if (!Gate::allows('update-delete-post', $postModel)) {
        //     abort(403);
        // }
        // $post = PostModel::where('id_post', $id_post)->firstOrFail();
        // if ($post) {
        //     $image = $post->picture;
        //     if ($image) {
        //         File::delete(public_path("images/public_images/" . $image));
        //     }
        //     $post->delete();
        // }


        $post = PostModel::where('id_post', $id_post)->firstOrFail();
        $post->delete();
        $id = Auth::id();
        return response()->json(['messsage' => 'Data Berhasil di Delete']);
       // return redirect('/post/manage');
    }

    public function deletePosttt($id_post, PostModel $postModel)
    {
        if (!Gate::allows('update-delete-post', $postModel)) {
            abort(403);
        }
        $post = PostModel::where('id_post', $id_post)->firstOrFail();
        if ($post) {
            $image = $post->picture;
            if ($image) {
                File::delete(public_path("images/public_images/" . $image));
            }
            $post->delete();
        }
       // return redirect('/post/manage');
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

    public function addPost(Request $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');
        $tag = $request->input('tag');
        if ($request->input('emitenSaham')) {
            $id_saham = $request->input('emitenSaham');
        } else {
            $id_saham = null;
        }
        $image = $request->file('image');
        if ($image) {
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public_images', $fileName, 'local_images');

            $post = PostModel::create([
                'title' => $title,
                'content' => $content,
                'picture' => $fileName,
                'tag' => $tag,
                'id_saham' => $id_saham,
                //'id_user' => Auth::id()
            ]);
            return response()->json([
                'status' => 'success',
                'data' => $post
            ], 200);
            //return 'berhasil';
        } else {
            $post = PostModel::create([
                'title' => $title,
                'content' => $content,
                'tag' => $tag,
                'id_saham' => $id_saham,
                'id_user' => Auth::id()
            ]);
            return response()->json([
                'status' => 'success',
                'data' => $post
            ], 200);
            //return 'berhasil';
        }
    }
}
