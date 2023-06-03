<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Validator;
use App\Http\Requests\User\LoginUserRequest;

class AuthController extends Controller
{
    public function oauthUser() {
        $user = Auth::user();

        if (Auth::check()) {
            return Response(['data' => Auth::user()], 200);
        }

        return Response(['data' => 'Unauthorized'], 401);
    }

    public function login(LoginUserRequest $request)
    {
        if(Auth::attempt($request->all())) {
            $user = Auth::user();
            $success =  $user->createToken('AccessToken')->plainTextToken; 
        
            return Response(['token' => $success], 200);
        }

        return Response(['message' => 'email or password wrong'], 401);
    }
    
    public function logout(): Response
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        
        return Response(['data' => 'User Logout successfully.'], 200);
    }
}
