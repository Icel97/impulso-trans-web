<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //llamart vista enviar roles
        $roles = Role::all();
        $permisos = Permission::all();

        return view('sistema.user.roles', compact('roles', 'permisos'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //guardar roles
        $role = Role::create(['name' => $request->input('nombre')]);
        return redirect()->route('roles.index')->with('success', 'Rol guardado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //actualizar nombre
        $request->validate([
            'nombre' => 'required|string',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('nombre');
        $role->save();

        return redirect()->route('roles.index')->with('success', 'Rol actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * mostrar permisos para asignar a un rol
     */
    public function permisos(Role $role)
    {
        $permisos = Permission::all();
        return view('sistema.user.rolPermiso', compact('role', 'permisos'));
    }

    /**
     * asignar permisos a un rol
     */
    public function asignarPermisos(Request $request, Role $role)
    {
        $role->permissions()->sync($request->permisos);
        return redirect()->route('roles.permisos', $role)->with('success', 'Permisos asignados');
    }


}
