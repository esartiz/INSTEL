@extends('layouts.admin')

@section('template_title')
    Financiamiento INSTEL
@endsection

@section('content')

    <div style="margin: 10px; padding:10px; border: 1px solid #c6c6c6" class="text-center">
        Listado de financiamientos creados. Del mas reciente al más antiguo por defecto. Para gestionarlo, ingrese al perfil de cada usuario<br>
    </div>

    <table class="table pagosTable table-striped" style="font-size: 14px">
        <thead>
            <tr>
                <th scope="col" style="width: 10%">Estado</th>
                <th scope="col" style="width: 20%">Estudiante</th>
                <th scope="col" style="width: 10%">Referencia</th>
                <th scope="col" style="width: 30%">Programa</th>
                <th scope="col" style="width: 10%">Valor</th>
                <th scope="col" style="width: 20%">Plazos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($creditos as $item)
            @php
                $plazos = explode('|',$item->plan);
            @endphp
            <tr class="">
                <td>{{ $item->matriculaCredito()->estado }}</td>
                <td>
                    <a href="{{ route('users.edit', $item->pagEstudiante()->id) }}">
                        {{ $item->pagEstudiante()->nombres.' '.$item->pagEstudiante()->apellidos }}
                    </a>
                </td>
                <td>{{ $item->contratoID }}</td>
                <td>{{ $item->matriculaCredito()->getPrograma()->nombre ?? 'ND' }}</td>
                <td>{{ $item->valor }}</td>
                <td>
                    @foreach ($plazos as $itemPlazo)
                    @if (!$loop->last)
                    Cuota {{ $loop->iteration }}: {{ $itemPlazo }}<br>
                    @endif
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

        
@endsection

@section('scripts')
    <script>
        $(".pagosTable").DataTable();
        var pagare;
    </script>
@endsection
