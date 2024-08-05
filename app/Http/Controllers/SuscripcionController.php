<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suscripcion;
use Illuminate\Support\Facades\Log;
use App\Lib\Constants;

class SuscripcionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $id = $request->query('id', null);

            if ($id) {
                $suscripciones = Suscripcion::find($id);
                $filter  = "custom";

                if (!$suscripciones) {
                    $request->session()->flash('error', Constants::SUSCRIPCIONES_MENSAJES['SUSCRIPCION_NO_ENCONTRADA']);
                    return view('sistema.suscripcion', compact('suscripciones', 'filter'));
                }
                $suscripciones = [$suscripciones];
                return view('sistema.suscripcion', compact('suscripciones', 'filter'));
            }

            $filter = $request->query('filter', 'all');
            switch ($filter) {
                case 'active':
                    $suscripciones = Suscripcion::where('estatus', 'Activa')->orderBy('fecha_fin', 'desc')->get();
                    break;
                case 'inactive':
                    $suscripciones = Suscripcion::where('estatus', 'Inactiva')->orderBy('fecha_fin', 'desc')->get();
                    break;
                case 'expired':
                    $suscripciones = Suscripcion::where('estatus', 'Vencida')->orderBy('fecha_fin', 'desc')->get();
                    break;
                default:
                    $suscripciones = Suscripcion::whereNot('estatus', 'inactiva')->orderBy('id', 'asc')->get();
                    break;
            }
            if (sizeof($suscripciones) === 0) {
                $request->session()->flash('info', Constants::SUSCRIPCIONES_MENSAJES['NO_HAY_SUSCRIPCIONES']);
                return view('sistema.suscripcion', compact('suscripciones', 'filter'));
            }


            return view('sistema.suscripcion', compact('suscripciones', 'filter'));
        } catch (\Exception $e) {
            Log::error('Error displaying suscripciones: ' . $e->getMessage());
            $request->session()->flash('error', Constants::GENERICOS['ERROR']);
            return view('sistema.suscripcion', compact('suscripciones', 'filter'));
        }
    }

    public function actualizarSuscripcion(Request $request)
    {
        try {
            $suscripcion = Suscripcion::find($request->id);

            if ($suscripcion == null) {
                return response()->json(['error' => Constants::SUSCRIPCIONES_MENSAJES['SUSCRIPCION_NO_ENCONTRADA']], 404);
            }

            $suscripcion->estatus = $request->estatus;
            $suscripcion->save();
            return response()->json(['message' => Constants::GENERICOS['ACTUALIZADO']], 200);
        } catch (\Exception $e) {
            Log::error('Error updating suscripción: ' . $e->getMessage());
            return response()->json(['error' => Constants::GENERICOS['ERROR']], 500);
        }
    }
}
