@extends('layouts.admin')

@section('template_title')
    Usuarios Graduados
@endsection

@section('content')
    <h3>En el sistema se registran {{ $users->count() }} graduandos en diferentes programas</h3>
    <div class="row">
        <div class="col-12 mb-4">
            <label for="" class="form-label">Programa</label>
            <select class="form-select" name="" id="filtraPorPg">
                <option value="">Seleccione</option>
                @foreach ($listaFiltro as $item)
                    <option value="{{ $item->id }}">{{ $item->tipo.' '.$item->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <table class="table" id="usuariosTable">
        <thead>
            <tr>
                <th scope="col">Estudiante</th>
                <th scope="col">Programa</th>
                <th scope="col">Fecha</th>
                <th scope="col">Acta</th>
                <th scope="col">Folio</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="">
                    <td scope="row">
                        <a href="{{ route('users.edit', $user->user) }}" target="_blank">
                            {{ $user->getEstudiante()->apellidos }} {{ $user->getEstudiante()->nombres }}
                        </a>
                    </td>
                    <td>{{ $user->getPrograma()->nombre }} <span style="font-size: 1px">filt_{{ $user->prg }}</span></td>
                    <td>{{ $user->fechaEgreso }}</td>
                    <td>{{ $user->acta }}</td>
                    <td>{{ $user->folio }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#usuariosTable").DataTable();
            $('.btwToolt').tooltip();
        });

        $('#filtraPorPg').change(function() {
            var table = $('#usuariosTable').DataTable();
            var searchMe = 'filt_' + $(this).val();
            if (searchMe == 'filt___') {
                searchMe = '';
            }
            console.log(searchMe)
            table.column(1).
            search(searchMe, true, false).
            draw();
        });
    </script>
@endsection
