<?php

namespace App\Http\Controllers;

use App\Models\autor;
use App\Models\docente;
use App\Models\informe;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Models\categoria;
class InformeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informe = Informe::All();
        return view('informe.index', compact('informe'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $docente = Docente::all();
        $categoria = Categoria::all();
        $autor = Autor::all();
        //dd($docente);
        return view('informe.create', compact('docente','categoria','autor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required',
            'descripcion'=>'required',
            'codigo'=>'required',
            'enlace'=>'required',
            'centro'=>'required',
            'docente'=>'required',
            'categoria'=>'required',
            'autor'=>'required',
        ]);

        $informe = new informe();

        $informe->info_nombre = $request->nombre;
        $informe->info_descripcion = $request->descripcion;
        $informe->info_codigo = $request->codigo;
        $informe->info_centro = $request->centro;
        $informe->info_enlace = $request->enlace;
        $informe->docente_id = $request->docente;
        $informe->categoria_id = $request->categoria;
        $informe->autor_id = $request->autor;

        $informe->save();

        return redirect()->route('informes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function show(informe $informe)
    {
        return view('informe.index', compact('informe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function edit(informe $informe)
    {
        $docente = Docente::all();
        $categoria = Categoria::all();
        $autor = Autor::all();
        return view('informe.edit', compact('informe','docente', 'categoria', 'autor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, informe $informe)
    {
        $request->validate([
            'nombre'=>'required',
            'descripcion'=>'required',
            'codigo'=>'required',
            'enlace'=>'required',
            'centro'=>'required',
            'docente'=>'required',
            'categoria'=>'required',
            'autor'=>'required',
        ]);

        //$informe = new informe();

        $informe->info_nombre = $request->nombre;
        $informe->info_descripcion = $request->descripcion;
        $informe->info_codigo = $request->codigo;
        $informe->info_centro = $request->centro;
        $informe->info_enlace = $request->enlace;
        $informe->docente_id = $request->docente;
        $informe->categoria_id = $request->categoria;
        $informe->autor_id = $request->autor;

        $informe->save();

        return redirect()->route('informes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function destroy(informe $informe)
    {
        $informe->delete();

        return redirect()->route('informes.index');
    }
}
