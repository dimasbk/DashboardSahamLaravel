<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostModel;

class LandingPageController extends Controller
{
    public function index()
    {
        $post = PostModel::where('tag', 'public')->take(5)->get();
        //dd($post);
        return view('landing_page', compact(['post']));
    }
}