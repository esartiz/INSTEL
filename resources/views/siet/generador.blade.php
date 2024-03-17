@php
    $semestreNombre = ['N/A', 'Primer Semestre', 'Segundo Semestre', 'Tercer Semestre', 'Semestre de Profudización Animación Musical y Presentación de Espectáculos', 'Semestre de Profudización Lectura de Noticias y Periodismo Radial', 'Semestre de Profudización Periodismo y Locución Deportiva', 'Semestre de Profudización Locución y Presentación de Televisión', 'Semestre de Profudización Producción y Locución Comercial', 'Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa'];
@endphp
<table class="table" border="1">
    <thead>
        <tr>
            <th colspan="3" scope="col">DATOS MATRICULA</th>
            <th scope="col"></th>
            <th colspan="2" scope="col">DATOS DE PROGRAMA</th>
            <th colspan="13" scope="col">DATOS PERSONALES</th>
            <th colspan="7" scope="col">MULTICULTURALIDAD</th>
        </tr>
        <tr>
            <th scope="col">FECHA ACT.</th>
            <th scope="col">PROGRAMA</th>
            <th scope="col">SEMESTRE/NIVEL</th>
            <th scope="col">CONSECUTIVO</th>
            <th scope="col">FECHA DE INGRESO</th>
            <th scope="col">JORNADA</th>
            <th scope="col">TIPO DE IDENTIFICACIÓN</th>
            <th scope="col">NÚMERO DE IDENTIFICACIÓN</th>
            <th scope="col">NOMBRES</th>
            <th scope="col">APELLIDOS</th>
            <th scope="col">GÉNERO</th>
            <th scope="col">ESTADO CIVIL</th>
            <th scope="col">FECHA NACIMIENTO</th>
            <th scope="col">LUGAR DE ORIGEN</th>
            <th scope="col">ESTRATO</th>
            <th scope="col">RÉGIMEN DE SALUD</th>
            <th scope="col">NIVEL DE FORMACIÓN</th>
            <th scope="col">OCUPACIÓN</th>
            <th scope="col">DISCAPACIDAD</th>
            <th scope="col">INDÍGENA</th>
            <th scope="col">AFRODESCENDIENTE</th>
            <th scope="col">DESPLAZADO</th>
            <th scope="col">POBLACIÓN DE FRONTERA</th>
            <th scope="col">CABEZA DE FAMILIA</th>
            <th scope="col">REINSERTADO</th>
            <th scope="col">POBLACIÓN ROMM</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $item)
        <tr class="">
            <td>{{ $item->updated_at }}</td>
            <td>
                @if ($item->userSIET()->misBoxMatriculas()->where('estado', 'ACTIVO')->first())
                    {{ $item->userSIET()->misBoxMatriculas()->where('estado', 'ACTIVO')->first()->getPrograma()->nombre }}
                @else
                S/M
                @endif
            </td>
            <td>
                @if ($item->userSIET()->misBoxMatriculas()->where('estado', 'ACTIVO')->first())
                    {{ $semestreNombre[$item->userSIET()->misBoxMatriculas()->where('estado', 'ACTIVO')->first()->nivel] }}
                @endif
            </td>
            <td scope="row" style="text-align: center">{{ $loop->iteration }}</td>
            <td style="text-align: center">{{ $item->userSIET()->grupo }}</td>
            <td></td>
            <td style="text-align: center">{{ $item->userSIET()->tipoDoc }}</td>
            <td>{{ $item->userSIET()->doc }}</td>
            <td>{{ $item->userSIET()->nombres }}</td>
            <td>{{ $item->userSIET()->apellidos }}</td>
            <td>{{ $item->userSIET()->sexo }}</td>
            <td>{{ $item->estadoCivil }}</td>
            <td>{{ $item->userSIET()->fecha_nac }}</td>
            <td>{{ $item->lugarNace }}</td>
            <td style="text-align: center">{{ $item->estrato }}</td>
            <td>{{ $item->eps }}</td>
            <td>{{ $item->nivelFormacion }}</td>
            <td>{{ $item->ocupacion }}</td>
            <td>{{ $item->discapacidad }}</td>
            <td style="text-align: center">@if (stripos($item->multicult, 'indi') !== false) X @endif</td>
            <td style="text-align: center">@if (stripos($item->multicult, 'afro') !== false) X @endif</td>
            <td style="text-align: center">@if (stripos($item->multicult, 'despl') !== false) X @endif</td>
            <td style="text-align: center">@if (stripos($item->multicult, 'fron') !== false) X @endif</td>
            <td style="text-align: center">@if (stripos($item->multicult, 'abeza') !== false) X @endif</td>
            <td style="text-align: center">@if (stripos($item->multicult, 'reins') !== false) X @endif</td>
            <td style="text-align: center">@if (stripos($item->multicult, 'Población RO') !== false) X @endif</td>
        </tr>
        @endforeach
    </tbody>
</table>