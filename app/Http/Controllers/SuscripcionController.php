<?php

namespace App\Http\Controllers;

use App\enums\PagoStatusEnum;
use App\enums\SuscripcionStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suscripcion;
use Illuminate\Support\Facades\Log;
use App\Lib\Constants;
use App\Models\Pago;
use Illuminate\Support\Facades\DB;

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


            $pagos = Pago::all();

            return view('sistema.suscripcion', compact('suscripciones', 'filter', 'pagos'));
        } catch (\Exception $e) {
            Log::error('Error displaying suscripciones: ' . $e->getMessage());
            $request->session()->flash('error', Constants::GENERICOS['ERROR']);
            return view('sistema.suscripcion', compact('suscripciones', 'filter'));
        }
    }

    public function actualizarSuscripcion(Request $request)
    {

        DB::beginTransaction();
        try {
            $action = $request->query('action');
            $suscripcion = Suscripcion::find($request->id);

            if ($suscripcion == null) {
                return redirect()->route('suscripciones.index')->with('error', Constants::SUSCRIPCIONES_MENSAJES['SUSCRIPCION_NO_ENCONTRADA']);
            }

            $suscripcion->estatus = SuscripcionStatusEnum::Vencida;
            $suscripcion->save();


            $user_id = $suscripcion->usuario_id;
            $pago = Pago::where('usuario_id', $user_id)->first();
            $pago->validado = PagoStatusEnum::Expirado;
            $pago->save();


            DB::commit();
            return redirect()->route('suscripciones.index')->with('success', Constants::SUSCRIPCIONES_MENSAJES['SUSCRIPCION_ACTUALIZADA']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating suscripción: ' . $e->getMessage());
            return redirect()->route('suscripciones.index')->with('error', Constants::GENERICOS['ERROR']);
        }
    }
}
