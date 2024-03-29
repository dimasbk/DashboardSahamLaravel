<?php

namespace App\Http\Controllers;

use App\Models\PriceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PlanController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $prices = PriceModel::where('id_analyst', Auth::id())->paginate(10);

        return view('plan', compact(['prices']));
    }

    public function create()
    {
        return view('createPlan');
    }

    public function delete($id)
    {
        $price = PriceModel::where('id_price', $id)->firstOrFail();
        $price->delete();
        return redirect('/plan/manage')->with('status', 'Plan berhasil dihapus');
    }


    public function edit($id)
    {
        $price = PriceModel::where('id_price', $id)->firstOrFail();
        return view('editPlan', compact(['price']));
    }

    public function insert(Request $request)
    {
        if (Auth::user()->id_roles == 3) {
            return redirect('/');
        }

        $validated = $request->validate([
            'month' => 'required',
            'price' => 'required'
        ]);

        $price = PriceModel::updateOrCreate(
            [
                'id_analyst' => Auth::id(),
                'month' => $validated['month']

            ],
            [
                'price' => $validated['price']
            ]
        );

        return redirect('/plan/manage')->with('status', 'Plan berhasil dibuat/diubah');
    }

}