<?php
$semList = 0;
$notasTotal = 0;
$materiasTotal = 0;
$promSem = 0;
$elUs = $lasMatriculas->first()->getEstudiante();

//Nombre de los semestres
$semestreNombre = ['', 
                    'Primer Semestre', 
                    'Segundo Semestre', 
                    'Tercer Semestre', 
                    'Semestre de Profudización Animación Musical y Presentación de Espectáculos',
                    'Semestre de Profudización Lectura de Noticias y Periodismo Radial',
                    'Semestre de Profudización Periodismo y Locución Deportiva',
                    'Semestre de Profudización Locución y Presentación de Televisión',
                    'Semestre de Profudización Producción y Locución Comercial',
                    'Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa'
];

function fechaEs($fecha, $refData)
{
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $diaNominal = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciseis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte', 'veintiuno ', 'vientidos ', 'veintitrés ', 'veinticuatro', 'veinticinco', 'veintiséis', 'veintisiete', 'veintiocho', 'veintinueve', 'treinta', 'treinta y uno'];
    $dias_ES = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    $dias_EN = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    //$nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $meses_EN = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    if ($refData == 0) {
        $laFechaFormat = $numeroDia . ' de ' . $nombreMes . ' de ' . $anio;
    } else {
        $laFechaFormat = $diaNominal[(int)$numeroDia] . ' (' . $numeroDia . ') del mes de ' . $nombreMes . ' de ' . $anio;
    }
    return $laFechaFormat;
}

$matriculaCertificar = $lasMatriculas->last();
foreach ($lasMatriculas as $item){
    if($item->estado !== "INACTIVO"){
        $matriculaCertificar = $item;
    }
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>INSTEL - Certificado de Notas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">
    <style>
        @page {
            margin: 140px 50px 50px 50px !important;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        .logo {
            position: fixed;
            top: -130px;
            width: 100%;
            text-align: center;
            font-size: 12px;
        }

        .referencia {
            font-size: 12px;
            font-weight: bold;
        }

        .contenido {
            text-align: justify;
            font-size: 14px;
        }

        .haceConstar {
            font-size: 26px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0px;
        }

        .titular {
            text-transform: uppercase;
            font-weight: bold;
        }

        .code-qr {
            background-color: #FFF;
            position: absolute;
            top: 0px;
            font-size: 9px;
            width: 150px;
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 15px; 
            font-family: 'Times New Roman', Times, serif;
            font-size: 16px;
            width: 100%;
            color: #989898;
            text-align: center;
            box-sizing: border-box;
        }

        .hojaConNotas {
            page-break-after: always;
        }

        table {
            border-collapse: collapse;
            border: 1px solid black;
            width: 100%;
            display: inline-table;
            page-break-inside: avoid;
        }

        table th,
        table td {
            border: solid 1px;
        }

        table tbody:empty {
            display: none;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <header class="logo">
<img src="https://virtual.instel.edu.co/images/logo.png">
<br>
<br>
Calle 15 Norte No. 8N-54 B/Granada Cali, Colombia<br>
www.instel.edu.co
</header>

    <footer class="footer">
        <i>Formamos Profesionales para los Medios de Comunicación…</i>
    </footer>


    <div class="contenido">
        <p class="referencia">
            REF. {{ $lasMatriculas->first()->getEstudiante()->cod }}
        </p>
        Santiago de Cali, {{ fechaEs(date('Y-m-d'), 0) }}
        <br><br>
        El suscrito Director General del <b>INSTITUTO NACIONAL DE TELECOMUNICACIONES LTDA “INSTEL LTDA”,</b>
        entidad autorizada por el Estado colombiano para impartir Programas Educativos en el área de las Comunicaciones
        para Medios Audiovisuales, según Resoluciones No. 0635 de 1991, 0557 y 0719 de 2000 y la reciente Resolución
        No. 4143.010.2-06533 de DICIEMBRE 20 de 2020, emanadas de la Secretaría de Educación del Municipio de Santiago
        de Cali según las facultades conferidas por la Ley 115 de 1994 y el Decreto 1075 de mayo de 2015,

        <div class="haceConstar">
            HACE CONSTAR
        </div>

        Que <span class="titular">{{ $lasMatriculas->first()->getEstudiante()->nombres . ' ' . $lasMatriculas->first()->getEstudiante()->apellidos }}</span> titular de la cédula
        de ciudadanía No. {{ $lasMatriculas->first()->getEstudiante()->doc }} de {{ $lasMatriculas->first()->getEstudiante()->doc_ex }}, es 
        @switch($matriculaCertificar->estado)
            @case("ACTIVO")
                @if ($elUs->sexo == "Masculino")<b>ESTUDIANTE ACTIVO </b> @else <b>ESTUDIANTE ACTIVA </b> @endif
                de nuestra institución en el programa <b>{{ Str::upper($lasMatriculas->first()->getPrograma()->tipo . '  EN ' . $lasMatriculas->first()->getPrograma()->nombre) }} </b>
                cursando  <b> {{ Str::upper($semestreNombre[$matriculaCertificar->nivel]) }} </b> en el periodo 
                <b> {{ Session::get('config')['nombrePeriodos'][substr($matriculaCertificar->periodo, -1)] }} </b> del presente 
                bajo el Registro No. <b>{{ substr($lasMatriculas->first()->getEstudiante()->cod, -4) }}</b>.
            @break
            @case("GRADUADO")
                @if ($elUs->sexo == "Masculino")<b>GRADUADO </b> @else <b>GRADUADA </b> @endif
                de nuestra institución en el programa <b>{{ Str::upper($lasMatriculas->first()->getPrograma()->tipo . '  EN ' . $lasMatriculas->first()->getPrograma()->nombre) }} </b>
                finalizando satisfactoriamente los contenidos programáticos del mismo como se registró en el <b>ACTA {{ $matriculaCertificar->acta }} </b>
                que reposa en el <b>FOLIO {{ $matriculaCertificar->folio }} </b> del día <b> {{ fechaEs($matriculaCertificar->fechaEgreso, 1) }}</b>.
                @break
            @default
                @if ($elUs->sexo == "Masculino")<b>ESTUDIANTE INACTIVO </b> @else <b>ESTUDIANTE INACTIVA </b> @endif
                de nuestra institución en el programa <b>{{ Str::upper($lasMatriculas->first()->getPrograma()->tipo . '  EN ' . $lasMatriculas->first()->getPrograma()->nombre) }} </b>
                cursando hasta el <b> {{ Str::upper($semestreNombre[$matriculaCertificar->nivel]) }} </b> en el periodo 
                <b> {{ Session::get('config')['nombrePeriodos'][substr($matriculaCertificar->periodo, -1)] }} </b> de {{ substr($matriculaCertificar->periodo, 0, 4) }}
                bajo el Registro No. <b>{{ substr($lasMatriculas->first()->getEstudiante()->cod, -4) }}</b>.
        @endswitch
        

        @if ($tipoCert == 2)
            <p>A su solicitud se adjuntan las notas correspondientes a los semestres.</p>
        @endif

        @if ($tipoCert == 3)
            <p>
                A su solicitud se adjunta <b>INFORME DE NOTAS</b> y <b>CONTENIDO
                    PROGRAMÁTICO INSTITUCIONAL</b> correspondiente al Programa de Estudio
                con el propósito de presentar en la UNAD a efectos de homologación en virtud al
                Convenio interinstitucional vigente. Debe anexarse el resto de documentos que
                le exijan.
            </p>
        @endif

        <p>
            Se firma en Santiago de Cali, para los fines pertinentes el día {{ fechaEs(date('Y-m-d'), 1) }}.
        </p>

        <p>Certifica,</p>
        <img src="https://virtual.instel.edu.co/images/20230209_154436.png" height="120" alt=""><br>
        <div style="font-size: 11px; margin-top:-20px">
            <span class="titular">ALEISSY LASSO ÁGREDO</span><br>
            Director General <br>
            T.P. No. 40686 Min. Educación Nacional<br>
            Miembro de la Asociación Colombiana de Locutores, ACL
        </div>
    </div>


    @if ($tipoCert != 1)


        <div class="hojaConNotas"></div>

    <div class="contenido">

        <div style="text-align: center; font-size:20px; margin: 10px 0px; font-weight: bold;">INFORME DE NOTAS</div>
        <table>
            <tbody>
                <tr class="">
                    <td>Estudiante:</td>
                    <td>{{ $elUs->apellidos . ' ' . $elUs->nombres }}</td>
                    <td>Identificación:</td>
                    <td>{{ $elUs->tipoDoc . ' ' . $elUs->doc }}</td>
                </tr>
            </tbody>
        </table>

        @foreach ($lasMatriculas as $item)
        @if ($item->estado !== "ACTIVO" && $item->materias()->count() > 0)
        @php
            $promSem = 0;
        @endphp
            
        <table style="font-size: 14px; text-align: center; margin-top:30px">
            <thead>
                <tr>

                    <td colspan="4" style="font-weight: bold;background-color: #efeded;">
                     {{ $semestreNombre[$item->nivel] }} 
                    </td>

                </tr>
                <tr>
                    <th style="width: 40%">Componente Temático</th>
                    <th style="width: 10%">Nota</th>
                    <th style="width: 30%">Letras</th>
                    <th style="width: 20%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item->materias() as $modulo)
                @php
                    $nota = ($modulo->hab == NULL ? $modulo->def : $modulo->hab);
                    $promSem += $nota;
                    $notasTotal += $nota;
                    $materiasTotal++; 
                @endphp
                <tr>
                    <td>{{ $modulo->n_materia }}</th>
                    <td>{{ $nota }}</th>
                    <td>{{ $formatter->toWords(($modulo->hab == null ? $modulo->def : $modulo->hab), 1) }}</th>
                    <td>{{ $modulo->resultado }}</td>
                </tr>
                @endforeach
                <tr>
                    <td style="text-align:right; font-weight: bold;background-color: #efeded;">
                        Promedio Semestre:
                    </td>
                    <td style="text-align:center; font-weight: bold;background-color: #efeded;">
                        {{ number_format($promSem / $item->materias()->count(), 2, '.', '') }}
                    </td>
                    <td style="text-align:center; font-weight: bold;background-color: #efeded;">
                        {{ $formatter->toWords(number_format($promSem / $item->materias()->count(), 2, '.', ''),2) }}
                    </td>
                    <td style="font-weight: bold;background-color: #efeded;">
                        Periodo: {{ $item->periodo }}
                    </td>
                </tr>
                
            </tbody>
        </table>

        @endif
        @endforeach

        <p>
        <b>Promedio consolidado estudiante: {{ number_format($notasTotal / $materiasTotal, 2, '.', '') }} ({{ $formatter->toWords(number_format($notasTotal / $materiasTotal, 2, '.', '')) }})</b>
        </p>

        <p>
            Expedido en Santiago de Cali, el día {{ fechaEs(date('Y-m-d'), 1) }}.
        </p>

        <p>Certifica,</p>
        <img src="https://virtual.instel.edu.co/images/20230209_154436.png" height="120" alt=""><br>

        <div style="font-size: 11px; margin-top:-20px">
            <span class="titular">ALEISSY LASSO ÁGREDO</span><br>
            Director General <br>
            T.P. No. 40686 Min. Educación Nacional<br>
            Miembro de la Asociación Colombiana de Locutores, ACL
        </div>

    @endif
    </div>
</body>

</html>
