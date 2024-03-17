@php
    $semestreNombre = ['N/A', 'Primer Semestre', 'Segundo Semestre', 'Tercer Semestre', 'Semestre de Profudización Animación Musical y Presentación de Espectáculos', 'Semestre de Profudización Lectura de Noticias y Periodismo Radial', 'Semestre de Profudización Periodismo y Locución Deportiva', 'Semestre de Profudización Locución y Presentación de Televisión', 'Semestre de Profudización Producción y Locución Comercial', 'Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa'];

    $periodos = [];
    $nombrePeriodos = Session::get('config')['nombrePeriodos'];
    for ($i = 2000; $i <= date('Y') + 1; $i++) {
        for ($j = 1; $j < count($nombrePeriodos); $j++) {
            array_push($periodos, ['id' => $i . $j, 'nn' => $i . '(' . $j . ') - ' . $nombrePeriodos[$j]]);
        }
    }
    $estadosMat = ['ACTIVO', 'INACTIVO', 'GRADUADO'];
@endphp

@extends('layouts.admin')

@section('template_title')
    {{ $user->nombres . ' ' . $user->apellidos }} | Perfil INSTEL Virtual
@endsection

@section('content')
    <section class="content container">
        <div class="col-md-12">

            @if ($user->deleted_at)
                <div class="alert alert-danger" role="alert">
                    Este usuario se encuentra <b>deshabilitado. <a href="/restoreUser/{{ $user->id }}">Habilítelo
                            haciendo clic aquí</a></b>
                </div>
            @endif

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <div class="card-title d-flex justify-content-between">
                        <h3>{{ $user->nombres . ' ' . $user->apellidos }}</h3>
                        @canImpersonate($guard = null)
                        @if ($user->rol != 'Inactivo')
                            <a href="{{ route('simulaUsuario', $user->id) }}" class="btn btn-outline-secondary"><i
                                    class="fa-solid fa-repeat"></i> Navegar como {{ $user->nombres }}</a>
                        @endif
                        @endCanImpersonate

                        @if ($user->prg == 1)
                            <div class="row g-3">
                                <div class="col-auto">
                                    <a href="/contrato/{{ $user->id }}/{{ $user->grupo }}" class="btn btn-primary"
                                        href="#" role="button">Generar CSE</a>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}" role="form"
                        enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf

                        @include('user.form')

                    </form>

                    @if ($user->observ !== null)
                        <!-- Si es egresado tiene Acta y Folio -->
                        <div class="alert alert-success" role="alert">
                            {{ $user->observ }}
                        </div>
                        <!-- Si es egresado tiene Acta y Folio -->
                    @endif
                </div>
            </div>
        </div>
    </section>

    <br><br>

    <!-- Módulos Box -->
    <div class="container mb-4">
        <div class="card card-default">
            <div class="card-header text-center">
                <h3 class="card-title">Módulos Asignados</h3>
            </div>

            <!-- Asignación del Modulo -->
            <form method="POST" action="{{ route('asignar-modulo') }}" class="row m-3">
                @csrf
                <input type="hidden" name="docente" value="{{ $user->id }}">
                <div class="col-12">
                    Asignar módulo a {{ $user->nombres }}:
                </div>
                <div class="col-6 mb-3">
                    <select class="form-select form-select-sm" name="elModuloAsig" id="elModuloAsig">
                        @foreach ($modulos as $item)
                            <option value="{{ $item->id }}">{{ $item->titulo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 mb-3">
                    {!! Form::select(
                        'periodo',
                        array_combine(array_column($periodos, 'id'), array_column($periodos, 'nn')),
                        date('Y') . '1',
                        ['class' => 'form-select form-select-sm mb-3', 'id' => 'elGrupoAsig'],
                    ) !!}
                </div>
                <div class="col-3 mb-3">
                    <div class="d-grid gap-2">
                        <button type="submit" name="" id="" class="btn btn-sm btn-success">
                            Asignar Módulo
                        </button>
                    </div>
                </div>
            </form>
            <!-- Fin Asignación del Modulo -->

            <div class="card-body">
                @include('modulo.tabla_asignacion', ['tipo' => 0])
            </div>
        </div>
    </div>
    </div>

    <!-- Sesiones Box -->
    <div class="container mb-4">
        <div class="card card-default">
            <div class="card-header text-center">
                <h3 class="card-title">Gestión en Sesiones Seminarios</h3>
            </div>
            <div class="card-body">
                <h3>Retroalimentación de Sesiones</h3>
                <div class="row">
                    @foreach ($user->sesionesAsignadas()->where('fecha', '<', now())->groupBy(function ($date) {
                return \Carbon\Carbon::parse($date->fecha)->locale('es')->isoFormat('MMMM YYYY');
            })->reverse()->sortBy('fecha') as $mes => $registrosDelMes)
                        <div class="p-2 text-center text-white" style="background-color: #00468C">{{ strtoupper($mes) }}
                        </div>

                        @foreach ($registrosDelMes as $item)
                            <div class="col-md-4 mb-3 p-3 {{ $item->retro == null ? 'bg-danger text-white' : '' }} "
                                style="border: 1px solid #e3e3e3">
                                <b>Seminario: </b> {{ $item->dataSeminar()->programa()->nombre }}<br>
                                <b>Sesión: </b> {{ $item->dataSeminar()->sesionID }}<br>
                                <b>Estudiante: </b>
                                {{ $item->estudiante()->nombres . ' ' . $item->estudiante()->apellidos }}<br>
                                <b>Fecha: </b> {{ $item->fecha }}<br>
                                {{ $item->retro }}
                            </div>
                        @endforeach
                        <hr>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btwToolt"
                onclick="return confirm('¿Desea deshabilitar este usuario?')" data-toggle="tooltip" data-placement="top"><i
                    class="fa fa-fw fa-trash"></i> DESHABILITAR USUARIO</button>
        </form>
        <form action="{{ route('usuadmclave') }}" method="post">
            @csrf
            <input type="hidden" name="idRest" value="{{ $user->id }}">
            <input type="hidden" name="idDoc" value="{{ $user->doc }}">
            <button onclick="return confirm('¿Está seguro(a) de reestablecer la clave a este(a) usuario(a)?')"
                type="submit" name="" id="" class="btn btn-primary">Reestablecer clave para
                {{ $user->nombres }}</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(".pagosTable").DataTable();

    </script>
@endsection
