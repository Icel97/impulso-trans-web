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
        $pago = Pago::where('comprobante_url', 'like', '%' . $file_path_raw . '%')->first(); 
    
        if ($pago) {
            return response()->json(['error' => 'Pago already exists.'], 400);
        } 

        $pago = new Pago();
        $pago->comprobante_url = $fileName; 
        $pago->validado = PagoStatusEnum::Pendiente; #default pago status. has to be validated by admin 
        $pago->usuario_id = $request->user_id;

        $pago->save();

        return response()->json($pago);
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
    
        if ($action === 'accepted') {
            // Logic for accepting the payment
            $pago->validado = PagoStatusEnum::Aprobado; 
            $pago->save();
            return redirect()->route('pagos.index')->with('success', 'Pago validado');
        } elseif ($action === 'rejected') {
            // Logic for rejecting the payment
            $pago->validado = PagoStatusEnum::Rechazado;
            $pago->save();
            return redirect()->route('pagos.index')->with('success', 'Pago rechazado');
        }
    
        return redirect()->route('pagos.index')->with('error', 'Acción no reconocida');
    }
    
    public function displayPhoto($id)
    {
        $pago = Pago::find($id); 
        return response()->file(storage_path('app/public/pagos/' . date('Y') . '/' . date('m') . '/' . $pago->comprobante_url));
    }

}
