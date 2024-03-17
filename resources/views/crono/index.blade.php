@extends('layouts.admin')

@section('template_title')
    Temporalidad Académica
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Defina el periodo de cada semana académica
                            </span>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('cronos.store') }}"  role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="box-body row">
                                <div class="form-group col-4">
                                    Nombre referencia:
                                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                                </div>
                                <div class="form-group col-3">
                                    Inicia:
                                    <input type="date" name="ini" id="ini_0" onchange="ajustF(0)" class="form-control" required>
                                </div>
                                <div class="form-group col-3">
                                    Finaliza:
                                    <input type="date" name="fin" id="fin_0" class="form-control" required>
                                </div>   
                                <div class="box-footer mt20 col-2">
                                    _<br>
                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                </div>                     
                            </div>
                            
                        </div>

                    </form>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>ID</th>
										<th>Nombre Referencia</th>
										<th>Inicio</th>
										<th>Fin</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cronos as $crono)

                                    <form method="POST" action="{{ route('cronos.update', $crono->id) }}"  role="form" enctype="multipart/form-data">
                                        {{ method_field('PATCH') }}
                                        @csrf
            
                                        <tr>
                                            <td>{{ ++$i }}</td>
											<td><input type="text" name="nombre" id="nombre" class="form-control" value="{{ $crono->nombre }}" required></td>                                            
											<td><input type="date" name="ini" id="ini_{{ $crono->id }}" onchange="ajustF({{ $crono->id }})"  class="form-control" value="{{ $crono->ini }}" required></td>                                            
											<td><input type="date" name="fin" id="fin_{{ $crono->id }}" class="form-control" value="{{ $crono->fin }}" required></td>
                                            <td>
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-fw fa-edit"></i> Editar</button>
                                            </form>
                                        </td><td>
                                                <form action="{{ route('cronos.destroy',$crono->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar este periodo de tiempo?')"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
            
                                   
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $cronos->links() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function ajustF(tt){
        var date = new Date($('#ini_' + tt).val());
        date.setDate(date.getDate() + 6);
        document.getElementById("fin_" + tt).valueAsDate = date;
    }
</script>
@endsection