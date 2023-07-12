<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;
    
    public function signup(SignupRequest $request) 
    {
        $request->validated($request->all());

        $user = User::create([
            "name" =>  $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        
        return $this->success([
            "user" => $user,
            "token" => $user->createToken("API token of " . $user->name)->plainTextToken
        ], "signup success", 201);
    }

    public function login(LoginRequest $request)  
    {
        
        $request-> validated($request->all());
        if (!Auth::attempt($request->only(["email", "password"]))) {
            return $this->error(null, "credentials do not match", 401);
        }

        $user = User::where("email", $request->email)->first();


        return $this->success([
            "user" => $user,
            "token" => $user->createToken("API tojen of" . $user->name)->plainTextToken
        ], 'login success');
    }
}