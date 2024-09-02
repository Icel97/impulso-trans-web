<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\lib\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AsignarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        try {
            $usuarios = User::orderBy('id', 'ASC')->get();

            if (sizeof($usuarios) === 0) {
                $req->session()->flash('error', Constants::USUARIOS_MENSAJES['NO_HAY_USUARIOS']);
                return view('sistema.user.usuarios', compact('usuarios'));
            }

            return view('sistema.user.usuarios', compact('usuarios'));
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return redirect()->back()->with('error', Constants::USUARIOS_MENSAJES['ERROR_MOSTRAR_USUARIOS']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Implement this method if needed
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                log::error('Error creating user: ' . $validator->errors());
                DB::rollBack();
                return redirect()->route('usuarios.index')->withErrors($validator)->withInput();
            }

            // Create a new user
            $usuario = new User();
            $usuario->name = $request->nombre;
            $usuario->email = $request->email;
            $usuario->password = bcrypt($request->password);
            $usuario->save();

            // Assign the role 'user' by default
            $usuario->roles()->sync(2); // Assuming 2 is the role ID for 'user'

            // Commit the transaction
            DB::commit();

            return redirect()->route('usuarios.index')->with('success', Constants::USUARIOS_MENSAJES['USUARIO_CREADO']);
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', Constants::GENERICOS['ERROR']);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $usuario = User::findOrFail($id);
            return view('sistema.user.show', compact('usuario'));
        } catch (\Exception $e) {
            Log::error('Error fetching user: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', Constants::GENERICOS['ERROR']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = Role::all();
            return view('sistema.user.userRol', compact('user', 'roles'));
        } catch (\Exception $e) {
            Log::error('Error fetching user for edit: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', Constants::GENERICOS['ERROR']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'roles' => 'required|array',
            ]);

            // Update user roles
            $user = User::findOrFail($id);
            $user->roles()->sync($request->roles);

            return redirect()->route('usuarios.edit', $user)->with('success', Constants::USUARIOS_MENSAJES['ROLES_ASIGNADOS']);
        } catch (\Exception $e) {
            Log::error('Error updating user roles: ' . $e->getMessage());
            return redirect()->route('usuarios.edit', $id)->with('error', Constants::USUARIOS_MENSAJES['ERROR_ACTUALIZAR_ROLES']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('usuarios.index')->with('success', Constants::GENERICOS['ELIMINADO']);
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', Constants::GENERICOS['ERROR']);
        }
    }
}
