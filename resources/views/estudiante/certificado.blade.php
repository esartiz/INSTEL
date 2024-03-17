@php
    $datos = explode('|',$elGraduando->descr);

    function fechaEs($fecha, $tipo) {
            $fecha = substr($fecha, 0, 10);
            $numeroDia = date('d', strtotime($fecha));
            $dia = date('l', strtotime($fecha));
            $mes = date('F', strtotime($fecha));
            $anio = date('Y', strtotime($fecha));
            $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
            $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
            //$nombredia = str_replace($dias_EN, $dias_ES, $dia);
            $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
            return ($tipo == 0 ? $numeroDia." días del mes de ".$nombreMes." de ".$anio : $numeroDia." de ".$nombreMes." de ".$anio);
        }
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificado INSTEL</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;900&family=Pinyon+Script&display=swap" rel="stylesheet">

    <style>
        @page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }
        body{
            background-repeat: no-repeat;
            margin:0;
            font-family: 'Montserrat';
        }
        .first-page {
            background-image: url('https://instel.edu.co/public/images/instel_c.png');
            background-size: cover;
            background-repeat: no-repeat;
            /* Configura el fondo para ocupar toda la página */
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -3;
        }

    /* Estilo de fondo para la segunda página */
        .second-page {
            background-image: url('https://instel.edu.co/public/images/instel_c2.png');
            background-size: cover;
            background-repeat: no-repeat;
            /* Configura el fondo para ocupar toda la página */
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
        .persona{
            position: absolute;
            text-align: center;
            width: 1024px;
            font-size: 60px;
            font-family: 'Pinyon Script', cursive;
        }
        .code-qr{
            background-color: #FFF;
            position: absolute;
            top: 25px;
            left: 25px;
            font-size: 9px;
            width: 100px;
            text-align: center;
        }
        .cedID{
            top: 505px;
            left:220px;
            position: absolute;
            font-size: 20px;
        }
        .lugExp{
            top: 505px;
            left: 640px;
            position: absolute;
            font-size: 20px;
        }
        .titulo{
            position: absolute;
            text-align: center;
            width: 1024px;
            font-size: 30px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            color: #0b4789;
        }
        .otros{
            text-align: center;
            width: 1024px;
            position: absolute;
            font-size: 16px;
        }

    </style>
</head>
<body>
    <a class="code-qr" href="{{ $elGraduando->linkval }}" target="_blank">
        <div class="visible-print text-center">
            <img src="data:image/png;base64, {!! $qrcode !!}">
            <p>Escanee el código para comprobar la validez del presente certificado</p>
        </div>
    </a>
    <div class="first-page">
        <div class="persona" style="top:400px">
            {{ $elGraduando->getEstudiante()->nombres.' '.$elGraduando->getEstudiante()->apellidos }}
        </div>
        <div class="cedID">
            {{ $elGraduando->getEstudiante()->tipoDoc }}. No  {{ $elGraduando->getEstudiante()->doc }}
        </div>
        <div class="lugExp">
           {{ $elGraduando->getEstudiante()->doc_ex }}
        </div>
        <div class="titulo" style="margin-top: 580px;">
            {{ str_replace('(Grupal)', '', $datos[0]) }}
        </div>
        <div class="otros" style="top: 630px;">
            Intensidad total: {{ $datos[1] }}
            .<br>Dado en Santiago de Cali a los {{ fechaEs($datos[2], 0) }}.
        </div>
    </div>
    



    @if (!empty($datos[3]) && $datos[3] == "europacampus")
        

        <div style="page-break-before: always;"></div> <!-- Agrega un salto de página -->

        <div class="second-page">
            <a class="code-qr" href="{{ $elGraduando->linkval }}" target="_blank">
                <div class="visible-print text-center">
                    <img src="data:image/png;base64, {!! $qrcode !!}">
                    <p>Escanee el código para comprobar la validez del presente certificado</p>
                </div>
            </a>

            <div class="persona" style="top:360px; font-size:70px !important; color: #0b4789;">
                {{ $elGraduando->getEstudiante()->nombres.' '.$elGraduando->getEstudiante()->apellidos }}
            </div>
            <div class="titulo" style="margin-top: 525px; line-height: 20px;">
                {{ str_replace('(Grupal)', '', $datos[0]) }}<br><span style="font-size: 20px">{{ $datos[1] }}</span>
            </div>
            <div class="otros" style="top: 720px; font-weight: 900;">
                Alemania, {{ fechaEs($datos[2], 1) }}
            </div>
        </div>

    @endif
</body>
</html>

