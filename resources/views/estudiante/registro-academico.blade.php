@php
    function formatearFecha($fecha)
    {
        return \Carbon\Carbon::parse($fecha)->day . ' de ' . \Carbon\Carbon::parse($fecha)->monthName . ' de ' . \Carbon\Carbon::parse($fecha)->year;
    }
    $prf = $elGraduando->getEstudiante()->misBoxMatriculas()->where('nivel', '>', 3)->orderBy('nivel','ASC')->first()->nivel;
    $semestreNombre = ['', '', '', '', 'Animación Musical y Presentación de Espectáculos', 'Lectura de Noticias y Periodismo Radial', 'Periodismo y Locución Deportiva', 'Locución y Presentación de Televisión', 'Producción y Locución Comercial', ''];
    $losPerfilesMsc = ['', '', '', '', 'Animador Musical y Presentador de Espectáculos', 'Lector de Noticias y Periodista Radial', 'Periodista y Locutor Deportivo', 'Locutor y Presentador de Televisión', 'Productor y Locutor Comercial', ''];
    $losPerfilesFem = ['', '', '', '', 'Animadora Musical y Presentadora de Espectáculos', 'Lectora de Noticias y Periodista Radial', 'Periodista y Locutora Deportivo', 'Locutora y Presentadora de Televisión', 'Productora y Locutora Comercial', ''];
    $data = explode('|', $elGraduando->descr);
@endphp

<!doctype html>
<html lang="es">

<head>
    <title>Registro Académico</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">

    <style>
        @page {
            margin: 140px 80px 60px 80px !important;
            font-family: Arial, Helvetica, sans-serif;
            color: rgb(9, 53, 124);
        }
        .portada{
            margin: -160px -80px !important;
        }

        .logo {
            position: fixed;
            top: -70px;
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

        .titulo_documento {
            padding: 5px;
            border: 1px solid #000;
            background-color: #ececec;
            text-align: center;
            margin: 20px 0px 0px 0px;
            font-weight: bold;
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
            font-size: 13px;
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
        .tit_dat{
            background-color: #d1d1d1;
            font-weight: bold;
        }
    </style>
</head>

<body>
    
    <header class="logo">
        <table class="table table-primary">
            <tr class="">
                <td style="width: 35%"><img src="{{ public_path('images/logo_instel.png') }}" width="100%"></td>
                <td style="width: 65%; text-align: center;">
                    REGISTRO ACADÉMICO DE GRADUANDOS<br>
                    <b style="color:#365f91">Técnico Laboral en Locución en Radio, Televisión y Medios Digitales</b>
                </td>
            </tr>
        </table>
    </header>

    <footer class="footer">
        <br><br>
        <i>Formamos Profesionales para los Medios de Comunicación…</i>
    </footer>

    <div class="titulo_documento">
        INFORMACIÓN BÁSICA
    </div>

    <table>
        <tr>
            <td rowspan="3" style="width: 100px; text-align:center; height:120px">Foto 3x4</td>
            <td class="tit_dat">Nombre Completo:</td>
            <td>{{ $elGraduando->getEstudiante()->nombres. ' '.$elGraduando->getEstudiante()->apellidos }}</td>
            <td class="tit_dat">Documento:</td>
            <td>{{ $elGraduando->getEstudiante()->tipoDoc. ' '.$elGraduando->getEstudiante()->doc }}</td>
        </tr>
        <tr>
            <td class="tit_dat">Dirección:</td>
            <td colspan="3">
                {{ $elGraduando->getEstudiante()->dataSiet()->first()->direccion }} - 
                Barrio: {{ $elGraduando->getEstudiante()->dataSiet()->first()->barrio }}
                ({{ $elGraduando->getEstudiante()->dataSiet()->first()->ciudad }})
            </td>
        </tr>
        <tr>
            <td class="tit_dat">E-mail:</td>
            <td>{{ $elGraduando->getEstudiante()->email }}</td>
            <td class="tit_dat">Teléfono:</td>
            <td>{{ $elGraduando->getEstudiante()->telefono }}</td>
        </tr>
    </table>

    <div class="titulo_documento">
        INFORMACIÓN LABORAL
    </div>

    @for ($i = 3; $i < count($data); $i++)
        {!! $data[$i] !!}
        @if ($i < count($data) - 1)
            <br><br>
        @endif
    @endfor

    <div class="titulo_documento">
        INFORMACIÓN ACADÉMICA
    </div>
    <table>
        <tr>
            <td class="tit_dat">Institución Educativa de donde se graduó:</td>
            <td>{{ $data[1] }}</td>
        </tr>
        <tr>
            <td class="tit_dat">Otros Estudios:</td>
            <td>Instituto Nacional de Telecomunicaciones INSTEL</td>
        </tr>
        <tr>
            <td class="tit_dat">Profundización INSTEL:</td>
            <td>{{ $semestreNombre[$prf] }}</td>
        </tr>
        <tr>
            <td class="tit_dat">Diplomatura INSTEL:</td>
            <td>Comunicación Organizacional con énfasis en Jefatura de Prensa</td>
        </tr>
        <tr>
            <td class="tit_dat">Perfil graduando(a):</td>
            <td>{{ ($elGraduando->getEstudiante()->sexo == "Femenino" ? $losPerfilesFem[$prf] : $losPerfilesMsc[$prf]) }}</td>
        </tr>
    </table>

    <div class="titulo_documento">
        PRÁCTICA EN MEDIOS
    </div>
    {!! $data[2] !!}

    <table style="border: 0px; font-size:14px">
        <tr style="border: 0px">
            <td style="border: 0px">
                <h5>Juramento de registrado</h5>
                Yo, {{ strtoupper($elGraduando->getEstudiante()->nombres. ' '.$elGraduando->getEstudiante()->apellidos) }} declaro solemnemente que la información aquí consignada es veraz y verificable.
                <br><br>
                <br><br>
                <br><br>
                <div style="margin:auto; border-top: 1px solid #000; width:400px; text-align:center">
                    FIRMA DEL EGRESADO
                </div>
            </td>
        </tr>
    </table>
    

</body>

</html>
