<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $municipios = Municipio::all();

        return response()->json($municipios);
    }

    /**
     * Display a listing of municipalities by a specific state.
     *
     * @param int $estado_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByEstado($estado_id)
    {
        try {
            $municipios = Municipio::where('estado', $estado_id)->get();
    
            if ($municipios->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay municipios para este estado.'
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $municipios
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los municipios: ' . $e->getMessage()
            ], 500);
        }
    }
    
}
