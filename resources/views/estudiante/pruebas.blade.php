@php
    function formatearFecha($fecha)
    {
        return \Carbon\Carbon::parse($fecha)->day . ' de ' . \Carbon\Carbon::parse($fecha)->monthName . ' de ' . \Carbon\Carbon::parse($fecha)->year;
    }
    $pruebaData = [
        "pruebacomp1" => 'Tal como estaba programado, a <b>'.$elGraduando->getEstudiante()->nombres.'</b> se le citó a la prueba bajo los parámetros previamente determinados e informados. A la hora señalada se le suministró el Instrumento de Evaluación el cual fue respondido dentro del tiempo asignado. La prueba se dividió en los siguientes aspectos: Presentación Musical, Locución Radial Comercial, Locución Radial Noticiosa, Técnica Improvisativa, Reportería desde el sitio de los hechos y preguntas de conocimientos generales en Radio. Tiempo estándar de la prueba: 60’. Tiempo utilizado: 60’.',
        "pruebacomp2" => '<b>'.$elGraduando->getEstudiante()->nombres.'</b> cumplió con la Prueba de Aptitud en TÉCNICA VOCAL APLICADA A LA LOCUCIÓN, bajo los parámetros previamente determinados e informados. A la hora señalada se le suministró el Instrumento de Evaluación en tiempo real el cual fue respondido dentro del horario asignado. La prueba se dividió en secciones con claras finalidades: palabras con algún grado de dificultad, ejercicios con trabalenguas, interpretación de textos y técnica vocal aplicada a la lectura noticiosa.',
        "pruebacomp3" => 'Se le suministraron a <b>'.$elGraduando->getEstudiante()->nombres.'</b> los  parámetros previamente determinados e informados mediante el  instrumento apreciativo de sus competencias. A la hora indicada  se le hizo conocer dicho instrumento de evaluación en tiempo real  para que pudiera responderlo dentro del horario asignado. La  prueba constó de preguntas de apreciación ortográfica,  composicional, de redacción informativa, publicitaria y de  comprensión noticiosa.',
        "pruebacomp4" => 'Siguiendo los parámetros reglamentarios <b>'.$elGraduando->getEstudiante()->nombres.'</b> presentó la prueba tal y como estaba programada. A la hora señalada se le suministró el Instrumento de Evaluación en tiempo real el cual fue respondido dentro del horario asignado. La prueba se dividió en cuatro secciones: dos temas específicos nacionales, un tema específico internacional y preguntas de conocimientos sobre temas generales (economía, geografía, historia, capitales y monedas de países latinoamericanos).'
    ];
    $pruebaDescr = [
        "pruebacomp1" => '<b>1 - Producción y Locución Radial:</b> Conocimientos, habilidades y destrezas frente al micrófono tanto en cabina como en escenarios remotos.',
        "pruebacomp2" => '<b>2 - Técnica Vocal para Locutores:</b> Articulación, Dicción, Vocalización, Palabras de relativa dificultad para pronunciar, interpretación de textos, lectura de noticias)',
        "pruebacomp3" => '<b>3 - Redacción Periodística:</b> Ortografía, composición bajo la técnica radial, redacción a partir de datos sueltos e identificación de preguntas clave)',
        "pruebacomp4" => '<b>4 - Cultura General y Actualidad Política Nacional e Internacional: </b>Actualidad Política Colombiana, Actualidad Política Internacional, Sistemas de Gobierno, Capitales y Monedas de países latinoamericanos, Rangos Militares, Generalidades de Geografía y Conceptos Básicos de Economía)'
    ];
        $infoPrueba = explode('|', $elGraduando->descr);
        $datos = [
            ["ESTUDIANTE", Str::upper($elGraduando->getEstudiante()->nombres.' '.$elGraduando->getEstudiante()->apellidos)],
            ["CÓDIGO", substr($elGraduando->getEstudiante()->cod, -4)],
            ["FECHA DE EVALUACIÓN", formatearFecha($infoPrueba[2])],
            ["PRUEBA No.", $pruebaDescr[$infoPrueba[0]]],
            ["DOMICILIO", $elGraduando->getEstudiante()->dataSiet()->first()->ciudad.', '.$elGraduando->getEstudiante()->dataSiet()->first()->estado.' '.$elGraduando->getEstudiante()->dataSiet()->first()->pais],
            ["FASE MODULAR", $infoPrueba[3]],
            ["FASE PROTOCOLAR", $infoPrueba[4]],
            ["METODOLOGÍA DE LA PRUEBA", $pruebaData[$infoPrueba[0]]],
            ["JUICIO JURADO EVALUADOR<br>".$infoPrueba[7], '<i>'.$infoPrueba[8].'</i>'],
            ["FECHA DE CALIFICACIÓN", formatearFecha($infoPrueba[5])],
            ["RESULTADO PONDERADO", $infoPrueba[6].'%'],
            ["INTERPRETACIÓN", ((int)$infoPrueba[6] > 70 ? "APROBADO" : "NO APROBADO")]
        ]
@endphp

<!doctype html>
<html lang="es">

<head>
    <title>REPORTE DE RESULTADO PRUEBA</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">

    <style>
        @page {
            margin: 100px 80px 60px 80px !important;
            font-family: Arial, Helvetica, sans-serif;
            color: rgb(9, 53, 124);
        }
        .portada{
            margin: -110px -80px !important;
        }

        .logo {
            position: fixed;
            top: -60px;
            width: 100%;
            text-align: center;
            font-size: 16px;
            color: #000;
        }
        .logo table td {
            border: 1px solid #365f913f;
            padding: 5px;
        }

        .inicioDatos {
            position: absolute;
            z-index: 2;
            top: 750px;
            right: 0px;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            height: 50px;
            color: #365f91;
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: 0px;
            font-size: 13px;
            font-weight: bold;
            width: 100%;
            height: 50px;
            color: rgb(9, 53, 124);
            text-align: center;
            box-sizing: border-box;
        }

        p {
            text-align: justify;
        }

        h1{
            color: #f00d04;
            text-align: center;
        }
        h2{
            color: #f00d04;
            text-align: center;
            margin-top: -20px;
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
        <div class="inicioDatos">
            Estudiante:
            <div style="font-weight:bold; font-size:25px">
                <i>{{ $elGraduando->getEstudiante()->nombres }} {{ $elGraduando->getEstudiante()->apellidos }}</i>
            </div>
            Santiago de Cali, {{ formatearFecha($infoPrueba[5]) }}
        </div>
        <img src="{{ public_path('images/portadas/'.$infoPrueba[0].'.jpg') }}">
    </div>
    <div style="page-break-before: always;"></div>

    <header class="logo">
        <table class="table table-primary">
            <tr class="">
                <td style="width: 35%"><img src="{{ public_path('images/logo_instel.png') }}" width="100%"></td>
                <td style="width: 55%; text-align: center;">
                    CERTIFICACIÓN ACADÉMICA EN LOCUCIÓN<br>
                    <b style="color:#365f91">FASE PROTOCOLAR</b><br>
                    PRUEBAS DE APTITUD Y COMPETENCIAS
                </td>
                <td style="width: 10%; color:#365f91; text-align:center; font-size:10px">COHORTE {{ $infoPrueba[1] }}</td>
            </tr>
        </table>
    </header>

    <footer class="footer">
        <div style="width: 400px; border-top: 1px solid #000; text-align: center; margin:auto">
            Director Equipo Evaluador
        </div>
        <img src="{{ public_path('images/20230209_154436.png') }}" style="margin: -105px 0px; width: 200px">
        <br><br>
        CERTIFICACIÓN ACADÉMICA PARA LOCUTORES EMPIRICOS
    </footer>
    

    <table class="table-striped" style="margin-top: 30px">
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bolder; background-color:#365f91; color:#FFF">REPORTE DE RESULTADO DE PRUEBAS DE APTITUD Y COMPETENCIAS</td>
        </tr>
        @foreach ($datos as $item)
        <tr>
            <td style="text-align: right; font-weight: bolder;">{!! $item[0] !!}</td>
            <td style="text-align: justify">{!! $item[1] !!}</td>
        </tr>
        @endforeach
    </table>

    <div style="page-break-before: always;"></div>

    <h1>APLICABILIDAD</h1>
    <h2>DE LAS COMPETENCIAS ESPECÍFICAS</h2>

    Demostradas las competencias específicas en <b>{{ $infoPrueba[9] }}</b> por parte de 
    <b>{{ $elGraduando->getEstudiante()->nombres.' '.$elGraduando->getEstudiante()->apellidos }}</b>, 
    consideramos que es ahora capaz de asumir y desempeñar técnicamente, entre otras, las siguientes funciones:

    <ul class="listaF">
        <li>Comunicar mensajes radiofónicos (emitidos a través de las ondas  electromagnéticas o vía web) que eduquen, informen, orienten y entretengan a  grandes masas de audiencia con elevados criterios de seriedad, responsabilidad y  objetividad. </li>
        <li>Determinar en conjunto con el operador de audio los libretos por grabar con base  en lineamientos programativos bajo directrices establecidas. </li>
        <li>Grabar programas, promociones, mensajes de identificaciones de la radiodifusora,  mensajes institucionales, culturales, etc. </li>
        <li>Narrar e interpretar programas de diversa índole, tales como noticieros, eventos  deportivos, hechos de última hora, comunicados oficiales y demás boletines. <li>Animar y presentar diversos programas de espectáculos o musicales en vivo o  grabados. </li>
        <li>Constatar que los equipos (micrófonos, consolas, red, cintas, etc.), estén en  buenas condiciones antes de empezar el trabajo de locución conjuntamente con el  técnico de grabación para garantizar calidad total en la emisión. </li>
        <li>Elaborar y corregir libretos, guiones de noticias, programas y comentarios en  general. </li>
        <li>Participar y aportar en la producción de algunos programas o espacios radiales. <li>Idear, redactar, producir, locutar y grabar podcasts como formato novedoso en las  plataformas digitales. </li>
        <li>Cumplir con las normas y procedimientos en materia de seguridad integral,  establecida por la organización empresarial para la que labore. </li>
        <li>Elaborar informes periódicos de las actividades realizadas en estaciones de radio sean estas comerciales, virtuales o comunitarias. </li>
        <li>Realizar cualquiera otra tarea afín que le sea asignada por la dirección del medio  de comunicación radiofónico. </li>
    </ul>

</body>

</html>
