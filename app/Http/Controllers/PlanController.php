<?php

namespace App\Http\Controllers;

use App\Models\PriceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $prices = PriceModel::where('id_analyst', Auth::id())->get();

        return view('plan', compact(['prices']));
    }
}