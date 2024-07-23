<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suscripcion;

class SuscripcionController extends Controller
{
    
    public function index(Request $request)
    {

        $id = $request->query('id', null);
        
        if ($id) {
            $suscripciones = Suscripcion::find($id);

            // $is_active = $suscripciones->estatus == 'Inactiva'
            // if ($is_active) {
            // } else {
            //     $filter  = "inactive"; 
            // } 

            $filter  = "custom"; 
            
            if (!$suscripciones) {
                return redirect()->route('suscripciones.index')->with('error', 'Suscripción no encontrada');
            }
            #wrap in an array
            $suscripciones = [$suscripciones]; 
            return view('sistema.suscripcion', compact('suscripciones', 'filter'));
        }
        
        $filter = $request->query('filter', 'all'); 
        switch ($filter) {
            case 'active':
                $suscripciones = Suscripcion::where('estatus', 'Activa')->orderBy('created_at', 'desc')->get(); 
                break;
            case 'inactive':
                $suscripciones = Suscripcion::where('estatus', 'Inactiva')->orderBy('created_at', 'desc')->get();
                break;
            case 'expired':
                $suscripciones = Suscripcion::where('estatus', 'Vencida')->orderBy('created_at', 'desc')->get();
                break;
            default:
                $suscripciones = Suscripcion::orderBy('created_at', 'desc')->get();
                break;
        } 

        return view('sistema.suscripcion', compact('suscripciones','filter')); 
    }

    public function actualizarSuscripcion(Request $request)
    {
        $suscripcion = Suscripcion::find($request->id); 
        if ($suscripcion == null) {
            return response()->json(['error' => 'Suscripcion not found.'], 404);
        }
        $suscripcion->estatus = $request->estatus;
        $suscripcion->save();
        return response()->json(['message' => 'Suscripcion updated successfully.'], 200);
    }
}
