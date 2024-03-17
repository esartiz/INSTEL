@php
    $semestreNombre = ['N/A', 'Primer Semestre', 'Segundo Semestre', 'Tercer Semestre', 'Semestre de Profudización Animación Musical y Presentación de Espectáculos', 'Semestre de Profudización Lectura de Noticias y Periodismo Radial', 'Semestre de Profudización Periodismo y Locución Deportiva', 'Semestre de Profudización Locución y Presentación de Televisión', 'Semestre de Profudización Producción y Locución Comercial', 'Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa'];
@endphp

@extends('layouts.admin')

@section('template_title')
    Usuarios Registrados
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <h3>{{ $users->count() }} Estudiantes activos</h3>
                            <div class="float-right">
                                <form action="{{ route('users.check') }}" method="post">
                                    @csrf
                                    <input type="number" name="checkID" id="" required placeholder="No. Documento">
                                    <input type="hidden" name="rol" value="{{ $tipoDato }}">
                                    <button type="submit" class="btn btn-primary btn-sm float-right" data-placement="left">
                                        Registrar nuevo {{ $tipoDato }}
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label for="" class="form-label">Programa</label>
                                    <select class="form-select" name="" id="filtraPorPg">
                                        <option value="">Seleccione</option>
                                        @foreach ($listaFiltro as $item)
                                            <option value="{{ $item->id }}" myInfo="{{ $item->estructura }}">
                                                {{ $item->tipo . ' ' . $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-8">
                                    <label for="" class="form-label">Semestre</label>
                                    <select class="form-select" name="ciclo" onchange="buscaenLista()"
                                        id="cicloID"></select>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label">Grupo</label>
                                    <select class="form-select" name="grupo" onchange="buscaenLista()" id="grupoID">
                                        <option value="">Seleccione</option>
                                        <option value="1">Grupo A</option>
                                        <option value="2">Grupo B</option>
                                        <option value="3">Grupo C</option>
                                        <option value="4">Grupo D</option>
                                        <option value="5">Grupo A Sabatino</option>
                                        <option value="6">Grupo B Sabatino</option>
                                        <option value="7">Grupo C Sabatino</option>
                                        <option value="8">Grupo D Sabatino</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-hover" id="usuariosTable">
                            <thead class="thead">
                                <tr>
                                    <th></th>
                                    <th>Estudiante</th>
                                    <th>Matrículas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td style="width: 5%">
                                            <img id="output"
                                                src="{{ route('ft', 'profiles|0|t|' . $user->cod) }}.jpg?{{ date('YmdHis') }}"
                                                class="img-fluid"
                                                onerror="this.src='{{ route('ft', 'profiles|0|no-pic.jpg') }}';" />
                                        </td>
                                        <td style="width: 30%">
                                            <a href="{{ route('users.edit', $user->id) }}">
                                                {{ $user->apellidos }} {{ $user->nombres }}
                                            </a>
                                        </td>
                                        <td style="width: 65%">
                                            @if ($tipoDato == 'Estudiante')
                                                @foreach ($user->misBoxMatriculas()->orderBy('periodo', 'DESC')->get() as $iMt)
                                                    @if ($iMt->estado == 'ACTIVO')
                                                        <div style="font-size: 1px">
                                                            filt_{{ $iMt->prg }}_{{ $iMt->nivel }}_{{ substr($iMt->periodo, -1) }}
                                                        </div>
                                                    @endif
                                                    <div class="row {{ $iMt->estado == 'ACTIVO' ? 'bg-success text-white' : '' }}"
                                                        style="font-size: 12px">
                                                        <div class="col-md-5">
                                                            {{ $iMt->getPrograma()->nombre }}
                                                            <br>{{ $iMt->getSesiones()->sortBy('fecha')->reverse()->first()->fecha ?? '' }}

                                                        </div>
                                                        <div class="col-md-3">{{ $semestreNombre[$iMt->nivel] }}</div>
                                                        <div class="col-md-2">{{ $iMt->periodo }}</div>
                                                        <div class="col-md-2">{{ $iMt->estado }}</div>
                                                    </div>
                                                @endforeach
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

    <form action="{{ route('enviarMSJ') }}" method="POST">
        @csrf
        <div class="modal fade" id="boxMsj" tabindex="-1" role="dialog" aria-labelledby="boxMsjLabel"
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

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Asunto:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="asunto">
                            </div>
                        </div>

                        <br>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Mensaje:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="mensaje" id="" rows="10"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="msjIDto" id="msjIDto" value="">
                        <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        function sendmsj(dt, nf) {
            $('#boxActividad_tt').text("Enviar Mensaje a " + nf);
            $('#msjIDto').val(dt);
            $('#boxMsj').modal('show');
        }
        $('.cerrarModal').click(function() {
            $('.modal').modal('hide')
        })

        $(document).ready(function() {
            $("#usuariosTable").DataTable();
            $('.btwToolt').tooltip();
        });

        $('#filtraPorPg').change(function() {
            buscaSemestre($('option:selected', '#filtraPorPg').attr('myInfo'));
        });

        function buscaenLista() {
            var table = $('#usuariosTable').DataTable();
            var searchMe = 'filt_' + $('#filtraPorPg').val() + '_' + $('#cicloID').val() + '_' + $('#grupoID').val();
            if (searchMe == 'filt___') {
                searchMe = '';
            }
            console.log(searchMe)
            table.column(2).
            search(searchMe, true, false).
            draw();
        }
    </script>
@endsection
