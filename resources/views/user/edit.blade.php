@php
    $tiposPrueba = [['pruebacomp1', 'Producción y Locución Radial'], ['pruebacomp2', 'Técnica Vocal para Locutores'], ['pruebacomp3', 'Redacción Periodística'], ['pruebacomp4', 'Cultura General y Actualidad Política Nacional e Internacional']];
    $semestreNombre = ['N/A', 'Primer Semestre', 'Segundo Semestre', 'Tercer Semestre', 'Semestre de Profudización Animación Musical y Presentación de Espectáculos', 'Semestre de Profudización Lectura de Noticias y Periodismo Radial', 'Semestre de Profudización Periodismo y Locución Deportiva', 'Semestre de Profudización Locución y Presentación de Televisión', 'Semestre de Profudización Producción y Locución Comercial', 'Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa'];
    $semestreCertf = ['N/A', 'Fase Modular', 'Fase Protocolar'];
    $nSec = '';
    $periodos = [];
    $nombrePeriodos = Session::get('config')['nombrePeriodos'];
    for ($i = 2000; $i <= date('Y') + 1; $i++) {
        for ($j = 1; $j < count($nombrePeriodos); $j++) {
            array_push($periodos, ['id' => $i . $j, 'nn' => $i . $j . ' - ' . $nombrePeriodos[$j]]);
        }
    }
    $estadosMat = ['ACTIVO', 'INACTIVO', 'GRADUADO'];
    $miPeriodoActivo = ($matriculasBox->where('estado','ACTIVO')->first()->periodo ?? '');
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

                        @if ($matriculasBox->where('estado', 'ACTIVO')->count() > 0 && $user->rol == 'Estudiante')
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalId">
                                Generar CSE
                            </button>

                            <!-- Generador de Contrato de Prestación de Servicios Educativos -->
                            <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">Generar Contrato de Prestación de
                                                Servicios Educativos</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                @foreach ($matriculasBox->where('estado', 'ACTIVO') as $optMatr)
                                                    <a href="/contrato/{{ $optMatr->prg }}/{{ $user->id }}"
                                                        class="btn btn-primary col-12 mb-3" role="button">CSE
                                                        {{ $semestreNombre[$optMatr->nivel] }}
                                                        {{ $optMatr->getPrograma()->nombre }}</a>
                                                @endforeach
                                                @foreach ($programas->where('tipo', 'Paquete Seminario') as $optMatr)
                                                    <a href="/contrato/{{ $optMatr->id }}/{{ $user->id }}"
                                                        class="btn btn-primary col-12 mb-3" role="button">CSE
                                                        {{ $optMatr->nombre }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
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

                    @if ($matriculasBox->whereNotNull('fechaEgreso')->where('prg', 1)->count() > 0)
                        <!-- Si es egresado tiene Acta y Folio -->
                        <div class="alert alert-success text-center" role="alert">
                            Estudiante egresado del <b>Programa Técnico Laboral en
                                Locución con énfasis en Radio, Presentación de Televisión y Medios Digitales</b>.<br>
                            <div class="row">
                                <div class="col-4">
                                    Fecha de Grado: <span class="forFecha" dt-fmt="0"
                                        dt-f="{{ $matriculasBox->whereNotNull('fechaEgreso')->where('prg', 1)->first()->fechaEgreso }}"></span>
                                </div>
                                <div class="col-4">
                                    Acta: {{ $matriculasBox->whereNotNull('fechaEgreso')->where('prg', 1)->first()->acta }}
                                </div>
                                <div class="col-4">
                                    Folio:
                                    {{ $matriculasBox->whereNotNull('fechaEgreso')->where('prg', 1)->first()->folio }}
                                </div>
                            </div>
                        </div>
                        <!-- Si es egresado tiene Acta y Folio -->
                    @endif

                    <hr>
                    <h5>Documentos Estudiante</h5>
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <form action="{{ route('ProfilePic.delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="file" value="{{ $user->cod }}">
                                <button type="submit" class="btn btn-info btn-sm"
                                    onclick="return confirm('¿Desea rechazar la foto de carné del estudiante?')">
                                    <i class="fa-regular fa-circle-xmark"></i> Rechazar Foto de Perfil</button>
                            </form>
                        </div>

                        @foreach ($user->misDocumentos()->get() as $itemDoc)
                            <div class="col-md-3 text-center">
                                <form action="{{ route('docMatr.delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="file" value="{{ $itemDoc->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Desea eliminar el documento {{ $itemDoc->descr }}?')"><i
                                            class="fa fa-fw fa-trash"></i> Eliminar</button>
                                </form>
                                <br>
                                @if (strpos($itemDoc->descr, '|') !== false)
                                    <a href="{{ route('verCertificado', $itemDoc->file) }}" target="_blank">
                                        @if (strpos($itemDoc->descr, 'pruebacomp') !== false)
                                            Resultado Prueba {{ explode('|', $itemDoc->descr)[9] }}
                                        @else
                                            Certificado {{ explode('|', $itemDoc->descr)[0] }}
                                        @endif
                                    </a>
                                @else
                                    <a href="{{ route('ft', 'profiles|' . $itemDoc->file) }}" target="_blank">Ver
                                        Archivo
                                        {{ $itemDoc->descr }}</a>
                                @endif
                            </div>
                        @endforeach

                        <div class="col-md-3 text-center">
                            <form action="{{ route('estudiantedocs') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="" class="form-label">Tipo Documento</label>
                                    <select class="form-select" name="fileName1" id="">
                                        <option value="Documento de Identidad">Documento de Identidad</option>
                                        <option value="Diploma de Grado">Diploma de Grado</option>
                                        <option value="Acta de Grado">Acta de Grado</option>
                                        <option value="Experiencia en Medios">Experiencia en Medios</option>
                                        <option value="CSE {{ substr($user->cod, -4) . '-' . $miPeriodoActivo }} Firmado">
                                            CSE
                                            {{ substr($user->cod, -4) . '-' . $miPeriodoActivo }} Firmado</option>
                                        <option value="Pagaré {{ substr($user->cod, -4) . '-' . $miPeriodoActivo }} Firmado">
                                            Pagaré {{ substr($user->cod, -4) . '-' . $miPeriodoActivo }} Firmado</option>
                                    </select>
                                </div>
                                <input type="file" class="form-control cargaDocFl" name="file1" accept=".pdf"
                                    id="">
                                <input type="hidden" name="persona" value="{{ $user->id }}">
                            </form>
                        </div>

                        <!-- CERTIFICADOS DE SEMINARIO -->
                        <hr style="margin-top: 20px">
                        <h5>Generador de Certificados</h5>
                        <div class="row">
                            <div class="col-2 text-center">
                                <button onclick="addRegistroAcademico()" class="btn col-12 btn-sm btn-warning">Registro
                                    Académico</button>
                            </div>
                            <div class="col-2 text-center">
                                <a href="{{ route('addCNotas', '1-' . $user->id) }}" target="_blank"
                                    onclick="return confirm('¿Desea crear un certificado de notas simple de este usuario?')"
                                    class="btn col-12 btn-sm btn-success">Cert. Estudios Simple</a>
                            </div>
                            <div class="col-2 text-center">
                                <a href="{{ route('addCNotas', '2-' . $user->id) }}" target="_blank"
                                    onclick="return confirm('¿Desea crear un certificado de notas completo de este usuario?')"
                                    class="btn col-12 btn-sm btn-success">Cert. Notas</a>
                            </div>
                            <div class="col-2 text-center">
                                <a href="{{ route('addCNotas', '3-' . $user->id) }}" target="_blank"
                                    onclick="return confirm('¿Desea crear un certificado con contenido programático de este usuario?')"
                                    class="btn col-12 btn-sm btn-success">Cert. Notas UNAD</a>
                            </div>
                            <div class="col-2 text-center">
                                <button type="button" class="btn col-12 btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalPruebasCert">
                                    Informe pruebas
                                </button>

                                <div class="modal fade" id="modalPruebasCert" tabindex="-1" data-bs-backdrop="static"
                                    data-bs-keyboard="false" role="dialog" aria-labelledby="tituloPruebasCert"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                                        role="document">
                                        <form action="{{ route('crearPruebasAptitud') }}" method="POST"
                                            class="modal-content">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="tituloPruebasCert">INFORME DE RESULTADOS DE
                                                    PRUEBAS DE APTITUD Y COMPETENCIAS</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body row">
                                                <input type="hidden" name="user" value="{{ $user->id }}">
                                                <input type="hidden" name="prueba9" id="nombrePrueba">
                                                <div class="col-8">
                                                    {!! Form::label('tipoPrueba', 'Tipo de Prueba a generar') !!}
                                                    <select class="form-select mb-3" name="prueba0"
                                                        onchange="getNombrePrueba(this)" id="tipoPrueba" required>
                                                        <option value="">Seleccione</option>
                                                        @foreach ($tiposPrueba as $item)
                                                            <option value="{{ $item[0] }}">{{ $item[1] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-4">
                                                    {!! Form::label('fecha', 'Fecha Evaluación') !!}
                                                    <input type="date" class="form-control" name="prueba2" required>
                                                </div>

                                                <div class="col-4">
                                                    {!! Form::label('cohorte', 'Cohorte') !!}
                                                    {!! Form::select(
                                                        'prueba1',
                                                        array_combine(array_column($periodos, 'id'), array_column($periodos, 'nn')),
                                                        date('Y') . '1',
                                                        ['class' => 'form-control mb-3'],
                                                    ) !!}
                                                </div>

                                                <div class="col-4">
                                                    {!! Form::label('faseModular', 'Cohorte Fase Modular') !!}
                                                    <select class="form-select mb-3" name="prueba3" required>
                                                        <option value="">Seleccione</option>
                                                        <option value="ENERO A JUNIO {{ date('Y') }}">ENERO A JUNIO
                                                            {{ date('Y') }}</option>
                                                        <option value="MARZO A AGOSTO {{ date('Y') }}">MARZO A AGOSTO
                                                            {{ date('Y') }}</option>
                                                        <option value="JULIO A DICIEMBRE {{ date('Y') }}">JULIO A
                                                            DICIEMBRE {{ date('Y') }}</option>
                                                        <option
                                                            value="SEPTIEMBRE {{ date('Y') }} A FEBRERO {{ date('Y') + 1 }}">
                                                            SEPTIEMBRE {{ date('Y') }} A FEBRERO {{ date('Y') + 1 }}
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-4">
                                                    {!! Form::label('faseprotocolar', 'Cohorte Fase Protocolar') !!}
                                                    <select class="form-select mb-3" name="prueba4" required>
                                                        <option value="">Seleccione</option>
                                                        <option value="ENERO A JUNIO {{ date('Y') }}">ENERO A JUNIO
                                                            {{ date('Y') }}</option>
                                                        <option value="MARZO A AGOSTO {{ date('Y') }}">MARZO A AGOSTO
                                                            {{ date('Y') }}</option>
                                                        <option value="JULIO A DICIEMBRE {{ date('Y') }}">JULIO A
                                                            DICIEMBRE {{ date('Y') }}</option>
                                                        <option
                                                            value="SEPTIEMBRE {{ date('Y') }} A FEBRERO {{ date('Y') + 1 }}">
                                                            SEPTIEMBRE {{ date('Y') }} A FEBRERO {{ date('Y') + 1 }}
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-4">
                                                    {!! Form::label('fecha2', 'Fecha Calificación') !!}
                                                    <input type="date" class="form-control" name="prueba5" required>
                                                </div>

                                                <div class="col-2">
                                                    {!! Form::label('ponderado', '% Ponderado') !!}
                                                    <input type="number" class="form-control" name="prueba6" required>
                                                </div>

                                                <div class="col-6">
                                                    {!! Form::label('docente', 'Docente Evaluador') !!}
                                                    <input type="text" class="form-control" name="prueba7" required>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <label for="concepto" class="form-label">Juicio Jurado
                                                        Evaluador</label>
                                                    <textarea class="form-control" name="prueba8" id="" rows="8"></textarea>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Crear</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <br><br>

    <!-- Matrículas Box -->
    <div class="container" style="margin-bottom: 30px" id="matriculasEstudianteLista">
        <div class="card card-default">
            <div class="card-header">
                <span class="card-title card-title d-flex justify-content-between">
                    <h3>Matrículas Estudiante</h3>
                    <!-- Modal trigger button -->
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalAddMatr">
                        Nueva Matrícula
                    </button>
                </span>


                <!-- Modal Body -->
                <div class="modal fade" id="modalAddMatr" tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <form action="{{ route('matriculasbox.store') }}" method="post">
                        @csrf
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitleId">Matricular a {{ $user->nombres }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {!! Form::label('prg', 'Programa a matricular:') !!}
                                    <select name="prg" id="prg" class="form-control mb-3"
                                        onchange="optPrg(this)">
                                        @foreach ($programas as $item)
                                            @if ($nSec != $item->tipo)
                                                </optgroup>
                                                <optgroup label="{{ $item->tipo }}">
                                            @endif
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                            @php $nSec = $item->tipo; @endphp
                                        @endforeach
                                    </select>
                                    {!! Form::label('nivel', 'Semestre:') !!}
                                    {!! Form::select('nivel', $semestreNombre, null, ['class' => 'form-control mb-3']) !!}
                                    {!! Form::label('fechaIngreso', 'Fecha de Inicio:') !!}
                                    {!! Form::date('fechaIngreso', now(), ['class' => 'form-control mb-3']) !!}
                                    {!! Form::label('periodo', 'Periodo:') !!}
                                    {!! Form::select(
                                        'periodo',
                                        array_combine(array_column($periodos, 'id'), array_column($periodos, 'nn')),
                                        date('Y') . '1',
                                        ['class' => 'form-control mb-3'],
                                    ) !!}
                                    {!! Form::label('estado', 'Estado de Matrícula:') !!}
                                    {!! Form::select('estado', array_combine($estadosMat, $estadosMat), null, ['class' => 'form-control mb-3']) !!}
                                    <input type="hidden" name="user" value="{{ $user->id }}">
                                    <input type="hidden" name="otros" value="{{ Auth::user()->nombres }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row" style="font-size: 12px">
                @php
                    for ($a = 1; $a < count($semestreNombre); $a++) {
                        if ($matriculas->where('sem', $a)->count() > 0) {
                            echo '<div class="col-3">' . $semestreNombre[$a] . ': ' . $matriculas->where('sem', $a)->count() . ' módulos</div>';
                        } else {
                            echo '<div class="col-3 text-white bg-danger text-center"">' . $semestreNombre[$a] . ' sin notas </div>';
                        }
                    }
                @endphp
            </div>
            <div class="row" style="font-size: 12px">
                Seminarios:
                @php $tc = ""; @endphp
                @foreach ($user->misSesiones()->groupBy('seminarID') as $listaSemin)
                    @if (
                        $tc !==
                            $listaSemin->first()->dataSeminar()->programa()->nombre)
                        {{ $listaSemin->first()->dataSeminar()->programa()->nombre }} - {{ $listaSemin->first()->fecha }}
                    @endif
                    @php
                        $tc = $listaSemin
                            ->first()
                            ->dataSeminar()
                            ->programa()->nombre;
                    @endphp
                @endforeach
            </div>

            <div class="card-body row">
                @foreach ($matriculasBox as $matriCaja)
                    @php $listaIDMatricula = ""; @endphp
                    <div class="col-md-6 p-3" style="border: 1px solid #e3eff8">
                        <table class="table">
                            @if ($matriCaja->getPrograma()->tipo == 'Seminario-Taller')
                                <thead>
                                    <tr>
                                        <td colspan="4" style="font-size:12px">
                                            <b>ID Matrícula: </b>{{ $matriCaja->id }}<br>
                                            <b>Programa: </b>{{ $matriCaja->getPrograma()->nombre }}<br>
                                            <b>Inicio: </b>{{ $matriCaja->fechaIngreso }} <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col" style="width:100px">Fecha</th>
                                        <th scope="col">Sesión</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matriCaja->getSesiones() as $idSesion)
                                        @if ($idSesion->dataSeminar()->prg == $matriCaja->prg)
                                            <tr style="font-size: 12px">
                                                <td>
                                                    {{ $idSesion->fecha }}
                                                </td>
                                                <td scope="row">
                                                    <a href="#matriculasEstudianteLista"
                                                        onclick="openSesionEdit({{ $idSesion->id }})">
                                                        {{ $idSesion->dataSeminar()->sesionID }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {!! $idSesion->retro == null
                                                        ? '<i class="fa-regular fa-clock"></i>'
                                                        : '<i class="fa-solid fa-circle-check"></i>' !!}
                                                </td>
                                            </tr>
                                            @php
                                                $listaIDMatricula .= $idSesion->id . '|';
                                            @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            @else
                                <thead>
                                    <tr>
                                        <td colspan="4" style="font-size:12px">
                                            <b>ID Matrícula: </b>{{ $matriCaja->id }}<br>
                                            <b>Programa: </b>{{ $matriCaja->getPrograma()->nombre }}<br>
                                            <b>Periodo:
                                            </b>{{ substr($matriCaja->periodo, 0, 4) . ' ' . $nombrePeriodos[substr($matriCaja->periodo, -1)] }}
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col">
                                            {{ $matriCaja->getPrograma()->tipo == 'Certificaciones' ? $semestreCertf[$matriCaja->nivel] : $semestreNombre[$matriCaja->nivel] }}
                                        </th>
                                        <th scope="col">Nota</th>
                                        <th scope="col" colspan="2">
                                            <button class="btn btn-warning btn-sm"
                                                onclick="agregarModulo({{ $matriCaja->nivel }}, {{ $matriCaja->periodo }},{{ $matriCaja->id }})">+
                                                Módulo</button>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($matriculas->where('sem', $matriCaja->nivel) as $item)
                                        @if (($item->modulos_s()->first()->programa ?? 1) == $matriCaja->prg)
                                            <tr style="font-size: 12px">
                                                <td scope="row">
                                                    <a
                                                        href="{{ $item->materia == null ? '#' : route('modulos.edit', $item->materia) }}">
                                                        {{ $item->n_materia }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="btNota {{ $item->hab == null ? ($item->def < 3.5 ? 'nPerdida' : ($item->def > 4.5 ? 'nAprobada' : 'nExcelente')) : 'nRecuperada' }}"
                                                        data-nota="{{ $item->n1 . '|' . $item->n2 . '|' . $item->n3 . '|' . $item->def . '|' . $item->hab . '|' . $item->rem . '|' . $item->id . '|' . $item->sem }}">
                                                        {{ $item->def == null ? 'SN' : ($item->hab == null ? $item->def : $item->hab) }}
                                                    </div>
                                                </td>
                                                <td>{{ $item->resultado }}</td>
                                                <td>
                                                    <form action="{{ route('matriculas.destroy', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('¿Desea cancelar este modulo en este usuario?')"><i
                                                                class="fa fa-fw fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @php $listaIDMatricula .= $item->id."|"; @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            @endif

                        </table>
                        <div class="row">
                            <form class="col-md-4" action="{{ route('matriculasbox.destroy', $matriCaja->id) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="tipo" value="0">
                                <button onclick="return confirm('¿Desea eliminar esta matrícula del usuario?')"
                                    type="submit" class="btn btn-outline-danger btn-sm">Eliminar Solo la
                                    Matrícula</button>
                            </form>
                            <button
                                class="col-md-4 btn-sm btn btn-{{ $matriCaja->estado == 'ACTIVO' ? 'primary' : ($matriCaja->estado == 'INACTIVO' ? 'secondary' : 'success') }}"
                                data-mtr="{{ $matriCaja }}" onclick="editarMatBox(this)"
                                data-tp="{{ $matriCaja->getPrograma()->tipo }}"
                                data-cont="{{ $listaIDMatricula }}">EDITAR ({{ $matriCaja->estado }})</button>
                            <form class="col-md-4" action="{{ route('matriculasbox.destroy', $matriCaja->id) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="tipo" value="{{ $matriCaja->getPrograma()->tipo }}">
                                <input type="hidden" name="losID" value="{{ $listaIDMatricula }}">
                                <button
                                    onclick="return confirm('Se eliminará la matrícula y los módulos contenidos en él igual que las notas. Esta acción no puede reversarse ¿Está seguro(a)?')"
                                    type="submit" class="btn btn-outline-danger btn-sm">Eliminar Matrícula y
                                    Contenido</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End Matrículas Box -->

    <!-- Información Académica -->

    @if ($user->rol !== 'Docente' || 'Administrador')
        <!-- Técnico Laboral & Certificación Diplomado -->
        <div class="container" id="userFinanciero">

            <div class="card card-default" style="margin-top: 20px">
                <div class="card-header">
                    <div class="card-title d-flex justify-content-between">
                        <h3>Información Financiera</h3>
                        <button type="button" class="btn btn-primary btn-sm" onclick="editPagare(this,0)"
                            {{ $matriculasBox->where('estado', 'ACTIVO')->count() == 0 ? 'disabled' : '' }}>
                            Agregar Financiamiento
                        </button>
                    </div>


                </div>

                <div class="card-body">
                    <div class="row mb-4">

                        @isset($deuda)
                            @include('estudiante.boxDeuda')
                            <!-- END OTRA DEUDA -->
                        @endisset
                    </div>

                    <table class="table table-striped pagosTable">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Concepto</th>
                                <th scope="col">Pagare</th>
                                <th scope="col">Valor</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($financiero as $item)
                                <tr>
                                    <td>
                                        <div class="d-grid gap-2">
                                            <button onclick="pago({{ $item->user }},{{ $item->idRecibo }})"
                                                data-pr="{{ $item->persona()->first()['nombres'] . ' ' . $item->persona()->first()['apellidos'] }}"
                                                data-dc="{{ $item->persona()->first()['doc'] }}"
                                                data-fx="{{ $item }}" class="btn btn-success"><i
                                                    class="fa-solid fa-arrows-rotate"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <button onclick="verContratoSE('{{ $item->idRecibo }}','recibo')"
                                            class="btn btn-info" href="#" role="button">
                                            <i class="fa-solid fa-file-invoice"></i>
                                        </button>
                                    </td>
                                    <th scope="row" style="width: 13%">{{ $item->fecha }}<BR>{{ $item->idRecibo }}
                                    </th>
                                    <td>{{ $item->concept }}<br>{{ $item->observ }}</td>
                                    <td>{{ $item->pagareID }}</td>
                                    <td>{{ number_format($item->valor, 0, '', '.') }}</td>
                                    <td>
                                        <form action="{{ route('pago.del', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Desea eliminar este pago del usuario?')"><i
                                                    class="fa fa-fw fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="card card-default" style="margin-top: 20px">
                <div class="card-header">
                    <div class="card-title d-flex justify-content-between">
                        <h3>Entregas Estudiante</h3>
                    </div>
                </div>

                <div class="card-body">

                    <table class="table table-striped table-hover pagosTable" id="entregasTable">
                        <thead class="thead">
                            <tr>
                                <th>Fecha</th>
                                <th>Modulo</th>
                                <th>Actividad</th>
                                <th>Tipo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->misEntregas()->get() as $entrega)
                                @php
                                    $datoEntrega = $entrega->tarea()->first()->tipo_rta == 'link|' ? $entrega->link : ($entrega->tarea()->first()->tipo_rta == 'texto|' ? $entrega->respuesta : ($entrega->tarea()->first()->tipo_rta == 'pdf|' ? route('ft', 'entregas|pdf|' . $entrega->idUnico . '.pdf') : route('ft', 'entregas|audio|' . $entrega->idUnico . '.mp3')));
                                    $datoPos = $entrega->tarea()->first()->tipo_rta == 'link|' ? 0 : ($entrega->tarea()->first()->tipo_rta == 'texto|' ? 1 : ($entrega->tarea()->first()->tipo_rta == 'pdf|' ? 0 : 2));
                                @endphp
                                <tr>
                                    <td>{{ $entrega->created_at }}</td>
                                    <td>{{ $entrega->modulo()->first()->titulo }}</td>
                                    <td>{{ $entrega->tarea()->first()->enunciado }}</td>
                                    <td>
                                        <button data-fx="{{ $entrega->id }}" data-rt="" type="button"
                                            class="btn btn-warning" onclick="verEntrega(this, {{ $user->id }})"><i
                                                class="fa-regular fa-eye"></i> Ver Entrega</button>
                                    </td>
                                    <td>
                                        <form action="{{ route('entr.destroy', $entrega->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Desea eliminar y volver a activar esta entrega?')"><i
                                                    class="fa fa-fw fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form method="POST" action="" id="revTarea" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="_method" class="act_metodo" value="">
                        @csrf
                        <div class="modal fade" id="revisaTarea" tabindex="-1" role="dialog"
                            aria-labelledby="boxRecursoLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tareaTT">Revisar entrega</h5>
                                        <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="entregaData"></div>
                                        <input type="hidden" name="notaAutoEv" id="notaAutoEv">
                                    </div>

                                    <div class="modal-footer revisionFooter">
                                        <button type="button" class="btn btn-secondary cerrarModal"
                                            data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if ($user->rol == "Estudiante")
                

            <div class="card card-default" style="margin-top: 20px">
                <div class="card-header">
                    <span class="card-title">
                        <h3>Información SIET</h3>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-3">
                                    Estado Civil<br>
                                    <b>{{ $user->dataSiet->estadoCivil }}</b>
                                </div>

                                <div class="col-md-3">
                                    Tipo Sangre<br>
                                    <b>{{ $user->dataSiet->tipoSangre }}</b>
                                </div>

                                <div class="col-md-3">
                                    Nivel Educación<br>
                                    <b>{{ $user->dataSiet->nivelFormacion }}</b>
                                </div>

                                <div class="col-md-3">
                                    Ocupacion<br>
                                    <b>{{ $user->dataSiet->ocupacion }}</b>
                                </div>

                                <div class="col-md-3">
                                    Discapacidad<br>
                                    <b>{{ $user->dataSiet->discapacidad }}</b>
                                </div>

                                <div class="col-md-3">
                                    Transporte<br>
                                    <b>{{ $user->dataSiet->transporte }}</b>
                                </div>

                                <div class="col-md-3">
                                    Grupos especiales:<br>
                                    <b>{{ $user->dataSiet->multicult }}</b>
                                </div>

                                <div class="col-md-3">
                                    Lugar Nacimiento<br>
                                    <b>{{ $user->dataSiet->lugarNace }}</b>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row justify-content-md-center">
                        <div class="col-md-2">
                            <h5>Residencia</h5>
                        </div>
                        <div class="col-md-10">
                            <div class="row">

                                <div class="col-md-3">
                                    País<br>
                                    <b>{{ $user->dataSiet->pais }}</b>
                                </div>

                                <div class="col-md-3">
                                    Estado/Departamento<br>
                                    <b>{{ $user->dataSiet->estado }}</b>
                                </div>

                                <div class="col-md-3">
                                    Ciudad<br>
                                    <b>{{ $user->dataSiet->ciudad }}</b>
                                </div>

                                <div class="col-md-3">
                                    Barrio<br>
                                    <b>{{ $user->dataSiet->barrio }}</b>
                                </div>

                                <div class="col-md-6">
                                    Dirección Residencia<br>
                                    <b>{{ $user->dataSiet->direccion }}</b>
                                </div>

                                <div class="col-md-3">
                                    Estrato<br>
                                    <b>{{ $user->dataSiet->estrato }}</b>
                                </div>

                                <div class="col-md-3">
                                    Zona<br>
                                    <b>{{ $user->dataSiet->zona }}</b>
                                </div>

                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row justify-content-md-center">
                        <div class="col-md-2">
                            <h5>Datos de Seguridad Social</h5>
                        </div>
                        <div class="col-md-10">
                            <div class="row align-items-end">

                                <div class="col-md-3">
                                    Entidad Promotora de Salud - EPS<br>
                                    <b>{{ $user->dataSiet->eps }}</b>
                                </div>

                                <div class="col-md-3">
                                    Administradora de Régimen Subsidiado - ARS<br>
                                    <b>{{ $user->dataSiet->ars }}</b>
                                </div>

                                <div class="col-md-3">
                                    Aseguradora<br>
                                    <b>{{ $user->dataSiet->aseguradora }}</b>
                                </div>

                                <div class="col-md-3">
                                    Nivel SISBÉN<br>
                                    <b>{{ $user->dataSiet->sisben }}</b>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            @endif



        </div>


        <!-- Ver Recibo -->
        <div class="modal fade" id="verPagareM" tabindex="-1" aria-labelledby="verPagareMLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe id="printRec" name="printf" src="" width="100%" height="600"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger" id="imprimirContrato">Imprimir</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="d-flex justify-content-between">

        <div></div>

        <form action="{{ route('usuadmclave') }}" method="post">
            @csrf
            <input type="hidden" name="idRest" value="{{ $user->id }}">
            <input type="hidden" name="idDoc" value="{{ $user->doc }}">
            <button onclick="return confirm('¿Está seguro(a) de reestablecer la clave a este(a) usuario(a)?')"
                type="submit" name="" id="" class="btn btn-primary">Reestablecer clave para
                {{ $user->nombres }}</button>
    </div>
    </form>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">INSTEL Virtual</strong>
                <small>Acción realizada</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body"></div>
        </div>
    </div>

    <div class="modal fade" id="boxPagoEdit" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body boxPagoEdit">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para cambiar nota estudiante -->
    <form action="{{ route('editaNota') }}" method="POST" class="modal fade" id="editarNota" tabindex="-1"
        role="dialog" aria-labelledby="editarNotaTT" aria-hidden="true">
        @csrf
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarNotaTT">Editar Nota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body row">
                    <div class="col-2 mb-3">
                        <label for="" class="form-label">P. 1</label>
                        <input type="text" class="form-control notaEditFF" name="n1" id="vnt_1"
                            step="0.1" min="0" max="5">
                    </div>
                    <div class="col-2 mb-3">
                        <label for="" class="form-label">P. 2</label>
                        <input type="text" class="form-control notaEditFF" name="n2" id="vnt_2"
                            step="0.1" min="0" max="5">
                    </div>
                    <div class="col-2 mb-3">
                        <label for="" class="form-label">P. Final</label>
                        <input type="text" class="form-control notaEditFF" name="n3" id="vnt_3"
                            step="0.1" min="0" max="5">
                    </div>
                    <div class="col-2 mb-3">
                        <label for="" class="form-label">Def.</label>
                        <input type="text" class="form-control notaEditFF" name="def" id="vnt_4"
                            step="0.1" min="0" max="5">
                    </div>
                    <div class="col-2 mb-3">
                        <label for="" class="form-label">Recup.</label>
                        <input type="text" class="form-control notaEditFF" name="hab" id="vnt_5"
                            step="0.1" min="0" max="5"z>
                    </div>
                    <div class="col-2 mb-3">
                        <label for="" class="form-label">Repos.</label>
                        <input type="text" class="form-control notaEditFF" name="rem" id="vnt_6">
                    </div>
                    <div class="col-6 mb-3">
                        <label for="" class="form-label">Resultado:</label>
                        <input type="text" class="form-control" name="resultado" id="resultadoNota">
                    </div>
                    <div class="col-6 mb-3">
                        <label for="" class="form-label">Semestre:</label>
                        <select name="sem" id="semestreNota" class="form-control">
                            @foreach ($semestreNombre as $itemSemNt)
                                <option value="{{ $loop->iteration - 1 }}">{{ $itemSemNt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="hidden" name="idMatr" id="idMatr">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('matriculasbox.update', 1) }}" method="POST" class="modal fade" id="editarMatBox"
        tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        @csrf
        @method('PATCH')
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Editar Matrícula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body row">
                    <div class="col-md-12">
                        {!! Form::label('periodo_ed', 'Periodo:') !!}
                        {!! Form::select(
                            'periodo_ed',
                            array_combine(array_column($periodos, 'id'), array_column($periodos, 'nn')),
                            null,
                            ['class' => 'form-control mb-3'],
                        ) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::label('estado_ed', 'Estado de Matrícula:') !!}
                        {!! Form::select('estado_ed', array_combine($estadosMat, $estadosMat), null, ['class' => 'form-control mb-3']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::label('fechaEgreso', 'Fecha de Egreso:') !!}
                        {!! Form::date('fechaEgreso', null, ['class' => 'form-control mb-3']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::label('acta', 'Acta:') !!}
                        {!! Form::text('acta', null, ['class' => 'form-control mb-3']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::label('folio', 'Folio:') !!}
                        {!! Form::text('folio', null, ['class' => 'form-control mb-3']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('especial', 'Certificación extra:') !!}
                        {!! Form::select('especial', ['Ninguna', 'EuropaCampus Cert. Internacional'], null, ['class' => 'form-control mb-3']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="tipoPrgMat" name="tipoPrgMat" value="">
                    <input type="hidden" id="contenidoMat" name="contenidoMat" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="editaSesion" tabindex="-1" role="dialog" aria-labelledby="tteditaSesion"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Editar Sesión de Seminario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="seminarioEditForm">
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Financiamiento -->
    <form method="POST" action="" class="modal fade" id="pagareForm" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTT" aria-hidden="true">
        @csrf
        <input type="hidden" name="_method" value="" id="cs_method">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTT"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user" class="idUser" value="{{ $user->id }}">
                    <small id="helpId" class="form-text text-muted">Programa a financiar:</small>
                    <!-- No me recibe el Select -->
                    <input type="hidden" name="creditoMatr" id="creditoID">
                    <select id="creditoMatr" onchange="generarIDPag()" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach ($matriculasBox->where('estado', 'ACTIVO') as $optMatr)
                            <option value="{{ $optMatr->id }}" ciclo="{{ $optMatr->periodo }}"
                                valor="{{ $optMatr->getPrograma()->v_total }}"
                                cuotas="{{ $optMatr->getPrograma()->n_pagos }}"
                                tipoProg="{{ $optMatr->getPrograma()->tipo }}">{{ $optMatr->periodo }} -
                                {{ $semestreNombre[$optMatr->nivel] }} {{ $optMatr->getPrograma()->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="avisoPagCr"></div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="text-center">Tomador</h5>
                            @php
                                $inputTomador = [['Nombre Completo', 'nombre', $user->nombres . ' ' . $user->apellidos], ['Documento de identidad', 'documento', $user->doc], ['Expedición Documento', 'doc_ex', $user->doc_ex], ['Dirección', 'direccion', $user->dataSiet->direccion], ['Ciudad', 'ciudad', $user->dataSiet->ciudad], ['Barrio', 'barrio', $user->dataSiet->barrio], ['Teléfono', 'telefono', $user->telefono]];
                            @endphp
                            @foreach ($inputTomador as $itemForm)
                                <small id="helpId" class="form-text text-muted">{{ $itemForm[0] }}</small>
                                {{ Form::text('t_' . $itemForm[1], $itemForm[2], ['id' => 't_' . $itemForm[1], 'class' => 'form-control']) }}
                            @endforeach
                        </div>

                        <div class="col-md-4">
                            <h5 class="text-center">Avalista / Co-Deudor</h5>
                            @foreach ($inputTomador as $itemForm)
                                <small id="helpId" class="form-text text-muted">{{ $itemForm[0] }}</small>
                                {{ Form::text('c_' . $itemForm[1], null, ['id' => 'c_' . $itemForm[1], 'class' => 'form-control elCodeudor']) }}
                            @endforeach
                        </div>

                        <div class="col-md-4">
                            <h5 class="text-center">Crédito</h5>
                            <input type="hidden" class="form-control contratoID" disabled>
                            <input type="hidden" class="contratoID" name="contratoID" value="">
                            <input type="hidden" name="cicloAc" id="cicloAc">

                            <div class="col-12">
                                <small id="helpId" class="form-text text-muted">Valor $</small>
                                <input type="number" class="form-control" id="pagare_valor" name="valor"
                                    required="">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <small id="helpId" class="form-text text-muted"># Cuotas</small>
                                    <input type="number" class="form-control" name="cuotas" id="pCuotas"
                                        onchange="generarFechasPago()" required="">
                                </div>
                                <div class="col-12">
                                    <small id="helpId" class="form-text text-muted">Fecha Pagaré</small>
                                    <input type="date" class="form-control" name="fecha" id="pFecha"
                                        value="{{ now()->format('Y-m-d') }}" onchange="generarFechasPago()"
                                        required="">
                                </div>
                                <div class="col-12 listaPagos">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="modalAddMt" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTTmtAdd" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTTmtAdd">Asignar Módulos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-hover" id="listaModulos">
                        <thead class="thead">
                            <tr>
                                <th></th>
                                <th>Módulo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modulos as $modulo)
                                <tr class="selectMateria" data="{{ $modulo->id }}">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input checkmodulo" type="checkbox"
                                                value="{{ $modulo->id }}" id="ff_{{ $modulo->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        {{ $modulo->titulo }}
                                        <div style="font-size:11px; color:rgb(140, 140, 140)">
                                            <b>{{ explode('|', $modulo->programas->estructura)[$modulo->ciclo] }}</b><br>
                                            {{ $modulo->programas->tipo . ' ' . $modulo->programas->nombre }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form method="POST" action="{{ route('matriculas.store') }}" role="form"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="elBox" id="elBox">
                        <input type="hidden" name="semestre" id="semestreModuloAdd">
                        <input type="hidden" name="matriculaMasiva" id="matriculaMasiva">
                        <input type="hidden" name="estudiante" value="{{ $user->id }}">
                        <input type="hidden" name="grupo" id="grupoMasiva" value="{{ $user->grupo }}">
                        <br>
                        <button type="submit" class="btn btn-primary col-12" type="button">Matricular</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <form action="{{ route('addRegistroAc', $user->id) }}" class="modal fade" id="modalRegistroAc" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-hidden="true" id="laboral-form" method="POST">
        @csrf
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Generar Registro Académico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">Institución educ. donde se graduó</div>
                        <div class="col-8">
                            <input type="text" name="gradoAnt" class="form-control" id="">
                        </div>
                    </div>
                    <div class="m-3">
                        Indique a continuación la experiencia laboral del egresado <b>iniciando con la práctica realizada en INSTEL</b>
                    </div>
                        <div id="experiences">
                            <div class="experience row mt-3 mb-3" style="border-top: 1px solid #000">
                                <div class="col-8">
                                    <label for="empresa">Empresa:</label>
                                    <input type="text" class="form-control" name="empresa[]" required>
                                </div>
                                <div class="col-4">
                                    <label for="tipo-experiencia">Tipo de Experiencia:</label>
                                    <select class="form-control" name="tipo_experiencia[]">
                                        <option value="laboral">Laboral</option>
                                        <option value="practica">Práctica</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="telefono">Teléfono:</label>
                                    <input type="text" class="form-control" name="telefono" required>
                                </div>
                                <div class="col-6">
                                    <label for="tiempo-labor">Tiempo Laborado:</label>
                                    <input type="text" class="form-control" name="tiempo_labor[]" required>
                                </div>
                                <div class="col-10">
                                    <label for="labores-realizadas">Labores Realizadas:</label>
                                    <textarea class="form-control" name="labores_realizadas[]" rows="3"></textarea>
                                </div>
                                <div class="col-2 d-flex align-items-center">
                                    <button class="btn btn-danger btn-sm" type="button" onclick="removeExperience(this)">Eliminar</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="addExperience()">+ Experiencia</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Generar</button>
                </div>
            </div>
        </div>
    </form>



@endsection

@section('scripts')
    <script>
        let tipoProgSeleccionado = ""
        let plazos = "";

        function editarMatBox(ff) {
            const datos = $(ff).attr('data-mtr');
            const obj = JSON.parse(datos);
            $('#periodo_ed').val(obj.periodo)
            $('#estado_ed').val(obj.estado)
            $('#fechaEgreso').val(obj.fechaEgreso)
            $('#folio').val(obj.folio)
            $('#acta').val(obj.acta)
            $('#tipoPrgMat').val($(ff).attr('data-tp'))
            $('#contenidoMat').val($(ff).attr('data-cont'))
            $('#editarMatBox').attr('action', '/matriculasbox/' + obj.id);
            $('#editarMatBox').modal('show');
            console.log(obj);
        }

        $('.btNota').click(function() {
            let dat = ($(this).attr('data-nota')).split('|');
            console.table(dat);
            $('#vnt_1').val(dat[0])
            $('#vnt_2').val(dat[1])
            $('#vnt_3').val(dat[2])
            $('#vnt_4').val(dat[3])
            $('#vnt_5').val(dat[4])
            $('#vnt_6').val(dat[5])
            $('#idMatr').val(dat[6]);
            $('#semestreNota').val(dat[7]);
            $('#resultadoNota').val();
            $('#editarNota').modal('show');
            calculaNotaDef();
        });
        $('.notaEditFF').change(function() {
            calculaNotaDef();
        })

        function openSesionEdit(dd) {
            $('#seminarioEditForm').load('/data-sesions/' + dd + '/edit');
            $('#editaSesion').modal('show');
        }

        function calculaNotaDef() {
            let laDef = ($('#vnt_1').val() * 0.3) + ($('#vnt_2').val() * 0.3) + ($('#vnt_3').val() * 0.4);
            let laHab = $('#vnt_5').val();
            let statusDef = (laDef < 3.4 ? (laHab < 3.5 ? 'Perdido' : 'Recuperado') : 'Aprobado');
            $('#resultadoNota').val(statusDef);
            $('#vnt_4').val(laDef);
        }

        function pago(tt, ff) {
            $('#boxPagoEdit').modal('show');
            $('.boxPagoEdit').load('/pagos-detalle/' + tt + '-' + ff)
        }

        function editPagare(tt, nn) {
            $('#pagareForm').modal('show');
            if (nn != 0) {
                var datos = JSON.parse($(tt).attr('data-fx'));
                var deudor = JSON.parse(datos.deudor);
                var codeudor = JSON.parse(datos.codeudor);
                $('.docEst').prop('disabled', true);
                //
                titulo = "Editar financiamiento de {{ $user->nombres }}";
                $('#t_documento').val(deudor.doc);
                $('#t_nombre').val(deudor.nombre);
                $('#t_doc_ex').val(deudor.doc_ex);
                $('#t_direccion').val(deudor.direccion);
                $('#t_ciudad').val(deudor.ciudad);
                $('#t_barrio').val(deudor.barrio);
                $('#t_telefono').val(deudor.telefono);
                if (codeudor !== null) {
                    $('#c_documento').val(codeudor.doc);
                    $('#c_nombre').val(codeudor.nombre);
                    $('#c_doc_ex').val(codeudor.doc_ex);
                    $('#c_direccion').val(codeudor.direccion);
                    $('#c_ciudad').val(codeudor.ciudad);
                    $('#c_barrio').val(codeudor.barrio);
                    $('#c_telefono').val(codeudor.telefono);
                    $('.contratoID').val(datos.contratoID);
                    $('.elCodeudor').prop("disabled", false);
                } else {
                    $('.elCodeudor').prop("disabled", true);
                    $('#c_documento').val("");
                    $('#c_nombre').val("");
                    $('#c_doc_ex').val("");
                    $('#c_direccion').val("");
                    $('#c_ciudad').val("");
                    $('#c_barrio').val("");
                    $('#c_telefono').val("");
                    $('.contratoID').val("");
                }
                $('#cicloAc').val(datos.cicloAc);
                $('#pagare_valor').val(datos.valor);
                $('#pCuotas').val(datos.cuotas);
                $('#pFecha').val(datos.fecha);
                $('#creditoMatr').val(datos.matricula);
                $('#creditoID').val(datos.matricula);
                $('#creditoMatr').prop("disabled", true);
                plazos = datos.plan;
                method = "POST"
                ruta = "/pagareadd/" + datos.id;
            } else {
                plazos = "";
                $('#creditoMatr').prop("disabled", false);
                titulo = "Crear Financiamiento a {{ $user->nombres }}"
                $('#pagareForm')[0].reset();
                generarIDPag();
                method = "POST"
                ruta = "{{ route('pagareAdd', 0) }}"
            }
            //
            $('#modalTT').text(titulo);
            $('#cs_method').val(method)
            $('#pagareForm').attr("action", ruta);
            generarFechasPago();
        }

        function generarIDPag() {
            var slOp = $('#creditoMatr').find('option:selected');
            $('#creditoID').val($('#creditoMatr').val());
            $('#cicloAc').val(slOp.attr('ciclo'));
            $('#pagare_valor').val(slOp.attr('valor'));
            $('#pCuotas').val(slOp.attr('cuotas'));
            $(".contratoID").val('{{ substr($user->cod, -4) }}-' + slOp.attr('ciclo'));
            tipoProgSeleccionado = slOp.attr('tipoprog');
            generarFechasPago();
        }

        function generarFechasPago() {
            $('.listaPagos').empty();
            let fecha = new Date($('#pFecha').val());
            if (tipoProgSeleccionado == "Seminario-Taller") {
                fecha.setDate(fecha.getDate() + 42);
            }
            for (let i = 1; i <= $('#pCuotas').val(); i++) {
                var año = fecha.getFullYear();
                var mes = (fecha.getMonth() + 1) + i;
                var día = fecha.getDate();
                var nfecha = año + '-' + (mes < 10 ? '0' : '') + mes + '-' + (día < 10 ? '0' : '') + día;
                $('.listaPagos').append('<small id="helpId" class="form-text text-muted">Cuota ' + i +
                    '</small><input type="date" class="form-control" name="fecha' + i + '" id="fecha' + i +
                    '" value="' + nfecha + '" />');
            }
            if (plazos !== "") {
                console.log(plazos);
                let fechasPlz = plazos.split('|');
                let idFech = 1;
                fechasPlz.forEach(element => {
                    $('#fecha' + idFech).val(element)
                    idFech++;
                });
            }
        }

        function agregarModulo(ff, dd, nn) {
            $('#semestreModuloAdd').val(ff);
            $('#grupoMasiva').val(dd);
            $('#elBox').val(nn);
            $('#modalAddMt').modal('show');
        }

        let tareaSel = "";
        let btSel;
        let estudianteSel;

        function verEntrega(t, idEst) {
            btSel = t;
            $('#campo').val($(t).attr('data-nt'));
            $('.entregaData').load("/entregashow/" + $(t).attr('data-fx'));
            $('#revisaTarea').modal('show');
            $('#retroalimentacion').val($(t).attr('data-rt'));
            $('#laNota').val($(t).attr('data-vl'));
            tareaSel = $(t).attr('data-fx');
            $('.act_metodo').val("PATCH");
            $('#notaAutoEv').val(1);
            $('.revisionFooter').html(
                '<button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button><button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>'
            );
            estudianteSel = idEst;
            $("#revTarea").attr('action', '/revision/' + tareaSel);
        }

        let semestreNombre = ['N/A', 'Primer Semestre', 'Segundo Semestre', 'Tercer Semestre',
            'Semestre de Profudización Animación Musical y Presentación de Espectáculos',
            'Semestre de Profudización Lectura de Noticias y Periodismo Radial',
            'Semestre de Profudización Periodismo y Locución Deportiva',
            'Semestre de Profudización Locución y Presentación de Televisión',
            'Semestre de Profudización Producción y Locución Comercial',
            'Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa'
        ];

        function optPrg(dd) {
            let datGuia = $("#prg option:selected").parent().attr("label");
            let nuevasOpc = "";
            if (datGuia == "Técnico Laboral") {
                let guia = 0;
                semestreNombre.forEach(element => {
                    nuevasOpc += '<option value="' + guia + '">' + element + '</option>';
                    guia++;
                });
            } else if (datGuia == "Certificaciones") {
                nuevasOpc = '<option value="1">Fase Modular</option><option value="2">Fase Protocolar</option>'
            } else {
                nuevasOpc = '<option value="0">N/A</option>'
            }
            $('#nivel').html(nuevasOpc)
        }

        function getNombrePrueba(tt) {
            $('#nombrePrueba').val($(tt).find(':selected').text())
        }


        $(".pagosTable").DataTable();

        //Registro académico certf
        function addRegistroAcademico() {
            $('#modalRegistroAc').modal('show');
        }

        function addExperience() {
            var experience = document.querySelector('.experience');
            var clone = experience.cloneNode(true);
            var experiences = document.getElementById('experiences');
            experiences.appendChild(clone);
        }

        function removeExperience(button) {
            var experience = button.parentNode.parentNode;
            experience.parentNode.removeChild(experience);
        }
    </script>
@endsection
