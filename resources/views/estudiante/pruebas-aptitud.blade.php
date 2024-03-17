@php
    function formatearFecha($fecha)
    {
        return \Carbon\Carbon::parse($fecha)->day . ' de ' . \Carbon\Carbon::parse($fecha)->monthName . ' de ' . \Carbon\Carbon::parse($fecha)->year;
    }
    $criterios = explode('|',$userPrueba->laPrueba()->instruccion);
    $resultados1 = ($userPrueba->valoracion1 == NULL ? ['','','','','',''] : explode('|',$userPrueba->valoracion1));
    $resultados2 = ($userPrueba->valoracion2 == NULL ? ['','','','','',''] : explode('|',$userPrueba->valoracion2));
    $observ1 = ($userPrueba->observacion1 == NULL ? ['','','','','',''] : explode('|',$userPrueba->observacion1));
    $observ2 = ($userPrueba->observacion2 == NULL ? ['','','','','',''] : explode('|',$userPrueba->observacion2));
@endphp

<!doctype html>
<html lang="es">

<head>
    <title>Informe {{ $userPrueba->laPrueba()->nombre }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">

    <style>
        @page {
            margin: 150px 80px 60px 80px !important;
            font-family: Arial, Helvetica, sans-serif;
            color: rgb(9, 53, 124);
        }
        .portada{
            margin: -160px -80px !important;
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
            font-family: 'Times New Roman', Times, serif;
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
        <img src="{{ public_path('images/portadas/pa-'.$userPrueba->idPrueba.'.jpg') }}">
    </div>
    <div style="page-break-before: always;"></div>

    <header class="logo">
        <table class="table table-primary">
            <tr class="">
                <td style="width: 35%"><img src="{{ public_path('images/logo_instel.png') }}" width="100%"></td>
                <td style="width: 65%; text-align: center;">
                    PARÁMETROS DE APRECIACIÓN PRUEBA DE APTITUD No. {{ $userPrueba->idPrueba }}<br>
                    <b style="color:#365f91">Comunicación & Locución en Radio, Televisión y Medios Digitales</b>
                </td>
            </tr>
        </table>
    </header>

    <footer class="footer">
        <br><br>
        <i>Formamos Profesionales para los Medios de Comunicación…</i>
    </footer>

    {{ ($userPrueba->getEstudiante()->sexo == "Masculino" ? "Apreciado" : "Apreciada") }} estudiante, {{ $userPrueba->getEstudiante()->nombres }} {{ $userPrueba->getEstudiante()->apellidos }}
    
    {!! $userPrueba->laPrueba()->texto !!}

    <table style="font-size:12px">
        <tr>
            <td><b>Estudiante:</b></td>
            <td>{{ $userPrueba->getEstudiante()->nombres }} {{ $userPrueba->getEstudiante()->apellidos }}</td>
        </tr>
        <tr>
            <td><b>Área de la Prueba:</b></td>
            <td>{{ $userPrueba->laPrueba()->area }}</td>
        </tr>
        <tr>
            <td><b>Fecha evaluación:</b></td>
            <td>{{ formatearFecha($userPrueba->fechaIni) }}</td>
        </tr>
        <tr>
            <td><b>Jurado 1:</b></td>
            <td>{{ $userPrueba->laPrueba()->jurado1()->nombres }} {{ $userPrueba->laPrueba()->jurado1()->apellidos }}</td>
        </tr>
        @if ($userPrueba->laPrueba()->jurado2())
        <tr>
            <td><b>Jurado 2:</b></td>
            <td>{{ $userPrueba->laPrueba()->jurado2()->nombres }} {{ $userPrueba->laPrueba()->jurado2()->apellidos }}</td>
        </tr>
        @endif
    </table>
    
    <table style="margin-top: 20px">
        <tr>
            <th style="width: 40%">PARÁMETRO EVALUADO</th>
            <th>CRITERIO JURADO 1</th>
            @if ($userPrueba->laPrueba()->jurado2())
            <th>CRITERIO JURADO 2</th>
            @endif
        </tr>
        @for ($i = 0; $i < count($criterios); $i++)
        <tr>
            <td>{{ $criterios[$i] }}</td>
            <td style="text-align: center">{{ $resultados1[$i] }}</td>
            @if ($userPrueba->laPrueba()->jurado2())
            <td style="text-align: center">{{ $resultados2[$i] }}</td>
            @endif
        </tr>
        <tr style="font-size: 11px">
            <td style="text-align: right;"><b>OBSERVACIÓN:</b></td>
            <td>{{ $observ1[$i] }}</td>
            @if ($userPrueba->laPrueba()->jurado2())
            <td>{{ $observ2[$i] }}</td>
            @endif
        </tr>
        @endfor
    </table>
    <div style="font-size:12px">NOTA: Los criterios van desde D (Deficiente) hasta E (Excelente) pasando por A (Aceptable) B (Bueno) y MB (Muy Bueno).</div>

    <table style="margin-top: 20px; text-align: center; border:none">
        <tr style="border:none">
            <td style="border:none">
                <img src="{{ public_path('images/f-'.$userPrueba->laPrueba()->jurado1.'.png') }}"><br>
                {{ $userPrueba->laPrueba()->jurado1()->nombres.' '.$userPrueba->laPrueba()->jurado1()->apellidos }}
                <div style="font-weight: bold; font-size:12px">Jurado 1</div>
            </td>
            @if ($userPrueba->laPrueba()->jurado2())
            <td style="border:none">
                <img src="{{ public_path('images/f-'.$userPrueba->laPrueba()->jurado2.'.png') }}"><br>
                {{ $userPrueba->laPrueba()->jurado2()->nombres.' '.$userPrueba->laPrueba()->jurado2()->apellidos }}
                <div style="font-weight: bold; font-size:12px">Jurado 2</div>
            </td>
            @endif
        </tr>
    </table>

</body>

</html>
