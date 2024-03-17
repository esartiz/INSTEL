@php
    $periodosLetra = Session::get('config')['gruposNombre'];
@endphp

@extends('layouts.admin')

@section('template_title')
    Bienvenido al módulo administrador
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ route('anuncio')}}" method="post">
            @csrf
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <h5>Agenda General</h5>
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        Informe a la comunidad Insteliana sobre eventos próximos durante esta semana. El anuncio general debe ser corto, aparecerá a 
                        todos y no es necesario indicarle la fecha porque aparecerá hasta que se elimine.
                        <b>Los avisos financieros y de actividades académicas aparecen automáticamente</b>
                        <div class="row" style="margin-top: 20px">
                            <div class="col-5">
                                <h4>Nuevo</h4>
                                <form action="{{ route('anuncio') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="modulo" value="0">
                                    <div class="form-group">
                                        <label for="nivel">Destino:</label>
                                        <select class="form-control" name="nivel" id="nivel">
                                            <option value="1">Sección Ten en cuenta</option>
                                            <option value="2">Toda la Comunidad</option>
                                            <option value="ROLEstudiante">Todos los Estudiantes</option>
                                            <option value="ROLDocente">Todos los Docentes</option>
                                            <optgroup label="Estudiantes por Programa / Ciclo">
                                            @foreach ($programas as $item)
                                                <option value="PRG{{ $item->id }}">{{ $item->nombre }} (Todos)</option>
                                                @php $ciclo = explode('|', $item->estructura); @endphp
                                                @foreach ($ciclo as $item2)
                                                @if (!$loop->first)
                                                <option value="CCL{{ $item->id }}-{{ ($loop->iteration - 1) }}">{{ $item->nombre }} ({{ $item2 }})</option>
                                                @endif
                                                @endforeach
                                            @endforeach
                                            <optgroup label="Usuario específico">
                                            @foreach ($estudiantes as $item)
                                            <option value="COD{{ $item->cod }}">{{ $item->apellidos }}, {{ $item->nombres }}</option>
                                            @endforeach
                                        </select>
                                        <label for="vence">Fecha</label>
                                        <input type="date" id="vence" name="vence" class="form-control">

                                        <label for="texto">Texto:</label>
                                        <textarea name="texto" id="texto" class="form-control" maxlength="125" rows="5"></textarea>

                                        <label for="ruta">Link destino:</label>
                                        <input type="text" id="ruta" name="ruta" class="form-control" value="#">

                                        <label for="fecha">Grupo:</label>
                                        <select class="form-select form-select" name="grupo">
                                            <option value="" selected>Todos / No Aplica</option>
                                            @for ($i = date('Y')-1; $i <= (date('Y')+1); $i++)
                                                @for ($j = 1; $j < count($periodosLetra); $j++)
                                                    <option value="{{ $i.$j }}">{{ $i }} - {{ $periodosLetra[$j]}}</option>
                                                @endfor
                                            @endfor
                                        </select>

                                        <div class="d-grid gap-2" style="margin-top: 10px">
                                          <button type="submit" name="" id="" class="btn btn-primary">Crear</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="col-7">
                                <h4>Creados</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-borderless align-middle">
                                        <thead class="table-light">
                                            <caption>Listado de anuncios y eventos</caption>
                                            <tr>
                                                <th>Evento/Anuncio</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-group-divider">
                                                @foreach ($anuncio as $item)
                                                <tr>
                                                    <td scope="row">
                                                        {{ $item->texto }}<br>
                                                        <small class="text-muted">
                                                            {{ ($item->vence == '2022-01-01 00:00:00' ? 'VISIBLE SIEMPRE' : $item->vence) }} | {{ ($item->vence == '2022-01-01 00:00:00' ? 'PARA TODOS' : $item->nivel) }} | {{ $item->ruta }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('anuncio-delete') }}" method="post">
                                                            @csrf
                                                            {{ method_field('DELETE') }}
                                                            <input type="hidden" name="deleteme" value="{{ $item->id }}">
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar definitivamente este evento?')" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Deshabilitar"><i class="fa fa-fw fa-trash"></i> </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                
                                            </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<hr>
<br>
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span id="card_title">
                Enviar Notificación Push
            </span>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('send.web-notification') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Destino</label>
                <select class="form-select" name="tipo" id="tipoNotif">
                    <option value="1">Toda la comunidad de INSTEL Virtual</option>
                    <option value="2">Todos los docentes de INSTEL Virtual</option>
                    <option value="3">Todos los estudiantes de INSTEL Virtual</option>
                    <option value="4">Estudiantes de un módulo</option>
                </select>
            </div>
            <div class="mb-3 opcionesModulo">
                <label for="" class="form-label">Destino:</label>
                <select class="form-select" name="destino" id="">
                    <option value="0">Seleccione uno</option>
                    @foreach ($listaModulos as $item)
                        <option value="{{ $item->id }}">{{ $item->titulo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Título</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
                <label>Texto</label>
                <textarea class="form-control" name="body"></textarea>
            </div>
            <br>
            <button type="submit" class="btn btn-success btn-block">Enviar Notificación Push</button>
        </form>
    </div>
</div>

@endsection


@section('scripts')
<script>
    $('#tipoNotif').change(function(){
        if($(this).val() == "4"){
            $('.opcionesModulo').show();
        } else {
            $('.opcionesModulo').hide();
        }
    })
    $('.opcionesModulo').hide();
</script>
@endsection
