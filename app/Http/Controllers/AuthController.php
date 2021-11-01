<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            //uniques to the user table to the email field
            'email' => 'required|string|unique:users,email',
            //password_confirmation must be sent
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        //201 something was created 😂
        return response($response, 201);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //Check email, first means it will get the first value available
        //even if it is supposed to be an unique value 🤷‍♀️
        $user = User::where('email', $fields['email'])->first();
        //Check password
        if(!$user || Hash::check($fields['password'], $user->password)){
            return response([
                "Message" => "Wrong credentials"
            ], 401);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        return [
            'Message' => 'Success'
        ];
    }
}
