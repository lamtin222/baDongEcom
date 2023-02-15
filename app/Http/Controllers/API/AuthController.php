<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AppBaseController;

class AuthController extends AppBaseController
{
    /**
     *
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);
            $credentials = request(['email', 'password']);

            if (!Auth::guard('customer')->attempt($credentials)) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }

            $user =Customer::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }

            $tokenResult = $user->createToken('authToken',[$request->type])->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user_info'=>$user->toArray()
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }
    public function logout(Request $request)
    {
        $user=Auth::user();
        // $user->tokens()->delete();
        $user->currentAccessToken()->delete();
        return response()->json([
            'status_code' => 200,
            'message'=>'Logout complete'
        ]);
    }

}
