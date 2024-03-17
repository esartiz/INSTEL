<?php

namespace App\Http\Controllers;

use App\Models\MatriculasCaja;
use App\Models\Prueba;
use DB;
use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\Recurso;
use App\Models\Tarea;
use App\Models\Matricula;
use App\Models\Entrega;
use App\Models\Mensaje;
use App\Models\Sala;
use App\Models\Anuncio;
use App\Models\Repositorio;
use App\Models\Siet;
use App\Models\Graduando;
use App\Models\FConcepto;
use App\Models\FBill;
use App\Models\Asistencia;
use App\Models\User_doc;
use App\Models\Encuesta;
use App\Models\DataSesion;

use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Luecano\NumeroALetras\NumeroALetras;
use Carbon\Carbon;

use Auth, Session, Image, Storage;

class Estudiante extends Controller
{
    public function __construct()
    {
        $this->middleware('Estudiante');
    }
    
    public function index()
    {
        //Primero revisa el estado financiero si está o no habilitado por pago. Está en orden DESC para que tome el pagaré de los Seminarios
        $deuda = Auth::user()->misBoxMatriculas()->where('estado', 'ACTIVO')->orderBy('id','DESC')->first()->getDeuda();
        $cuotasV = 0;
        if($deuda){
            $dt = "";
            $planPago = explode('|', $deuda->plan);
            for ($i=0; $i < count($planPago) - 1; $i++) {
                if(Carbon::parse($planPago[$i]) < date('Y-m-d')){
                    if(!$deuda->pagosSobreDeuda()->where('cuota', ($i + 1))->first()){
                        $cuotasV++;
                        $dt = "No hemos recibido tu pago de la <b>cuota ".($i + 1)."</b> antes del <span class='forFecha' dt-fmt='0' dt-f='".$planPago[$i]."'></span>. Realiza el pago y evita la suspensión de tu acceso a INSTEL Virtual.";
                    }
                }
            }
            if($dt !== ""){
                $mensajeD = ($cuotasV > 1 ? 'El acceso a INSTEL Virtual está restringido. No hemos recibido el pago de tus cuotas pendientes, por favor contáctanos.' : $dt);
                Session::put('msjFinanciero', [$mensajeD, $cuotasV]);
                if($cuotasV > 1){
                    return redirect()->route('financiero');
                }
            }
        }

        //Reconoce si es un estudiante matriculado o sea con código. Si no, queda como inscrito
        if(Auth::user()->cod !== NULL){
            $matricula = MatriculasCaja::where('user', Auth::user()->id)->where('estado', 'ACTIVO')->get();
            $anuncio = Anuncio::where('modulo',NULL)->get();








            /*
            $matricula = MatriculasCaja::where('user', Auth::user()->id)->where('estado', 'ACTIVO')->orderBy('id', 'DESC')->first();
            //Si es un seminario o si es de otro programa
            if($matricula->getPrograma()->tipo == "Seminario-Taller"){
                $misModulos = [];
                $anuncio = [];
                $infoGeneral = [];
            } else {
                $misModulos = $matricula->materias()
                    ->sortBy(function($materia) {
                    return $materia->modulos_s()->first()->fecha1;
                });
                $infoGeneral = Repositorio::where('modulo', NULL)->where('nombre', 'like', '%|'.Auth::user()->misBoxMatriculas()->where('estado','ACTIVO')->first()->prg.'|'.Auth::user()->misBoxMatriculas()->where('estado','ACTIVO')->first()->nivel.'%')->where('grupo',Auth::user()->misBoxMatriculas()->where('estado','ACTIVO')->first()->periodo)->get();
                $anuncio = Anuncio::where('modulo',NULL)->get();
            }






            
            //$matricula = MatriculasCaja::where('user', Auth::user()->id)->where('prg', '1')->where('estado', 'ACTIVO');

            $matricula = MatriculasCaja::where('user', Auth::user()->id)->where('estado', 'ACTIVO')
                        ->whereHas('getProgramaMtr', function ($query) {
                            $query->where('tipo', '!=', 'Seminario-Taller');
                        })
                        ->get();
            
            if($matricula->count() > 0){
                $misModulos = $matricula->first()->materias()
                    ->sortBy(function($materia) {
                    return $materia->modulos_s()->first()->fecha1;
                });
                $infoGeneral = Repositorio::where('modulo', NULL)->where('nombre', 'like', '%|'.Auth::user()->misBoxMatriculas()->where('estado','ACTIVO')->first()->prg.'|'.Auth::user()->misBoxMatriculas()->where('estado','ACTIVO')->first()->nivel.'%')->where('grupo',Auth::user()->misBoxMatriculas()->where('estado','ACTIVO')->first()->periodo)->get();
                $anuncio = Anuncio::where('modulo',NULL)->get();
            } else {
                $misModulos = new Modulo();
                $anuncio = new Anuncio();
                $infoGeneral = new Repositorio();
            }
            */
            
            //INTRO LOGO CHECK
            if(Session::get('intro')){
                return view('estudiante.index',compact('matricula','anuncio'));
            } else {
                Session::put('intro', 1);
                return view('intro');
            }
        } else {
            return view('estudiante.inscrito');
        }
    }
    

    public function verTarea($id){
        $myGroup = Auth::user()->misBoxMatriculas()->where('prg', Session::get('idModulo')->programa)->where('estado','ACTIVO')->first()->periodo;
        $myGroupModule = substr($myGroup, -1);
        $tiempos = \AppHelper::timeModule(Session::get('idModulo'), $myGroup);
        $tarea = Tarea::find($id);


        if($tarea->limite == NULL){
            $idSemanaT = explode('|', $tarea->fechas)[$myGroupModule];
            $tDesde = ($tarea->tipo == 0 ? $tiempos[$idSemanaT][0] : $tiempos[$idSemanaT][2]);
            $tLimite = ($tiempos[$idSemanaT][3]);
        } else {
            $tDesde = $tarea->desde;
            $tLimite = $tarea->limite;
        }
        
        $ft1 = date('Y-m-d', strtotime($tDesde));
        $ft2 = date('Y-m-d', strtotime($tLimite));
        $ft0 = date('Y-m-d', strtotime(now()));
            
        if (($ft0 >= $ft1) && ($ft0 <= $ft2)){
            if(Session::get('idModulo')->id == $tarea->modulo){
                Session::put('idTarea',$tarea);
                return view('estudiante.tarea',compact('tarea','tDesde','tLimite'));
            }
        }else{
            //return $tDesde.' al '.$tLimite;
            return redirect()->route('estudiante.md', $tarea->modulo)->with('success', 'La entrega no se puede realizar, estás por fuera del plazo.');
        }
    }


    public function verTareaSeminario($id){
        Session::put('idTarea',$id);
        $tarea = new tarea();
        $infoSem = Auth::user()->misSesiones()->where('seminarID',$id)->first();

        $f0 = date('Y-m-d');
        $f1 = $infoSem->fecha;
        $f2 = date('Y-m-d',strtotime("+6 day", strtotime($f1)));

        if (($f0 >= $f1) && ($f0 <= $f2)){
            $tDesde = $f1.' 00:00:00';
            $tLimite = $f2.' 23:59:59';
            $tarea->tipo_rta = $infoSem->dataSeminar()->tareaTipo;
            $tarea->modulo = "0";
            $tarea->enunciado = $infoSem->dataSeminar()->tarea;
            return view('estudiante.tarea',compact('tarea','tDesde','tLimite'));
        }else{
            return 'La actividad estuvo disponible desde el '.$f1.' hasta el '.$f2;
        }

    }

    public function entregar(Request $request){
        //return response()->json($request);
        $idUnico = md5(uniqid(rand(), true));
        $misPDF = '';
        $misLinks = '';
        //Toma los links enviados
        if($request->totalLink){
            for ($i=1; $i <= $request->totalLink; $i++) { 
                $misLinks .= $request['link_'.$i].'||';
            }
        }
        //Carga los PDF cargados
        if($request->totalPDF){
            for ($i=1; $i <=$request->totalPDF; $i++) { 
                if($request->hasFile('pdf_'.$i)){
                    $request->file('pdf_'.$i)->storeAs('userfiles/entregas/pdf/', $idUnico.'_'.$i.'.pdf');
                    $misPDF .= $idUnico.'_'.$i.'.pdf||';
                }
            }
        }
        //Guarda la info en la BD
        $entrega = Entrega::create([
            'de'        => Auth::user()->id,
            'modulo'    => Session::get('idTarea')->modulo,
            'tarea'     => Session::get('idTarea')->id,
            'retro'     => '',
            'status'    => 1,
            'idUnico'   => $idUnico,
            'respuesta' => $misPDF,
            'link'      => $misLinks
        ]);
        return redirect()->route('estudiante.md',Session::get('idTarea')->modulo)
                ->with('success', 'Se realizó la entrega satisfactoriamente');
    }

    public function entregarSeminario(Request $request){
        //return response()->json($request);
        $idUnico = md5(uniqid(rand(), true));
        $infoSEND = '';
        //Toma los links enviados
        if($request->totalLink){
            for ($i=1; $i <= $request->totalLink; $i++) { 
                $infoSEND .= $request['link_'.$i].'||';
            }
        }
        //Carga los PDF cargados
        if($request->totalPDF){
            for ($i=1; $i <=$request->totalPDF; $i++) { 
                if($request->hasFile('pdf_'.$i)){
                    $request->file('pdf_'.$i)->storeAs('userfiles/entregas/pdf/', $idUnico.'_'.$i.'.pdf');
                    $infoSEND .= $idUnico.'_'.$i.'.pdf||';
                }
            }
        }
        //Guarda la info en la BD
        DataSesion::where('user',Auth::user()->id)->where('seminarID',Session::get('idTarea'))->update([
            'envio'     => $infoSEND
        ]);
        return redirect('/')->with('success', 'Se realizó la entrega satisfactoriamente');
    }

    public function enviarMSJ(Request $request){
        $hoy = date('Y-m-d H:i:s');
        if(isset(Session::get('idModulo')->docente)){
            $msjPara = Session::get('idModulo')->docente;
        } else {
            $msjPara = $request->msjIDto;
        }
        $entrega = Mensaje::create(array_merge($request->all(), ['start_date' => $hoy, 'end_date' => date("Y-m-d H:i:s",strtotime($hoy."+ 6 months")), 'de' => Auth::user()->id, 'para' => $msjPara, 'status' => 0]));


        return back()->with('success', 'El mensaje se ha enviado.');
    }

    public function verMsj($id){
        $elMensaje = Mensaje::find($id);
        if($elMensaje->de == Auth::user()->id){
            Session::put('idMensaje',$id);
            return response()->json($elMensaje);
        } else {
            return 0;
        }
    }

    public function estudiantedocs(Request $request){
        //Foto de Perfil
        if($request->fotoPerfil != null){
            $laFoto = Image::make($request->file('fotoPerfil'))->orientate();
            $height = $laFoto->height();
            $width = $laFoto->width();
            if($width < $height){
                $laFoto->resize(null, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img = $laFoto->save(storage_path('app/userfiles/profiles/0/'.Auth::user()->cod.'.jpg'), 72);
                //Miniatura
                $laFotoMini = $laFoto->resize(null, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img = $laFotoMini->save(storage_path('app/userfiles/profiles/0/t/'.Auth::user()->cod.'.jpg'), 72);
            }
        }
        //Documentos Matricula
        for ($i=1; $i <6 ; $i++) {
            if($request->hasFile('file'.$i)){
                $nombreDoc = md5(uniqid(rand(), true)).'.pdf';
                $request->file('file'.$i)->storeAs('userfiles/profiles/', $nombreDoc);
                User_doc::create(['user' => (Auth::user()->rol == "Administrador" ? $request->persona : Auth::user()->id), 'file' => $nombreDoc, 'descr' => $request['fileName'.$i] ]);
            }
        }
        //Documentos firmados
        if($request->theFile != null){
            $request->file('fileFirmado')->storeAs('userfiles/profiles/', $request->theFile);
            $dt = User_doc::where('file', $request->theFile)->first();
            $dt->update(['descr' => $dt->descr.' Firmado']);
        }
        return back()->with('success', 'Documentos cargados satisfactoriamente.');
    }

    public function doc_del(Request $request){
        $elDoc = User_doc::find($request->file);
        Storage::delete('userfiles/profiles/'.$elDoc->file);
        $elDoc->delete();
        return redirect()->back()->with('success', 'Archivo eliminado');
    }

    public function profilepicdel(Request $request){
        Storage::delete('userfiles/profiles/0/'.$request->file.'.jpg');
        Storage::delete('userfiles/profiles/0/t/'.$request->file.'.jpg');
        return redirect()->back()->with('success', 'Foto de Perfil rechazada');
    }

    public function siet(){
        $datasiet = Siet::where('user',Auth::user()->id)->first();
        return view('siet.index',compact('datasiet'));
    }

    public function sietAdd(Request $request){
        $data = $request->except(['_token','_method']);
        Siet::where('user',Auth::user()->id)->update($data);
        return back()->with('success', 'Información Actualizada satisfactoriamente');
    }    

    public function certificado($id)
    {
        $elGraduando = User_doc::where('file',$id)->first();
        if(Auth::user()->id == $elGraduando->user || Auth::user()->rol == "Administrador"){
            //return response()->json($graduandoEdit);
            $elGraduando->linkval = 'https://certificado.instel.edu.co/validador/'.$elGraduando->file;
            $qrcode = base64_encode(QrCode::format('png')->size(100)->errorCorrection('H')->generate($elGraduando->linkval));
            //Settings según tipo de Documento
            if(strpos($elGraduando->descr, 'pruebacomp') !== false){
                $tipoCertificado = 'pruebas';
                $pageOrientation = 'portait';
            } elseif (strpos($elGraduando->descr, 'INFINRSAC') !== false){
                $tipoCertificado = 'informe-academico';
                $pageOrientation = 'portait';
            } elseif (strpos($elGraduando->descr, 'Registro Académico') !== false){
                $tipoCertificado = 'registro-academico';
                $pageOrientation = 'portait';
            } elseif (strpos($elGraduando->descr, 'europacampus') !== false){
                $tipoCertificado = 'certificado-int';
                $pageOrientation = 'letter';
            } else {
                $tipoCertificado = 'certificado';
                $pageOrientation = 'landscape';
            }
            $pdf = Pdf::loadView('estudiante.'.$tipoCertificado, compact('qrcode', 'elGraduando'));
            $pdf->setPaper('letter', $pageOrientation);
            //return $pdf->stream();
            return $pdf->stream('certificado_'.date('YmdHis').'.pdf');
        }
    }

    public function ayuda(){
        return view('ayuda');
    }

    public function guardaEncuesta(Request $request){
        $m = Session::get('idModulo');
        Encuesta::create(['modulo' => $m->id,'docente' => $m->docente, 'user' => Auth::user()->id,'rtas' => $request->rtas]);
        return redirect()->route('estudiante.md', $m->id)->with('success', 'Encuesta diligenciada con éxito. Gracias');
    }

    public function devolverEntrega($id){
        $dt = Entrega::find($id);
        if($dt->de == Auth::user()->id){
            Storage::delete('userfiles/entregas/audio/'.$dt->idUnico);
            Storage::delete('userfiles/entregas/pdf/'.$dt->idUnico);
            //return response()->json($dt);
            $dt->delete();
            return redirect()->back()->with('success', 'La entrega se eliminó y queda habilitada para volver a enviarse.');
        }
    }

    //MESA DE AYUDA
    function mesayuda(Request $request){
        $mensaje_extra = '';
        $idTicket = 'TQ'.date('mydsih');

        if($request->foto != null){
            $photo = $request->file('foto');
            $idFot = $idTicket.'.'.$photo->getClientOriginalExtension();
            $image = Image::make($photo)->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/userfiles/ayuda/' . $idFot));
            $mensaje_extra = '<hr><a href="/userfiles/ayuda|'.$idFot.'" target="_blank"><img src="/userfiles/ayuda|'.$idFot.'" class="img-fluid"></a>';
        }

        $entrega = Mensaje::create([
            'asunto' => $idTicket,
            'start_date' => date('Y-m-d H:i:s'), 
            'end_date' => date("Y-m-d H:i:s",strtotime(now()."+ 6 months")), 
            'de' => Auth::user()->id, 
            'para' => 3,
            'mensaje' => $request->mensaje.$mensaje_extra,
            'status' => 0
        ]);

        return back()->with('success', 'Ticket <b># '.$idTicket.'</b> creado satisfactoriamente. Recibirás respuesta a tu solicitud en la sección de <b>Mensajes</b> a la mayor brevedad.');
    }
    
    public function pruebasAptitud(){
        $pruebas = Prueba::where('user', Auth::user()->id)->get();
        return view('estudiante.pruebas-ultimo-semestre');
    }
    public function verPruebaAptitud($id){
        $userPrueba = Prueba::where('codigo',$id)->first();
        if(Auth::user()->id == $userPrueba->user || Auth::user()->rol == "Administrador"){
            $pdf = Pdf::loadView('estudiante.pruebas-aptitud', compact('userPrueba'));
            $pdf->setPaper('letter', 'portait');
            //return $pdf->stream();
            return $pdf->stream('certificado_'.date('YmdHis').'.pdf');
        }
    }

    public function verCarnet(){       
        $miPrograma = Auth::user()->misBoxMatriculas()->where('estado','ACTIVO')->first();

        if($miPrograma->getPrograma()->tipo !== "Seminario-Taller"){
            
            $imagen = Image::make(public_path('images/bg-carnet.png'));

            $imagen->text(Auth::user()->nombres, $imagen->getWidth() / 2, $imagen->getHeight() / 2, function ($font) {
                $font->file(public_path('fonts/Montserrat-Medium.ttf')); // Ajusta la ruta según la ubicación de tu fuente
                $font->size(50); // Ajusta el tamaño del texto según tus necesidades
                $font->color('#194878'); // Ajusta el color del texto según tus necesidades
                $font->align('center');
                $font->valign('middle');
            });
            $imagen->text(mb_strtoupper(Auth::user()->apellidos, 'UTF-8'), $imagen->getWidth() / 2, $imagen->getHeight() / 2 + 40, function ($font) {
                $font->file(public_path('fonts/Montserrat-Black.ttf')); // Ajusta la ruta según la ubicación de tu fuente
                $font->size(40); // Ajusta el tamaño del texto según tus necesidades
                $font->color('#194878'); // Ajusta el color del texto según tus necesidades
                $font->align('center');
                $font->valign('middle');
            });

            // Nombre Programa
            $textoLines = wordwrap($miPrograma->getPrograma()->tipo.' '.$miPrograma->getPrograma()->nombre, 40, "\n"); // Ajusta el número de caracteres por línea según tus necesidades

            // Coordenadas iniciales para el texto
            $x = $imagen->getWidth() / 2;
            $y = $imagen->getHeight() / 2 + 80;

            // Agregar el texto en varios renglones
            foreach (explode("\n", $textoLines) as $line) {
                $imagen->text($line, $x, $y, function ($font) {
                    $font->file(public_path('fonts/Montserrat-Medium.ttf'));
                    $font->size(25); // Ajusta el tamaño del texto según tus necesidades
                    $font->color('#8294ac'); // Ajusta el color del texto según tus necesidades
                    $font->align('center');
                    $font->valign('middle');
                });

                // Ajustar la coordenada Y para la siguiente línea
                $y += 28; // Ajusta el espaciado entre líneas según tus necesidades
            }



            $imagen->text(Auth::user()->tipoDoc.': '.Auth::user()->doc, $imagen->getWidth() / 2, $imagen->getHeight() / 2 + 180, function ($font) {
                $font->file(public_path('fonts/Montserrat-Black.ttf')); // Ajusta la ruta según la ubicación de tu fuente
                $font->size(25); // Ajusta el tamaño del texto según tus necesidades
                $font->color('#ff313e'); // Ajusta el color del texto según tus necesidades
                $font->align('center');
                $font->valign('middle');
            });
            $imagen->text('CÓDIGO ESTUDIANTE: '.substr(Auth::user()->cod, -4), $imagen->getWidth() / 2, $imagen->getHeight() / 2 + 205, function ($font) {
                $font->file(public_path('fonts/Montserrat-Black.ttf')); // Ajusta la ruta según la ubicación de tu fuente
                $font->size(25); // Ajusta el tamaño del texto según tus necesidades
                $font->color('#ff313e'); // Ajusta el color del texto según tus necesidades
                $font->align('center');
                $font->valign('middle');
            });

            //Foto de Perfil ff313e 
            $imagen->insert(Image::make(storage_path('app/userfiles/profiles/0/'.Auth::user()->cod.'.jpg'))->resize(220, 300), 'center', 0, -205);

            //Código QR de validación
            $qrcode = base64_encode(QrCode::format('png')->size(200)->errorCorrection('H')->generate('https://certificado.instel.edu.co/carnet/'.base64_encode($miPrograma->id)));
            $codigoQRImagen = Image::make($qrcode);
            $codigoQRImagen->resize(200, 200);
            $imagen->insert($codigoQRImagen, 'bottom-left', 90, 80);

            return $imagen->response('jpg');
        }
    }
    
    //mesaticket
}
