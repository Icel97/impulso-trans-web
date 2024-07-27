<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\PagoStatusEnum; 
use App\Models\Pago; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Historial_Pago;
use Illuminate\Support\Facades\Storage;

class PagoController extends Controller
{

    public function index(Request $request)
    { 
        $filter = $request->query('filter', 'all');

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
                $pagos = Pago::orderBy('created_at', 'desc')->get();
                break;
        }
        return view('sistema.pago', compact('pagos','filter')); 
    }

    public function getAllPagos()
    {
        // Mostrar todos los pagos y los usuarios asociados 
        $pagos = Pago::with('user')->orderBy('created_at', 'desc')->get();
        return $pagos; 
    }  

    public function createPago(Request $request)
    {
        Log::info('createPago called', ['request' => $request->all()]);

        $validator = Validator::make($request->all(), [
            'comprobante_url' => 'required|file', // Ensure it is a file
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
        #create hash of 5 characters based on user id 
        $fileName = $date . '_' . $userId . "_pago." . $request->file('comprobante_url')->extension(); 
        $filePath = $request->file('comprobante_url')->storeAs('public/pagos/' . date('Y') . '/' . $fileName);

        $file_path_raw =  $date . '_' . $userId . "_pago."; # no extension 
        $pago = Pago::where('usuario_id', $request->user_id)->first();
        
        if ($pago) {
            $estatus = $pago->validado; 
            if ($estatus === PagoStatusEnum::Pendiente) {
                $pago->comprobante_url = $fileName;
                $pago->validado = PagoStatusEnum::Revision; 
                $pago->fecha_envio = now();
                $pago->save();
                return response()->json(['success' => 'Pago updated successfully.'], 200);
            } 
            return response()->json(['error' => 'Pago already exists.'], 400); 
         
        } else 
        {
            return response()->json(['error' => 'There has been an error.'], 400);
        }
    }

    public function show($id)
    {
        $pago = Pago::find($id);
        if (!$pago) {
            return response()->json(['error' => 'Hubo un error'], 404);
        }

    }
    

    public function validarPago(Request $request)
    {
        $action = $request->input('action');
        $id = $request->input('id'); 
        $pago = Pago::find($id);
    
        if (!$pago) {
            return redirect()->route('pagos.index')->with('error', 'Pago no encontrado');
        }
    
        DB::transaction(function () use ($pago, $action) {
            if ($action === 'accepted') {
                // Create a history record before updating the status
                // Historial_Pago::create([
                //     'pago_id' => $pago->id,
                //     'comprobante_url' => $pago->comprobante_url,
                //     'validado' => $pago->validado,
                //     'fecha_envio' => $pago->fecha_envio,
                //     'usuario_id' => $pago->usuario_id,
                //     'created_at' => $pago->created_at,
                //     'updated_at' => $pago->updated_at,
                // ]);
    
                $pago->validado = PagoStatusEnum::Aprobado; 
                $pago->save();
            } elseif ($action === 'rejected') {
                $pago->validado = PagoStatusEnum::Rechazado;
                $pago->save();
            }
        });
    
        if ($action === 'accepted') {
            return redirect()->route('pagos.index')->with('success', 'Pago validado');
        } elseif ($action === 'rejected') {
            return redirect()->route('pagos.index')->with('success', 'Pago rechazado');
        }
    
        return redirect()->route('pagos.index')->with('error', 'Acción no reconocida');
    }
    public function displayPhoto($id)
    {
        try {
            $pago = Pago::findOrFail($id);  // Use findOrFail to throw an exception if not found
            
            $filePath = storage_path('app/public/pagos/' . date('Y') . '/' . $pago->comprobante_url);
            
            if (!Storage::disk('public')->exists('pagos/' . date('Y') . '/' . $pago->comprobante_url)) {
                throw new \Exception('File not found.');
            }
    
            return response()->file($filePath);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error displaying photo: ' . $e->getMessage());
            
            // Handle the error (e.g., return a default image, error message, or redirect)
            return redirect()->back()->with('error', 'Error displaying the photo: ' . $e->getMessage());
        }
    }

}
