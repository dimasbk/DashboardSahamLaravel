<?php

namespace App\Http\Controllers;

use App\Models\SahamModel;
use App\Models\SubscriberModel;
use Gate;
use Illuminate\Http\Request;
use App\Models\PostModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function index()
    {
        $postData = PostModel::where('id_user', Auth::id())->join('users', 'tb_post.id_user', '=', 'users.id')
            ->get();
        return view('userPost', compact(['postData']));
    }

    public function create()
    {
        if (Auth::user()->id_roles == 3) {
            return redirect('/');
        } else {
            $saham = SahamModel::all();

            return view('createPost', compact(['saham']));
        }
    }

    public function getUserPost()
    {
        if (Auth::user()->id_roles == 2) {
            $postData = PostModel::where('id_user', Auth::id())
                ->join('users', 'tb_post.id_user', '=', 'users.id')
                ->paginate(10);

            $saham = SahamModel::all();
            return view('postmanage', compact(['postData', 'saham']));
        } else {
            return redirect('/');

        }
    }



    public function getUserPostAdmin()
    {
        if (Auth::user()->id_roles == 1) {
            $postData = PostModel::join('users', 'tb_post.id_user', '=', 'users.id')->paginate(10);

            $saham = SahamModel::all();

            return view('admin/postmanage', compact(['postData', 'saham']));
        } else {
            return redirect('/');
        }
    }


    public function view($id)
    {

        $postData = PostModel::where('id_post', $id)->first();
        if ($postData->tag == 'private') {
            if (Auth::check()) {
                $isSubscribed = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', $postData->id_user)->where('status', 'subscribed')->first();
                if ($isSubscribed) {
                    //dd('test1');
                    return view('postpre', compact(['postData']));
                }
            }
            return redirect('/');
        } else {
            //dd('test3');
            return view('postpre', compact(['postData']));
        }
    }

    public function analystPost($id)
    {
        $isSubscribed = SubscriberModel::where('id_subscriber', Auth::id())->where('id_analyst', $id)->where('status', 'subscribed')->first();
        if ($isSubscribed) {
            $postData = PostModel::where('id_user', $id)->join('users', 'tb_post.id_user', '=', 'users.id')->get();

            return view('landingPage/post', compact(['postData']));
        } else {
            return redirect('/');
        }
    }

    public function getPost()
    {

        $subscribed = [1, 2, 3];
        $postData = PostModel::where('id_user', Auth::id())
            ->join('users', 'tb_post.id_user', '=', 'users.id')
            ->get();


        return view('postpre', compact(['postData']));
    }

    public function addPost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'tag' => 'required',
        ]);
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
            return redirect('/post/manage')->with('status', 'Post berhasil dibuat');
        } else {
            $post = PostModel::create([
                'title' => $title,
                'content' => $content,
                'tag' => $tag,
                'id_saham' => $id_saham,
                'id_user' => Auth::id()
            ]);
            return redirect('/post/manage')->with('status', 'Post berhasil dibuat');
        }
    }

    public function editPost($id, PostModel $postModel)
    {
        $post = PostModel::where('id_post', $id)->get()->toArray();
        $saham = SahamModel::all();
        //dd($post);
        if ($post[0]['id_user'] != Auth::id()) {
            abort(403);
        }
        //dd($post);
        return view('postEdit', compact(['post', 'saham']));
    }

    public function editPostAdmin($id, PostModel $postModel)
    {
        if (Auth::user()->id_roles == 1) {
            $post = PostModel::where('id_post', $id)->get()->toArray();
            //dd($post);
            return view('admin/postEdit', compact(['post']));
        }
        return redirect('/');
    }

    public function edit(Request $request, PostModel $postModel)
    {
        //dd($postData);

        if ($request->image == null) {
            PostModel::where('id_post', $request->id)->update([
                'title' => $request->title,
                'content' => $request->content,
                'tag' => $request->tag,
            ]);
            return redirect('/post/manage')->with('status', 'Post berhasil diubah');
        } else {
            $oldimage = PostModel::where('id_post', $request->id)->value('picture');
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public_images', $fileName, 'local_images');
            PostModel::where('id_post', $request->id)->update([
                'title' => $request->title,
                'content' => $request->content,
                'tag' => $request->tag,
                'picture' => $fileName
            ]);
            if ($oldimage) {
                File::delete(public_path("images/public_images/" . $oldimage));
            }
            return redirect('/post/manage')->with('status', 'Post berhasil diubah');
        }
    }

    public function editAdmin(Request $request, PostModel $postModel)
    {
        //dd($postData);
        if (Auth::user()->id_roles == 1) {
            if ($request->image == null) {
                PostModel::where('id_post', $request->id)->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'tag' => $request->tag,
                ]);
                return redirect('/admin/post')->with('status', 'Post berhasil diubah');
            } else {
                $oldimage = PostModel::where('id_post', $request->id)->value('picture');
                $image = $request->file('image');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public_images', $fileName, 'local_images');
                PostModel::where('id_post', $request->id)->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'tag' => $request->tag,
                    'picture' => $fileName
                ]);
                if ($oldimage) {
                    File::delete(public_path("images/public_images/" . $oldimage));
                }
                return redirect('/admin/post')->with('status', 'Post berhasil diubah');
            }
        }

        return redirect('/');
    }

    public function deletePost($id, PostModel $postModel)
    {
        $post = PostModel::where('id_post', $id)->firstOrFail();
        //dd($id);
        if ($post->id_user == Auth::id()) {
            if ($post) {
                $image = $post->picture;
                if ($image) {
                    File::delete(public_path("images/public_images/" . $image));
                }
                $post->delete();
            }
            return redirect('/post/manage');
        }
        return redirect('/post/manage');
    }

    public function deletePostAdmin($id)
    {
        if (Auth::user()->id_roles == 1) {
            $post = PostModel::where('id_post', $id)->firstOrFail();
            if ($post) {
                $image = $post->picture;
                if ($image) {
                    File::delete(public_path("images/public_images/" . $image));
                }
                $post->delete();
            }
            return redirect('/admin/post/manage');
        }
        return redirect('/');
    }
}