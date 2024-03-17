@php
    $periodosLetra = Session::get('config')['gruposNombre'];
    $semestreNombre = ['', 'Primer Semestre', 'Segundo Semestre', 'Tercer Semestre', 'Semestre de Profudización Animación Musical y Presentación de Espectáculos', 'Semestre de Profudización Lectura de Noticias y Periodismo Radial', 'Semestre de Profudización Periodismo y Locución Deportiva', 'Semestre de Profudización Locución y Presentación de Televisión', 'Semestre de Profudización Producción y Locución Comercial', 'Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa'];
    $cuentas = ['info@instel.edu.co', 'aleissy1@gmail.com', 'lassoa037@gmail.com', 'docente2@instel.edu.co', 'Sala Externa'];
@endphp

@extends('layouts.admin')

@section('template_title')
    Programación INSTEL
@endsection

@section('content')

    <h2 class="text-center">Programación del <span class="forFecha" dt-fmt="0" dt-f="{{ $diasSemana[0] }}"></span> al <span
            class="forFecha" dt-fmt="0" dt-f="{{ $diasSemana[5] }}"></span></h2>

    <div class="d-flex justify-content-between">
        <a href="/listazoom/{{ $theWeek[0] }}">
            << Semana Anterior</a>
                <a href="/listazoom/0">Semana Actual</a>
                <a href="/listazoom/{{ $theWeek[1] }}">Semana Siguiente >></a>
    </div>

    <div class="d-flex text-center fs-4">
        <div class="col-1">Sala</div>
        @foreach ($diasSemana as $dias)
            <div class="col bg-success text-white" style="min-width: 400px; border: 1px solid #dddddd">
                <span class="forFecha" dt-fmt="10" dt-f="{{ $dias }}"></span>
            </div>
        @endforeach
    </div>

    @foreach ($cuentas as $item)
        <div class="d-flex">
            <div class="col-1 text-center"><b>{{ $loop->iteration }}</b><br>{{ explode('@', $item)[0] }}</b></div>
            @foreach ($diasSemana as $dias)
                <div class="col" style="min-width: 400px; border: 1px solid #dddddd">
                    <button dt1="{{ $dias }}" dt2="{{ $item }}" dt3="{{ $loop->parent->iteration }}"
                        type="button" class="btn btn-sm col-12 btn-link" onclick="formEvent(this)"> + Agregar</button>

                    @foreach ($sesiones as $evento)
                        @if ($evento->fecha == $dias && $evento->cuentaZoom == $item && $evento->zoom !== null)
                            <table class="table table-bordered" style="width: 380px; margin:10px; font-size: 12px">
                                <tr>
                                    <td>
                                        <a href="/users/{{ $evento->user }}/edit" target="_blank">
                                            Seminario: {{ $evento->dataSeminar()->programa()->nombre }}<br>
                                            Estudiante: {{ $evento->estudiante()->nombres }}
                                            {{ $evento->estudiante()->apellidos }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary text-white" style="font-size: 11px">
                                        https://us02web.zoom.us/j/{{ $evento->zoom }}
                                    </td>
                                </tr>
                            </table>
                        @endif
                    @endforeach

                    @foreach ($eventos as $eventoModulo)
                        @if ($eventoModulo->fecha == $dias && $eventoModulo->sala == $item)
                            <table class="table table-bordered" style="width: 380px; margin:10px; font-size: 12px">
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-10">
                                                <b>{{ $eventoModulo->nombre }}</b>
                                            </div>
                                            <div class="col-2">
                                                <form action="{{ route('evento.destroy') }}" method="post">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <input type="hidden" name="deleteme" value="{{ $eventoModulo->id }}">
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Desea eliminar definitivamente este evento?')"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-bs-original-title="Deshabilitar"><i
                                                            class="fa fa-fw fa-trash"></i> </button>
                                                </form>
                                            </div>
                                        </div>
                                        Grupo: {{ $eventoModulo->grupo }}<br>
                                        @php
                                            if (
                                                $eventoModulo
                                                    ->infoModulo()
                                                    ->programas()
                                                    ->first()->id == 1
                                            ) {
                                                echo 'Téc. Loc | ' . $semestreNombre[$eventoModulo->infoModulo()->ciclo];
                                            } else {
                                                echo $eventoModulo
                                                    ->infoModulo()
                                                    ->programas()
                                                    ->first()->nombre;
                                            }
                                        @endphp
                                        <br><a href="#" onclick="editaEvento('{{ $eventoModulo }}')">[ Editar ]</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-primary text-white" style="font-size: 11px">
                                        {{ $eventoModulo->link }}
                                    </td>
                                </tr>
                            </table>
                        @endif
                    @endforeach

                </div>
            @endforeach
        </div>
    @endforeach

    <div class="modal fade" id="addEvento" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="tituloAddEvento" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <form action="" method="post" id="cajaEvento">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloAddEvento"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                        @csrf
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="">Módulo</label>
                                <select name="modulo" id="elModulo" class="form-control">
                                    <option value="">Seleccione el Módulo</option>
                                    @foreach ($modulos as $item)
                                        <option datsem="{{ $item->sem }}" datzoom ="{{ $item->sala }}" datfechas="{{ '|'.$item->fecha1.'|'.$item->fecha2.'|'.$item->fecha3.'|'.$item->fecha4 }}" value="{{ $item->id }}">{{ $item->titulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input id="msemanas" type="hidden" name="msemanas">
                            <input id="nombremd" type="hidden" name="nombremd">

                            <div class="form-group col-md-4">
                                <label for="">Tipo Actividad</label>
                                <select name="preNombre" id="preNombre" class="form-control">
                                    
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                            <label for="fecha">Grupo:</label>
                            <select class="form-select form-select" name="grupo" id="grupoID">
                                <option value="" selected>Todos / No Aplica</option>
                                @for ($i = date('Y')-1; $i <= date('Y') + 1; $i++)
                                    @for ($j = 1; $j < count($periodosLetra); $j++)
                                        <option value="{{ $i . $j }}">{{ $i }} -
                                            {{ $periodosLetra[$j] }}</option>
                                    @endfor
                                @endfor
                            </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="fechainput">Fecha:</label>
                                <input name="fecha" id="fechainput" type="date" class="form-control" value="">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="cuentainput">Sala:</label>
                                <input name="sala" id="cuentainput" type="text" class="form-control" value="">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="">Link:</label>
                                <input name="link" id="elLink" type="text" class="form-control" value="">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="">Nombre Evento:</label>
                                <input name="nombre" id="elNombre" type="text" class="form-control" value="">
                            </div>

                            <small class="text-danger text-center" id="avisoFecha"></small>

                            <div class="form-group col-md-12 mt-3" id="opcionRepeat">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="opcion" id="si" value="si" checked>
                                    <label class="form-check-label" for="si" id="avisoRepeat">Repetir evento</label>
                                </div>
                            
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="opcion" id="no" value="no">
                                    <label class="form-check-label" for="no">No, solo por esta vez</label>
                                </div>
                            </div>

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </div>

            </form>
        </div>
    </div>


@endsection


@section('scripts')
    <script>
        var salas = [
            [],
            ['84985740198', '86476569451'],
            ['82315139862', '83056016059'],
            ['82359681410', '82503729677'],
            ['88322562572', '83899572740'],
            ['0', '0']
        ];

        function formEvent(dd) {
            $("#cajaEvento").attr('action', '{{ route('createMeeting') }}');
            $("#cajaEvento")[0].reset();
            $('#opcionRepeat').show();
            var dia = $(dd).attr('dt1');
            var cuenta = $(dd).attr('dt2');
            $('#fechainput').val(dia);
            $('#cuentainput').val(cuenta);
            $('#tituloAddEvento').text("Agregar a la Sala " + cuenta + " el día " + dia);
            $('#addEvento').modal('show');
            //
            $('#preNombre').empty();
            $('#preNombre').append('<option value="Clase">Clase</option><option value="' + salas[$(dd).attr('dt3')][0] +
                '">Práctica AM</option><option value="' + salas[$(dd).attr('dt3')][1] + '">Práctica PM</option>')
        }

        $("#elModulo").on("change", function() {
            var valorSeleccionado = $(this).val();
            var datsem = $(this).find("option:selected").attr("datsem");
            var datzoom = $(this).find("option:selected").attr("datzoom");
            var nn = $(this).find('option:selected').text();

            $('#msemanas').val(datsem);
            $('#nombremd').val(nn);
            $('#elLink').empty();
            $('#elLink').val("https://us02web.zoom.us/j/" + datzoom);
            $('#avisoRepeat').text("Crear este evento en esta fecha y en las próximas " + (datsem - 1) +
                " semanas?");
        });
        $('#preNombre').on("change", function() {
            $('#elLink').empty();
            $('#elLink').val("https://us02web.zoom.us/j/" + $(this).val());
        });
        $('#grupoID').on("change", function() {
            var cadena = $(this).val();
            var datfechas = ($("#elModulo").find("option:selected").attr("datfechas")).split('|');
            $('#avisoFecha').text(datfechas[cadena[cadena.length - 1]] +
                " es el inicio de este módulo según el sistema.")
        });


        function editaEvento(dd) {
            var jsonData = JSON.parse(dd);
            $("#cajaEvento").attr('action', '/edit-meeting/' + jsonData.id);
            $('#opcionRepeat').hide();

            $('#fechainput').val(jsonData.fecha);
            $('#cuentainput').val(jsonData.sala);
            $('#elNombre').val(jsonData.nombre);
            $('#elModulo').val(jsonData.modulo);
            $('#grupoID').val(jsonData.grupo);
            $('#elLink').val(jsonData.link);
            $('#addEvento').modal('show');

            $('#tituloAddEvento').text("Editar " + jsonData.nombre);
        }
    </script>
@endsection
