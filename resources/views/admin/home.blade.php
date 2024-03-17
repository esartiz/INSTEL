@php
    $totalCartera = 0;
    $periodosLetra = Session::get('config')['gruposNombre'];
    $semestreNombre = ['', 'Primer Semestre', 'Segundo Semestre', 'Tercer Semestre', 'Semestre de Profudización Animación Musical y Presentación de Espectáculos', 'Semestre de Profudización Lectura de Noticias y Periodismo Radial', 'Semestre de Profudización Periodismo y Locución Deportiva', 'Semestre de Profudización Locución y Presentación de Televisión', 'Semestre de Profudización Producción y Locución Comercial', 'Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa'];
@endphp

@extends('layouts.admin')

@section('template_title')
    Bienvenido al módulo administrador
@endsection

@section('content')
    <form action="{{ route('users.buscar') }}" method="post" style="width: 100%">
        @csrf
        <div class="input-group mb-3">
            <input type="text" name="buscar" class="form-control"
                placeholder="Buscar Usuario por Documento, Nombres o Apellidos" aria-describedby="button-addon2">
            <button class="btn btn-outline-primary" type="submit" id="button-addon2">Buscar</button>
        </div>
    </form>
    
    @if ($nuevosI->count() > 0)
    <h4>Nuevos inscritos</h4>
            <div class="table-responsive">
                <table class="table table-light">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Programa</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nuevosI as $item)
                        <tr class="">
                            <td scope="row">{{ $item->nombre }}</td>
                            <td>{{ $item->tipo_programa }} {{ $item->programa }}</td>
                            <td>{{ $item->telefono }}</td>
                            <td>{{ $item->correo }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($item->fechaForm)->format('d/m') }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($item->fechaForm)->format('H:i:s') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="text-align: right; padding-bottom: 20px"><a href="/inscripciones">Ir a inscripciones >> </a></div>
            </div> 
    @endif

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="text-white d-flex justify-content-between align-items-center"
                style="background-color: rgb(16, 79, 128); padding:10px">
                <div>Estudiantes Activos</div>
                <div style="font-size: 31px; font-weight: bold;">
                    {{ $users->where('rol', 'Estudiante')->count() }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-white d-flex justify-content-between align-items-center"
                style="background-color: rgb(46, 52, 57); padding:10px">
                <div>Docentes</div>
                <div style="font-size: 31px; font-weight: bold;">
                    {{ $users->where('rol', 'Docente')->count() }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-white d-flex justify-content-between align-items-center"
                style="background-color: #f23838; padding:10px">
                <div>Estudiantes Inactivos</div>
                <div style="font-size: 31px; font-weight: bold;">
                    {{ $users->where('rol', 'Inactivo')->count() }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-white d-flex justify-content-between align-items-center"
                style="background-color: #241d3b; padding:10px">
                <div>Egresados</div>
                <div style="font-size: 31px; font-weight: bold;">
                    {{ $users->where('rol', 'Egresado')->count() }}
                </div>
            </div>
        </div>
    </div>

    <div id="chart_div"></div>
    <div id="chart_div2"></div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data1 = new google.visualization.DataTable();
            data1.addColumn('string', 'Topping');
            data1.addColumn('number', 'Slices');
            data1.addRows([
                @foreach ($cajaMatr->groupBy('prg') as $category => $items)
                    @if ($category !== 1)
                        ['{{ $items->first()->getPrograma()->nombre }}', {{ $items->count() }}],
                    @endif
                @endforeach
            ]);

            // Set chart options
            var options1 = {
                'title': 'Matrículas activas en otros Programas',
                'width': '100%',
                'height': 500
            };

            // Instantiate and draw our chart, passing in some options.
            var chart1 = new google.visualization.PieChart(document.getElementById('chart_div2'));
            chart1.draw(data1, options1);

            var data2 = new google.visualization.DataTable();
            data2.addColumn('string', 'Topping');
            data2.addColumn('number', 'Slices');
            data2.addRows([
                @foreach ($cajaMatr->where('prg', 1)->groupBy('nivel') as $category => $items)
                    ['{{ $semestreNombre[$items->first()->nivel] . ': ' . $items->count() }}',
                        {{ $items->count() }}
                    ],
                @endforeach
            ]);

            // Set chart options
            var options2 = {
                'title': 'Matrículas por Semestre Técnico Lab. Locución',
                'width': '100%',
                'height': 500
            };

            // Instantiate and draw our chart, passing in some options.
            var chart2 = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart2.draw(data2, options2);
        }
    </script>

    <h4>Estudiantes en mora</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Estudiante</th>
                <th scope="col">Pagaré</th>
                <th scope="col">Cuota / Fecha Limite</th>
                <th scope="col">Días</th>
                <th scope="col" style="text-align: right">Deuda</th>
                <th scope="col" style="text-align: right">Mora</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagosAviso as $item)
                    @php
                        $pendientePago = "";
                        $deudaCash = 0;
                        $deudaMora = 0;
                        $losPlazos = explode('|', $item->plan);
                        for ($i=0; $i < count($losPlazos)-1; $i++) { 
                            if (now() > $losPlazos[$i]){
                                if(!$item->pagosHechos()->where('cuota', ($i + 1))->first()){
                                    $pendientePago .= "<div>Cuota ".($i + 1). ": ".$losPlazos[$i]."</div>";
                                    $fechaVence = $losPlazos[$i];
                                    $deudaCash += ($item->valor / $item->cuotas);
                                    $deudaMora += ($item->valor / $item->cuotas) * 0.03;
                                    //
                                    $totalCartera += ($deudaCash + $deudaMora);
                                }
                            }
                        }
                    @endphp

                    @if ($pendientePago !== "")
                        
                    <tr>
                        <td>
                            <a href="{{ route('users.edit', $item->pagEstudiante()->id) }}" style="{{ ($item->matriculaCredito()->estado == 'ACTIVO' ? 'font-weight: bold' : 'color:gray') }}">
                                {{ $item->pagEstudiante()->nombres . ' ' . $item->pagEstudiante()->apellidos }}
                            </a>
                        </td>
                        <td>{{ $item->contratoID }}</td>
                        <td>
                            {!! $pendientePago !!}
                        </td>
                        <td class="text-center">
                            @php
                                $fechaInicio = new DateTime($fechaVence);
                                $fechaActual = new DateTime();
                                $intervalo = $fechaInicio->diff($fechaActual);
                                echo $intervalo->days;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            $ {{ number_format($deudaCash, 0, '', '.') }}
                        </td>
                        <td style="text-align: right">
                            $ {{ number_format($deudaMora, 0, '', '.') }}
                        </td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right; font-size: 20px;">Total Cartera:</td>
                <td colspan="2" style="text-align: right; font-size: 20px;">$ {{ number_format($totalCartera, 0, '', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h4>Generar PDF Backup de notas</h4>
    <form action="{{ route('generadorbckp')}}" class="row" method="POST">
        @csrf
        <div class="col-md-3">
            <select name="year" id="year" class="form-control">
                <option value="">Seleccione año</option>
                @for ($i = date('Y'); $i > 2000; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <select name="periodo" id="periodo" class="form-control">
                @foreach (Session::get('config')['nombrePeriodos'] as $item)
                    <option value="{{ $loop->iteration - 1 }}">{{ $item == '' ? 'Seleccione Periodo' : $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="prg" id="prg" class="form-control">
                <optgroup label="Técnico Laboral">
                    <option value="1">Locución con énfasis en Radio, Presentación de Televisión y Medios Digitales
                    </option>
                </optgroup>
                <optgroup label="Diplomado">
                    <option value="27">En Comunicación Organizacional con énfasis en Jefatura de Prensa</option>
                </optgroup>
                <optgroup label="Certificaciones">
                    <option value="17">Certificación Académica para Locutores Empíricos</option>
                    <option value="18">Certificación Académica en Periodismo con énfasis en Reportería</option>
                    <option value="19">Actualización y Certificación para Egresados Antiguos</option>
                    <option value="20">Homologación Técnica para Egresados en Comunicación de otras instituciones
                    </option>
                    <option value="28">Certificación Técnica como Formadores Talleristas</option>
                    <option value="34">Proceso Técnico de Certificación Académica en Periodismo Deportivo</option>
                </optgroup>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">GENERAR</button>
        </div>
    </form>
@endsection


@section('scripts')
@endsection
