<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            //'fcm_token' => 'nullable'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_roles' => "3",
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    // public function login(Request $request)
    // {
    //     if (!Auth::attempt($request->only('email', 'password')))
    //     {
    //         return response()
    //             ->json(['message' => 'Unauthorized'], 401);
    //     }

    //     $user = User::where('email', $request['email'])->firstOrFail();

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()
    //         ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);
    // }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Wrong username or password'], 401);
        }

        // if ($request->filled('fcm_token')){
        //     Auth::user()->update(['fcm_token' => $request->fcm_token]);
        // }

        $user = User::where('email', $request['email'])->firstOrFail();
        $user = User::where('email', $request['email'])
            ->join('tb_roles', 'users.id_roles', '=', 'tb_roles.id_roles')
            ->select('users.*', 'tb_roles.roles')
            ->firstOrFail();
        $idRole = $user->id_roles;
        $roleName = $user->roles;
        $name = $user->name;
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['name'=>$name,'message' => 'Hi '.$user->name.', welcome to StockApp','access_token' => $token, 'token_type' => 'Bearer','id_role'=>$idRole, 'role'=>$roleName ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
