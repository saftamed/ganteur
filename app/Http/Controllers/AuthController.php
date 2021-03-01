<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
class AuthController extends Controller
{
    public function login(Request $request)
    {

        
        $loging = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
            
        $user = User::where('email' , $loging['email'])->where('password',$loging['password'])->first();
         //   var_dump($user);
         if(!empty( $user)){
            Auth::login($user);
            if(!Auth::check()){
                return "failed !! ";
            }
            $token = Auth::user()->createToken('authToken')->accessToken;
            return response(['token' => $token,'name' => $user->name]);
         }
         return "failed !! ";
       

    }
}
