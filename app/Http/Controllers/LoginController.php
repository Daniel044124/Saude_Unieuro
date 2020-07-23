<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function authenticate(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json(Auth::user(), 200);
            }
            return response()->json([
                'error' => 'Dados inválidos.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Houve um erro em sua solicitação.'
            ], 400);
        }
    }

    public function logout() {
        Auth::logout();
        return response()->json(null, 204);
    }
}
