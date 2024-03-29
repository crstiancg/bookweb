<?php

namespace App\Http\Controllers;

use App\Models\Escritor;
use App\Models\libro;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// use File;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:autors.index')->only('index');
        $this->middleware('can:autors.create')->only('create','store');
        $this->middleware('can:autors.edit')->only('edit','destroy');
        $this->middleware('can:autors.destroy')->only('destroy');
    }

    public function index()
    {
        $libros = libro::select('*')->orderBy('id', 'desc')->get(); //::paginate(); para mostrar solo una cantidad de datos
        
        return view('libro.index', compact('libros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $escritor = Escritor::all();
        return view('libro.create', ['escritor' => $escritor]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, libro $libro)
    {
        $request->validate([
            'titulo'=> 'required',
            'slug' => 'required|unique:libros,li_slug',
            'autors'=> 'required',
            'descripcion'=> 'required',
            'drive' => 'required',
            // 'imagen' => 'required|image|max:2048',
        ]);
        // if($request->hasFile('imagen')) {
            $imagenes = $request->file('imagen')->store('public/imagenes');
            $url = Storage::url($imagenes);

            // $libro = libro::create([
            //     'li_titulo' => $request->titulo,
            //     'li_slug' => Str::slug($request->titulo),
            //     'li_enlace' => $request->drive,
            //     'li_image' =>  $url,
            //     'li_descripcion' => $request->descripcion,
            // ]);

            $libro = new libro();


            $libro->li_titulo = $request->titulo;
            $libro->li_slug  = Str::slug($request->titulo);
            $libro->li_enlace = $request->drive;
            $libro->li_image = $url;
            $libro->li_descripcion =$request->descripcion;
        // }
        $libro->save();

        $libro->escritors()->attach($request->input('autors'));

        return redirect()->route('libros.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function show(libro $libro)
    {
        
        return view('libro.show', compact('libro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function edit(libro $libro)
    {
        $escritor = Escritor::all();

        return view('libro.edit', compact('libro', 'escritor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, libro $libro)
    {
        $request->validate([
            'titulo'=> 'required',
            'slug' => 'required|unique:libros,li_slug,'.$libro->id,
            'autors'=> 'required',
            'descripcion'=> 'required',
            'drive' => 'required',
        ]);

        // $libro = libro::find(32);

        if($request->hasFile('imagen')){
            $request->validate([
                'imagen' =>'required|image|max:2048',
            ]);

            // $path = '/storage/imagenes/'.$request->li_image;
            // if(File::exists($path))
            // {
            //     File::delete($path);
            // }
            $url = str_replace('storage','public', $libro->li_image);
            // Storage::delete($url);

            $imagenes = $request->file('imagen')->store('public/imagenes');
            $libro->li_image = Storage::url($imagenes);

            Storage::delete($url);
        }

        //return $request->all();
        

        $libro->li_titulo = $request->titulo;
        $libro->li_slug = Str::slug($request->titulo);
        $libro->li_enlace = $request->drive;
        $libro->li_descripcion = $request->descripcion;

        $libro->escritors()->sync($request->input('autors'));

        $libro->save();
        
        return redirect()->route('libros.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function destroy(libro $libro)
    {
        $url = str_replace('storage','public', $libro->li_image);
        Storage::delete($url);

        $libro->delete();

        return back()->with('eliminar', 'delete');
    }
}
