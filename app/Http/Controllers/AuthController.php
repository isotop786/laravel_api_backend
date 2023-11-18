<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password')))
        {
            $user = Auth::user();

            $token = $user->createToken('admin')->accessToken;

            return[
                'token' => $token,
                // 'user' => $user
            ];
        }

        return response([
            'error' => 'Invalid Credentials',

        ], Response::HTTP_UNAUTHORIZED);
    }

    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        return response(
            $user,
            Response::HTTP_CREATED
        );
    }


}
