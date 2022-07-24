<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $req)
    {
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();
        $user->token = $user->createToken('e_commerce')->plainTextToken;
        return response()->json(
            [
                'user' => $user
            ]
        );
    }

    public function login(Request $req)
    {
        $user = User::where('email',$req->email)->first();
        if($user || Hash::check($req->password, $user->password))
        {
            $user->token = $user->createToken('e-commerce')->plainTextToken;
            return $user;
        }
        return response()->json(['msg' =>'email or password not correct']);
    }
}
