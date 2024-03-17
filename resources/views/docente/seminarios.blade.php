@php
    $seminariosFuturos = $seminariosAsignados->where('fecha','>=', date('Y-m-d'));
    $seminariosPasados = $seminariosAsignados->where('fecha','<=', date('Y-m-d'));
    $pendientes = 0;
@endphp
@extends('layouts.instel')
@section('template_title') Seminarios asigandos @endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>Se te han asignado <b>{{ $seminariosFuturos->count() }} Sesiones de seminarios por realizar</b></div>
                </div>
                <div class="card-body row">

                    <table class="table table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Sesión</th>
                                <th>Estudiante</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        @foreach ($seminariosFuturos->sortBy('fecha') as $item)
                            <tr>
                                <td scope="row">
                                    <input data-fx="{{ $item->id }}" type="date" class="form-control cambiaFecha" name="" id="" value="{{ $item->fecha }}">
                                    <small id="msj_{{ $item->id }}" class="text-muted" style="max-width: 150px"></small>
                                </td>
                                <td><b>{{ $item->dataSeminar()->sesionID }}</b><br><small class="muted-text">{{ $item->dataSeminar()->programa()->nombre }}</small></td>
                                <td>{{ $item->estudiante()->apellidos }}, {{ $item->estudiante()->nombres }}</td>
                                <td>
                                    @if ($item->fecha == date("Y-m-d"))
                                    @php
                                    $claveZoom = "";
                                    switch($item->cuentaZoom){
                                        case("aleissy1@gmail.com"):
                                            $claveZoom = "Colombo1";
                                            break;
                                        case("lassoa037@gmail.com"):
                                            $claveZoom = "INSTELcali123";
                                            break;
                                        case("info@instel.edu.co"):
                                            $claveZoom = "CALIinstel12345";
                                            break;
                                        case("docente2@instel.edu.co"):
                                            $claveZoom = "CALIinstel1990";
                                            break;
                                        default;
                                    }                                   
                                    @endphp
                                    <a href="https://us02web.zoom.us/j/{{ $item->zoom }}" target="_blank" type="button" class="btn btn-success btn-sm">Entrar a Sala de Zoom</a>
                                    <button onclick="verDetalleSala(this)" data-id="{{$item->zoom}}" data-fx="{{ $item->cuentaZoom }}" data-cl="{{ $claveZoom }}" type="button" class="btn btn-warning btn-sm">Ver acceso Zoom</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>

    <br>

    <!-- Seminarios ya realizados -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>Has realizado <b>{{ $seminariosPasados->count() }} Sesiones.</b></div>
                </div>
                <div class="card-body row">

                    <div class="boxAlerta"></div>
                    
                    <table class="table table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Sesión</th>
                                <th>Estudiante</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        @foreach ($seminariosPasados as $item)
                            <tr>
                                <td scope="row">
                                    {{ $item->fecha }}
                                </td>
                                <td><b>{{ $item->dataSeminar()->sesionID }}</b><br><small class="muted-text">{{ $item->dataSeminar()->programa()->nombre }}</small></td>
                                <td>{{ $item->estudiante()->apellidos }}, {{ $item->estudiante()->nombres }}</td>
                                <td>

                                    @if ($item->fecha <= date("Y-m-d"))
                                    @php
                                    $status_retro = (is_null($item->retro) ? 'success' : 'outline-success');
                                    $txt_btt = (is_null($item->retro) ? 'Entrega / Valoración' : '<i class="fa-solid fa-clipboard-check" style="margin-right: 10px"></i> Sesión Completa');
                                    if(is_null($item->retro)){
                                        $pendientes++;
                                    }
                                    @endphp
                                    
                                    <button onclick="valorar(this)" data-fx-user="{{ $item->estudiante()->nombres }} {{ $item->estudiante()->apellidos }}" data-fx-ruta="{{ $item->envio }}" data-fx-tipo="{{ $item->tareaTipo }}" data-fx="{{ $item->envio }}"  data-id="{{ $item->id }}" data-retro="{{ $item->retro }}" type="button" class="btn btn-sm btn-{{ $status_retro }}">{!! $txt_btt !!}</button>
                                    
                                    @endif
                                    
                                    @if ($item->fecha == date("Y-m-d"))
                                    @php
                                    $claveZoom = "";
                                    switch($item->cuentaZoom){
                                        case("aleissy1@gmail.com"):
                                            $claveZoom = "Colombo1";
                                            break;
                                        case("lassoa037@gmail.com"):
                                            $claveZoom = "INSTELcali123";
                                            break;
                                        case("info@instel.edu.co"):
                                            $claveZoom = "CALIinstel12345";
                                            break;
                                        case("docente2@instel.edu.co"):
                                            $claveZoom = "CALIinstel1990";
                                            break;
                                        default;
                                    }
                                    @endphp
                                    <button onclick="verDetalleSala(this)" data-id="{{$item->zoom}}" data-fx="{{ $item->cuentaZoom }}" data-cl="{{ $claveZoom }}" type="button" class="btn btn-warning btn-sm">Entrar Sala de Zoom</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>

<div class="modal fade" id="modEditSesion" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar información de la sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('editar.sesion')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="idEdit" id="idEdit" value="">
                    <div class="mb-3">
                      <label for="" class="form-label">Archivo PDF guía</label>
                      <input type="file" class="form-control" name="archivo" accept="application/pdf">
                      <small id="helpId" class="form-text text-muted">Cargue un documento PDF con información introductoria/preparatoria</small>
                    </div>

                    <h5>Actividad posterior a la Sesión</h5>
                    <small id="helpId" class="form-text text-muted">El(la) estudiante tendrá plazo de entregar una actividad desde el día siguiente que finaliza la sesión hasta un día antes de la próxima sesión del seminario</small>
                    <div class="mb-3">
                        <label for="" class="form-label">Tipo de Actividad</label>
                        <select class="form-select" name="tareaTipo" id="tareaTipo">
                            <option value="|pdf">Cargar un PDF</option>
                            <option value="|link">Link de Youtube</option>
                        </select>
                    </div>
                    <div class="mb-3">
                      <label for="tarea" class="form-label">Instrucciones para realizar la actividad</label>
                      <textarea class="form-control" name="tarea" id="tarea" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar información</button>
                </form>
            </div>
        </div>
    </div>
</div>

<form action="{{route('retro.sesion')}}" method="POST" class="modal fade" id="modalValorar" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="titleValorar" aria-hidden="true">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleValorar">Realizar valoración de la sesión </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="entrega">

                </div>
                <hr>
                <h5>Retroalimentación de la sesión:</h5>
                <div class="mb-3">
                  <label for="retro" class="form-label">Esta retroalimentación dará cuenta del avance en la sesión y será visible para la/el estudiante.</label>
                  <textarea class="form-control" name="retro" id="retro" rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="idValoracion" id="idValoracion">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </div>
</form>


<div class="modal fade" id="verSalaClase" tabindex="-1" role="dialog" aria-labelledby="salamodaltt" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="salamodaltt">Encuentros Sincrónicos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  
        </div>
        <div class="modal-body" style="text-align: left">
          {{ Auth::user()->nombres }}, para iniciar ten en cuenta las siguientes recomendaciones:
          <br><br>
          <ul>
            <li>Ingrese a la sala 30 minutos antes.</li>
            <li>Una vez finalice la clase cierre sesión para que la sala pueda estar disponible para el próximo módulo.</li>
            <li>Tome asistencia desde la plataforma.</li>
            <li>Por la seguridad de todos, evite compartir el acceso.</li>
          </ul>
          <hr>
          <b>Datos de acceso zoom:</b><br>
          Email:
          <div id="laCuenta" style="text-align:right"></div>
          Contraseña:
          <div id="laClave" style="text-align:right"></div>
          <div class="muted-text" id="rtaCop" style="font-size:10px"></div>
        </div>
        <div class="modal-footer">
          <a href="" id="linkGo" target="_blank" class="btn btn-info" role="button">
            <i class="fa-solid fa-street-view"></i> INGRESAR
          </a>
        </div>
      </div>
    </div>
  </div>
  
@endsection


@section('scripts')
<script>
    $('.cambiaFecha').change(function(){
        var idDt = $(this).attr('data-fx');
        var nFecha = $(this).val();
        $.ajax({
            type: "post",
            url: "{{route('reagendar.sesion')}}",
            data: {
                id: idDt,
                nFecha, nFecha,
                _token : '{{csrf_token()}}'
            },
            success: function (msg) {
                console.log("OK: " + msg)
                $('#msj_' + idDt).text(msg)
            }, 
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    })

    function valorar(t){
        $('#titleValorar').text($(t).attr('data-fx-user'));
        $('#modalValorar').modal('show');
        let infoEntrega = ($(t).attr('data-fx-ruta')).split('||');
        let contador = 0;
        let showRta;
        infoEntrega.forEach(element => {
            console.log(element)
            if(element !== ''){
                contador++;
                if($(t).attr('data-fx-tipo') == '|pdf'){
                    showRta += '<li><a href="/userfiles/entregas|pdf|' + element + '" target="_blank">VER PDF ' + contador + '</a></li>';
                } else {
                    showRta += '<li><a href="'+ element +'" target="_blank">VER LINK ' + contador + '</a></li>';
                }
            }
        });
        $('.entrega').html(showRta);
        $('#idValoracion').val($(t).attr('data-id'));
        $('#retro').val($(t).attr('data-retro'))
    }

    function showDataSession(t){
        $('#modEditSesion').modal('show')
        $('#idEdit').val($(t).attr('data-fx1'));
        $('#tareaTipo').val($(t).attr('data-fx3'));
        $('#tarea').val($(t).attr('data-fx4'));
    }

    function verDetalleSala(tt){
        $('#verSalaClase').modal('show');
        $('#laCuenta').text($(tt).attr('data-fx'));
        console.log($(tt).attr('data-fx'))
        $('#laClave').text($(tt).attr('data-cl'));
        $('#linkGo').attr('href', 'https://us02web.zoom.us/j/' + $(tt).attr('data-id'));
    }
    function copyClave(dd) {
      $('#' + dd).show();
      $('#' + dd).select();
      document.execCommand("copy");
      $('#' + dd).hide();
    }

    @if ($pendientes > 0)
        $('.boxAlerta').html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>Recuerda que faltan <strong>{{ $pendientes }} retroalimentaciones</strong> por realizar.</div>')
    @endif
</script>
@endsection
