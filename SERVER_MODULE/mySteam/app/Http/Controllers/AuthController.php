<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request){

        $validate = validator($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validate->fails()){
            return response()->json(['message' => 'There something missing', 'errors' => $validate->errors()], 403);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json(['message' => 'The email with password dnnt match'], 402);
        }

        if(Hash::check($request->password, $user->password)){
            $token = $user->createToken('mysteam')->plainTextToken;
            return response()->json(['message' => 'login success', 'user' => $user, 'token' => $token]);
        }

        return response()->json(['message' => 'The email with password dnnt match'],402);
    }

    public function register(Request $request){

        $validate = validator($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|unique:users,email'
        ]);

        if($validate->fails()){
            return response()->json(['message' => 'There something missing', 'errors' => $validate->errors()]);
        }

        $request['user_id'] = 2; //user role

        $user = User::create($request->all());
        $token = $user->createToken('mysteam')->plainTextToken;

        return response()->json(['message' => 'Welcome', 'user' => $user, 'token' => $token]);
    }

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'logout success']);
    }
}
