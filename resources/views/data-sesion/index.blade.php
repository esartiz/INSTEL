@php
    $cuentas = ['aleissy1@gmail.com', 'lassoa037@gmail.com', 'info@instel.edu.co', 'docente2@instel.edu.co'];
@endphp
@extends('layouts.admin')

@section('template_title')
    Sesiones de Seminario
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">Estudiantes matriculados en seminarios:
                                    <div class="mb-3">
                                        <select class="form-select" name="" id="filterEst" onchange="viewStudentSm(this)">
                                            <option selected>Seleccione</option>
                                            @foreach ($dataSesions->groupBy('idUser') as $item)
                                            <option value="{{ $item->first()->idUser }}">{{$item->first()->apellidos}} {{$item->first()->nombres}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </span>

                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <h3 class="titleEstud"></h3>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
										<th>Fecha</th>
										<th>Sesión</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataSesions as $dataSesion)
                                        <tr class="dataEst_{{ $dataSesion->idUser }} boxEstudiante">
                                            
											<td>{{ $dataSesion->fecha }}</td>
											<td>
                                                <a href="/data-seminars/{{ $dataSesion->seminarID }}/edit">
                                                    {{ $dataSesion->dataSeminar()->sesionID }}
                                                </a>
                                                <br>
                                                <small>{{ $dataSesion->dataSeminar()->programa()->nombre }}</small>

                                                <form class="row changeSessionSem" method="POST" action="{{ route('data-sesions.update', $dataSesion->id) }}"  dtInf="{{ $dataSesion->id }}" enctype="multipart/form-data">
                                                    {{ method_field('PATCH') }}
                                                    @csrf
                                                    <div class="col-6">
                                                      <label class="text-muted">Link Zoom:</label>
                                                      <div class="input-group mb-3">
                                                            <select class="form-select form-select-sm" name="cuentaZoom">
                                                                <option value="">Cuenta Zoom</option>
                                                                @foreach ($cuentas as $item)
                                                                <option value="{{ $item }}" @if($item == $dataSesion->cuentaZoom) selected @endif>{{ $item }}</option>
                                                                @endforeach
                                                            </select>
                                                        <input type="number" class="form-control input-sm" name="zoom" value="{{ $dataSesion->zoom }}">
                                                      </div>
                                                    </div>                                                       
                                                    <div class="col-6">
                                                        <label class="text-muted">Docente:</label>
                                                        <select class="form-select form-select-sm" name="docente">
                                                            @php
                                                                foreach ($listaDocente as $item) {
                                                                    echo '<option value="'.$item->id.'"'.($item->id == $dataSesion->docente ? ' selected' : '').'>'.$item->apellidos.' '.$item->nombres.'</option>';
                                                                }
                                                            @endphp
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="text-muted">Fecha:</label>
                                                      <input type="date" class="form-control" name="fecha" value="{{ $dataSesion->fecha }}">
                                                    </div>
                                                    <div class="col-8">
                                                        <label class="text-muted">Repositorio:</label>
                                                        <input type="text" class="form-control" name="repositorio" value="{{ $dataSesion->repositorio }}">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="text-muted">Retroalimentación:</label>
                                                        <textarea class="form-control" name="retro" rows="3">{{ $dataSesion->retro }}</textarea>
                                                    </div>
                                                    <div class="d-grid gap-2" style="margin: 10px">
                                                      <button type="submit" class="btn btn-success" id="bt_{{ $dataSesion->id }}">Modificar</button>
                                                      <div class="alert alert-primary avisoSs"  id="av_{{ $dataSesion->id }}" role="alert"><strong>Guardando datos...</strong> espere un segundo</div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('data-sesions.destroy',$dataSesion->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('¿Desea eliminar esta sesión?')" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
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
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    $('.boxEstudiante').hide();
    $('.avisoSs').hide();
    $('.progress').hide();
    $('.dataEst_' + $('#filterEst').val()).show();

    function viewStudentSm(vv){
        $('.progress').show();
        $('.boxEstudiante').hide();
        $('.dataEst_' + $(vv).val()).show();
        $('.titleEstud').html('<a href="/users/' + $(vv).val() + '/edit">' + $(vv).find('option:selected').text() + '</a>');
    }


    $('.changeSessionSem').submit(function(e) {
        var idDataSel = $(this).attr('dtInf');
        $('#bt_' + idDataSel).hide();
        $('#av_' + idDataSel).show();
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: $('input[name="_method"]').val(),
            data: formData,
            success: function(response) {
                console.log(response)
                $('#bt_' + response).show();
                $('#av_' + response).text('Información guardada correctamente');
            },
        error: function(xhr, status, error) {
            console.log(error);
        }
        });
    });
    </script>
@endsection