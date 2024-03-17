@php
$infoDeudor = json_decode($datos->deudor);
$infoCoDeudor = json_decode($datos->codeudor);
$nombreCompleto = strtoupper($infoDeudor->nombre);
$nombreCompletoCoDeudor = strtoupper($infoCoDeudor->nombre);
$semestreNominal = ["", "PRIMER","SEGUNDO","TERCER","CUARTO","QUINTO","SEXTO"];
@endphp

<!doctype html>
<html lang="es">

<head>
    <title>PAGARE N. {{ $datos->contratoID }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

        <style>
            body{
                font-size: 14px;
            }
        </style>
</head>

<body>

    <div class="text-center">
        <a href="/pagare/1-{{ $datos->id }}" class="btn btn-danger" target="_parent">Enviar al Usuario para Firmar</a>
    </div>

    <div class="container">
        <header class="text-center">
            <p><img src="https://virtual.instel.edu.co/images/logo.png" /></p>
            <h3 class="text-center">PAGARE N. {{ $datos->contratoID }}</h3>
        </header>

        <div style="text-align: justify">
            Yo,<b> {{ $nombreCompleto }}</b> titular de la Cédula de Ciudadanía No. {{ $infoDeudor->doc}}
            expedida en {{ $infoDeudor->doc_ex}}, DEBO y PAGARÉ  a la  orden del<b> INSTITUTO NACIONAL DE TELECOMUNICACIONES
             "INSTEL",</b> en sus oficinas ubicadas en la Calle 15 Norte No. 8N - 54 del Barrio Granada de Cali - Valle,
            la cantidad de <b> $ {{ number_format($datos->valor, 0, '','.') }} </b> (la cantidad en letras es: <b>{{ $formatter->toWords($datos->valor, 0) }} PESOS M/CTE </b>)
            que he recibido en calidad de crédito educativo de esta entidad, más los intereses correspondientes, conforme a las normas 
            consagradas tanto en el Código de Comercio como las del reglamento de vinculación de alumnos y otorgamiento de créditos 
            educativos, que declaro conocer y aceptar. Relevo expresamente al beneficiario de este pagaré de la obligación de protesto.
            El Capital e Intereses se pagarán por el suscriptor en <b>{{ $datos->cuotas }} cuotas mensuales iguales y sucesivas</b> , con fecha de vencimiento 
            en los días establecidos. El número y monto de las cuotas es el que se indica a continuación:

            <br><br>

            <div class="table" style="max-width: 800px; margin: auto;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10%;" class="text-cemter">Cuota</th>
                            <th style="width: 20%;">Fecha</th>
                            <th style="width: 20%;">Capital</th>
                            <th style="width: 10%;">Interés</th>
                            <th style="width: 20%;">Cuota</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @for ($i = 0; $i < $datos->cuotas; $i++)
                        <tr class="">
                            <td class="text-center">
                                {{ ($i) + 1 }}
                            </td>
                            <td>{{ date('d/m/Y', strtotime(explode('|',$datos->plan)[$i])) }}</td>
                            <td>$ {{ number_format(($datos->valor / $datos->cuotas), 0, '','.') }}</td>
                            <td>$ 0</td>
                            <td>$ {{ number_format(($datos->valor / $datos->cuotas), 0, '','.') }}</td>
                        </tr>
                        @endfor
                        
                    </tbody>
                </table>
            </div>

            <br>

            (Ya deducidas tanto inscripción y matrícula como la cuota inicial).
            <br><br>
            
            El pago de la obligación contenida en este pagaré deberá efectuarse en la fecha de vencimiento. 
            El simple retardo en el pago de todo o parte de una cualesquiera de las cuotas permitirá exigir 
            la cancelación integra de la suma adeudada, considerándose la obligación de plazo vencido y 
            capitalizados los intereses devengados no pagados. La carga de la prueba corresponderá al deudor, 
            quien deberá acreditar el pago de las cuotas que haya efectuado. El nuevo capital así formado, 
            devengará intereses a la tasa correspondiente al interés máximo convencional existente para 
            operaciones de crédito de dinero que <b>en este caso se tasa al 3 % mensual</b>.

            <br><br>
            
            Todas las obligaciones derivadas de este pagaré se considerarán indivisibles para los efectos legales.
            A su vez los derechos, impuestos, gastos notariales y otros que afecten o puedan afectar a este documento, 
            a sus prorrogas, re-pactaciones o renovaciones y a los correspondientes recibos y cancelaciones que se otorguen, 
            serán de cargo exclusivo del deudor.

            <br><br>
            
            En virtud de lo previsto por la ley, sobre letra de cambio y pagaré, instruyo al <b>INSTITUTO NACIONAL DE 
            TELECOMUNICACIONES "INSTEL"</b> para que proceda a incorporar la fecha de vencimiento al presente pagaré. 
            Así mismo, faculto e instruyo a la institución en mención para incorporar, de conformidad a la solicitud de 
            crédito o re-pactaciones posteriores el monto de dinero, intereses y número de cuotas correspondiente al préstamo 
            que por el presente instrumento se garantiza.

            <br><br>
            
            En atención a que las presentes instrucciones interesan al tenedor del pagaré, declaro expresamente el 
            carácter irrevocable de las mismas en los términos de lo consagrado por la ley colombiana tanto en el Código 
            de Comercio como en el Código de Procedimiento Civil. Para todos los efectos de lo dispuesto en la ley, 
            declaro expresamente que el presente pagaré debe ser considerado pagadero a plazos. Para todos los efectos 
            de este pagaré, fijo mi domicilio en 
            <b>{{ strtoupper($infoDeudor->direccion. ' - BARRIO '.$infoDeudor->barrio. ' en la ciudad de '.$infoDeudor->ciudad) }} </b>y me someto a 
            la jurisdicción de los órganos competentes de justicia.

            <br><br>
            
            En Santiago de Cali, <span class="forFecha" dt-fmt="0" dt-f="{{$datos->created_at }}"></span>
            <br><br>


            <h5>AVAL</h5>
            
            Avalo el presente pagaré constituyéndome expresamente en codeudor solidario del suscriptor o deudor 
            antes individualizado y a favor del <b>INSTITUTO NACIONAL DE TELECOMUNICACIONES "INSTEL" </b>o a quienes sus 
            derechos represente, por todas y cada una de las obligaciones señaladas precedentemente, por todo el tiempo 
            que transcurriere hasta el efectivo y completo pago de este documento, declarando que acepto desde ya todas 
            las renovaciones, o prórrogas, re-pactaciones o esperas, que con o sin abono, puedan concederse al suscriptor, 
            manteniendo mi responsabilidad hasta el pago total de la deuda, aún cuando éste pagaré se perjudique.

            <br><br>
            
            Declaro conocer y aceptar las normas que regulan el crédito avalado, en especial lo referido al descuento 
            por planilla que mi empleador efectuará a mi remuneración en caso de incumplimiento del deudor principal, 
            El presente instrumento se suscribe con la cláusula sin protesto, quedando el beneficiario relevado de la 
            obligación de protestarlo. Para los efectos legales de este aval, el lugar en que debe efectuarse el pago 
            es el indicado al comienzo de este instrumento sometiéndose el avalista  a la jurisdicción de los Tribunales 
            correspondientes a dicho lugar.

            <br><br>

            <table width="100%">
                <tr>
                    <td width="50%">
                        <div style="font-weight: bold; margin-bottom: 100px;">
                            SUSCRIPTOR
                        </div>
                        <hr style="width: 80%;">
                        <b>{{ $nombreCompleto }}</b><br>
                        {{ $infoDeudor->doc}} de {{ $infoDeudor->doc_ex}} <br>
                        Domicilio: {{ $infoDeudor->direccion}}<br>
                        Barrio: {{ $infoDeudor->barrio}}<br>
                        Ciudad: {{ $infoDeudor->ciudad}}<br>
                        Teléfono: {{ $infoDeudor->telefono}}<br>
                    </td>

                    <td>
                        <div style="font-weight: bold; margin-bottom: 100px;">
                            AVALISTA O RESPALDANTE
                        </div>
                        <hr style="width: 80%;">
                        <b>{{ $nombreCompletoCoDeudor }}</b><br>
                        {{ $infoCoDeudor->doc}} de {{ $infoCoDeudor->doc_ex}} <br>
                        Domicilio: {{ $infoCoDeudor->direccion}}<br>
                        Barrio: {{ $infoCoDeudor->barrio }}<br>
                        Ciudad: {{ $infoCoDeudor->ciudad}}<br>
                        Teléfono: {{ $infoCoDeudor->telefono}}<br>
                    </td>
                </tr>
            </table>
            <div class="row">
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-6">
                    
                </div>
             </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
        </script>
    

    <script>
        $(".forFecha").each(function (index) {
        const date = new Date(($(this).attr("dt-f")).replace(/-/g, '\/'));
        const daysLong = [
            "Domingo",
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
        ];
        const months = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ];
        const theYear = date.getFullYear();
        const theMonth = date.getMonth();
        const theDate = date.getDate();
        const theDay = date.getDay();
        const theHH = date.getHours();
        const theMM = date.getMinutes();
        var laHH, losMM;
        (theHH < 9 ? laHH = "0"+theHH : laHH = theHH);
        (theMM < 9 ? losMM = "0"+theMM : losMM = theMM);
        var dataFinal =  `${daysLong[theDay]}, a los ${theDate} día(s) del mes de ${months[theMonth]} de ${theYear}`
        $(this).text(dataFinal);
    });
    </script>
</body>

</html>