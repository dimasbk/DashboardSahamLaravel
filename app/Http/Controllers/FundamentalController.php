<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FundamentalController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($emiten){

        return view('fundamental', compact('emiten'));
    }
}
