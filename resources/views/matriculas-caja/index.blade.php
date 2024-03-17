@extends('layouts.admin')

@section('template_title')
    Usuarios Registrados
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">

            <span id="card_title">
                {{ $matriculasCajas->count() }} Matrículas Activas
            </span>

        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card-body">
        <table class="table table-striped table-hover" id="usuariosTable">
            <thead class="thead">
                <tr>
                    <th>Estudiante</th>
                    <th>Matrícula</th>
                    <th>Periodo</th>
                    <th>Ciclo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($matriculasCajas as $matriculasCaja)
                    <tr>
                        <td>
                            @php
                                $userID = ($matriculasCaja->getEstudiante() ? route('users.edit', $matriculasCaja->getEstudiante()->id) : '#');
                                $userNm = ($matriculasCaja->getEstudiante() ? $matriculasCaja->getEstudiante()->apellidos.' '.$matriculasCaja->getEstudiante()->nombres : 'SIN DATOS');
                            @endphp
                            <a href="{{ $userID }}">
                                {{ $matriculasCaja->id.' - '.$userNm }}
                            </a>
                        </td>
                        <td>{{ $matriculasCaja->getPrograma()->nombre }}</td>
                        <td>{{ $matriculasCaja->nivel }}</td>
                        <td>{{ $matriculasCaja->periodo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
