@extends('layouts.instel')
@section('template_title')
    {{ $modulo->titulo }} - INSTEL Virtual
@endsection
@section('content')

    <div class="container">

        <div class="d-flex bd-highlight">
            <div class="p-2 bd-highlight">
                <h3>{{ $modulo->titulo }}</h3>
            </div>
            <div class="ms-auto p-2 bd-highlight">
                @if ($modulo->sala !== NULL)
                <a href="https://us02web.zoom.us/j/{{ $modulo->sala }}" target="_blank" class="btn btn-primary" role="button">SALA DE LA CLASE</a>
                @endif

                @if ($laSala)
                <a href="https://us02web.zoom.us/j/{{ $laSala->link_host }}" target="_blank" class="btn btn-danger" role="button">SALA PRÁCTICA</a>
                @endif
                    
                <a href="/" class="btn btn-outline-primary"><i class="fa-solid fa-circle-chevron-left"></i>
                    Regresar</a><br><br>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif

        <div class="accordion" id="moduloContent">

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingZero">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseZero"
                        aria-expanded="true" aria-controls="collapseZero">
                        <span class="moduloSeccion"><i class="fa-solid fa-circle-info"></i> INFORMACIÓN DEL MÓDULO</span>
                    </button>
                </h2>
                <div id="collapseZero" class="accordion-collapse collapse show" aria-labelledby="headingZero"
                    data-bs-parent="#moduloContent">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="card mb-3 col-12">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ route('ft','img|modulos|' . $modulo->image) }}"
                                            class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <p class="card-text">{{ $modulo->descripcion }}</p>
                                            <p class="card-text"><small class="text-muted">Docente:
                                                    {{ $modulo->user->nombres . ' ' . $modulo->user->apellidos }}</small></p>
                                            <a href="{{ route('inbox.show', $modulo->user->cod) }}"
                                                class="btn btn-outline-success"><i class="fa-solid fa-envelope"></i> Enviar
                                                mensaje al tutor</a>
                                        </div>
                                        @isset($anuncio->vence)
                                            @if ($anuncio->vence > now())
                                                <div class="anuncio">
                                                    {!! $anuncio->texto !!}
                                                </div>
                                            @endif
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <span class="moduloSeccion"><i class="fa-solid fa-book"></i> RECURSOS Y MATERIAL DE APOYO</span>
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#moduloContent">
                    <div class="accordion-body">
                        <div class="list-group">
                            @foreach ($recursos as $recurso)
                                @php
                                    if ($recurso->sem == 0) {
                                        $tiempoIni = $tiempos[1][0];
                                        $tiempoFin = $tiempos[$modulo->sem][1];
                                    } else {
                                        $tiempoIni = $tiempos[$recurso->sem][0];
                                        $tiempoFin = $tiempos[$recurso->sem][1];
                                    }
                                @endphp

                                @if ($tiempoIni <= date('Y-m-d H:i:s') && $tiempoFin >= date('Y-m-d H:i:s'))
                                    @if ($recurso->tipo == "file")
                                    <a href="{{ route('ft', 'files|'.$recurso->file) }}" target="_blank"
                                    @else
                                    <a href="#" onclick="openVideo(this)" data="@if($recurso->tipo == "file"){{ $recurso->cRec }}@else{{ $recurso->file }}@endif" data-t="{{ $recurso->tipo }}"
                                    @endif
                                        class="list-group-item active list-group-item-action flex-column align-items-start">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <h5 class="mb-1">{{ $recurso->titulo }}</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <small>Disponible Ahora</small>
                                            </div>
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-1">
                                                <small>Abrir</small>
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5 class="mb-1">{{ $recurso->titulo }}</h5>
                                            </div>
                                            <div class="col-md-3">
                                                <small>
                                                    Desde: <span class="forFecha" dt-f="{{ $tiempoIni }}"></span>
                                                </small>
                                            </div>
                                            <div class="col-md-3">
                                                <small>
                                                    Hasta: <span class="forFecha" dt-f="{{ $tiempoFin }}"></span>
                                                </small>
                                            </div>
                                            <div class="col-md-2">
                                                <small>No Disponible aún</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <span class="moduloSeccion"><i class="fa-solid fa-folder"></i> REPOSITORIO SESIONES DEL
                                MÓDULO</span>
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#moduloContent">

                        <div class="accordion-body">
                            <div class="row">
                                @foreach ($grabaciones as $item)
                                    <div class="col-md-6 text-center">
                                        {{ $item->nombre }}
                                        <iframe src="https://drive.google.com/file/d/{{ $item->ruta }}/preview"
                                            width="100%" height="340" allow="autoplay"></iframe>
                                        Grabación del <span class="forFecha" dt-f="{{ $item->fecha }}"><br>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>


        <div class="modal fade" id="boxVideo" tabindex="-1" role="dialog" aria-labelledby="boxVideoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="boxActividad_tt"></h5>
                        <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9 loadVid"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
                    </div>
                </div>
            </div>
        </div>


    @endsection

    @section('scripts')
        <script>
            function openVideo(tt) {
                var tp = $(tt).attr('data-t');
                var contenido;

                switch (tp) {
                    case 'repo':
                        contenido = '<iframe src="https://drive.google.com/file/d/' + $(tt).attr('data') +
                            '/preview" width="100%" height="480" allow="autoplay"></iframe>';
                        break;
                    case 'link':
                        if ($(tt).attr('data').includes("v=")) {
                            var vd = $(tt).attr('data').split('v=');
                            contenido = '<iframe id="loadVid" width="100%" height="500" src="https://www.youtube.com/embed/' +
                                vd[1] + '?autoplay=1" frameborder="0" allow="autoplay" allowfullscreen></iframe>';
                            $('#boxVideo').modal('show');
                        } else {
                            window.open($(tt).attr('data'), '_blank');
                        }
                        break;
                    default:
                        console.log("wait..." + tp)
                }
                $('.loadVid').html(contenido);
            }

            $('.cerrarModal').click(function() {
                $('.modal').modal('hide')
            })

            document.getElementById('boxVideo').addEventListener("hidden.bs.modal", function(event) {
                $('.loadVid').empty();
            });
            $('.accordion-button').click(function() {
                $(window).scrollTop(0);
            })
        </script>
    @endsection
