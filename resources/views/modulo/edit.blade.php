@php
    $tipoActiv = ['Tarea', 'Autoevaluación', 'Recuperación', 'Reposición Parcial 1', 'Reposición Parcial 2', 'Reposición Parcial 3'];
    $periodos = [];
    $nombrePeriodos = Session::get('config')['nombrePeriodos'];
    for ($i = 2000; $i <= date('Y') + 1; $i++) {
        for ($j = 1; $j < count($nombrePeriodos); $j++) {
            array_push($periodos, ['id' => $i . $j, 'nn' => $i . '(' . $j . ') - ' . $nombrePeriodos[$j]]);
        }
    }
@endphp

@extends('layouts.admin')

@section('template_title')
    {{ $modulo->titulo }}: Actualizar
@endsection

@section('content')
    <section class="content container">
        <a href="{{ route('modulos.index') }}" class="btn btn-outline-primary"><i class="fa-solid fa-circle-chevron-left"></i>
            Regresar</a><br><br>

        @includeif('partials.errors')
        <div class="card card-default">
            <div class="card-header">
                <span class="card-title">
                    {{ $modulo->titulo }}
                </span>
            </div>
            <div class="card-body row">
                <form method="POST" action="{{ route('modulos.update', $modulo->id) }}" role="form"
                    enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    @csrf
                    @include('modulo.form')
                </form>
            </div>
        </div>

        <BR>

        <h3>Actividades del Módulo</h3>
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span id="card_title">
                        Cuenta con <b>{{ $tareas->count() }} Actividades</b>
                    </span>
                    <div class="float-right">
                        <button onclick="nuevoActividad(this)" class="btn btn-primary btn-sm float-right"
                            data-placement="left">
                            + AGREGAR ACTIVIDAD
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead">
                            <tr>
                                <th class="col-md-1">Tipo</th>
                                <th class="col-md-4"></th>
                                <th class="col-md-6">Vigencia</th>
                                <th class="col-md-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tareas as $tarea)
                                <tr>
                                    <td class="text-center">
                                        <span style="font-size: 10px">{{ $tarea->tipo ? $tipoActiv[$tarea->tipo] : '' }}</span>
                                        <button class="btn btn-sm btn-success" data="{{ $tarea }}"
                                            onclick="editActividad(this)"><i class="fa fa-fw fa-edit"></i>
                                            Modificar</button>
                                    </td>
                                    <td>
                                        @if ($tarea->tipo != 0)
                                            <a href="{{ route('ft', 'files|au|' . $tarea->isAU) }}" target="_blank">
                                                {{ $tarea->ord }} / {{ $tarea->enunciado }}
                                            </a>
                                        @else
                                            {{ $tarea->ord }} / {{ $tarea->enunciado }}
                                        @endif
                                        <hr>
                                        @php $sendKind = explode('|', $tarea->tipo_rta) @endphp
                                        @foreach ($sendKind as $item)
                                        @if (!$loop->last)
                                        <small class="text-center" style="color: #00468C">{!! $item == 'pdf' ? '<i class="fa-solid fa-file-pdf"></i> RESPUESTA EN PDF' : '<i class="fa-solid fa-link"></i> RESPUESTA EN LINK' !!}</small><br>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="row g-3">
                                        @if ($tarea->limite == null)
                                        <div class="col-12 text-center bg-success text-light">Semana Disponible</div>
                                        @for ($i = 1; $i <= 8; $i++)
                                            <div class="col-3">
                                                Gr. {{ Session::get('config')['gruposNombre'][$i] }}
                                                <select class="tarea_{{ $tarea->id }}" name="" id="tarea_{{ $tarea->id.'_'.$i }}" onchange="cambiaWeek(this.value, {{ $tarea->id }}, 'tarea')">
                                                    <option value="1">ND</option>
                                                    @for ($j = 1; $j < explode('|',$modulo->semanas)[$i] + 1; $j++)
                                                    <option value="{{ $j }}" {{ (explode('|', $tarea->fechas)[$i] == $j ? 'selected' : '') }}>{{ $j }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        @endfor
                                        @else
                                            <div class="col-12">
                                                Del {{ $tarea->desde }} <br>al {{ $tarea->limite }}
                                            </div>
                                        @endif
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Desea eliminar esta actividad?')"><i
                                                    class="fa fa-fw fa-trash"></i> Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <hr>

        <h3>Recursos del módulo</h3>
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span id="card_title">
                        Cuenta con <b>{{ $recursos->count() }} Recursos</b>
                    </span>
                    <div class="float-right">
                        <button class="btn btn-primary btn-sm float-right" onclick="nuevoRecurso(this)" data="X">
                            + AGREGAR NUEVO RECURSO
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead">
                            <tr>
                                <th class="col-md-1"></th>
                                <th class="col-md-4">Recurso</th>
                                <th class="col-md-6">Vigencia</th>
                                <th class="col-md-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recursos as $recurso)
                                <tr>
                                    <td>
                                        <button class="btn btn-success btn-sm" data="{{ $recurso }}"
                                            onclick="editRecurso(this)"><i class="fa fa-fw fa-edit"></i> Modificar</a>
                                    </td>
                                    <td>
                                        @if ($recurso->tipo == 'link')
                                            <a href="{{ $recurso->file }}" target="_blank" class="nav-bar">
                                            @else
                                                <a href="{{ route('ft', 'files|' . $recurso->file) }}" target="_blank">
                                        @endif
                                        {{ $recurso->titulo }}<br>
                                        <small>{{ $recurso->file }}</small>
                                    </td>

                                    <td>
                                        <div class="row g-3">
                                        <div class="col-12 text-center bg-success text-light">Semana Disponible</div>

                                        @for ($i = 1; $i <= 8; $i++)
                                            <div class="col-3">
                                                Gr. {{ Session::get('config')['gruposNombre'][$i] }}
                                                <select class="recurso_{{ $recurso->id }}" name="" id="recurso_{{ $recurso->id.'_'.$i }}" onchange="cambiaWeek(this.value, {{ $recurso->id }}, 'recurso')">
                                                    @for ($j = 0; $j < explode('|',$modulo->semanas)[$i] + 1; $j++)
                                                    <option value="{{ $j }}" {{ (explode('|', $recurso->fechas)[$i] == $j ? 'selected' : '') }}>{{ $j }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        @endfor
                                        
                                        </div>
                                    </td>

                                    
                                    <td>
                                        <form action="{{ route('recursos.destroy', $recurso->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Desea eliminar este recurso?')"><i
                                                    class="fa fa-fw fa-trash"></i> Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <hr>
            <!-- Docentes asignados -->
            <h3>Docentes del Módulo</h3>
            <div class="card mb-3">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            Cuenta con <b>{{ $modulo->docentes()->count() }} asignaciones docentes</b>
                        </span>
                    </div>
                </div>
    
                <div class="card-body">
                    <!-- Asignación del Modulo -->
                    <form method="POST" action="{{ route('asignar-modulo') }}" class="row">
                        @csrf
                        <input type="hidden" name="elModuloAsig" value="{{ $modulo->id }}">
                        <div class="col-12 mb-3">
                            <select class="form-select form-select-sm" name="docente" id="docente">
                                @foreach ($profesores as $item)
                                <option value="{{ $item->id }}" @if ($modulo->docente == $item->id) selected @endif>{{ $item->nombres }} {{ $item->apellidos }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            {!! Form::select(
                                'periodo',
                                array_combine(array_column($periodos, 'id'), array_column($periodos, 'nn')),
                                date('Y') . '1',
                                ['class' => 'form-select form-select-sm mb-3', 'id' => 'elGrupoAsig'],
                            ) !!}
                        </div>
                        <div class="col-6 mb-3">
                            <div class="d-grid gap-2">
                                <button type="submit" name="" id="" class="btn btn-sm btn-success">
                                    Asignar Módulo
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- Fin Asignación del Modulo -->
                    @include('modulo.tabla_asignacion', ['tipo' => 1])

                </div>
            </div>
            <!-- Final Docentes asignados -->

            <!-- Estudiantes asignados -->
            <h3>Estudiantes del Módulo</h3>
            <div class="card mb-3">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            Cuenta con <b>{{ $matriculas->count() }} Estudiantes</b>
                        </span>
                    </div>
                </div>
    
                <div class="card-body">
                    <div class="row">
    
                        <div class="col-md-12">
                            <table class="table table-striped table-hover usuariosTable">
                                <thead class="thead">
                                    <tr>
                                        <th class="col-1"></th>
                                        <th class="col-1">Grupo</th>
                                        <th class="col-5">Apellidos y Nombre</th>
                                        <th class="col-1">30%</th>
                                        <th class="col-1">30%</th>
                                        <th class="col-1">40%</th>
                                        <th class="col-1">DEF</th>
                                        <th class="col-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matriculas as $item)
                                        @php
                                            $notaPromedio = number_format($item->n1 * 0.3 + $item->n2 * 0.3 + $item->n3 * 0.4, 1, '.', '');
                                            if ($notaPromedio < 3.5) {
                                                $prColor = ['FFF', 'f71f02'];
                                            } elseif ($notaPromedio > 4.4) {
                                                $prColor = ['FFF', '044a08'];
                                            } else {
                                                $prColor = ['000', 'f5f3c1'];
                                            }
                                            $grupo = substr($item->grupo, 0, -1) . '-' . $opcionesMatr[substr($item->grupo, -1) - 1];
                                        @endphp
                                        <tr>
                                            <td>
                                                <div id="btNt_{{ $item->id }}" class="text-center">
                                                    <button type="button" class="btn btn-info btn-sm"
                                                        onclick="editarNota(this)" data="{{ $item }}"><i
                                                            class="fa fa-fw fa-edit"></i></button>
                                                </div>
                                            </td>
                                            <td>{{ $item->elGrupo($item->grupo) }}</td>
                                            <td>
                                                <a href="{{ route('users.edit', $item->user->id) }}">
                                                    {{ $item->user->apellidos }}<br>{{ $item->user->nombres }}
                                                </a>
                                            </td>
                                            <td>
                                                <div id="ntxt_1_{{ $item->id }}">{{ $item->n1 }}</div>
                                            </td>
                                            <td>
                                                <div id="ntxt_2_{{ $item->id }}">{{ $item->n2 }}</div>
                                            </td>
                                            <td>
                                                <div id="ntxt_3_{{ $item->id }}">{{ $item->n3 }}</div>
                                            </td>
                                            <td>
                                                <div id="ntxt_pr_{{ $item->id }}"
                                                    style="text-align: center; font-width: bold; color:#{{ $prColor[0] }}; background-color:#{{ $prColor[1] }}">
                                                    {{ $notaPromedio }}</div>
                                            </td>
                                            <td>
                                                <form action="{{ route('matriculas.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Desea cancelar este modulo en este usuario?')"><i
                                                            class="fa fa-fw fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final Estudiantes asignados -->


        @if ($encuesta->count() > 0)
        <!-- Encuestas de módulo -->
        <h3>Percepción del Módulo</h3>
        @php
            $preg = [
                'El contenido visto en el módulo es coherente y pertinente con sus necesidades de aprendizaje.',
                'Los contenidos son facilitados en un ambiente orientado a su aprendizaje y enfocado a los objetivos de cada unidad.',
                'El ambiente de estudio (clases sincrónicas) responde a una planeación estratégica indicada previamente.',
                'La estructura de las actividades realizadas durante esté módulo, le permite adquirir el conocimiento necesario para continuar con su proceso de aprendizaje.',
                'La práctica del módulo le permitió afianzar sus habilidades y conocimientos.',
                'Tus opiniones nos permiten mejorar, indícanos algún comentario y/o sugerencia frente al contenido del módulo.',
                'El docente/tutor facilita los contenidos del Módulo teniendo en cuenta la planeación institucional conocida previamente.',
                'El docente/tutor es puntual, mantiene un trato respetuoso y propicia la participación activa de los estudiantes.',
                'El docente/tutor ejecuta una metodología de clase pertinente, que afianza la motivación y refuerza los logros de los estudiantes.',
                'El docente/tutor demuestra dominio en los contenidos del módulo, y los presenta de forma clara, precisa y con vocabulario técnico.',
                'El docente/tutor utiliza estrategias para crear un ambiente de estudio organizado y dispone de material complementario para el desarrollo de su clase.',
                'Tus opiniones nos permiten mejorar, indícanos algún comentario y/o sugerencia frente al desempeño del/la docente.',
            ];
            
            $rtas = [];
            $idRt = 0;
            for ($i = 0; $i < count($preg); $i++) {
                $rtas[$i][0] = 0;
                $rtas[$i][1] = 0;
                $rtas[$i][2] = 0;
            }
            foreach ($encuesta as $item) {
                $rr = explode('|', str_replace(["\r", "\n"], '', $item->rtas));
                for ($i = 0; $i < count($preg); $i++) {
                    if ($rr[$i] === '2') {
                        $rtas[$i][2]++;
                    }
                    if ($rr[$i] === '1') {
                        $rtas[$i][1]++;
                    }
                    if ($rr[$i] === '0') {
                        $rtas[$i][0]++;
                    }
                }
            }
        @endphp
        <div class="card mb-3">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span id="card_title">
                        Cuenta con <b>{{ $encuesta->count() }} encuestas realizadas</b>
                    </span>
                </div>
            </div>

            <div class="card-body">
                Respuestas cerradas. <b>Convenciones: <span class="text-primary">Siempre</span> - <span
                        class="text-success">A veces</span> - <span class="text-danger">Nunca</span></b>
                <div class="row">
                    <div class="col-md-6">
                        @for ($i = 0; $i < count($preg); $i++)
                            @if ($i !== 5 && $i !== 11)
                                {{ $preg[$i] }}<br>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ ($rtas[$i][2] * 100) / $encuesta->count() }}%"
                                        aria-valuenow="{{ ($rtas[$i][2] * 100) / $encuesta->count() }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                        {{ number_format(($rtas[$i][2] * 100) / $encuesta->count(), 1, '.', '') }}%</div>
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ ($rtas[$i][1] * 100) / $encuesta->count() }}%"
                                        aria-valuenow="{{ ($rtas[$i][1] * 100) / $encuesta->count() }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                        {{ number_format(($rtas[$i][1] * 100) / $encuesta->count(), 1, '.', '') }}%</div>
                                    <div class="progress-bar bg-danger" role="progressbar"
                                        style="width: {{ ($rtas[$i][0] * 100) / $encuesta->count() }}%"
                                        aria-valuenow="{{ ($rtas[$i][0] * 100) / $encuesta->count() }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                        {{ number_format(($rtas[$i][0] * 100) / $encuesta->count(), 1, '.', '') }}%</div>
                                </div>
                            @endif
                        @endfor
                    </div>
                    <div class="col-md-6" style="max-height: 660px; overflow-y: auto;">
                        <b>Comentarios:</b><br>
                        En azul sobre el módulo. En Blanco sobre el docente.
                        @foreach ($encuesta->sortBy('fecha')->reverse() as $item)
                        @php 
                        $datOp = explode('|', str_replace(["\r", "\n"], '', $item->rtas))[5]; 
                        $datDc = explode('|', str_replace(["\r", "\n"], '', $item->rtas))[11]; 
                        @endphp
                        @if ($datOp !== "")
                        <div style="font-size: 12px; margin:3px; padding: 5px; border: 1px solid #c3c3c3; background-color: #c4e1f8">
                            {{ $datOp }}<br>
                            <div style="text-align: right">{{ $item->elEstudiante()->first()->nombres.' '.$item->elEstudiante()->first()->apellidos}} ({{ $item->fecha }})</div>
                        </div>
                        @endif
                        @if ($datDc !== "")
                        <div style="font-size: 12px; margin:3px; padding: 5px; border: 1px solid #c3c3c3">
                            {{ $datDc }}<br>
                            <div style="text-align: right">{{ $item->elEstudiante()->first()->nombres.' '.$item->elEstudiante()->first()->apellidos}} ({{ $item->fecha }})</div>
                        </div>
                        @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        @endif




        <!-- repositorio de grabaciones -->
        <h3>Sesiones del Módulo</h3>
        <div class="row">
            <div class="card col-md-8">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            Existen <b>{{ $grabaciones->count() }} Grabaciones</b>
                        </span>
                        <div class="float-right">
                            <button class="btn btn-primary btn-sm float-right" onclick="nuevaGrabacion(this)"
                                data="X">
                                + AGREGAR NUEVA GRABACIÓN
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover usuariosTable">
                        <thead class="thead">
                            <tr>
                                <th class="col-3">Fecha</th>
                                <th class="col-3">Nombre</th>
                                <th class="col-1">URL</th>
                                <th class="col-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grabaciones as $item)
                                <tr>
                                    <td>{{ $item->fecha }}<br><b>Grupo: {{ $item->grupo }}</b></td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>
                                        <a href="https://drive.google.com/file/d/{{ $item->ruta }}/view?usp=share_link"
                                            target="_blank">
                                            [ Ver enlace ]
                                        </a>
                                    </td>
                                    <td>
                                        <form action="/repositoriodel/{{ $item->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Desea quitar esta grabación de la lista?')"><i
                                                    class="fa fa-fw fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Lista de asistencia -->
            <div class="card col-md-4">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            Asistencias tomadas en el Módulo:
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    @php
                        $tDat = '';
                        $idModalClick = 0;
                    @endphp
                    @foreach ($asistencia as $item)
                        @if ($tDat != $item->fecha)
                            @php $idModalClick++ @endphp
                            <button onclick="viewAttendance({{ $idModalClick }})" class="btn btn-outline-info btn-sm "
                                data-placement="left">
                                {{ $item->fecha }}
                            </button>
                        @endif
                        @php $tDat = $item->fecha @endphp
                    @endforeach
                </div>
            </div>

        </div>
        </div>


        <!-- Modal grabaciones -->

        <form action="{{ route('recording.store') }}" method="POST" class="modal fade" id="boxRecording"
            tabindex="-1" role="dialog" aria-labelledby="boxRecordingLabel" aria-hidden="true">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar nueva Grabación</h5>
                        <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="g_titulo" class="form-label">Nombre de la Grabación</label>
                                <input type="text" class="form-control" name="nombre" id="g_titulo" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="mb-3">
                                <label for="g_ruta" class="form-label">URL de Google Drive</label>
                                <input type="text" onchange="formatURLDrive()" class="form-control" name="ruta"
                                    id="g_ruta" required>
                            </div>
                        </div>

                        <div class="form-group col-8">
                            <div class="mb-3">
                                <label for="g_fecha" class="form-label">Fecha de la clase</label>
                                <input type="date" class="form-control" name="fecha" id="g_fecha" required>
                            </div>
                        </div>

                        <div class="form-group col-4">
                            <div class="mb-3">
                                <label for="g_fecha" class="form-label">Grupo</label>
                                <select class="form-select" name="grupo" id="">
                                    @php $gruposID = ['', 'A', 'B', 'C', 'D']; @endphp
                                    @foreach ($gruposID as $key => $item)
                                        @if (!$loop->first)
                                            <option value="{{ (date('Y')-1).$key }}">{{ (date('Y')-1).'-'.$item }}</option>
                                            <option value="{{ (date('Y')).$key }}">{{ (date('Y')).'-'.$item }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="modulo" value="{{ $modulo->id }}">
                        <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
                    </div>
                </div>
            </div>
            </div>
        </form>



        <!-- Modal Recurso -->
        <form method="POST" id="recursoForm" role="form" enctype="multipart/form-data">
            <input type="hidden" name="_method" class="act_metodo" value="">
            <input type="hidden" name="author" value="admin">
            @csrf
            <div class="modal fade" id="boxRecurso" tabindex="-1" role="dialog" aria-labelledby="boxRecursoLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="boxRecurso_tt">Agregar nuevo Recurso</h5>
                            <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal"
                                aria-label="Close">
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
                                    <select class="form-select form-select-lg" name="tipo" id="f_tipo" onchange="genTipo(this.value, '')">
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
                            <button type="button" class="btn btn-secondary cerrarModal"
                                data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>




        <form method="POST" id="actividadForm" role="form" enctype="multipart/form-data">
            <input type="hidden" name="_method" class="act_metodo" value="">
            @csrf
            <div class="modal fade" id="boxActividad" tabindex="-1" role="dialog" aria-labelledby="boxActividadLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="boxActividad_tt"></h5>
                            <div class="mb-3">
                                <label for="" class="form-label">Tipo Actividad</label>
                                <select class="form-select form-select-lg" name="tipo" id="tipoActividad">
                                    <option value="1">Autoevaluación</option>
                                    <option value="0">Tarea</option>
                                    <option value="2">Recuperación</option>
                                    <option value="3">Reposición Parcial 1</option>
                                    <option value="4">Reposición Parcial 2</option>
                                    <option value="5">Reposición Parcial 3</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body row">
                            <div class="form-group col-md-12">
                                <div class="mb-3">
                                    <label for="enunciado" class="form-label">Nombre de la Actividad</label>
                                    <input type="text" class="form-control" name="enunciado" id="enunciado" required>
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="isAU" class="form-label">Documento guía</label>
                                <input type="file" class="form-control" name="isAU" id="isAU" placeholder=""
                                    aria-describedby="fileHelpId">
                                <div id="fileHelpId" class="form-text">Cargue el archivo que contiene las instrucciones
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="" class="form-label">Tipo de Respuestas admitidas</label>
                                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                    <input type="checkbox" class="btn-check tipoR_menu" id="bt_link" value="link"
                                        onchange="respAdmit()">
                                    <label class="btn btn-outline-primary" for="bt_link">Link</label>

                                    <input type="checkbox" class="btn-check tipoR_menu" id="bt_pdf" value="pdf"
                                        onchange="respAdmit()">
                                    <label class="btn btn-outline-primary" for="bt_pdf">PDF</label>
                                </div>
                            </div>
                            <input type="hidden" name="tipo_rta" class="tipo_rta">

                            <div class="form-group col-md-2">
                                <div class="mb-3 semanasData">
                                    <label for="" class="form-label">Semana</label>
                                    <input type="number" class="form-control" name="ord" id="ord">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="" class="form-label"></label>
                                <input type="checkbox" class="btn-check" id="btFechaChange" value="0"
                                    onchange="changeDateSend()">
                                <label class="btn btn-outline-primary" for="btFechaChange">
                                    Personalizar fecha
                                </label>
                            </div>

                            <div class="form-group col-md-3 fechaEspecial">
                                <div class="mb-3">
                                    <label for="act_fecha" class="form-label">Entrega desde:</label>
                                    <input type="datetime-local" step="any" class="form-control" name="desde"
                                        id="act_fecha1">
                                </div>
                            </div>

                            <div class="form-group col-md-3 fechaEspecial">
                                <div class="mb-3">
                                    <label for="act_fecha" class="form-label">Entrega hasta:</label>
                                    <input type="datetime-local" class="form-control" name="limite" id="act_fecha2">
                                </div>
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary cerrarModal"
                                data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>



        <!-- Asistencias listas -->


        <!-- PREV. SCHEMA D -->
        <form method="POST" action="" class="boxAttendance" role="form" enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="attendanceEd" tabindex="-1" role="dialog" aria-labelledby="attendanceEdLabel"
                aria-hidden="true">
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
                            <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal"
                                aria-label="Close">
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


                                    @php
                                        $tDatPup = '';
                                        $idModal = 0;
                                    @endphp
                                    @foreach ($asistencia as $item)
                                        @if ($tDatPup != $item->fecha)
                                            @php
                                                $idModal++;
                                                $iAst = 0;
                                            @endphp

                                </tbody>
                            </table>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary cerrarModal"
                                data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="modal fade" id="boxAttendance_{{ $idModal }}" tabindex="-1" role="dialog"
            aria-labelledby="attendanceEdLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">

                <div class="modal-content">

                    <form action="{{ route('asistencia_delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="refDelete" value="{{ $item->fecha }}">
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Desea eliminar este listado de asistencia?')"><i
                                class="fa fa-fw fa-trash"></i> Eliminar Lista</button>
                    </form>

                    <div class="modal-header">
                        <h5 class="modal-title">Asistencia de día {{ $item->fecha }}</h5>

                        <form method="POST" action="{{ route('asistencia_edit') }}"
                            class="boxAttendance_{{ $idModal }}" role="form">
                            @csrf
                            <div>
                                <div class="mb-3">
                                    <label for="fechaAsst" class="form-label">Fecha:</label>
                                    <input type="date" name="fecha" class="form-control" id="fechaAsst"
                                        value="{{ $item->fecha }}" required>
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
                                            <input type="hidden" name="idEst_{{ $iAst }}"
                                                value="{{ $item->id }}">
                                            <input class="form-check-input" name="ast_v_{{ $iAst }}"
                                                type="checkbox" id="att_{{ $iAst }}"
                                                @if ($item->presencia == '1') checked @endif>
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

    </section>

    <!-- Modal para editar nota -->
    <div class="modal fade" id="editarNota" tabindex="-1" role="dialog" aria-labelledby="myEditarNota">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myEditarNota">Editar Nota</h5>
                </div>
                <div class="modal-body">

                    <form id="changeNota" action="{{ route('ajusteNotas') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="parcial1">Parcial 1</label>
                                <input type="number" class="form-control" id="parcial1" name="parcial1"
                                    step="0.1" min="0" max="5">
                            </div>
                            <div class="form-group col-4">
                                <label for="parcial2">Parcial 2</label>
                                <input type="number" class="form-control" id="parcial2" name="parcial2"
                                    step="0.1" min="0" max="5">
                            </div>
                            <div class="form-group col-4">
                                <label for="parcial3">Parcial 3</label>
                                <input type="number" class="form-control" id="parcial3" name="parcial3"
                                    step="0.1" min="0" max="5">
                            </div>
                            <input type="hidden" id="idNotaCh" name="idMatr">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary saveNot">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

        function nuevaGrabacion() {
            $('#boxRecording').modal('show');
        }

        function nuevoRecurso(t) {
            $('#boxRecurso').modal('show');
            genTipo("file", '');
            $('#boxRecurso_tt').text("Agregar nuevo Recurso");
            $('#recursoForm').attr('action', '{{ route('recursos.store') }}')
            $('#f_tipo').val();
            $('.act_metodo').val("POST");
            $('.enviarBt').text('Crear Recurso')
        }

        function editRecurso(t) {
            $('#boxRecurso').modal('show');
            const gtDt = JSON.parse($(t).attr('data'));
            $('#boxRecurso_tt').text("Editar Recurso");
            $('#f_titulo').val(gtDt.titulo)
            $('#recursoForm').attr('action', '/recursos/' + gtDt.id);
            $('#f_tipo').val(gtDt.tipo);
            $('.act_metodo').val("PATCH")
            $('.enviarBt').text('Editar Recurso');
            genTipo(gtDt.tipo, gtDt.file);
        }

        function genTipo(tipo, vv) {
            var cdT = "";
            if (tipo == "file") {
                cdT =
                    '<label for="file" class="form-label">Archivo adjunto</label><input type="file" class="form-control" name="file" accept="application/pdf, application/vnd.ms-word"><div id="fileHelpId" class="form-text">Acepta solo archivos PDF</div>';
            } else {
                cdT =
                    '<label for="titulo" class="form-label">Link del Recurso</label><input type="text" class="form-control" name="file" value="' +
                    vv + '" placeholder="Ej. https://www.youtube.com/?v=12abC456">'
            }
            $('.tipo_file').html(cdT);
        }

        function cambiaWeek(vv, elID, tipo) {
            var valorAsignado = '';
            $('.' + tipo + '_' + elID).each(function() {
                valorAsignado += '|' + $(this).val();
            });
            console.log(valorAsignado)
            $.ajax({
                type: "post",
                url: "{{ route('changeWeek') }}",
                data: {
                    vv: valorAsignado,
                    tipo,
                    elID,
                    elID,
                    _token: '{{ csrf_token() }}'
                },
                success: function(msg) {
                    console.log(msg)
                }
            });
        }

        function nuevoActividad(t) {
            $('#boxActividad').modal('show');
            $('#actividadForm').attr('action', '{{ route('tareas.store') }}')
            $('.act_metodo').val("POST");
            $('#boxActividad_tt').text("Nueva Actividad para el Módulo");
            $('#enunciado').val();
            $('#act_rtatipo').val();
            $('#act_fecha1').val();
            $('#act_fecha2').val();
            $('#ord').val();
            $('.enviarBt').text('Crear Actividad');
            $('.fechaEspecial').hide();
            respCheck();
        }

        function editActividad(t) {
            const gtDt = JSON.parse($(t).attr('data'));
            $('#boxActividad').modal('show');
            $('#actividadForm').attr('action', '/tareas/' + gtDt.id);
            $('.act_metodo').val("PATCH");
            $('#boxActividad_tt').text("Editar Actividad");
            $('#enunciado').val(gtDt.enunciado);
            $('.tipo_rta').val(gtDt.tipo_rta);
            $('#act_fecha1').val(gtDt.desde);
            $('#act_fecha2').val(gtDt.limite);
            $('#ord').val(gtDt.ord);
            $('#tipoActividad').val(gtDt.tipo).change();
            $('.enviarBt').text('Editar Actividad');
            if (gtDt.desde === null) {
                $("#btFechaChange").prop("checked", false);
                $('#btFechaChange').val(0);
            } else {
                $("#btFechaChange").prop("checked", true);
                $('#btFechaChange').val(1);
            }
            changeDateSend()
            respCheck()
        }

        $('.cerrarModal').click(function() {
            $('.modal').modal('hide')
        })

        function viewAttendance(dd) {
            $('#boxAttendance_' + dd).modal('show');
        }

        $(document).ready(function() {
            $(".usuariosTable").DataTable();
            $('.btwToolt').tooltip();
        });

        function respCheck() {
            $(".tipoR_menu").prop("checked", false);
            if ($('.tipo_rta').val() !== "") {
                var dt = ($('.tipo_rta').val()).split('|');
                console.table(dt);
                dt.forEach(element => {
                    $("#bt_" + element).prop("checked", true);
                });
            }
        }

        function respAdmit() {
            var tipoRta = "";
            $(".tipoR_menu:checked").each(function() {
                tipoRta += $(this).val() + '|';
            });
            $('.tipo_rta').val(tipoRta)
        }

        function changeDateSend() {
            if ($('#btFechaChange').is(':checked')) {
                $('.fechaEspecial').show();
                $('.semanasData').hide();
                $('#btFechaChange').val(1);
            } else {
                $('.fechaEspecial').hide();
                $('.semanasData').show();
                $('#btFechaChange').val(0);
                $('#act_fecha1').val('');
                $('#act_fecha2').val('');
            }
        }

        function editarNota(t) {
            const gtDt = JSON.parse($(t).attr('data'));
            $('#parcial1').val(gtDt.n1);
            $('#parcial2').val(gtDt.n2);
            $('#parcial3').val(gtDt.n3);
            $('#idNotaCh').val(gtDt.id);
            $('.saveNot').removeClass('d-none');
            $('#editarNota').modal('show');
        }

        $('#changeNota').submit(function(event) {
            $('.saveNot').addClass('d-none');
            console.log("va")
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                success: function(response) {
                    let elID = $('#idNotaCh').val();
                    console.log(response);
                    $('#ntxt_1_' + elID).text($('#parcial1').val());
                    $('#ntxt_2_' + elID).text($('#parcial2').val());
                    $('#ntxt_3_' + elID).text($('#parcial3').val());
                    $('#ntxt_pr_' + elID).empty();
                    $('#editarNota').modal('hide');
                    $('#btNt_' + elID).html(
                        '<i class="fa-solid fa-circle-check text-success" style="font-size:25px"></i>'
                    );
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        });
        @foreach(array_slice(Session::get('config')['gruposNombre'], 1) as $item)
        creaSemanas('{{ $item }}')
        @endforeach
    </script>
    
@endsection
