<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class AuthenticationController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|unique:users|max:255',
            'password'=>'required|min:6'
        ]);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        $token=$user->createToken('auth_token')->accessToken;

        return response([
            'token'=>$token
        ]);

    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $user=User::where('email',$request->email)->first();

        if(!$user|| !Hash::check($request->password,$user->password)){
            return response([
                'message'=>'The provided credentials are incorrect'
            ]);
        }

        $token=$user->createToken('auth_token')->accessToken;

        return response([
            'token'=>$token
        ]);

        
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response([
            'message'=>'Logged out sucesfully'
        ]);
    }
}
