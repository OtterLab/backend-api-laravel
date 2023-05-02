<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /** 
     * Login user and create token
     * 
     * @param [string] email
     * @param [string] password
    */

    public function login(Request $request)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        
        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)) {
            $LoginUser = Auth::user();

            return response()->json([
                'error' => 'Incorrect email or password'
            ], 401);
        }

        $LoginUser = $request->user();

        return response()->json([
            'login_user' => $LoginUser,
            'authorization' => [
                'token' => $LoginUser->createToken('apptoken')->plainTextToken,
                'message' => 'Login successfully'
            ]
        ], 202);
    }
}
