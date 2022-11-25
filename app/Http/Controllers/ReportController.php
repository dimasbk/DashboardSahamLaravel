<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct(){
        
        $this->middleware('auth');
    }

}
