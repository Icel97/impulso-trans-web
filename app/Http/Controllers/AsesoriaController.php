<?php

namespace App\Http\Controllers;

use App\Enums\AsesoriasMotivoEnum;
use App\Http\Controllers\Controller;
use App\Models\Asesoria;
use Illuminate\Http\Request;
use App\Enums\AsesoriasStatusEnum;
use App\lib\Constants;
use App\Models\Cancelaciones;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AsesoriaController extends Controller
{
    public function index(Request $req)
    {

        $filter = $req->query('filter');

        switch ($filter) {
            case 'pendientes':
                $asesorias = Asesoria::where('status', AsesoriasStatusEnum::PENDIENTE)->with('user')->get();
                break;
            case 'confirmadas':
                $asesorias = Asesoria::where('status', AsesoriasStatusEnum::FINALIZADA)->with('user')->get();
                break;
            default:
                $asesorias = Asesoria::with('user')->get();
                break;
        }

        $asesorias = Asesoria::all();
        $estatus = AsesoriasStatusEnum::toArray();
        return view('sistema.asesorias.index', compact('asesorias', 'filter', 'estatus'));
    }

    public function create(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'id_user' => 'required|exists:users,id',
                'motivo' => 'required|in:' . implode(',', AsesoriasMotivoEnum::toArray()),
                'id_estado_nacimiento' => 'required|exists:estados,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Creating a new Asesoria record
            $asesoria = new Asesoria();
            $asesoria->id_user = $req->id_user;
            $asesoria->motivo = $req->motivo;
            $asesoria->id_estado_nacimiento = $req->id_estado_nacimiento;
            $asesoria->estatus = AsesoriasStatusEnum::PENDIENTE;
            $asesoria->save();

            return response()->json(['message' => 'Asesoria creada correctamente'], 201);
        } catch (\Exception $e) {
            Log::error('Error creating asesoria: ' . $e->getMessage());
            return response()->json(['error' => Constants::GENERICOS['ERROR']], 500);
        }
    }

    public function show(Request $req)
    {
        $id = $req->route('id');
        $asesoria = Asesoria::where('id', $id)->with('user.cancelacion')->first();
        $asesoria->user->makeHidden('id');
        if ($asesoria) {
            return response()->json($asesoria, 200);
        } else {
            return response()->json(['error' => 'Asesoria no encontrada'], 404);
        }
    }

    public function actualizar(Request $req)
    {
        try {

            $validator = Validator::make($req->all(), [
                'estatus' => 'required|in:' . implode(',', AsesoriasStatusEnum::toArray()),
                'notas' => 'nullable|string',
            ]);


            if ($validator->fails()) {
                return response()->json(['errord' => $validator->errors()], 400);
            }


            $id = $req->id;
            $estatus = $req->estatus;
            $notas = $req->notas;
            $asesoria = Asesoria::find($id);
            if ($asesoria) {
                $user_id = $asesoria->id_user;
                // If the asesoria is being cancelled, we need to update the cancelaciones table
                if ($asesoria->estatus != AsesoriasStatusEnum::CANCELADA->value && $estatus == AsesoriasStatusEnum::CANCELADA->value) {
                    $canceladaCount = Cancelaciones::firstOrCreate(['id_user' => $user_id]);
                    $canceladaCount->total += 1;
                    $canceladaCount->save();
                }
                // If the asesoria is being updated to a different status, we need to update the cancelaciones table
                else if ($asesoria->estatus == AsesoriasStatusEnum::CANCELADA->value && $estatus != AsesoriasStatusEnum::CANCELADA->value) {
                    $canceladaCount = Cancelaciones::firstOrCreate(['id_user' => $user_id]);
                    $canceladaCount->total = 0;
                    $canceladaCount->save();
                }

                if ($estatus == AsesoriasStatusEnum::CANCELADA->value || $estatus == AsesoriasStatusEnum::FINALIZADA->value) {
                    $asesoria->fecha_cita = new \DateTime();
                }
                $asesoria->estatus = $estatus;
                $asesoria->notas = $notas;
                $asesoria->save();
                return response()->json(['message' => 'Asesoria actualizada correctamente'], 200);
            } else {
                return redirect()->route('asesorias.index')->with('error', 'Asesoria no encontrada');
            }
        } catch (\Exception $e) {
            Log::error('Error updating asesoria: ' . $e->getMessage());
            return response()->json(['error' => Constants::GENERICOS['ERROR']], 500);
        }
    }
}
