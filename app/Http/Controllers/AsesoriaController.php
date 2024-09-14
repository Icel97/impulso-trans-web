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
                $asesorias = Asesoria::where('estatus', AsesoriasStatusEnum::PENDIENTE)->with('user')->get();
                break;
            case 'finalizadas':
                $asesorias = Asesoria::where('estatus', AsesoriasStatusEnum::FINALIZADA)->with('user')->get();
                break;
            case 'canceladas':
                $asesorias = Asesoria::where('estatus', AsesoriasStatusEnum::CANCELADA)->with('user')->get();
                break;
            default:
                $asesorias = Asesoria::with('user')->get();
                break;
        }

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
                'fecha_cita' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Creating a new Asesoria record
            $asesoria = new Asesoria();
            $asesoria->id_user = $req->id_user;
            $asesoria->motivo = $req->motivo;
            $asesoria->id_estado_nacimiento = $req->id_estado_nacimiento;
            $asesoria->fecha_cita = $req->fecha_cita;
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
            // Validate form input
            $validator = Validator::make($req->all(), [
                'estatus' => 'required|in:' . implode(',', AsesoriasStatusEnum::toArray()),
                'notas' => 'nullable|string',
                'id' => 'required|exists:asesorias,id',
            ]);

            if ($validator->fails()) {
                Log::error('form malo: ' . $validator->errors());
                return redirect()->route('asesorias.index')
                    ->withErrors($validator)
                    ->withInput()
                    ->with('modal_open', true)  // Indicate that modal should be open
                    ->with('asesoria_id', $req->id);  // Pass asesoria ID to session
            }

            $asesoria = Asesoria::find($req->id);
            if ($asesoria) {
                $asesoria->estatus = $req->estatus;
                $asesoria->notas = $req->notas;
                $asesoria->save();

                return redirect()->route('asesorias.index')
                    ->with('success', 'Asesoria actualizada correctamente');
            } else {
                return redirect()->route('asesorias.index')
                    ->with('error', 'Asesoria no encontrada');
            }
        } catch (\Exception $e) {
            Log::error('Error updating asesoria: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Hubo un error actualizando la asesoría.');
        }
    }
}
