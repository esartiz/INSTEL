@php
    $codVerif = substr($dataRecibo->first()->persona()->cod, -4);
    $direccionCompleta = $dataRecibo->first()->siet()->direccion.' / '.$dataRecibo->first()->siet()->barrio.' ('.$dataRecibo->first()->siet()->ciudad.')';
@endphp
<!doctype html>
<html lang="ES">

<head>
    <title>Recibo {{ $dataRecibo->first()->idRecibo }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@300;500&display=swap" rel="stylesheet">

    <style>

        body {
            font-family: 'Teko', sans-serif;
            font-weight: 300;
            font-size: 1.4em;
        }
        .cabezote{
            font-family: 'Montserrat';
        }
        .datoConcept{
            font-weight: 700;
            text-transform: uppercase
        }
    </style>

</head>



<body class="container">
    <div class="row text-center align-items-center cabezote">
        <div class="col-4">
            <img src="https://virtual.instel.edu.co/images/logo.png" class="img-fluid">
        </div>
        <div class="col-8">
            <h5>INSTITUTO NACIONAL DE TELECOMUNICACIONES - INSTEL</h5>
            <div style="font-size: 14px">
                Nit. 800.221.647-5<br>
                Calle 15 Norte No. 8N-54 | Tel. (602) 4021082-321 8753745 | Admisiones: 302 8617186<br>
                ÁREA FINANCIERA - CALI
            </div>
                        
        </div>
    </div>


    <div class="text-center cabezote" style="font-weight: 500; font-size: 14px; color: #173880; margin-top: 10px;">
        INSTEL hace parte de las 61 instituciones latinoamericanas signatarias del PALECH 2014 firmado en San Juan,
        Puerto Rico - PACTO DE AMÉRICA LATINA POR UNA EDUCACIÓN CON CALIDAD HUMANA
    </div>


    <main>
        <div style="text-align: right; font-size: 16px; font-weight: 500;">
            Código de Verificación: {{ $codVerif }}
        </div>
        <div
            style="text-align: center; font-size: 33px; font-weight: 500; border-top: 1px solid #173880; border-bottom: 1px solid #173880; color:#173880; margin:20px 0px">
            RECIBO ELECTRÓNICO DE CAJA
        </div>

        <table width="100%">
            <tbody>
                <tr>
                    <td width="60%">
                        RECIBO NO. <span class="datoConcept">{{ $dataRecibo->first()->idRecibo }}</span>
                    </td>
                    <td width="40%">
                        FECHA: <span class="datoConcept">{{ $dataRecibo->first()->fecha }}</span>
                    </td>
                </tr>
                <tr>
                    <td width="60%">
                        RECIBIMOS DE: <span class="datoConcept" style="text-transform: uppercase">
                          {{ $dataRecibo->first()->persona()->nombres.' '.$dataRecibo->first()->persona()->apellidos }} 
                        </span>
                    </td>
                    <td width="40%">
                        {{ $dataRecibo->first()->persona()->tipoDoc }}: <span class="datoConcept">{{ $dataRecibo->first()->persona()->doc.' DE '.$dataRecibo->first()->persona()->doc_ex }}</span>
                    </td>
                </tr>
                <tr>
                    <td width="60%">
                        DIRECCIÓN: <span class="datoConcept">{{ $direccionCompleta ?? '' }}</span>
                    </td>
                    <td width="40%">
                        TEL. <span class="datoConcept">{{ $dataRecibo->first()->persona()->telefono }}</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="text-cemter">
            FORMA DE PAGO: <span class="datoConcept">{{ $dataRecibo->first()->formaPago }}</span>
        </div>

        <br>

        <div class="row container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th style="text-align: right;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($dataRecibo as $item)
                      <tr>
                        <td>{{ $item->concept }}</td>
                        <td style="text-align: right;">$ {{ number_format($item->valor, 0, '','.') }}</td>
                    </tr>
                  @endforeach
                    <tr>
                        <td style="text-align: right;">TOTAL TRANSFERIDO POR ESTE CONCEPTO:</td>
                        <td style="text-align: right;">$ {{ number_format($dataRecibo->sum('valor'), 0, '','.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center" style="font-weight: 500; margin: 20px 0px;">
            *** {{ $formatter->toWords($dataRecibo->sum('valor'), 0) }} PESOS MDA. CTE ***
        </div>

        @foreach ($dataRecibo->first()->persona()->misDeudas()->get() as $itemDD)
        @php
        //Calcula el Nuevo saldo
        $saldoAnterior = $itemDD->valor - $dataRecibo->first()->persona()->misPagos()->where('pagareID', $itemDD->contratoID)->where('fecha','<', $dataRecibo->first()->fecha)->where('cuota','<',100)->sum('valor');
        $goToPagare = $dataRecibo->where('pagareID', $itemDD->contratoID)->sum('valor');
        @endphp

        @if ($goToPagare > 0)
            
        <table width="100%" class="concepto_table saldoF textoRec text-center">
            <thead>
                <tr>
                    <th>Obligación</th>
                    <th>Saldo Anterior</th>
                    <th>Abono Capital</th>
                    <th>Nuevo Saldo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $itemDD->contratoID }}</td>
                    <td>$ {{ number_format($saldoAnterior, 0, '','.') }}</td>
                    <td>$ {{ number_format($goToPagare, 0, '','.') }}</td>
                    <td>$ {{ number_format($saldoAnterior - $goToPagare, 0, '','.') }}</td>
                </tr>
            </tbody>
        </table>
        @endif

        @endforeach

       
        

        <div class="text-center cabezote"
            style="font-size: 12px; color: #173880; border-top: 1px solid #173880; border-bottom: 1px solid #173880; padding: 10px 0px; font-weight: 500">
            Este comprobante electrónico no es el reemplazo de su RECIBO DE CAJA ORIGINAL; es un documento que prueba la
            transacción realizada en la fecha descrita. Dado que es
            estudiante virtual, cuando lo desee podrá reclamar el Recibo de Caja físico original que generó el sistema
            financiero institucional como soporte de su transacción.
        </div>

        <div class="text-center" style="margin-top: 20px; font-size: 16px; font-weight: 500;">
            2023 – ÁREA FINANCIERA - SECCIÓN DE REGISTROS ELECTRÓNICOS DE PAGOS – CÓDIGO DE VERIFICACIÓN {{ $codVerif }}
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>
