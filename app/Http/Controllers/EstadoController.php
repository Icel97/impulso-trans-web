<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $estados = Estado::all();

            if ($estados->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron estados.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $estados
            ], 200);

        } catch (\Exception $e) {
            // Manejar cualquier excepción
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los estados: ' . $e->getMessage()
            ], 500);
        }
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
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $estado = Estado::create($request->all());

        return response()->json($estado, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Estado $estado)
    {
        return response()->json($estado);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estado $estado)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $estado->update($request->all());

        return response()->json($estado);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estado $estado)
    {
        $estado->delete();

        return response()->json(null, 204);
    }
}
