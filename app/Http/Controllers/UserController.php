<?php

namespace App\Http\Controllers;

use App\Models\RequestModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use stdClass;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        $request = RequestModel::where('user_id', Auth::id())
            ->orderBy('id_request', 'desc')->first();
        //dd($request);
        if ($request == null) {
            $request = new stdClass;
            $request->status = 'no request';
        }
        return view('editProfile', compact('request'));
    }

    public function request()
    {
        $request = RequestModel::updateOrCreate([
            'user_id' => Auth::id(),
        ], [
            'status' => 'pending'
        ]);

        return redirect()->back()->with('status', 'Request berhasil dibuat mohon menunggu konfirmasi admin');
    }

    public function update(Request $request)
    {
        $image = $request->file('profile-picture');
        if ($image) {
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_picture', $fileName, 'local_images');

            $profile = User::where('id', Auth::id())->update([
                'name' => $request->name,
                'profile_picture' => $fileName
            ]);
        } else {
            $profile = User::where('id', Auth::id())->update([
                'name' => $request->name,
            ]);
        }

        return redirect()->back()->with('status', 'Profile Updated');
    }

    public function deletePhoto()
    {
        $profile = User::where('id', Auth::id())->firstOrFail();
        File::delete(public_path("images/profile_picture/" . $profile->profile_picture));
        $profile = User::where('id', Auth::id())->update([
            'profile_picture' => null
        ]);

        return redirect()->back()->with('status', 'Profile Updated');
    }
}