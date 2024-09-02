<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointOfInterest;

class MapaController extends Controller
{
    public function index()
    {
        $points = PointOfInterest::all();
        return view('sistema.mapa', compact('points'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'estado' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'documentos' => 'required|string',
        ]);
        PointOfInterest::create($request->all());
        return redirect()->route('puntos.index')->with('success', 'Punto guardado');
    }
    public function edit(string $id)
    {
        $point = PointOfInterest::find($id);
        return response()->json($point);
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'estado' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'documentos' => 'required|string',
        ]);
        $point = PointOfInterest::find($id);
        $point->update($request->all());
        return redirect()->route('puntos.index')->with('success', 'Punto actualizado');
    }
    public function destroy(string $id)
    {
        $point = PointOfInterest::find($id);
        $point->delete();
        return redirect()->route('puntos.index')->with('success', 'Punto eliminado');
    }
}
