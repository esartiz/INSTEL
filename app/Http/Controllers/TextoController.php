<?php

namespace App\Http\Controllers;

use App\Models\Texto;
use App\Models\Programa;
use Illuminate\Http\Request;

use Image, Storage;

/**
 * Class TextoController
 * @package App\Http\Controllers
 */
class TextoController extends Controller
{
    public function makeSeo($text, $limit=75)
    {
      // replace non letter or digits by -
      $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

      // trim
      $text = trim($text, '-');

      // lowercase
      $text = strtolower($text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      if(strlen($text) > 70) {
        $text = substr($text, 0, 70);
      } 

      if (empty($text))
      {
        //return 'n-a';
        return time();
      }

      return $text;
    }

    public function index()
    {
        $textos = Texto::paginate();

        return view('texto.index', compact('textos'))
            ->with('i', (request()->input('page', 1) - 1) * $textos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $texto = new Texto();
        return view('texto.create', compact('texto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Texto::$rules);

        $texto = Texto::create($request->all());

        return redirect()->route('textos.index')
            ->with('success', 'Texto created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $texto = Texto::find($id);

        return view('texto.show', compact('texto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $texto = Texto::find($id);

        return view('texto.edit', compact('texto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Texto $texto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Texto $texto)
    {
        request()->validate(Texto::$rules);

        $texto->update($request->all());

        return redirect()->route('textos.index')
            ->with('success', 'Texto updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function textodelete($id)
    {
        $texto = Texto::find($id)->delete();

        return redirect()->back()->with('success', 'Texto eliminado');
    }

    public function verProgramas(){
        $oferta = Programa::orderBy('tipo','DESC')->orderBy('nombre')->get();
        $textos = Texto::all();
        return view('texto.programas', compact('oferta','textos'));
    }

    public function verTexto($id,$slug){
        $textos = Texto::where('categoria',$id)->orderBy('id','DESC')->get();
        return view('texto.texto', compact('textos','slug'));
    }

    public function textoedicion(Request $request){

        if($request->id == "0"){
            $idUnicoFoto = md5(uniqid(rand(), true));
            Texto::create([
                'nombre' => $request->nombre,
                'categoria' => $request->categoria,
                'url' => $this->makeSeo($request->nombre).'_'.date('His'),
                'pretexto' => $request->pretexto,
                'texto' => $request->texto,
                'imagen' => ($request->fotoTxt ? $idUnicoFoto : NULL)
            ]);
            $rta = 'Se incluyó '.$request->nombre.' con éxito';
        } else {
            $chag = Texto::find($request->id);
            $idUnicoFoto = ($chag->imagen == NULL ? md5(uniqid(rand(), true)) : $chag->imagen);
            $chag->update([
                'nombre' => $request->nombre,
                'pretexto' => $request->pretexto,
                'texto' => $request->texto,
                'imagen' => $idUnicoFoto
            ]);
            $rta = 'El texto '.$request->nombre.' se modificó con éxito';
        }

        if($request->fotoTxt != null){
            $laFoto = Image::make($request->file('fotoTxt'))->orientate();
            $laFoto->resize(null, 500, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img = $laFoto->save(storage_path('app/public/uploads/noticias/'.$idUnicoFoto.'.jpg'), 72);
        }

        return redirect()->back()->with('success', $rta);
    }

    public function savePrograma(Request $request){
        $data = $request->except(['_token','_method','id']);
        Programa::find($request->id)->update($data);
        return redirect()->back()->with('success', 'Se ha modificado la información');
    }
}
