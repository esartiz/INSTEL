@php
    $myGroupModule = substr($miMatricula->first()->grupo, -1);
@endphp
@extends('layouts.instel')
@section('template_title')
    {{ $modulo->titulo }} - INSTEL Virtual
@endsection
@section('content')

    <div class="container">

        <div class="d-flex bd-highlight">
            <div class="p-2 bd-highlight">
                <h3>{{ $modulo->titulo }}</h3>
                <small class="text-muted">
                    Este módulo se desarrollará entre el
                    <span class="forFecha" dt-f="{{ $tiempos[0][0] }}"></span> y el
                    <span class="forFecha" dt-f="{{ $tiempos[0][1] }}"></span>
                </small>
            </div>

            <div class="ms-auto p-2 bd-highlight">
                <a href="/" class="btn btn-outline-primary"><i class="fa-solid fa-circle-chevron-left"></i>Regresar</a><br><br>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif

        <div class="accordion" id="moduloContent">

            @if ($miMatricula->first()->hab != null)
                <!-- Inicio de la Habilitación -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingHab">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseHab" aria-expanded="false" aria-controls="collapseHab">
                            <span class="moduloSeccion"><i class="fa-solid fa-sun"></i> RECUPERACIÓN: <span style="color:red"> {{ $miMatricula->first()->hab }}</span></span>
                        </button>
                    </h2>
                    <div id="collapseHab" class="accordion-collapse collapse show" aria-labelledby="headingHab"
                        data-bs-parent="#moduloContent">

                        <div class="accordion-body">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th class="col-md-11">Enunciado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tareas as $tarea)
                                        @if ($tarea->tipo == 2)
                                         @include('modulo.tareaBox')
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- Fin de la Habilitación -->
            @endif


            @if ($miMatricula->first()->rem != null)
                @php
                    $getReposiciones = explode(',', $miMatricula->first()->rem);
                @endphp
                <!-- Inicio de la Reposición -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingHab">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseHab" aria-expanded="false" aria-controls="collapseHab">
                            <span class="moduloSeccion"><i class="fa-solid fa-sun"></i> REPOSICIÓN DE PARCIALES</span>
                        </button>
                    </h2>
                    <div id="collapseHab" class="accordion-collapse collapse show" aria-labelledby="headingHab"
                        data-bs-parent="#moduloContent">

                        <div class="accordion-body">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th class="col-md-11">Enunciado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i < count($getReposiciones); $i++)
                                        @php
                                            $tarea = $tareas->where('tipo', $getReposiciones[$i] + 2)->first();
                                        @endphp
                                        @include('modulo.tareaBox')
                                    @endfor
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- Fin de la Habilitación -->
            @endif

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingZero">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
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
                                        <img src="{{ route('ft', 'img|modulos|' . $modulo->image) }}" class="img-fluid rounded-start">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">

                                            <table class="table table-light text-center" style="font-size: 12px">
                                                <tr>
                                                    <th colspan="3">Sesiones sincrónicas del Módulo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($modulo->eventos()->where('grupo', $miMatricula->first()->grupo)->sortBy('fecha') as $itemClases)
                                                @php
                                                    $startBtnClass = \Carbon\Carbon::parse($itemClases->fecha)->subDays(1);
                                                    $endBtnClass = \Carbon\Carbon::parse($itemClases->fecha)->addDays(1);
                                                @endphp
                                                <tr>
                                                    <td>{{ $itemClases->nombre }}</td>
                                                    <td><span class="forFecha" dt-fmt="0" dt-f="{{ $itemClases->fecha }}"></span></td>
                                                    <td>
                                                        @if ($startBtnClass <= now() && now() <= $endBtnClass)
                                                        <a class="btn btn-link btn-sm" href="{{ $itemClases->link }}" target="_blank" role="button">Sala de Clase</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            </table>

                                            <table class="table table-light text-center" style="font-size: 12px">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">PARCIAL 1<br>(30%)</th>
                                                        <th scope="col">PARCIAL 2<br>(30%)</th>
                                                        <th scope="col">PARCIAL 3<br>(40%)</th>
                                                        <th scope="col">DEF<br>(100%)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="">
                                                        <td class="notaMod">{{ $miMatricula->first()->n1 }}</td>
                                                        <td class="notaMod">{{ $miMatricula->first()->n2 }}</td>
                                                        <td class="notaMod">{{ $miMatricula->first()->n3 }}</td>
                                                        <td class="notaMod">{{ number_format(($miMatricula->first()->n1 * 0.3) + ($miMatricula->first()->n2 * 0.3) + ($miMatricula->first()->n3 * 0.4), 1, '.', '') }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <p class="card-text">{{ $modulo->descripcion }}</p>
                                            <p class="card-text"><small class="text-muted">
                                                <b>
                                                {{ ($modulo->docentes()->where('grupo', $miMatricula->first()->grupo)->count() > 1 ? 'Docentes: ' : 'Docente: ') }}</b><br>
                                                @foreach ($modulo->docentes()->where('grupo', $miMatricula->first()->grupo) as $elDocente)
                                                {{ $elDocente->user()->nombres }} {{ $elDocente->user()->apellidos }} <br>
                                                @endforeach
                                            </small>
                                            </p>
                                
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
                        <div class="row row-cols-1 row-cols-md-4 text-center g-4">
                            @foreach ($recursos as $recurso)
                                @php
                                    $idSemana = explode('|', $recurso->fechas)[$myGroupModule];
                                    if ($idSemana == 0) {
                                        $tiempoIni = $tiempos[0][0];
                                        $tiempoFin = $tiempos[0][1];
                                    } else {
                                        $tiempoIni = $tiempos[$idSemana][0];
                                        $tiempoFin = $tiempos[$idSemana][1];
                                    }
                                    //Disponibilidad del recurso
                                    if($tiempoIni <= date('Y-m-d H:i:s') && $tiempoFin >= date('Y-m-d H:i:s')){
                                        $recursoBg = '00468C';
                                        $recursoTx = 'FFF';
                                        $recursoDs = true;
                                    } else {
                                        $recursoTx = '00468C';
                                        $recursoBg = 'FFF';
                                        $recursoDs = false;
                                    }
                                    //Clase de recurso
                                    if ($recurso->tipo == 'file'){
                                        $recursoIcon = 'fa-solid fa-file-pdf';
                                        $recursoHref = route('ft', 'files|' . $recurso->file);
                                        $extraCode = 'target = "_blank"';
                                    } else {
                                        $recursoIcon = 'fa-brands fa-youtube';
                                        $recursoHref = '#';
                                        $extraCode = 'onclick="openVideo(this)"';
                                    }
                                @endphp
                                <div class="col">
                                    <div class="card h-100" style="order: {{ $idSemana }}; font-size: 12px; background-color: #{{ $recursoBg }}; color: #{{ $recursoTx }};">
                                        <i class="{{ $recursoIcon }}" style="font-size:5em"></i>
                                        <h5 class="m-2" style="text-transform: uppercase">{{ $recurso->titulo }}</h5>
                                        @if ($recursoDs)
                                        <a class="btn btn-primary" href="{{ $recursoHref }}" {!! $extraCode !!} data="{{ $recurso->file }}" data-t="{{ $recurso->tipo }}" role="button">Ver Recurso</a>
                                        @else
                                        <span class="forFecha" dt-f="{{ $tiempoIni }}"></span> - <span class="forFecha" dt-f="{{ $tiempoFin }}"></span>
                                        @endif                                    
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <span class="moduloSeccion"><i class="fa-solid fa-pen"></i> ACTIVIDADES PARA DESARROLLAR </span>
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#moduloContent">
                    <div class="accordion-body">
                        <div class="table-responsive">

                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th class="col-md-12">Enunciado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tareas as $tarea)
                                        @if ($tarea->tipo == 0)
                                            @include('modulo.tareaBox')
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <span class="moduloSeccion"><i class="fa-solid fa-square-check"></i> AUTOEVALUACIONES</span>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#moduloContent">

                    <div class="accordion-body">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th class="col-md-12">Enunciado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tareas as $tarea)
                                    @if ($tarea->tipo == 1)
                                        @include('modulo.tareaBox')
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

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
                                    Grabación del <span class="forFecha" dt-fmt="0" dt-f="{{ $item->fecha }}"><br>
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
                    <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal" aria-label="Close">
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


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <!-- Ver entrega -->
    <div class="modal fade" id="revisaTarea" tabindex="-1" role="dialog" aria-labelledby="boxRecursoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tareaTT">Entrega realizada</h5>
                    <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="entregaData"></div>
                    <hr>
                    <a class="btn btn-danger btExtraVerEntrega"
                        onclick="return confirm('¿Está seguro(a) de cancelar el envío de esta entrega?. Esta acción no se puede reversar y deberá realizarla de nuevo.')"
                        href="#" role="button">Cancelar entrega y dejarla disponible de nuevo</a>
                </div>

                <div class="modal-footer revisionFooter">
                    <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
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
                            vd[1] + '?autoplay=1" frameborder="0" allow="autoplay" allowfullscreen></iframe><br> ' + 
                            '<a href="https://www.youtube.com/watch?v=' +
                            vd[1] + '" target="_blank">[ Ver en YouTube ]</a>';
                        $('#boxVideo').modal('show');
                    } else {
                        window.open($(tt).attr('data'), '_blank');
                    }
                    break;
                default:
                    console.log("wait..." + tp)
            }
            $('.loadVid').html(contenido);
            $('.modal-footer').show();
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

        @if ($hacerEncuesta)
            var intervalId = window.setInterval(function() {
                clearInterval(intervalId)
                contenido =
                    '<iframe id="loadVid" width="100%" height="500" src="/encuesta-modulo" frameborder="0" allow="autoplay" allowfullscreen></iframe>';
                $('.modal-body').html(contenido);
                $('#staticBackdrop').modal('show');
            }, 1000);
        @endif

        let tareaSel = "";
        let btSel;

        function verEntrega(t) {
            btSel = t;
            let tLm = Date.parse($(t).attr('data-fch'));
            let tNw = Date.parse('{{ now() }}');
            if (tLm > tNw) {
                $('.btExtraVerEntrega').show();
                $('.btExtraVerEntrega').attr('href', '/devolverEntrega/' + $(t).attr('data-fx'));
            } else {
                $('.btExtraVerEntrega').hide();
            }
            console.log(tNw + '-' + tLm);
            $('.entregaData').load("/entregashow/" + $(t).attr('data-fx'));
            $('#revisaTarea').modal('show');
        }
    </script>
@endsection
