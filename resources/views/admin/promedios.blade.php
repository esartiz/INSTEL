@extends('layouts.admin')

@section('template_title')
    Promedios actuales
@endsection

@section('content')
    <h1>Promedios del periodo {{ $listaEst->first()->periodo }} del ciclo {{ $listaEst->first()->nivel }}</h1>

    <table class="table table-light promedioTable">
        <thead>
            <tr>
                <th scope="col">Estudiante</th>
                <th scope="col">Notas</th>
                <th scope="col">Promedio</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($listaEst as $item)
                @php
                    $sumNot = 0;
                    $nHab = 0;
                    $nRec = 0;
                @endphp
                <tr class="">
                    <td scope="row">
                        <a href="/users/{{ $item->user }}/edit" target="_blank">{{ $item->getEstudiante()->apellidos }}
                            {{ $item->getEstudiante()->nombres }} </a><br>
                        <small
                            class="muted-text">SMT{{ $item->nivel }}-{{ Session::get('config')['gruposNombre'][substr($item->periodo, -1)] }}{{ substr($item->periodo, -1) > 4 ? '-SABATINO' : '-VIRTUAL' }}</small>
                    </td>
                    <td class="row text-center">
                        @foreach ($item->materias() as $mt)
                            @php
                                $definitiva = $mt->n1 * 0.3 + $mt->n2 * 0.3 + $mt->n3 * 0.4;
                                $sumNot += $definitiva;
                                $nHab += $mt->hab == null ? 0 : 1;
                                $nRec += $mt->rem == null ? 0 : 1;
                            @endphp
                            <div class="col-6">
                                <div class="row m-1">
                                    <div class="col-12"
                                        style="font-weight: bold; font-size:10px; border-bottom: 1px solid #00468c54;">
                                        {{ $mt->modulos_s()->first()->titulo }}</div>
                                    <div class="col-3">
                                        <div style="font-size: 8px; margin-bottom:-30px"> PARCIAL 1</div><br>
                                        {{ $mt->n1 }}
                                    </div>
                                    <div class="col-3">
                                        <div style="font-size: 8px; margin-bottom:-30px"> PARCIAL 2</div><br>
                                        {{ $mt->n2 }}
                                    </div>
                                    <div class="col-3">
                                        <div style="font-size: 8px; margin-bottom:-30px"> PARCIAL 3</div><br>
                                        {{ $mt->n3 }}
                                    </div>
                                    <div class="col-3">
                                        <div style="font-size: 8px; margin-bottom:-30px"> DEFINITVA</div><br>
                                        {{ $definitiva }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </ul>
                    </td>
                    <td class="text-center">
                        <div style="font-weight: bold; font-size:33px; margin-bottom:-30px">
                            {{ number_format($sumNot > 0 ? $sumNot / $item->materias()->count() : 0, 2, ',', '.') }}
                        </div>
                        <small class="text-muted">
                            <br>RECUP: {{ $nHab }}
                            <br>REPOS: {{ $nRec }}
                        </small>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $(".promedioTable").DataTable();

        function buscaLista() {
            var dataTable = $('.promedioTable').DataTable();
            dataTable.search('SMT' + $('#cicloID').val() + '-' + $('#grupoID').val()).draw();
        }
    </script>
@endsection
