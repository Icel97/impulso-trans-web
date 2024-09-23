<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request)
    {
        DB::beginTransaction();

        try {
            $messages = [
                'name.required' => 'El nombre es obligatorio.',
                'lastName.required' => 'El apellido es obligatorio.',
                'email.unique' => 'El correo electrónico ya está registrado.',
                'password.regex' => 'La contraseña debe tener al menos una letra mayúscula, una minúscula y un número.',
                'telefono.required' => 'El número de teléfono es obligatorio.',
                'telefono.min' => 'El número de teléfono debe tener exactamente 10 dígitos.',
            ];
    
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:3|max:35',
                'lastName' => 'required|string|min:3|max:35',
                'identidad_genero' => 'required|in:Hombre trans,Mujer trans,No Binario,Otro,Sin definir',
                'pronombre' => 'required|in:Él,Ella,Elle,Otro,Ninguno,Preguntar antes',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'telefono' => 'required|min:10|max:10',
                'bithday' => 'required|date',
            ], $messages);
    
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
            }
    
            $user = User::create([
                'name' => $request->name,
                'apellidos' => $request->lastName,
                'identidad_genero' => $request->identidad_genero,
                'pronombres' => $request->pronombre,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'password' => Hash::make($request->password),
                'fecha_nacimiento' => $request->bithday,
            ]);
            $user->roles()->sync([2]);
            DB::commit();
    
            return response()->json(['success' => true, 'message' => 'Registro exitoso, ahora puedes iniciar sesión', 'user' => $user], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al registrar el usuario', 'error' => $th->getMessage()], 500);
        }
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
                'apellidos' => $user->apellidos,
                'identidad_genero' => $user->identidad_genero,
                'pronombres' => $user->pronombres,
                'fecha_nacimiento' => $user->fecha_nacimiento,
                'email' => $user->email,
                'telefono' => $user->telefono,
                'id_estado_residencia' => $user->id_estado_residencia,
                'id_municipio_residencia' => $user->id_municipio_residencia,
                'discapacidad' => $user->discapacidad,
                'neurovergencia' => $user->neurovergencia,
                'indigena' => $user->indigena,
                'afrodescendiente' => $user->afrodescendiente,
                'profile_photo_path' => $user->profile_photo_path
            ]
        ], 200);
    }

    public function updateUser(Request $request, $id)
    {
        DB::beginTransaction();
    
        try {
            $messages = [
                'name.required' => 'El nombre es obligatorio.',
                'lastName.required' => 'El apellido es obligatorio.',
                'email.unique' => 'El correo electrónico ya está registrado.',
                'telefono.required' => 'El número de teléfono es obligatorio.',
                'telefono.min' => 'El número de teléfono debe tener exactamente 10 dígitos.',
            ];
    
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:3|max:35',
                'lastName' => 'required|string|min:3|max:35',
                'identidad_genero' => 'required|in:Hombre trans,Mujer trans,No Binario,Otro,Sin definir',
                'pronombre' => 'required|in:Él,Ella,Elle,Otro,Ninguno,Preguntar antes',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($id), 
                ],
                'password' => 'nullable|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'telefono' => 'required|min:10|max:10',
                'bithday' => 'date',
            ], $messages);
    
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
            }
    
            $user = User::findOrFail($id);
    
            $user->update([
                'name' => $request->name,
                'apellidos' => $request->apellidos,
                'identidad_genero' => $request->identidad_genero,
                'pronombres' => $request->pronombres,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'fecha_nacimiento' => $request->bithday,
                'id_estado_residencia' => $request->id_estado_residencia,
                'id_municipio_residencia' => $request->id_municipio_residencia,
                'discapacidad' => $request->discapacidad,
                'neurovergencia' => $request->neurovergencia,
                'indigena' => $request->indigena,
                'afrodescendiente' => $request->afrodescendiente,
                'profile_photo_path' => $request->profile_photo_path
            ]);
        
            DB::commit();
    
            return response()->json(['success' => true, 'message' => 'Usuario actualizado exitosamente', 'user' => $user], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al actualizar el usuario', 'error' => $th->getMessage()], 500);
        }
    }

}
