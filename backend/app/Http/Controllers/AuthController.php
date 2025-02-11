<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'password' => 'required|string|max:32',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password,)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao registrar usuário',
                'message' => $e->getMessage(),
            ], 500);
        }

        return $this->login($request);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:150',
            'password' => 'required|string|max:32',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credenciais inválidas'], 403);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso.'
        ], 200);
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado de todos os dispositivos.'
        ], 200);
    }
}
