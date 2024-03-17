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
            background-image: url('https://instel.edu.co/public/images/c_int.png');
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
            width: 820px;
            font-size: 60px;
            font-family: 'Pinyon Script', cursive;
            color: #031d69;
            top: 530px
        }
        .code-qr{
            background-color: #FFF;
            position: absolute;
            top: 25px;
            left: 680px;
            font-size: 9px;
            width: 100px;
            text-align: center;
        }
        .cedID{
            color: #031d69;
            top: 615px;
            position: absolute;
            font-size: 20px;
            width: 820px;
            text-align: center;
        }
        .titulo {
            position: absolute;
            text-align: center;
            width: 700px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 30px;
            line-height: 20px;
            font-family: 'Montserrat', sans-serif;
            top: 695px;
            color: #031d69;
            display: flex;
            align-items: center;
            height: 80px;
        }

        .intesidad{
            color: #031d69;
            text-align: center;
            width: 700px;
            left: 50%;
            transform: translateX(-50%);
            position: absolute;
            font-size: 16px;
        }
        .fechaLugar{
            position: absolute;
            text-align: center;
            width: 820px;
            font-size: 18px;
            font-weight: 900;
            font-family: 'Montserrat', sans-serif;
            top: 950px;
            color: #031d69;
        }
        .registro {
            position: absolute;
            text-align: center;
            width: 820px;
            font-size: 12px;
            font-family: 'Montserrat', sans-serif;
            top: 1010px;
            color: #031d69;
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
        <div class="persona">
            {{ $elGraduando->getEstudiante()->nombres.' '.$elGraduando->getEstudiante()->apellidos }}
        </div>
        <div class="cedID">
            {{ $elGraduando->getEstudiante()->tipoDoc }}. No  {{ $elGraduando->getEstudiante()->doc }}
        </div>
        <div class="intesidad" style="top: 650px;">
            Por haber concluído exitosamente sus estudios de {{ $datos[1] }} en 
        </div>
        <div class="titulo">
            {{ str_replace('(Grupal)', '', $datos[2]) }}
        </div>
        <div class="intesidad" style="top: 740px;">
            ({{ $datos[3] }})
        </div>
        <div class="fechaLugar">
            <br>Alemania, {{ fechaEs($datos[4], 1) }}
        </div>
        <div class="registro">
            Registro No. {{ $datos[0] }}
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

