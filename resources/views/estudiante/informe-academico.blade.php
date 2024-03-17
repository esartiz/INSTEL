@php
    function formatearFecha($fecha)
    {
        return \Carbon\Carbon::parse($fecha)->day . ' de ' . \Carbon\Carbon::parse($fecha)->monthName . ' de ' . \Carbon\Carbon::parse($fecha)->year;
    }

    $nombresPeriodos = ["", "ENERO-JUNIO DE ".date('Y'), "MARZO-AGOSTO DE ".date('Y'), "JULIO-DICIEMBRE DE ".date('Y'), "SEPTIEMBRE-FEBRERO DE ".(date('Y') + 1), "ENERO-JUNIO  DE ".(date('Y')+1), "MARZO-AGOSTO DE ".(date('Y') +1 )];
    $numPeriodos = ["", "A", "B", "C", "D"];

    $infoPrueba = explode('|', $elGraduando->descr);
    $nombres = $elGraduando->getEstudiante()->nombres;
    $apellidos = $elGraduando->getEstudiante()->apellidos;
    $codigo = substr($elGraduando->getEstudiante()->cod, -4);
    $empresa = $infoPrueba[1];
    $fecha = $infoPrueba[2];
    $evaluacion = explode('-', $infoPrueba[3]);
    $observs = explode('·', $infoPrueba[4]);
    $obsGral = $infoPrueba[5];
    $tp = $infoPrueba[6];
    $cohorte = substr($infoPrueba[7], 0, 4);
    $cohorteLt = $nombresPeriodos[substr($infoPrueba[7], -1)];

    //Datos del certif
    $analisis = [
        [21,"0", "MÒDULO INTRODUCTORIO", "", "<b>Tutores:</b> Aleissy Lasso Ágredo y Grace Salinas Gómez"],
        [22, "I", "GENERALIDADES DE LA COMUNICACIÓN ORGANIZACIONAL", "Durante el desarrollo de este primer Módulo, ".$nombres." demostró entendimiento pleno de los procesos que de manera coordinada coadyuvan en las organizaciones empresariales con un correcto flujo de la información en todas las direcciones.", "<b>Tutora:</b> Grace Salinas Gómez"],
        [23, "II", "PSICOLOGÍA ORGANIZACIONAL", $nombres." tuvo la oportunidad en este Módulo de explorar las conductas de los individuos en interacción y en función de una misma idea; no obstante, como lo pudo analizar, entre los mismos seres humanos existen diferentes perspectivas que alteran tanto el clima organizacional que se vive en las entidades públicas y privadas como las condiciones ideales de productividad de estas.", "<b>Tutora:</b> Tatiana Lucía Lasso Ruíz"],
        [24, "III", "ORGANIZACIÓN DE EVENTOS", "En este Módulo demostró de la mejor manera con varios casos prácticos las estrategias esenciales para organizar desde la logística y las particularidades específicas, cualquier tipo de evento, entendiendo la importancia de estos al interior de las empresas.", "<b>Tutora</b>: Mónica Ramírez"],
        [24, "IV", "ANÁLISIS DE CASOS", "Muchas veces, por más que se planee un evento o cualquier tipo de espectáculo, se presentan fallas de manera parcial o estruendosas… Las razones por las cuales fracasan algunos eventos fueron meticulosamente analizadas por ".$nombres." en este cuarto Módulo.", "<b>Tutora:</b> Mónica Ramírez"],
        [25, "V", "JEFATURA DE PRENSA", "Ya en la parte final del Diplomado, este último Módulo se encargó de mostrarle a ".$nombres." de qué manera es posible hoy día redactar un buen Boletín de Prensa y cuáles son los aspectos relevantes de cualquier comunicación interna en la empresa, el lenguaje que se utiliza, los términos usuales en general la metodología propia de este tipo de redacción especializada.", "<b>Tutor: </b>Aleissy Lasso Ágredo"]
    ];

    $criterios = ["Conocimiento del tema", "Solvencia Expresiva", "Calidad del Trabajo", "Orden y Coherencia", "Calidad de las estrategias formuladas"];

@endphp

<!doctype html>
<html lang="es">

<head>
    <title>INFORME FINAL GESTIÓN ACADÉMICA - INSTEL</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">

    <style> 
        @page {
            margin: 130px 80px 60px 80px !important;
            font-family: Arial, Helvetica, sans-serif;
            color: rgb(9, 53, 124);
        }
        .portada{
            margin: -130px -80px !important;
        }

        .logo {
            position: fixed;
            top: -100px;
            width: 100%;
            text-align: center;
            font-size: 16px;
            color: #000;
        }
        .logo table td {
            border: 1px solid #365f913f;
            padding: 5px;
        }

        .inicioNombres{
            position: absolute;
            z-index: 2;
            left: 0;
            top: 400px;
            font-size: 25px;
            font-weight: bold;
            width: 100%;
            height: 50px;
            color: #FFF;
            text-align: center;
        }

        .inicioDatos {
            position: absolute;
            z-index: 2;
            top: 750px;
            right: 0px;
            font-size: 15px;
            font-weight: bold;
            width: 100%;
            height: 50px;
            color: #133968;
            text-align: center;
        }

        .footer {
            font-family: 'Times New Roman', Times, serif;
            position: fixed;
            bottom: 0px;
            font-size: 20px;
            width: 100%;
            height: 50px;
            color: rgb(104, 104, 104);
            text-align: center;
            box-sizing: border-box;
        }

        p {
            text-align: justify;
        }
        .listaF{
            margin-top: 20px; 
        }
        .listaF li{
            text-align: justify;
            margin-bottom: 5px;
        }

        .tituloBoxTt {
            font-size: 25px;
            font-weight: bold;
            text-align: center;
            padding: 0px;
        }

        .titulo_documento {
            padding: 20px;
            border: 1px solid #000;
            background-color: #ececec;
            text-align: center;
            margin: 20px 0px;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f6fafc;
            /* Color de fondo para filas impares */
        }

        .table-striped tbody tr:nth-child(even) {
            background-color: #ffffff;
            /* Color de fondo para filas pares */
        }

        table {
            font-size: 14px;
            border-collapse: collapse;
            border: 1px solid black;
            width: 100%;
            display: inline-table;
            page-break-inside: avoid;
        }

        table th,
        table td {
            padding: 5px;
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
    <div class="portada">
        <div class="inicioNombres">
            {{ $nombres }} {{ $apellidos }}
        </div>
        <div class="inicioDatos">
                Protocolo No. 1<br>
                <div style="font-size: 22px">
                DIPLOMADO EN COMUNICACIÓN ORGANIZACIONAL<br> CON ÉNFASIS EN JEFATURA DE PRENSA<br>
                {{ $cohorte. '-' . $numPeriodos[substr($infoPrueba[7], -1)]}}
                </div>
                {{ $cohorteLt }}<br>
        </div>
        <img src="{{ public_path('images/portadas/informe.jpg') }}">
    </div>
    <div style="page-break-before: always;"></div>

    <header class="logo">
        <img src="{{ public_path('images/logo_instel.png') }}" width="300px">
    </header>

    <footer class="footer">
        <i>Formamos Profesionales para los Medios de Comunicación...</i>
    </footer>

    


    <div style="margin-top: 100px; border:1px solid #b47258; text-align:center; padding: 10px; font-size:28px; font-family: 'Times New Roman', Times, serif;">
        Informe Final de Resultado Académico
    </div>
    <div style="margin-top:100px; text-align:center; font-weight:bold">
        Protocolo No. 1<br>
        <div style="font-size: 22px">
        DIPLOMADO EN COMUNICACIÓN ORGANIZACIONAL<br> CON ÉNFASIS EN JEFATURA DE PRENSA<br><br>
        {{ $cohorte. '-' . $numPeriodos[substr($infoPrueba[7], -1)]}}
        </div>
        {{ $cohorteLt }}
    </div>
    <div style="margin-top: 100px; border:1px solid #5888b4; text-align:center; padding: 10px; font-size:28px; font-family: 'Times New Roman', Times, serif;">
        {{ Str::upper($nombres.' '.$apellidos) }}<br>
        <div style="font-size: 18px">{{ $elGraduando->getEstudiante()->tipoDoc.' '.$elGraduando->getEstudiante()->doc }}</div>
    </div>
    <div style="margin-top:100px; text-align:center; font-weight:bold">
        Santiago de Cali, {{ formatearFecha($fecha) }}
    </div>
    <div style="page-break-before: always;"></div>




    <div style="background-color: #fcffef; border:1px solid #1a49a7; text-align:center; padding:1px; margin-bottom:20px">
        <h1 style="line-height: 5px; margin-top:35px">ANÁLISIS POS-DIPLOMADO</h1>
        <h3 style="line-height: 5px">SOBRE SU DESEMPEÑO ACADÉMICO GENERAL</h3>
        <h6 style="line-height: 5px; margin-top:-5px"><i>(Con base en los Resultados Finales de cada Módulo cursado)</i></h6>
    </div>

    <table>
        <tr style="background-color:#dadada; font-weight:bold">
            <th>MÓDULO</th>
            <th>CRITERIO CONSENSUADO DEL COMITÉ EVALUADOR</th>
            <th>NOTA</th>
        </tr>
        @foreach ($analisis as $item)
        <tr>
            <td style="text-align: center; background-color:#dadada; font-weight:bold">{{ $item[1] }}</td>
            <td>
            <i>
                <b>{{ $item[2] }}: </b> {{ $item[3] }}<br>
                {!! $item[4] !!}
            </i>
            </td>
            <td style="font-weight: bold; font-size:16px; text-align:center">
                @php
                    $notaBox = $elGraduando->getEstudiante()->lasMatriculas()->where('materia', $item[0])->first();
                    echo ($notaBox ? ($notaBox->def < 3.5 ? $notaBox->hab : $notaBox->def): 'PD');
                @endphp
            </td>
        </tr>
        @endforeach
        
    </table>
    <div style="page-break-before: always;"></div>




    <div style="background-color: #fcffef; border:1px solid #1a49a7; text-align:center; padding:1px; margin-bottom:20px">
        <h1 style="line-height: 5px; margin-top:35px">ANÁLISIS DE LA SUSTENTACIÓN</h1>
        <h3 style="line-height: 5px">DEL TRABAJO DE DIAGNÓSTICO ORGANIZACIONAL</h3>
        <h3 style="line-height: 5px">“Análisis del Sistema de Comunicación Organizacional - {{ $empresa }}”</h3>
        <h6 style="line-height: 5px; margin-top:-5px"><i>(Con base en los Resultados Finales de cada Módulo cursado)</i></h6>
    </div>

    <div style="text-align: center; font-size: 18px">
        <h3>En opinión del Equipo Evaluador:</h3>

        <i>{{ $nombres }} {{ ($tp == "grupo" ? " y sus compañeros de grupo describieron " : " describió ") }} 
        de forma clara el panorama comunicacional de {{ $empresa }} 
        y {{ ($tp == "grupo" ? " visibilizaron " : " visibilizó ") }}  algunas falencias que persisten al interior de la
        entidad en materia de comunicación organizacional.
        <br><br>
        {{ ($tp == "grupo" ? " Formularon " : " Formuló ") }} algunas estrategias básicas las cuales al ser aplicadas
        podrán mejorar en forma sustancial el sistema de comunicación interna y coadyudará en la solución de los errores que impiden una
        elevada eficiencia en este aspecto.
        <br><br>
        {{ ($tp == "grupo" ? " Lograron " : " Logró ") }} identificar los propósitos de la entidad, redifiniendo los
        fines de la organización en el contexto de las entidades que prestan servicios similares y evidenciaron que {{ $empresa }}
        podría operar en mejores condiciones con relación a sus procesos internos y de comunicación organizacional lo cual se podría traducir
        en mejoría notable en su productividad.
        <br><br>
        Consideramos que fue una oportunidad ideal para contribuir con la organización desde la perspectiva de la comunicación organizacional y
        ya les corresponderá a los directivos y demás colaboradores implementar las estrategias encaminadas todas a que los 
        integrantes (clientes internos y externos) se puedan comunicar en mejores condiciones en aras de lograr a futuro mayor eficiencia y
        alta productividad.
        </i>
    </div>

    <div style="border: 1px solid #365f91; text-align:center; padding: 10px; margin-top: 40px">CALIFICACIÓN: ver Planilla de Sustentación (adjunta)</div>
    <div style="page-break-before: always;"></div>




    <div style="background-color: #fcffef; border:1px solid #1a49a7; text-align:center; padding:1px; margin-bottom:30px">
        <h2 style="line-height: 15px; margin-top:15px">EVIDENCIA DE SUSTENTACIÓN DE TRABAJO FINAL</h2>
        <h5 style="line-height: 5px; margin:-5px 0px 2px 0px">Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa – {{ $cohorte. '-' . $numPeriodos[substr($infoPrueba[7], -1)]}}</h5>
    </div>

    <table style="margin-bottom: 30px">
        <tr>
            <th style="text-align: left; border: 1px solid #FFF !important">Estudiante Sustentante:</th>
            <td style="text-align: left; border: 1px solid #FFF !important">{{ $nombres.' '.$apellidos}} {{ ($tp == "grupo" ? " y otros " : "") }}</td>
        </tr>
        <tr>
            <th style="text-align: left; border: 1px solid #FFF !important">Programa de estudio:</th>
            <td style="text-align: left; border: 1px solid #FFF !important">TEC. EN LOCUCIÓN PARA RADIO Y PRESENTAC. DE TELEVISIÓN</td>
        </tr>
        <tr>
            <th style="text-align: left; border: 1px solid #FFF !important">Título del Trabajo:</th>
            <td style="text-align: left; border: 1px solid #FFF !important">{{ $empresa }}</td>
        </tr>
        <tr>
            <th style="text-align: left; border: 1px solid #FFF !important">Fecha evaluación:</th>
            <td style="text-align: left; border: 1px solid #FFF !important">{{ formatearFecha($fecha) }}</td>
        </tr>
        <tr>
            <th style="text-align: left; border: 1px solid #FFF !important">Jurado:</th>
            <td style="text-align: left; border: 1px solid #FFF !important">EFRÉN RIOFRÍO</td>
        </tr>
    </table>

    <table>
        <tr>
            <th>PARÁMETRO EVALUADO</th>
            <th>CRITERIO DEL JURADO</th>
            <th>OBSERVACIÓN ESPECÍFICA</th>
        </tr>
        @for ($i = 0; $i < count($criterios); $i++)
        <tr>
            <th style="text-align: left">{{ $criterios[$i] }}</th>
            <th>{{ $evaluacion[$i] }}</th>
            <td>{{ $observs[$i] }}</td>
        </tr>
        @endfor
    </table>

    <div style="margin: 10px 0px; text-align:center; font-size: 11px">
       <b> NOTA:</b> Los criterios van desde <b>D</b> (Deficiente) hasta <b>E</b> (Excelente) pasando por <b>A</b> (Aceptable) <b>B</b> (Bueno) y <b>MB</b> (Muy Bueno)
    </div>

    @if ($obsGral !== "")
    <div style="margin: 10px 0px; text-align:center">
        <h3>OBSERVACIONES GENERALES</h3>
        {{ $obsGral }}
    </div>
    @endif

    <div style="margin-top: 20px; text-align:center">
        <img src="{{ public_path('images/f-0.png') }}"><br>
        ________________________________________<br>
        Firma del Jurado
    </div>

</body>

</html>
