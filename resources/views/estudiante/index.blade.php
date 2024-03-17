@php
    $sesionAhora = true;
    $autoeval = [];
    $guiaSeminar = 0;
    $obj = $obj ?? new stdClass();
    $dataMatriculaF = Auth::user()
        ->misBoxMatriculas()
        ->where('estado', 'ACTIVO')
        ->orderBy('id', 'DESC')
        ->first();
    $docReq = \AppHelper::checkDocsReqs(Auth::user());
@endphp

@extends('layouts.instel')

@section('content')
    <div class="container">
        @if (Session::exists('msjFinanciero'))
            <div class="alert alert-danger">{!! Session::get('msjFinanciero')[0] !!}</div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif

        @if (
            (Auth::user()->dataSiet()->first()->updated_at < '2023-05-15' ||
                Auth::user()->dataSiet()->first()->pais == null) &&
                Auth::user()->misSesiones()->count() == 0)
            <!-- ALERTA SIET -->
            <div class="container alert alert-danger" role="alert">
                <h4 class="alert-heading">Tu información personal está desactualizada desde el <span class="forFecha"
                        dt-fmt="0" dt-f="{{ Auth::user()->dataSiet()->first()->updated_at }}"></span></h4>
                <p>
                    Para INSTEL es importante contar con tus datos personales actualizados. (Al menos de los últimos 3
                    meses)
                    Diligencia el formulario para el SIET <b><a href="/siet">haciendo clic aquí</a></b>.
                </p>
                <hr>
                <p class="mb-0">Actualiza tus datos antes del 11 de Agosto de 2023 y evita que tu acceso a la plataforma
                    sea bloqueada. <span class="countdown"></span>
                </p>
            </div>
        @else
            @if (count($docReq) > 0)
                <div class="container alert alert-success" role="alert">
                    <h4 class="alert-heading">Debe cargar algunos documentos faltantes</h4>
                    <p>Para iniciar su proceso de formación con INSTEL es necesario que cargue los siguientes documentos
                        faltantes:</p>
                    <ul>
                        @foreach ($docReq as $item)
                            <li>Debe cargar el documento {{ $item }} </li>
                        @endforeach
                    </ul>
                    <hr>
                    <p class="mb-0">Para cargarlos entre a <b><a href="/profile">su Perfil</a></b>, cargue los documentos
                        y de clic en GUARDAR</p>
                </div>
            @else
                @include('estudiante.agenda')

                @include('estudiante.index_pruebas')

                @foreach ($matricula as $boxM)
                @if ($boxM->getPrograma()->tipo !== 'Seminario-Taller')
                @php
                    $misModulos = $boxM->materias();
                @endphp
                @include('estudiante.index_mod')
                @endif 
                @endforeach

                @include('estudiante.index_sem')
            @endif
        @endif

    </div>



    <div class="modal fade" id="retroAl" tabindex="-1" role="dialog" aria-labelledby="retrBox" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="retrBox">Retroalimentación de la sesión por parte del Docente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid" id="retrTxt">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        function verRetro(tt) {
            $('#retroAl').modal('show');
            $('#retrTxt').text($(tt).attr('data-rt'))
            $('#retrBox').text("Retroalimentación de " + $(tt).attr('data-de'))

        }

        $('.notaMod').each(function() {
            var dtCom = parseFloat($(this).text());
            if (dtCom == 0.0) {
                $(this).css("background-color", "transparent");
            } else if (dtCom > 0.0 && dtCom < 3.5) {
                $(this).css("background-color", "#ffd9d6");
            } else if (dtCom >= 3.5 && dtCom < 4.5) {
                $(this).css("background-color", "#f5f2dc");
            } else if (dtCom >= 4.5) {
                $(this).css("background-color", "#e2f7df");
            }
        });

        function openMsj(tt, deMsj) {
            var url = "vermsj/" + tt
            $.get(url, function(data) {
                if (data == 0) {
                    alert("Función no permitida")
                } else {
                    $('#msjView').modal('show');
                    $('#t_msj').text(data.asunto);
                    $('#f_msj').text(data.start_date);
                    $('#m_msj').text(data.mensaje);
                    $('#dd_msj').text(data.updated_at);
                    $('#r_msj').text("Respuesta de " + deMsj);
                    $('#msjT').text(data.respuesta);
                    //
                }
            });
        }
    </script>
@endsection
