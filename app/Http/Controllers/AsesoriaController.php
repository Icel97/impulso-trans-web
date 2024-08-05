<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Asesoria;
use Illuminate\Http\Request;

class AsesoriaController extends Controller
{
    public function index()
    {
        $asesorias = Asesoria::all();
        return view('sistema.asesorias.index', compact('asesorias'));
    }
}
