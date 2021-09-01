<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class ApiAuthController extends Controller
{
    use ApiResponse;
    
    public function apiRegister(Request $request)
    {		
        // ?? is this going to through exception ??
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);
		//?? Exception ??
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //event(new Registered($user));
        //Auth::login($user);
        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    /**
     * Handle an incoming authentication request from API.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return json
     */
    public function apiLogin(LoginRequest $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
        
        if (!Auth::attempt($attr)) {
            // ['status'=>'Error', 'message' => $msg, 'data'=>'']
            return $this->error('Credentials not match', 401);
        }
        $user = Auth::user();
        // ['status'=>'Success', 'message' => '', 'data'=>[token=>$token]]
        return $this->api_success(['token' => $user->createToken('API Token')->plainTextToken]);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function apiLogout(Request $request)
    {
        // Deleting all tokens: add device specific check
        Auth::user()->tokens()->delete();
        // ['status'=>'Success', 'message' => $msg, 'data'=>'']
        return $this->api_success(['token' =>'Token Revoked']);
    }
}
