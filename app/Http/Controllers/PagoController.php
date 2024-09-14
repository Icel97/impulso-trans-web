<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\PagoStatusEnum;
use App\Models\Pago;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Lib\Constants;
use Illuminate\Contracts\Session\Session;

class PagoController extends Controller
{

    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $pagos = [];
        try {
            switch ($filter) {
                case 'approved':
                    $pagos = Pago::where('validado', 'Aprobado')->orderBy('created_at', 'desc')->get();
                    break;
                case 'rejected':
                    $pagos = Pago::where('validado', 'Rechazado')->orderBy('created_at', 'desc')->get();
                    break;
                case 'pending':
                    $pagos = Pago::where('validado', "Pendiente")->orderBy('created_at', 'desc')->get();
                    break;
                case 'review':
                    $pagos = Pago::where('validado', 'Revision')->orderBy('created_at', 'desc')->get();
                    break;
                default:
                    $pagos = Pago::whereNot('validado', 'Pendiente')->orderBy('created_at', 'desc')->get();
                    break;
            }

            $request->session()->forget('error');
            return view('sistema.pago', compact('pagos', 'filter'));
        } catch (\Exception $e) {
            Log::error('Error displaying pagos: ' . $e->getMessage());
            $request->session()->flash('error', Constants::PAGO_MENSAJES['MOSTRAR_TODOS']);
            return view('sistema.pago', compact('pagos', 'filter'));
        }
    }

    public function createPago(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'comprobante_url' => 'required|file',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            if (!$request->hasFile('comprobante_url')) {
                return response()->json(['error' => 'File not provided.'], 400);
            }

            $date = date('m-d-Y');

            $user = User::find($request->user_id);
            $userId = $user->id;
            $fileName = $date . '_' . $userId . "_pago." . $request->file('comprobante_url')->extension();

            $pago = Pago::where('usuario_id', $request->user_id)->first();

            if ($pago) {
                $estatus = $pago->validado;
                if ($estatus === PagoStatusEnum::Pendiente || $estatus === PagoStatusEnum::Expirado || $estatus === PagoStatusEnum::Rechazado) {
                    $pago->comprobante_url = $fileName;
                    $pago->validado = PagoStatusEnum::Revision;
                    $pago->fecha_envio = now();
                    $pago->save();
                    $request->file('comprobante_url')->storeAs('public/pagos/' . date('Y'), $fileName);
                    return response()->json(['success' => Constants::PAGO_MENSAJES["PAGO_ENVIADO"]], 200);
                }
                return response()->json(['error' => Constants::PAGO_MENSAJES["PAGO_YA_ENVIADO"]], 400);
            } else {
                return response()->json(['error' => Constants::GENERICOS["ERROR"]], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error creating pago: ' . $e->getMessage());
            return response()->json(['error' => Constants::GENERICOS["ERROR"]], 500);
        }
    }

    public function show($id)
    {
        try {
            $pago = Pago::find($id);
            if (!$pago) {
                return response()->json(['error' => Constants::PAGO_MENSAJES["PAGO_NO_ENCONTRADO"]], 404);
            }
            return response()->json($pago);
        } catch (\Exception $e) {
            Log::error('Error showing pago: ' . $e->getMessage());
            return response()->json(['error' => Constants::GENERICOS["ERROR"]], 500);
        }
    }

    public function validarPago(Request $request)
    {
        try {
            $action = $request->input('action');
            $id = $request->input('id');
            $pago = Pago::find($id);

            if (!$pago) {
                return redirect()->route('pagos.index')->with('error', Constants::PAGO_MENSAJES["PAGO_NO_ENCONTRADO"]);
            }

            DB::transaction(function () use ($pago, $action) {
                if ($action === 'accepted') {
                    $pago->validado = PagoStatusEnum::Aprobado;
                    $pago->save();
                } elseif ($action === 'rejected') {
                    $pago->validado = PagoStatusEnum::Rechazado;
                    $pago->save();
                }
            });

            if ($action === 'accepted') {
                return redirect()->route('pagos.index')->with('success', Constants::PAGO_MENSAJES["PAGO_VALIDADO"]);
            } elseif ($action === 'rejected') {
                return redirect()->route('pagos.index')->with('success', Constants::PAGO_MENSAJES["PAGO_RECHAZADO"]);
            }

            return redirect()->route('pagos.index')->with('error', Constants::GENERICOS["ACCION_NO_RECONOCIDA"]);
        } catch (\Exception $e) {
            Log::error('Error validating pago: ' . $e->getMessage());
            return redirect()->route('pagos.index')->with('error', Constants::GENERICOS["ERROR"]);
        }
    }

    public function displayPhoto(Request $req, $id)
    {
        try {
            $pago = Pago::findOrFail($id);

            $filePath = storage_path('app/public/pagos/' . date('Y') . '/' . $pago->comprobante_url);

            if (!Storage::disk('public')->exists('pagos/' . date('Y') . '/' . $pago->comprobante_url)) {
                $req->session()->flash('error', Constants::GENERICOS["PAGO_NO_ENCONTRADO"]);
                $pagos = Pago::whereNot('validado', 'Pendiente')->orderBy('created_at', 'desc')->get();
                return view("sistema.pago", ['error' => Constants::GENERICOS["PAGO_NO_ENCONTRADO"], 'pagos' => $pagos, 'filter' => 'all']);
            }

            return response()->file($filePath);
        } catch (\Exception $e) {
            Log::error('Error displaying photo: ' . $e->getMessage());
            $pagos = Pago::whereNot('validado', 'Pendiente')->orderBy('created_at', 'desc')->get();
            $req->session()->flash('error', Constants::GENERICOS["ERROR"]);
            return view("sistema.pago", ['error' => Constants::GENERICOS["ERROR"], 'pagos' => $pagos, 'filter' => 'all']);
        }
    }
}
