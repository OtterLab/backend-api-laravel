<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    /**
     * Create new User
     * 
     * @param [string] fullname
     * @param [string] email
     * @param [string] password
    */

    public function register(Request $request)
    {
        /** validate incoming data */
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 200);
        }

        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        if($user->save()) {
            $token = $user->createToken('apptoken')->plainTextToken;

            return response()->json([
                'message' => 'User successfully created',
                'token' => $token
            ], 201);
        }
        else {
            return response()->json([
                'error' => 'Unable to create user'
            ], 422);
        }
    }
}
