<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:35',
            'lastName' => 'required|string|min:3|max:35',
            'identidad_genero' => 'required|in:Hombre trans,Mujer trans,No Binario,Otro,Sin definir',
            'pronombre' => 'required|in:Él,Ella,Elle,Otro,Ninguno,Preguntar antes',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|confirmed',
            'bithday' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'apellidos' => $request->lastName,
            'identidad_genero' => $request->identidad_genero,
            'pronombres' => $request->pronombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'fecha_nacimiento' => $request->bithday,
            // 'rol_id' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Datos de acceso incorectos'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'lastName' => $user->apellidos,
                'identidad_genero' => $user->identidad_genero,
                'pronombres' => $user->pronombres,
                'email' => $user->email,
                'birthday' => $user->fecha_nacimiento,
            ]
        ], 200);
    }
}
