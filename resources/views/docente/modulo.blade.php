@php
    $listaEstudiantes = $modulo->estudiantesAsignados()->where('grupo', $modulo->grupo)->get();
    $myGroupModule = substr($modulo->grupo, -1);
@endphp

@extends('layouts.instel')
@section('template_title'){{ $modulo->modulo()->titulo }} @endsection
@section('content')
<div class="container">
    <div class="d-flex bd-highlight mb-3">
        <div class="p-2 bd-highlight">
            <h3>{{ $modulo->modulo()->titulo }} - Grupo <span class="forGrupo" dt-f="{{ $modulo->grupo }}"></span></h3>
            <small class="text-muted">
              Este módulo se desarrollará entre el 
              <span class="forFecha" dt-f="{{ $tiempos[0][0] }}"></span> y el
              <span class="forFecha" dt-f="{{ $tiempos[0][1] }}"></span>
          </small>
        </div>
        <div class="ms-auto p-2 bd-highlight">
            <a href="/" class="btn btn-outline-info"><i class="fa-solid fa-circle-chevron-left"></i> Regresar</a>
        </div>
      </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    <div class="text-center">
        <button onclick="verNotas()" type="button" name="" id="" class="btn btn-warning">
            <i class="fa-solid fa-clipboard-check"></i> CALIFICACIONES DEL MÓDULO
        </button>

        <button onclick="checkAttendance()" type="button" name="" id="" class="btn btn-success">
          <i class="fa-solid fa-hand"></i> TOMAR ASISTENCIA
        </button>
    </div>

    <div class="accordion accordion-flush" id="moduloContent">
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                <span class="moduloSeccion"><i class="fa-solid fa-circle-info"></i> INFORMACIÓN DEL MÓDULO</span>
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#moduloContent">
            <div class="accordion-body">
                <div class="row">
                    <div class="card mb-3 col-12">
                        <div class="row g-0">
                          <div class="col-md-4">
                            <img src="{{ route('ft','img|modulos|'.$modulo->modulo()->image) }}" class="img-fluid rounded-start" alt="...">
                            <hr>
                            <h6>Asistencias tomadas en este grupo en el Módulo:</h6>
                            @php $tDat = ""; $idModalClick = 0 @endphp
                            @foreach ($modulo->asistencias() as $item)
                            @if ($tDat != $item->fecha)
                                @php $idModalClick++ @endphp
                                <button onclick="viewAttendance({{ $idModalClick }})" class="btn btn-outline-info btn-sm "  data-placement="left">
                                    {{ $item->fecha}}
                                </button>
                            @endif
                            @php $tDat = $item->fecha @endphp
                            @endforeach
                          </div>
                          <div class="col-md-8">
                            <div class="card-body">
                              <table class="table table-light text-center" style="font-size: 12px">
                                <tr>
                                    <th colspan="3">Sesiones sincrónicas del Módulo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modulo->eventos()->where('grupo', $modulo->grupo)->sortBy('fecha') as $itemClases)
                                @php
                                    $startBtnClass = \Carbon\Carbon::parse($itemClases->fecha)->subDays(1);
                                    $endBtnClass = \Carbon\Carbon::parse($itemClases->fecha)->addDays(1);
                                @endphp
                                <tr>
                                    <td>{{ $itemClases->nombre }}</td>
                                    <td><span class="forFecha" dt-fmt="0" dt-f="{{ $itemClases->fecha }}"></span></td>
                                    <td>
                                        @if ($startBtnClass <= now() && now() <= $endBtnClass)
                                        <a class="btn btn-link btn-sm" href="{{ $itemClases->link }}" target="_blank" role="button">Sala de Clase</a><br>
                                        @php
                                            $claveZoomPrac = "";
                                            switch($itemClases->sala){
                                              case("aleissy1@gmail.com"):
                                                $claveZoomPrac = "Colombo1";
                                                break;
                                            case("lassoa037@gmail.com"):
                                                $claveZoomPrac = "INSTELcali123";
                                                break;
                                            case("info@instel.edu.co"):
                                                $claveZoomPrac = "CALIinstel12345";
                                                break;
                                            case("docente2@instel.edu.co"):
                                                $claveZoomPrac = "CALIinstel1990";
                                                break;
                                            default;
                                          }
                                        @endphp
                                        <table style="text-align: left">
                                          <tr>
                                            <th>Cuenta:</th>
                                            <td>{{ $itemClases->sala }}</td>
                                          </tr>
                                          <tr>
                                            <th>Clave:</th>
                                            <td>{{ $claveZoomPrac }}</td>
                                          </tr>
                                        </table>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>


                              <p class="card-text">{{ $modulo->descripcion }}</p>
                            </div>

                            <!-- Inicio Anuncio a la clase -->
                            <div class="card">
                                <form action="{{ route('anuncio')}}" method="post">
                                    @csrf
                                <div class="card-header">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">

                                        <span id="card_title">
                                            Anuncia algo para los(as) Estudiantes del Módulo si crees necesario</b> 
                                        </span>

                                        <div class="float-right">
                                            <small for="inputPassword">Visible hasta:</small>
                                            <input type="datetime-local" name="vence" value="{{ $anuncio->vence ?? '' }}" class="form-control">
                                            <input type="hidden" name="modulo" value="{{ $modulo->id }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <textarea class="ckeditor" name="texto" id="texto" rows="13" required>
                                        @isset($anuncio->texto)
                                            {!! $anuncio->texto !!}
                                        @endisset
                                    </textarea>
                                    <button type="submit" name="" id="" class="btn btn-primary">Actualizar Anuncio</button>
                                </div>
                                </form>
                            </div>
                            <!-- Final Anuncio a la clase -->
                          </div>
                        </div>
                      </div>
                </div>
              </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                <span class="moduloSeccion"><i class="fa-solid fa-book"></i> RECURSOS Y MATERIAL DE APOYO</span>
            </button>
          </h2>
          <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#moduloContent">
            <div class="accordion-body">

                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>                                    
                            <th class="col-6">Recurso</th>
                            <th class="col-3">Visible</th>
                            <th class="col-3"><button class="btn btn-primary btn-sm float-right" onclick="nuevoRecurso(this)" data="X">+ AGREGAR RECURSO</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modulo->recursos() as $recurso)
                        @php
                        $elGrupo = substr($modulo->grupo, -1);
                        if ($recurso->sem == 0) {
                            $tiempoIni = $tiempos[0][0];
                            $tiempoFin = $tiempos[0][1];
                        } else {
                            $tiempoIni = $tiempos[explode('|', $recurso->fechas)[$elGrupo]][0];
                            $tiempoFin = $tiempos[explode('|', $recurso->fechas)[$elGrupo]][1];
                        }
                        @endphp
                        <tr>
                            <td>{{ $recurso->titulo }}</td>
                            <td>
                              @if ($recurso->author != "admin")
                              Todo el Módulo
                              @else
                              <small>Desde: <span class="forFecha" dt-f="{{ $tiempoIni }}"></span><br>Hasta: <span class="forFecha" dt-f="{{ $tiempoFin }}"></span></small></td>
                              @endif
                            <td>
                                <div class="d-flex justify-content-between">
                                <a class="btn btn-info btn-sm" href="@if ($recurso->tipo == "link") {{ $recurso->file }} @else {{ route('ft','files|'.$recurso->file) }} @endif" target="_blank"><i class="fa fa-fw fa-eye"></i> Ver Recurso</a>

                                @if ($recurso->author != "admin")
                                <button class="btn btn-success btn-sm" data="{{ $recurso }}" onclick="editRecurso(this)"><i class="fa fa-fw fa-edit"></i> Modificar</a>
                                    <form action="{{ route('recursos.destroy',$recurso->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"  onclick="return confirm('¿Desea eliminar este recurso?')"><i class="fa fa-fw fa-trash"></i> Eliminar</button>
                                    </form>
                                @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                <span class="moduloSeccion"><i class="fa-solid fa-pen"></i> ACTIVIDADES PARA DESARROLLAR </span>
            </button>
          </h2>
          <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#moduloContent">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>                                    
                            <th class="col-md-6">Enunciado</th>
                            <th class="col-md-2">Vigencia</th>
                            <th class="col-md-2">Tipo Respuesta</th>
                            <th class="col-md-2">
                                <button onclick="nuevoActividad(this)" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                    + AGREGAR NUEVA ACTIVIDAD
                                  </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modulo->tareas() as $tarea)
                        @if ($tarea->tipo == 0)
                            <tr>                                        
                                <td>{{ $tarea->enunciado }}</td>
                                <td>
                                    <small>
                                      Del <span class="forFecha" dt-f="{{ $tiempos[explode('|', $recurso->fechas)[$elGrupo]][0] }}"></span>
                                      al <span class="forFecha" dt-f="{{ $tiempos[explode('|', $recurso->fechas)[$elGrupo]][1] }}"></span>
                                    </small>
                                </td>
                                <td>
                                    <small class="text-center" style="color: #00468C">
                                        @switch($tarea->tipo_rta)
                                            @case("pdf|")
                                                <i class="fa-solid fa-file-pdf"></i> RESPUESTA EN PDF
                                                @break
                                            @case("audio|")
                                                <i class="fa-solid fa-music"></i> RESPUESTA EN AUDIO
                                                @break
                                            @case("texto|")
                                                <i class="fa-solid fa-keyboard"></i> RESPUESTA EN TEXTO
                                                @break
                                            @case("link|")
                                                <i class="fa-solid fa-link"></i> RESPUESTA EN LINK
                                                @break
                                            @default
                                                
                                        @endswitch
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-sm btn-success"  data="{{ $tarea }}" onclick="editActividad(this)"><i class="fa fa-fw fa-edit"></i> Modificar</button>
                                        <form action="{{ route('tareas.destroy',$tarea->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar esta actividad?')"><i class="fa fa-fw fa-trash"></i> Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

          </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading4">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse4" aria-expanded="false" aria-controls="flush-collapseThree">
                <span class="moduloSeccion"><i class="fa-solid fa-square-check"></i> AUTOEVALUACIONES</span>
              </button>
            </h2>
            <div id="flush-collapse4" class="accordion-collapse collapse" aria-labelledby="flush-heading4" data-bs-parent="#moduloContent">
              <div class="accordion-body">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>                                    
                            <th class="col-md-11">Enunciado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modulo->tareas() as $tarea)
                        @if ($tarea->tipo == 1)
                        @php
                            if($tarea->limite == NULL){
                              $idSemanaT = explode('|', $tarea->fechas)[$myGroupModule];
                              $tDesde = $tiempos[$idSemanaT][2];
                              $tLimite = $tiempos[$idSemanaT][3];
                            } else {
                              $tDesde = $tarea->desde;
                              $tLimite = $tarea->limite;
                            }
                        @endphp
                            <tr>   
                                <td>
                                    <a href="{{ route('ft','files|au|'.$tarea->isAU)}}" target="_blank">
                                        <b>{{ $tarea->enunciado }}</b>
                                    </a>
                                    <br>
                                        <small>
                                          Disponible desde el  <span class="forFecha" dt-f="{{ $tDesde }}"></span>
                                      hasta el <span class="forFecha" dt-f="{{ $tLimite }}"></span>
                                    </small>

                                    <div class="d-flex justify-content-between">
                                        <small class="text-center" style="color: #00468C">
                                            @switch($tarea->tipo_rta)
                                                @case("pdf")
                                                    <i class="fa-solid fa-file-pdf"></i> RESPUESTA EN PDF
                                                    @break
                                                @case("audio")
                                                    <i class="fa-solid fa-music"></i> RESPUESTA EN AUDIO
                                                    @break
                                                @case("texto")
                                                    <i class="fa-solid fa-keyboard"></i> RESPUESTA EN TEXTO
                                                    @break
                                                @case("link")
                                                    <i class="fa-solid fa-link"></i> RESPUESTA EN LINK
                                                    @break
                                                @default
                                                    
                                            @endswitch
                                        </small>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading5">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse5" aria-expanded="false" aria-controls="flush-collapseThree">
                <span class="moduloSeccion"><i class="fa-solid fa-circle-check"></i> ENTREGAS DE LOS {{ $listaEstudiantes->count() }} ESTUDIANTES</span>
              </button>
            </h2>
            <div id="flush-collapse5" class="accordion-collapse collapse" aria-labelledby="flush-heading5" data-bs-parent="#moduloContent">
              <div class="accordion-body">
                <table class="table table-striped table-hover usuariosTable">
                    <thead class="thead">
                        <tr>                                    
                            <th class="col-md-1"></th>
                            <th class="col-md-3">Estudiante</th>
                            <th class="col-md-8 text-center">
                                <table class="table text-center">
                                    <tr>
                                        @foreach ($modulo->tareas() as $item)
                                        @if ($item->tipo == 1  || $item->tipo == 0)
                                        <td style="width: {{100 / $modulo->recursos()->count()}}%; color:#00468C; font-size:10px">
                                          <b>{{ $item->enunciado }}</b>
                                        </td>
                                        @endif
                                        @endforeach
                                    </tr>
                                </table>    
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listaEstudiantes as $estudiante)
                            <tr>                                        
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $estudiante->user->apellidos.' '.$estudiante->user->nombres }}</td>
                                <td>
                                    <table class="table text-center">
                                        <tr>
                                            @foreach ($modulo->tareas() as $tarea)
                                            @if ($tarea->tipo == 1  || $tarea->tipo == 0) 

                                            @php
                                                $gt = $tarea->entregasDoc->where('de', $estudiante->estudiante)->first();
                                            @endphp
                                            @if ($gt == "" || $gt == NULL)
                                                <td><button type="button" class="btn btn-outline-danger"><i class="fa-regular fa-clock"></i> Pendiente</button></td>
                                            @else
                                            <td>
                                                @if ($gt->retro == NULL)
                                                <button data-fx="{{ $gt->id }}" data-rt="" type="button" class="btn btn-warning" onclick="verEntrega(this, {{$estudiante->id}})"><i class="fa-regular fa-eye"></i> Ver Entrega</button>
                                                @else
                                                <button data-fx="{{ $gt->id }}" data-rt="{{ $gt->retro }}" class="btn btn-outline-success" onclick="verEntrega(this, {{$estudiante->id}})"><i class="fa-regular fa-square-check"></i> Revisada</button>
                                                @endif
                                            </td>
                                            @endif
                                                
                                            @endif
                                            @endforeach
                                        </tr>
                                    </table>  
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading6">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse6" aria-expanded="false" aria-controls="flush-collapseThree">
                <span class="moduloSeccion"><i class="fa-solid fa-folder"></i> REPOSITORIO SESIONES DEL MÓDULO</span>
              </button>
            </h2>
            <div id="flush-collapse6" class="accordion-collapse collapse" aria-labelledby="flush-heading6" data-bs-parent="#moduloContent">
              <div class="accordion-body">
                <div class="row">
                    @foreach ($modulo->grabaciones() as $item)
                    <div class="col-md-6 text-center">
                        {{$item->nombre}}
                        <iframe src="https://drive.google.com/file/d/{{ $item->ruta }}/preview" width="100%" height="340" allow="autoplay"></iframe>
                        Grabación del <span class="forFecha" dt-fmt="0" dt-f="{{ $item->fecha }}"></span><br>
                    </div>
                    @endforeach
                </div>
              </div>
            </div>
          </div>
      </div>


<form method="POST" id="actividadForm" role="form" enctype="multipart/form-data">
    <input type="hidden" name="_method" class="act_metodo" value="">
      @csrf
      <div class="modal fade" id="boxActividad" tabindex="-1" role="dialog" aria-labelledby="boxActividadLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="boxActividad_tt">Agregar nueva Actividad</h5>
            <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body row">
            <div class="form-group col-md-12">
                <div class="mb-3">
                  <label for="" class="form-label">Enunciado de la Actividad</label>
                  <textarea class="form-control" name="enunciado" id="enunciado" rows="8" required></textarea>
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <div class="mb-3">
                    <label for="act_rtatipo" class="form-label">Tipo de Respuesta</label>
                    <select class="form-select" name="tipo_rta" id="act_rtatipo">
                    <option value="texto|">Texto</option>
                    <option value="link|">Link (Ej. Youtube)</option>
                    <option value="audio|">Audio</option>
                    <option value="pdf|">Archivo PDF</option>
                    </select>
                </div>
            </div>        

            <div class="form-group col-md-8">
              <div class="mb-3">
                  <label for="f_ord" class="form-label">Actividad para desarrollarse durante:</label>
                  <select class="form-select" name="ord" id="f_ord">
                      <option value="0">Todo el módulo</option>
                      @php
                      for ($i=0; $i < count($tiempos)-1; $i++) { 
                          echo '<option value="'.($i+1).'">Semana '.($i+1).' (Del '.$tiempos[$i+1][0].' al '.$tiempos[$i+1][1].')</option>';
                      }
                      @endphp
                  </select>
              </div>
          </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
          </div>
        </div>
      </div>
    </div>
  </form>


<form method="POST" id="recursoForm" role="form" enctype="multipart/form-data">
  <input type="hidden" name="_method" class="act_metodo" value="">
    @csrf
    <div class="modal fade" id="boxRecurso" tabindex="-1" role="dialog" aria-labelledby="boxRecursoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="boxRecurso_tt">Agregar nuevo Recurso</h5>
          <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="mb-3">
                  <label for="titulo" class="form-label">Nombre del Recurso</label>
                  <input type="text" class="form-control" name="titulo" id="f_titulo" required>
                </div>
            </div>

            <div class="form-group">
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Recurso</label>
                    <select class="form-select" name="tipo" id="f_tipo" onchange="genTipo(this.value, '')">
                        <option value="file">Archivo Adjunto (PDF)</option>
                        <option value="link">Link externo</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="mb-3 tipo_file">
                  
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
        </div>
      </div>
    </div>
  </div>
</form>



<form method="POST" action="" id="revTarea" role="form" enctype="multipart/form-data">
    <input type="hidden" name="_method" class="act_metodo" value="">
      @csrf
      <div class="modal fade" id="revisaTarea" tabindex="-1" role="dialog" aria-labelledby="boxRecursoLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tareaTT">Revisar entrega</h5>
            <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body">
            <div class="entregaData"></div>
            <input type="hidden" name="notaAutoEv" id="notaAutoEv">
          </div>
                
          <div class="modal-footer revisionFooter">
            <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
          </div>
        </div>
      </div>
    </div>
  </form>



    <!-- CALIFICACIONES -->
    <form method="POST" action="{{ route('notas') }}" class="idT" role="form" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="califModTable" tabindex="-1" role="dialog" aria-labelledby="boxRecursoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Notas del Módulo</h5>
              <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <div class="modal-body">

              <b>Importante:</b> Si agregó notas en la parte de "Entrega de Estudiantes" y no ha actualizado la página,
              actualícela para ver en este listado las notas guardadas.
  
              <table class="table table-striped table-hover">
                  <thead class="thead">
                      <tr>                                    
                          <th class="col-md-6">Estudiante</th>
                          <th class="col-md-1">Nota 1(30%)</th>
                          <th class="col-md-1">Nota 2(30%)</th>
                          <th class="col-md-1">Nota 3(40%)</th>
                          <th class="col-md-2">Final(100%)</th>
                      </tr>
                  </thead>
                  <tbody class="baseNotas">
                      
                  </tbody>
              </table>
  
            </div>
                  
            <div class="modal-footer">
              <input type="hidden" name="totalAtt" id="totalAttNotas">
              <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- FIN CALIFICACIONES -->


  
  <!-- Nueva asistencia -->
  <form method="POST" action="{{ route('asistencia') }}" class="idT" role="form" enctype="multipart/form-data">
      @csrf
      <div class="modal fade" id="attendanceMod" tabindex="-1" role="dialog" aria-labelledby="boxRecursoLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tomar asistencia</h5>
            <div>
                <div class="mb-3">
                    <label for="fechaAsst" class="form-label">Fecha:</label>
                    <input type="date" name="fecha" class="form-control" id="fechaAsst" required>
                    <input type="hidden" name="grupo" value="{{ $modulo->grupo }}">
                  </div>
            </div>
            <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body">

            <table class="table table-striped table-hover">
                <thead class="thead">
                    <tr>                                    
                        <th class="col-md-3">Apellidos</th>
                        <th class="col-md-3">Nombres</th>
                        <th class="col-md-5"></th>
                    </tr>
                </thead>
                <tbody>
                    @php $iAst = 0 @endphp
                    @foreach ($listaEstudiantes as $estudiante)
                    @php $iAst++ @endphp
                        <tr> 
                            <td>{{ $estudiante->user->apellidos }}</td>
                            <td>{{ $estudiante->user->nombres }}</td>
                            <td>
                                    <input type="hidden" name="ast_id_{{ $loop->iteration }}" value="{{ $estudiante->user->id }}">

                                    <input class="form-check-input" type="radio" name="ast_v_{{ $loop->iteration }}" id="btAsis_{{ $loop->iteration }}_1" value="1" checked>
                                    <label class="form-check-label" for="btAsis_{{ $loop->iteration }}_1">Si</label>
                                    <input class="form-check-input" type="radio" name="ast_v_{{ $loop->iteration }}" id="btAsis_{{ $loop->iteration }}_2" value="0">
                                    <label class="form-check-label" for="btAsis_{{ $loop->iteration }}_2">No</label>
                            </td>
                        </tr>
                    @endforeach
                    <input type="hidden" name="totalAtt" value="{{ $iAst }}">
                </tbody>
            </table>

          </div>
                
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- Fin Nueva asistencia -->










  


  <!-- Asistencias listas -->


            <!-- PREV. SCHEMA D -->
  <form method="POST" action="" class="boxAttendance" role="form" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="attendanceEd" tabindex="-1" role="dialog" aria-labelledby="attendanceEdLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <div>
              <div class="mb-3">
                  <label for="fechaAsst" class="form-label">Fecha:</label>
                  <input type="date" name="fecha" class="form-control" id="fechaAsst" required>
                </div>
          </div>
          <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">

          <table class="table table-striped table-hover">
              <thead class="thead">
                  <tr>                                    
                      <th class="col-md-3">Apellidos</th>
                      <th class="col-md-3">Nombres</th>
                      <th class="col-md-5"></th>
                  </tr>
              </thead>
              <tbody>

            <!-- PREV. SCHEMA D -->

  
  @php $tDatPup = ""; $idModal = 0; @endphp
  @foreach ($modulo->asistencias() as $item)    
  @if ($tDatPup != $item->fecha)
  @php $idModal++; $iAst = 0; @endphp

</tbody>
</table>

</div>
    
<div class="modal-footer">
<button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
</div>
</div>
</div>
</div>
</form>
  
    <div class="modal fade" id="boxAttendance_{{ $idModal }}" tabindex="-1" role="dialog" aria-labelledby="attendanceEdLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">

      <div class="modal-content">

        <form action="{{ route('asistencia_delete') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="refDelete" value="{{ $item->fecha }}">
            <button type="submit" class="btn btn-danger btn-sm"  onclick="return confirm('¿Desea eliminar este listado de asistencia?')"><i class="fa fa-fw fa-trash"></i> Eliminar Lista</button>
          </form>

        <div class="modal-header">
          <h5 class="modal-title">Asistencia de día {{ $item->fecha }}</h5>

          <form method="POST" action="{{route('asistencia_edit')}}" class="boxAttendance_{{ $idModal }}" role="form">
            @csrf
          <div>
              <div class="mb-3">
                  <label for="fechaAsst" class="form-label">Fecha:</label>
                  <input type="date" name="fecha" class="form-control" id="fechaAsst" value="{{ $item->fecha }}" required>
                </div>
          </div>
        </div>
        
        <div class="modal-body">

          <table class="table table-striped table-hover">
              <thead class="thead">
                  <tr>                                    
                      <th class="col-md-3">Apellidos</th>
                      <th class="col-md-3">Nombres</th>
                      <th class="col-md-5"></th>
                  </tr>
              </thead>
              <tbody>
                @endif

                @php $iAst++ @endphp
                        <tr> 
                            <td>{{ $item->user->apellidos }}</td>
                            <td>{{ $item->user->nombres }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="idEst_{{ $iAst }}" value="{{ $item->id }}">
                                    <input class="form-check-input" name="ast_v_{{ $iAst }}" type="checkbox" id="att_{{ $iAst }}" @if ($item->presencia == "1") checked @endif>
                                    <label class="form-check-label" for="att_{{ $iAst }}">Asistió</label>
                                </div>
                            </td>
                        </tr>
                    <input type="hidden" name="totalAtt" value="{{ $iAst }}">

                @php $tDatPup = $item->fecha @endphp
@endforeach

</tbody>
</table>

</div>
    
<div class="modal-footer">
<button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
</div>
</div>
</div>
</div>
</form>

  <!-- Fin listas -->


<div class="prueba1"></div>
  

@endsection

@section('scripts')
<script>
    function nuevoRecurso(t){
        $('#boxRecurso').modal('show');
        genTipo("file",'');
        $('#boxRecurso_tt').text("Agregar nuevo Recurso");
        $('#recursoForm').attr('action', '{{ route('recursos.store') }}')
        $('#f_tipo').val();
        $('.act_metodo').val("POST");
        $('.enviarBt').text('Crear Recurso')
    }
    function editRecurso(t){
        $('#boxRecurso').modal('show');
        const gtDt = JSON.parse($(t).attr('data'));
        $('#boxRecurso_tt').text("Editar Recurso");
        $('#f_titulo').val(gtDt.titulo)
        $('#recursoForm').attr('action', '/recursos/'+gtDt.id);
        $('#f_tipo').val(gtDt.tipo);
        $('.act_metodo').val("PATCH")
        $('.enviarBt').text('Editar Recurso');
        genTipo(gtDt.tipo, gtDt.file)
    }
    function genTipo(tipo,vv){
        var cdT = "";
        if(tipo == "file"){
            cdT = '<label for="file" class="form-label">Archivo adjunto</label><input type="file" class="form-control" name="file" accept="application/pdf, application/vnd.ms-word"><div id="fileHelpId" class="form-text">Acepta solo archivos PDF</div>';
        } else {
            cdT = '<label for="titulo" class="form-label">Link del Recurso</label><input type="text" class="form-control" name="file" value="'+vv+'" placeholder="Ej. https://www.youtube.com/?v=12abC456">'
        }
        $('.tipo_file').html(cdT);
    }

    //

    function nuevoActividad(t){
        $('#boxActividad').modal('show');
        $('#actividadForm').attr('action', '{{ route('tareas.store') }}')
        $('.act_metodo').val("POST");
        $('#boxActividad_tt').text("Agregar nueva Actividad");
        $('#enunciado').val('');
        $('#act_rtatipo').val();
        $('#act_fecha1').val();
        $('#act_fecha2').val();
        $('#ord').val();
        $('.enviarBt').text('Crear Actividad');
    }
    function editActividad(t){
        const gtDt = JSON.parse($(t).attr('data'));
        $('#boxActividad').modal('show');
        $('#actividadForm').attr('action', '/tareas/'+gtDt.id);
        $('.act_metodo').val("PATCH");
        $('#boxActividad_tt').text("Editar Actividad");
        $('#enunciado').val(gtDt.enunciado);
        $('#act_rtatipo').val(gtDt.tipo_rta);
        $('#act_fecha1').val(gtDt.desde);
        $('#act_fecha2').val(gtDt.limite);
        $('#f_ord').val(gtDt.ord);
        $('.enviarBt').text('Editar Actividad');
    }

    $('.cerrarModal').click(function(){
        $('.modal').modal('hide')
    });

    let tareaSel = "";
    let btSel;
    let estudianteSel;
    function verEntrega(t, idEst){
      btSel = t;
      $('#campo').val($(t).attr('data-nt'));
      $('.entregaData').load("/entregashow/" + $(t).attr('data-fx'));
      $('#revisaTarea').modal('show');
      $('#retroalimentacion').val($(t).attr('data-rt'));
      $('#laNota').val($(t).attr('data-vl'));
      tareaSel = $(t).attr('data-fx');
      $('.act_metodo').val("PATCH");
      let datF = getNotasPersona(idEst);  
      $('#notaAutoEv').val(0);
      $('.revisionFooter').html('<button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button><button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>');
      estudianteSel = idEst;
    }

    $("#revTarea").submit(function(event){
      $('.revisionFooter').html('Guardando, espere por favor...');
      event.preventDefault();
      $.ajax({
        url: '/revision/' + tareaSel,
        type:'POST',
        data:$(this).serialize(),
        success:function(result){
          $('#revisaTarea').modal('hide');
          $(btSel).removeClass('btn-warning').addClass('btn-outline-success');
          $(btSel).html('<i class="fa-regular fa-square-check"></i> Revisada');
          $(btSel).attr('onclick', '#');
        }
      });
      console.log($(this).serialize());
    });





    //Notas
    let notasGrupo = [
    @foreach ($listaEstudiantes as $estudiante)
      {
        "nombre": "{{ $estudiante->user->apellidos }} {{ $estudiante->user->nombres }}", 
        "id":{{$estudiante->id}}, 
        "n1":{{($estudiante->n1 == NULL ? 0.0 : $estudiante->n1)}}, 
        "n2":{{($estudiante->n2 == NULL ? 0.0 : $estudiante->n2)}}, 
        "n3":{{($estudiante->n3 == NULL ? 0.0 : $estudiante->n3)}}, 
      },
    @endforeach
    ];
    notasGrupo.sort((a, b) => (a.nombre > b.nombre) ? 1: -1);
    let idEst = 1;
    notasGrupo.forEach(element => {
      let elCode = '<tr><td>' + idEst + '. ' + element.nombre + '</td>';
      let elProm = ((element.n1 * 0.3) + (element.n2 * 0.3) + (element.n3 * 0.4)).toFixed(1);
      elCode += '<input type="hidden" name="dtNot_' + idEst + '" value="' + element.id + '">';
      elCode += '<td><input type="number" class="form-control notaMod" data-st="'+element.id+'" name="n1_'+element.id+'" id="n1_'+element.id+'" step="0.1" min="0" max="5" value="'+element.n1+'"/></td>';
      elCode += '<td><input type="number" class="form-control notaMod" data-st="'+element.id+'" name="n2_'+element.id+'" id="n2_'+element.id+'" step="0.1" min="0" max="5" value="'+element.n2+'"/></td>';
      elCode += '<td><input type="number" class="form-control notaMod" data-st="'+element.id+'" name="n3_'+element.id+'" id="n3_'+element.id+'" step="0.1" min="0" max="5" value="'+element.n3+'"/></td>';
      elCode += '<td><div class="'+colorPromNt(elProm)+'" id="prom_'+element.id+'">'+elProm+'</div></td></tr>';
      $('.baseNotas').append(elCode);
      idEst++;
    });
    $('#totalAttNotas').val(idEst);
    function getNotasPersona(ffEst){
      let datF = notasGrupo.filter(function (person) { return person.id == ffEst });
      return datF[0];
    }
    //
    function colorPromNt(nProm){
      return (nProm < 3.5 ? 'nPerdida' : (nProm > 4.5 ? 'nAprobada' : 'nExcelente'));
    }
    function revisionCambiaNota(){
      $('#notaAutoEv').val(1);
    }
    $('.notaMod').change(function(){
      console.log($(this).attr('data-st'))
        var prColor = [];
        var elID = $(this).attr('data-st');
        var nProm = ($('#n1_' + elID).val() * 0.3) + ($('#n2_' + elID).val() * 0.3) + ($('#n3_' + elID).val() * 0.4);
        $('#prom_' + elID).removeClass();
        $('#prom_' + elID).addClass(colorPromNt(nProm));
        $('#prom_' + elID).text((nProm).toFixed(2));
    });
    function verNotas(){
        $('#califModTable').modal('show');
    };




    function checkAttendance(){
        $('#attendanceMod').modal('show');
    }
    function viewAttendance(dd){
        $('#boxAttendance_' + dd).modal('show');
    }
    

    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function (event) {
            let checkboxLabel = document.querySelector('label[for="'+checkbox.id+'"]');
            if (checkboxLabel) checkboxLabel.textContent = checkbox.checked?"Asistió":"Ausente";
        });
    });

    $(document).ready(function() {
        $(".usuariosTable").DataTable();
        $('.btwToolt').tooltip();
    });

    $('.accordion-button').click(function(){
        $(window).scrollTop(0);
    })

</script>
@endsection
