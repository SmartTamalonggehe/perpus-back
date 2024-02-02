<?php

namespace App\Http\Controllers\AUTH;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => 'error', 'pesan' => 'Login gagal email atau password salah'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // return $user;
        // menambah token pada user tokens
        $user = Auth::user();
        UserToken::create([
            'user_id' => $user->id,
            'token' => $token,
        ]);

        return response()->json([
            'id' => $user->id,
            'token' => $token,
            'email' => $user->email,
            'role' => $user->role,
            'status' => 'success',
        ], 200);
    }

    public function cekToken(Request $request)
    {
        $token = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $token);

        $user = UserToken::with('user')->where('token', $token)->first();
        if ($user) {
            return response()->json(['status' => 'success', 'data' => $user], 200);
        } else {
            return response()->json(['status' => 'error', 'pesan' => 'Token tidak ditemukan'], 401);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $token);

        $user = UserToken::where('token', $token)->first();
        if ($user) {
            // delete userToken
            $user->delete($user->id);
        } else {
            return response()->json(['status' => 'error', 'pesan' => 'Token tidak ditemukan'], 401);
        }

        auth()->logout();

        return response()->json(['status' => 'success', 'message' => 'Successfully logged out']);
    }
}
