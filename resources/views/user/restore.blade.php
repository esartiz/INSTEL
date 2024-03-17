@extends('layouts.admin')

@section('template_title')
    Usuarios Deshabilitados
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            
                            <h3>Usuarios Deshabilitados</h3>

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
										<th class="col-2">Nombre</th>
										<th class="col-2">Contacto</th>
										<th class="col-3">Datos</th>
										<th class="col-3">Desactivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <a href="/users/{{ $user->id }}/edit">
                                            {{ $user->apellidos }} {{ $user->nombres }}
                                            </a>
                                        </td>
                                        <td>{{ $user->telefono }}<br>{{ $user->email }}</td>
                                        <td>{{ $user->doc }} de {{ $user->doc_ex }}<br>{{ $user->fecha_nac }}<br>Cód: {{ $user->cod }}</td>
                                        <td>{{ $user->deleted_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#usuariosTable").DataTable();
    });
</script>
@endsection