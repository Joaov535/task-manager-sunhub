<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

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
        } catch (QueryException $e) {
             if (str_starts_with($e->getMessage(), 'SQLSTATE[23505]')) {
                return response()->json([
                    'error' => 'Erro ao cadastrar usuário',
                    'message' => 'O e-mail fornecido já está em uso.',
                ], 400);
            }

            return response()->json([
                'error' => 'Erro ao registrar usuário',
                'message' => 'Tivemos um problema ao cadastrar o usuário. Tente novamente em alguns instantes',
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
            return response()->json([
                'error' => 'Credenciais inválidas',
                 'message' => 'Verifique o email e senha informados.'
                ], 403);
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
