@extends('layouts.admin')

@section('template_title')
    Seminarios | 
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <div class="mb-3 col-6">
                                    <label for="" class="form-label">Ver sesiones de seminario</label>
                                    <select class="form-select" id="showProg" required>
                                        <option selected>Seleccionar</option>
                                        @foreach ($seminarList as $item)
                                        <option value="{{ $item->id }}"@if (Session::get('seminarioSelect') == $item->id) selected @endif>{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </span>

                             <div class="float-right">
                                <a href="{{ route('data-seminars.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  Crear nueva sesión para un Seminario
                                </a>
                              </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
										<th>Seminario-Taller</th>
										<th>Sesión</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataSeminars as $dataSeminar)
                                        <tr class="data_{{ $dataSeminar->prg}} datosSesiones">
											<td>{{ $dataSeminar->programa()->nombre }}</td>
											<td>
                                                @if (Storage::exists('userfiles/seminarios/'.$dataSeminar->recurso.'.pdf'))
                                                <a href="{{ route('ft','seminarios|'.$dataSeminar->recurso.'.pdf')}}" target="_blank"> {{ $dataSeminar->sesionID }} </a>
                                                @else
                                                {{ $dataSeminar->sesionID }}
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('data-seminars.destroy',$dataSeminar->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-success" href="{{ route('data-seminars.edit',$dataSeminar->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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

                <br>

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Generar sesiones a un seminario
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('data-seminars.store')}}" method="post" class="row">
                        @csrf
                        <div class="mb-3 col-6">
                            <label for="" class="form-label">Seminario</label>
                            <select class="form-select" name="prg" id="prg" required>
                                <option selected>Seleccionar</option>
                                @foreach ($seminarList as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                          <label for="" class="form-label">N. Sesiones</label>
                          <input type="number" class="form-control" name="nSesiones" required>
                        </div>
                        <button type="submit" class="btn btn-info">Crear Sesiones</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $('.datosSesiones').hide();
    $('.data_{{Session::get('seminarioSelect')}}').show();

    $('#showProg').change(function(){
        $('.datosSesiones').hide();
        $('.data_' + $(this).val()).show();
    })
</script>
@endsection