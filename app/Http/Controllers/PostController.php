<?php

namespace App\Http\Controllers;

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

    public function getUserPost()
    {
        $postData = PostModel::where('id_user', Auth::id())
            ->join('users', 'tb_post.id_user', '=', 'users.id')
            ->get();

        return view('postmanage', compact(['postData']));
    }


    public function view($id)
    {
        $postData = PostModel::where('id_post', $id)
            ->get();

        return view('postpre', compact(['postData']));
    }

    public function getPost()
    {
        $postData = PostModel::where('id_user', Auth::id())
            ->join('users', 'tb_post.id_user', '=', 'users.id')
            ->get();


        return view('userPost', compact(['postData']));
    }

    public function addPost(Request $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');
        $tag = $request->input('tag');
        $image = $request->file('image');
        if ($image) {
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public_images', $fileName, 'local_images');

            $post = PostModel::create([
                'title' => $title,
                'content' => $content,
                'picture' => $fileName,
                'tag' => $tag,
                'id_user' => Auth::id()
            ]);
            return 'berhasil';
        } else {
            $post = PostModel::create([
                'title' => $title,
                'content' => $content,
                'tag' => $tag,
                'id_user' => Auth::id()
            ]);
            return 'berhasil';
        }
    }

    public function editPost($id)
    {
        $post = PostModel::where('id_post', $id)->get()->toArray();
        //dd($post);
        return view('postEdit', compact(['post']));
    }

    public function edit(Request $request)
    {
        $postData = PostModel::where('id_post', $request->id)->firstOrFail();
        //dd($postData);
        if ($request->image == null) {
            $postData->title = $request->title;
            $postData->content = $request->content;
            $postData->tag = $request->tag;
            $postData->touch();
            $postData->save();
            return redirect('/post/manage');
        } else {
            $oldimage = PostModel::where('id_post', $request->id)->value('picture');
            $postData->title = $request->title;
            $postData->content = $request->content;
            $postData->tag = $request->tag;
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public_images', $fileName, 'local_images');
            $postData->picture = $fileName;
            $postData->touch();
            $postData->save();

            if ($oldimage) {
                File::delete(public_path("images/public_images/" . $oldimage));
            }
            return redirect('/post/manage');
        }
    }

    public function deletePost($id)
    {
        $post = PostModel::where('id_post', $id)->firstOrFail();
        if ($post) {
            $image = $post->picture;
            if ($image) {
                File::delete(public_path("images/public_images/" . $image));
            }
            $post->delete();
        }
        return redirect('/post/manage');
    }
}