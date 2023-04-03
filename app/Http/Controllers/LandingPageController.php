<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostModel;

class LandingPageController extends Controller
{
    public function index()
    {
        $post = PostModel::where('tag', 'public')
            ->orderBy('created_at', 'DESC')
            ->take(3)->get()->toArray();
        //dd($post);
        return view('landing_page', compact(['post']));
    }
}