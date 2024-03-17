@php
    $semestreNombre = ['', 'Primer Semestre', 'Segundo Semestre', 'Tercer Semestre', 'Semestre de Profudización Animación Musical y Presentación de Espectáculos', 'Semestre de Profudización Lectura de Noticias y Periodismo Radial', 'Semestre de Profudización Periodismo y Locución Deportiva', 'Semestre de Profudización Locución y Presentación de Televisión', 'Semestre de Profudización Producción y Locución Comercial', 'Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa'];
@endphp

<!doctype html>
<html lang="es">

<head>
    <title>REPORTE NOTAS SEMESTRE INSTEL</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">

    <style>
        @page {
            margin: 120px 80px 80px 80px !important;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .logo {
            position: fixed;
            top: -80px;
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
            bottom: -30px; 
            font-family: 'Times New Roman', Times, serif;
            font-size: 16px;
            width: 100%;
            height: 50px;
            color: #989898;
            text-align: center;
            box-sizing: border-box;
        }

        p {
            text-align: justify;
        }

        h1 {
            color: #f00d04;
            text-align: center;
        }

        h2 {
            color: #f00d04;
            text-align: center;
            margin-top: -20px;
        }

        .listaF {
            margin-top: 20px;
        }

        .listaF li {
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

    </style>
</head>

<body>
    <header class="logo">
        <table class="table table-primary">
            <tr class="">
                <td style="width: 35%"><img src="{{ public_path('images/logo_instel.png') }}" width="100%"></td>
                <td style="width: 55%; text-align: center;">
                    REPORTE DE NOTAS INSTEL<br>
                    <b style="color:#365f91">INSTEL VIRTUAL</b><br>
                    {{ $matriculas->first()->getPrograma()->nombre }}
                </td>
                <td style="width: 10%; color:#365f91; text-align:center; font-size:10px">COHORTE
                    {{ $matriculas->first()->periodo }}</td>
            </tr>
        </table>
    </header>

    <footer class="footer">
        <i>Formamos Profesionales para los Medios de Comunicación…</i>
    </footer>

    @foreach ($matriculas as $matricula)
        @if (!isset($currentNivel) || $matricula->nivel !== $currentNivel)
            @if (isset($currentNivel))
            <div style="page-break-after: always"></div>
            @endif
            <?php $currentNivel = $matricula->nivel; ?>
        @endif
        @if ($matricula->materias()->count() > 0)
        <table style="margin-bottom: 20px; width:100%; font-size:11px">
            <tr style="background-color: #e8e8e8">
                <td style="width: 50%"><b>{{ strtoupper($matricula->getEstudiante()->apellidos . ' ' . $matricula->getEstudiante()->nombres) }}</b></td>
                <td colspan="6" style="text-align: right"><b>{{ $semestreNombre[$matricula->nivel] }}</b></td>
            </tr>
            <tr style="font-weight: bold">
                <td>MODULO</td>
                <td>PR 1</td>
                <td>PR 2</td>
                <td>PR 3</td>
                <td>DEF.</td>
                <td>REC.</td>
                <td>REP.</td>
            </tr>
            @foreach ($matricula->materias() as $item)
                <tr>
                    <td>{{ $item->n_materia }}</td>
                    <td>{{ $item->n1 }}</td>
                    <td>{{ $item->n2 }}</td>
                    <td>{{ $item->n3 }}</td>
                    <td>{{ $item->def }}</td>
                    <td>{{ $item->hab }}</td>
                    <td>{{ $item->rem }}</td>
                </tr>
            @endforeach
        </table>
        @endif
    @endforeach
    @if (isset($currentNivel))
    @endif

</body>

</html>
