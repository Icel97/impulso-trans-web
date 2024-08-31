<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteText;

class TextoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //obtener ls textos de los programas
        $programas = WebsiteText::where('section', 'programas')->get();

        //llamar la vista y pasar los textos
        return view('sistema.texto', compact('programas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        foreach ($request->texts as $id => $data) {
            $text = WebsiteText::find($id);
            if ($text) {
                $text->title = $data['title'];
                $text->content = $data['content'];
                $text->url_img = $data['url_img'];
                $text->save();
            }
        }
        return redirect()->route('texto.index')->with('success', 'Textos actualizados correctamente');
    }
}
