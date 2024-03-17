@php
    $cuentas = ['', 'aleissy1@gmail.com', 'lassoa037@gmail.com', 'info@instel.edu.co', 'docente2@instel.edu.co'];
    $data1 = ['SALA 1', 'SALA 2', 'SALA 3', 'SALA 4'];
    $data2 = ['MAÑANA 09:00 AM - 01:00 PM', 'MAÑANA 09:00 AM - 11:00 AM', 'MAÑANA 11:00 AM - 01:00 PM', 'TARDE 02:00 PM - 04:00 PM', 'TARDE 02:00 PM - 06:00 PM', 'TARDE 04:00 PM - 06:00 PM'];
@endphp

@extends('layouts.admin')

@section('template_title')
    Salas de Práctica
@endsection

@section('content')
    <div class="row">
        <form action="{{ route('salas.store') }}" method="POST">
            @csrf
            <div class="col-sm-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h5>Crear nueva sala de práctica</h5>
                        </div>
                    </div>
                    <div class="card-text row p-2">
                        <div class="col-2">
                        <select class="form-select" name="nn1">
                            @foreach ($data1 as $itemDt1)
                                <option value="{{ $itemDt1 }}">{{ $itemDt1 }}</option>
                            @endforeach
                        </select>
                        </div>

                        <div class="col-6">
                        <select class="form-select col-6" name="nn2">
                            @foreach ($data2 as $itemDt2)
                                <option value="{{ $itemDt2 }}">{{ $itemDt2 }}</option>
                            @endforeach
                        </select>
                        </div>

                        <div class="col-4">
                            <input type="text" name="link_host" value="" class="form-control" placeholder="ID reunión zoom">
                        </div>

                        <div class="col-6">
                            Cuenta de Zoom:
                            <select class="form-select" name="cuentaZoom" id="cuentaZoom">
                                @php
                                    foreach ($cuentas as $value) {
                                        echo '<option value="' . $value . '">' . $value . '</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class="col-6">
                            Módulo a asignar:
                            <select class="form-select" name="asignada" id="asignada">
                                <option value="0">------ Ningún Módulo ------</option>
                                @foreach ($losModulos as $item2)
                                    <option value="{{ $item2->id }}">{{ $item2->titulo }}({{ $item2->user->nombres . ' ' . $item2->user->apellidos }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            <button type="submit" class="btn btn-primary">Crear</a>
        </form>
    </div>
    <hr>
    <div class="row">
        @foreach ($salasLista as $item)
            @php
                $nmSala = explode('|', $item->n_sala);
                $colorBG = str_contains($item->n_sala, 'TARDE') ? '#e6faff' : '#FFF';
                $iconDt = str_contains($item->n_sala, 'TARDE') ? 'cloud-moon' : 'sun';
            @endphp
            <div class="col-sm-6 p-2">
                <div class="card" style="background-color: {{ $colorBG }}">
                    <div class="card-body">
                        <div class="card-title justify-content-between d-flex">
                            <div><b>{{ $nmSala[0] }}</b>
                                <h5><i class="fa-solid fa-{{ $iconDt }}" style="margin-right: 10px"></i>{{ $nmSala[1] }}</h5>
                            </div>
                            <form action="{{ route('salas.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Desea eliminar esta sala del sistema?')"><i
                                        class="fa fa-fw fa-trash"></i></button>
                            </form>
                        </div>
                        <p class="card-text">Datos de la sala:
                        <form action="{{ route('salas.update', $item->id) }}" method="POST">
                            {{ method_field('PATCH') }}
                            @csrf
                            <select class="form-select" name="nn1">
                                @foreach ($data1 as $itemDt1)
                                    <option value="{{ $itemDt1 }}"@if ($nmSala[0] == $itemDt1) selected @endif>
                                        {{ $itemDt1 }}</option>
                                @endforeach
                            </select>
                            <select class="form-select" name="nn2">
                                @foreach ($data2 as $itemDt2)
                                    <option value="{{ $itemDt2 }}" @if ($nmSala[1] == $itemDt2) selected @endif>
                                        {{ $itemDt2 }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="link_host" value="{{ $item->link_host }}" class="form-control">
                            <select class="form-select" name="cuentaZoom" id="cuentaZoom">
                                @php
                                    foreach ($cuentas as $value) {
                                        $extraDt = $item->cuentaZoom == $value ? ' selected' : '';
                                        echo '<option value="' . $value . '"' . $extraDt . '>' . $value . '</option>';
                                    }
                                @endphp
                            </select>
                            <select class="form-select" name="asignada" id="asignada">
                                <option value="0">------ Ningún Módulo ------</option>
                                @foreach ($losModulos as $item2)
                                    <option value="{{ $item2->id }}"@if ($item->asignada == $item2->id) selected @endif>
                                        {{ $item2->titulo }}
                                        ({{ $item2->user->nombres . ' ' . $item2->user->apellidos }})
                                    </option>
                                @endforeach
                            </select>
                            </p>
                            <button type="submit" class="btn btn-primary">Guardar</a>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
