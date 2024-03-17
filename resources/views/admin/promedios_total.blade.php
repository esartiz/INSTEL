@extends('layouts.admin')

@section('template_title')
    Promedios consolidados Carrera
@endsection

@section('content')
<h1>Promedios consolidados Carrera</h1>
<div class="row mb-3">
    <div class="col-8">
        <label for="" class="form-label">Semestre</label>
        <select class="form-select" name="ciclo" onchange="buscaLista()" id="cicloID">
            <option value="">Seleccione</option><option value="1">Semestre 1</option><option value="2">Semestre 2</option><option value="3">Semestre 3</option><option value="4">Semestre de Profudización Animación Musical y Presentación de Espectáculos</option><option value="5">Semestre de Profudización Lectura de Noticias y Periodismo Radial</option><option value="6">Semestre de Profudización Periodismo y Locución Deportiva</option><option value="7">Semestre de Profudización Locución y Presentación de Televisión</option><option value="8">Semestre de Profudización Producción y Locución Comercial</option><option value="9">Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa</option></select>
    </div>
    <div class="col-4">
        <label for="" class="form-label">Grupo</label>
        <select class="form-select" name="grupo" onchange="buscaLista()" id="grupoID">
            <option value="">Seleccione</option>
            <option value="A">Grupo A</option>
            <option value="B">Grupo B</option>
            <option value="C">Grupo C</option>
            <option value="D">Grupo D</option>
        </select>
    </div>
</div>

    <table class="table table-light promedioTable">
        <thead>
            <tr>
                <th scope="col">Estudiante</th>
                <th scope="col" class="text-center">Grupo</th>
                <th scope="col" class="text-center">Sem 1</th>
                <th scope="col" class="text-center">Sem 2</th>
                <th scope="col" class="text-center">Sem 3</th>
                <th scope="col" class="text-center">Sem Prf</th>
                <th scope="col" class="text-center">Sem Dip</th>
            </tr>
        </thead>
        <tbody>

            @php 
                $idNom = '';
                $dataN = $results->whereNotNull('consol')->where('totalMat', '>', 0);
            @endphp
            @foreach ($results as $item)
            @if($item->estudiante !== $idNom)
            @if (!$loop->first)</tr> @endif
            <tr class="">
                <td scope="row">
                    <a href="/users/{{ $item->estudiante }}/edit" target="_blank">
                        {{ $item->user()->first()->nombres. ' '.$item->user()->first()->apellidos }}
                    </a>
                </td>
                <td class="text-center">
                    SMT{{ $item->user()->first()->ciclo }}-{{ Session::get('config')['gruposNombre'][substr($item->user()->first()->grupo,-1)] }}
                </td>
                @php
                    //Calculos por semestre
                    $ttNts = [];
                    for ($i=0; $i < 10; $i++) {
                        $dt = $dataN->where('estudiante', $item->estudiante)->where('sem', $i)->first();
                        if($dt !== null){
                            $prom = ($dt['totalMat'] > 0 ? $dt['consol'] / $dt['totalMat'] : 0);
                            array_push($ttNts, [$dt['consol'], $dt['totalMat'], $item->hbts, $item->rcp]);
                        } else {
                            array_push($ttNts, [0, 0, $item->hbts, $item->rcp]);
                        }
                    }
                    $prm1 = ($ttNts[1][1] > 0 ? number_format($ttNts[1][0] / $ttNts[1][1], 2, '.', '') : 0);
                    $prm2 = ($ttNts[2][1] > 0 ? number_format($ttNts[2][0] / $ttNts[2][1], 2, '.', '') : 0);
                    $prm3 = ($ttNts[3][1] > 0 ? number_format($ttNts[3][0] / $ttNts[3][1], 2, '.', '') : 0);
                    $smPrfCns = $ttNts[4][0] + $ttNts[5][0] + $ttNts[6][0] + $ttNts[7][0] + $ttNts[8][0];
                    $smPrfnMat = $ttNts[4][1] + $ttNts[5][1] + $ttNts[6][1] + $ttNts[7][1] + $ttNts[8][1];
                    $smPrfHab = $ttNts[4][2] + $ttNts[5][2] + $ttNts[6][2] + $ttNts[7][2] + $ttNts[8][2];
                    $smPrfnRep = $ttNts[4][3] + $ttNts[5][3] + $ttNts[6][3] + $ttNts[7][3] + $ttNts[8][3];
                    $prm4 = ($smPrfnMat > 0 ? number_format($smPrfCns / $smPrfnMat, 2, '.', '') : 0);
                    $prm5 = ($ttNts[9][1] > 0 ? number_format($ttNts[9][0] / $ttNts[9][1], 2, '.', '') : 0);
                @endphp
                <td class="text-center @if($prm1 >= 4.5) bg-success text-white @endif">
                    {{ $prm1 }} 
                    <div style="font-size: 10px">MODULOS: {{ $ttNts[1][1] }}</div>
                    <div style="font-size: 10px">HABILTS: {{ $ttNts[1][2] }}</div>
                    <div style="font-size: 10px">REPOSIC: {{ $ttNts[1][3] }}</div>
                </td>
                <td class="text-center @if($prm2 >= 4.5) bg-success text-white @endif">
                    {{ $prm2 }} 
                    <div style="font-size: 10px">MODULOS: {{ $ttNts[2][1] }}</div>
                    <div style="font-size: 10px">HABILTS: {{ $ttNts[2][2] }}</div>
                    <div style="font-size: 10px">REPOSIC: {{ $ttNts[2][3] }}</div>
                </td>
                <td class="text-center @if($prm3 >= 4.5) bg-success text-white @endif">
                    {{ $prm3 }} 
                    <div style="font-size: 10px">MODULOS: {{ $ttNts[3][1] }}</div>
                    <div style="font-size: 10px">HABILTS: {{ $ttNts[3][2] }}</div>
                    <div style="font-size: 10px">REPOSIC: {{ $ttNts[3][3] }}</div>
                </td>
                <td class="text-center @if($prm4 >= 4.5) bg-success text-white @endif">
                    {{ $prm4 }} 
                    <div style="font-size: 10px">MODULOS: {{ $smPrfnMat }}</div>
                    <div style="font-size: 10px">HABILTS: {{ $smPrfHab }}</div>
                    <div style="font-size: 10px">REPOSIC: {{ $smPrfnRep }}</div>
                </td>
                <td class="text-center @if($prm5 >= 4.5) bg-success text-white @endif">
                    {{ $prm5 }} 
                    <div style="font-size: 10px">MODULOS: {{ $ttNts[9][1] }}</div>
                    <div style="font-size: 10px">HABILTS: {{ $ttNts[5][2] }}</div>
                    <div style="font-size: 10px">REPOSIC: {{ $ttNts[5][3] }}</div>
                </td>
                @endif
            @if ($loop->first)</tr> @endif
            @php $idNom = $item->estudiante @endphp
            @endforeach
            
        </tbody>
    </table>

@endsection

@section('scripts')
<script>
    $(".promedioTable").DataTable();
    function buscaLista(){
        var dataTable = $('.promedioTable').DataTable();
        dataTable.search('SMT' + $('#cicloID').val() + '-' + $('#grupoID').val()).draw();
    }
</script>
@endsection
