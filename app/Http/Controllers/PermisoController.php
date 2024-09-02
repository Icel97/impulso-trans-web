<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\lib\Constants;
use Illuminate\Support\Facades\Validator;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //mostar vista de permisos con todos los permisos
        $permisos = Permission::all();
        return view('sistema.user.permisos', compact('permisos'));
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
        $permission = Permission::create(['name' => $request->input('nombre')]);
        return redirect()->route('permisos.index')->with('success', Constants::PERMISOS['PERMISO_CREADO']);
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
        $permission = Permission::find($id);
        return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Trim whitespaces from the input
        $request->merge([
            'nombre' => trim($request->input('nombre')),
        ]);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('permisos.index')->withErrors($validator)->withInput();
        }

        $permission = Permission::find($id);
        $permission->name = $request->input('nombre');
        $permission->save();

        return redirect()->route('permisos.index')->with('success', Constants::PERMISOS['PERMISO_ACTUALIZADO']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permisos.index')->with('success', Constants::PERMISOS['PERMISO_ELIMINADO']);
    }
}
