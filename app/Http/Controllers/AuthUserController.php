<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class AuthUserController extends Controller
{
    public function register(UserRequest $request)
    {

        $validated = $request->validated();

        $user = User::create([
            'name'       => $validated['name'],
            'password'   => hash::make($validated['password']),
            'email'      => $validated['email']

        ]);

        $token = $user->createToken('API_Token_For__' . $validated['name'])->plainTextToken;

        // you defirnd which data is returned to mobile developer user without create resource class

        $data['name']  = $user->name;
        $data['email'] = $user->email;
        $data['token'] = $token;

        return ApiResponse::send_response(201, 'user is created sueccessfullu created', $data);
    }

    public function login(Request $request)
    {
        // make sure credentials is corrrect
        $validated = $request->validate([
            'email'    =>  'required|email',
            'password' =>  ['required', Rules\Password::default()]
        ]);

        // make sure the user who try to login is authenticated 
        if (Auth::attempt($validated)) {

            $user = Auth::user();

            $data = [
                'name'  => $user->name,
                'token' => $user->createToken('Login_user__ ' . $user->name)->plainTextToken

            ];
            ####
            return ApiResponse::send_response('200', 'welcome back', $data);
        } else {
            return ApiResponse::send_response(400, 'yuymust register before login', []);
        }
    }

    public function logout(request $request)
    {
        // retrive the authicated user and i call him by auth::user()
        $user = $request->user();
        //delete the token which mobile develper got it when he log in 
        $user->currentAccessToken()->delete();

        return ApiResponse::send_response(200, 'You are logout', []);
    }
}
