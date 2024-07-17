<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AsignarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // mostrar usuarios en la vista
        $usuarios = User::all();
        return view('sistema.user.usuarios', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $user = User::find($id);
        $roles = Role::all();
        return view('sistema.user.userRol', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //actualizar roles
        $user = User::find($id);
        $user->roles()->sync($request->roles);
        return redirect()->route('usuarios.edit', $user)->with('success', 'Roles asignados');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
