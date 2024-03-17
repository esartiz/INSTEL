@php
    function formatearFecha($fecha)
    {
        return \Carbon\Carbon::parse($fecha)->locale('es')->dayName . ' ' . \Carbon\Carbon::parse($fecha)->day . ' de ' . \Carbon\Carbon::parse($fecha)->monthName . ' de ' . \Carbon\Carbon::parse($fecha)->year;
    }
    
    $semestreNominal = ['N/A', 'Primer Semestre Académico', 'Segundo Semestre Académico', 'Tercer Semestre Académico', 'Semestre de Profudización Animación Musical y Presentación de Espectáculos', 'Semestre de Profudización Lectura de Noticias y Periodismo Radial', 'Semestre de Profudización Periodismo y Locución Deportiva', 'Semestre de Profudización Locución y Presentación de Televisión', 'Semestre de Profudización Producción y Locución Comercial', ''];
    $user = $laMatricula->first()->getEstudiante();
    $elPrograma = $programas->where('id', $id)->first();

    //Si se trata del diplomado en el técnico
    if($laMatricula->first()->nivel == "9"){
        $elPrograma = $programas->where('id', 27)->first();
    }

    //El titular del contrato será si es menor de edad, la otrPer
    if ($user->tipoDoc == 'TI') {
        $pNombre = json_decode($user->otraPer)->nombre;
        $pDoc = json_decode($user->otraPer)->doc;
        $pDoc_ex = json_decode($user->otraPer)->doc_ex;
    } else {
        $pNombre = $user->nombres . ' ' . $user->apellidos;
        $pDoc = $user->doc;
        $pDoc_ex = $user->doc_ex;
    }
    $nombresPeriodos = ["", "ENERO-JUNIO DE ".date('Y'), "MARZO-AGOSTO DE ".date('Y'), "JULIO-DICIEMBRE DE ".date('Y'), "SEPTIEMBRE-FEBRERO DE ".(date('Y') + 1), "ENERO-JUNIO  DE ".(date('Y')+1), "MARZO-AGOSTO DE ".(date('Y') +1 )];
    $nombreCompleto = strtoupper($pNombre);
    $datos = $laMatricula->orderBy('fechaIngreso','DESC')->first()->getDeuda();
    $parte1 = '<b>'.($user->sexo == "Femenino" ? "LA ESTUDIANTE" : "EL ESTUDIANTE").'</b>';
    $parte2 = '<b>INSTEL</b>';
@endphp

<!doctype html>
<html lang="es">

<head>
    <title>CONTRATO DE PRESTACIÓN DEL SERVICIO EDUCATIVO</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap" rel="stylesheet">

    <style>
        @page {
            margin: 140px 100px 100px 80px !important;
            font-family: Arial, Helvetica, sans-serif;
            color: rgb(9, 53, 124);
        }

        .logo {
            position: fixed;
            top: -120px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #000;
        }

        .footer {
            position: fixed;
            bottom: 0px;
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
        <br><br><br><br>
        <i>Formamos Profesionales para los Medios de Comunicación…</i>
    </footer>

    <div class="titulo_documento">
        <div class="tituloBoxTt">CONTRATO DE PRESTACIÓN {{ substr($user->cod, -4) . '-' . $laMatricula->first()->periodo }} DEL
            SERVICIO EDUCATIVO</div>
        Santiago de Cali, {{ formatearFecha($laMatricula->first()->created_at) }}
    </div>


    <p>
        Entre el <b>INSTITUTO NACIONAL DE TELECOMUNICACIONES "INSTEL", Nit. 800.221.647-5</b>,
        entidad privada con Registro en Cámara de Comercio de Cali No. 363978-3, con vigencia como organización
        empresarial hasta el año 2034, con domicilio principal en la Calle 15 Norte No. 8N-54 del Barrio Granada
        en Cali, con Reconocimiento Oficial del Estado colombiano para impartir programas de formación técnica
        por competencias laborales en el área de los Medios de Comunicación, Radio, Prensa, Televisión y
        Plataformas Digitales, según la Resolución No. 4143.2.21.5414 de julio 8 de 2009 emanada de la Secretaría
        de Educación Municipal, en adelante "{!! $parte2 !!}", representada por
        el señor<b> ALEISSY LASSO ÁGREDO </b>titular de la cédula de ciudadanía No 6.401.878 expedida en
        Pradera, Valle, con Tarjeta Profesional No. 40686 expedida por el Ministerio de Educación Nacional y
        <b>{{ $nombreCompleto }}</b> identificado(a) con cédula de ciudadanía No. <b>{{ $pDoc }} </b>
        expedida
        en {{ $pDoc_ex }}

        @if ($user->tipoDoc == 'TI')
            en calidad de representante legal de <b>{{ strtoupper($user->nombres . ' ' . $user->apellidos) }}</b>
            identificado(a) con TI {{ $user->doc }}
        @endif

        en adelante <b>"{!! $parte1 !!}"</b>,
        domiciliado(a) en la dirección <b>{{ strtoupper($user->dataSiet->direccion) }}</b>
        del barrio <b>{{ strtoupper($user->dataSiet->barrio) }}</b>
        de la ciudad de
        <b>{{ strtoupper($user->dataSiet->ciudad . ', ' . $user->dataSiet->estado . ' (' . $user->dataSiet->pais . ')') }}</b>
        acuerdan celebrar el presente contrato de <b>PRESTACIÓN DE SERVICIOS EDUCATIVOS</b>, en los términos que a
        continuación se indican:
    </p>

    @if ($elPrograma->tipo == 'Técnico Laboral')
        <!-- CONTRATO DE TÉCNICO LABORAL EN LOCUCIÓN -->

        <p>
            <b>PRIMERO: {!! $parte2 !!} </b>se obliga a adelantar bajo la modalidad 
            {{ (substr($laMatricula->first()->periodo,-1) > 4 ? ' Presencial' : 'virtual, semi-presencial') }} con {!! $parte2 !!}
            el proceso académico de estudios por competencias correspondientes al programa <b>TÉCNICO LABORAL EN
                LOCUCION</b>,
            con duración de tres(3) semestres lectivos de formación básica (1.200 horas) másuna fase a elegir de
            profundización
            (150 horas) en una de cinco líneas de desempeño profesional (o énfasis). Las fases del proceso académico se
            describen de la siguiente manera:
        </p>

        <p>
            <b>- Fase de Formación Básica</b>: se adelanta en tres (3) semestres lectivos cada uno con una
            intensidad de 400 horas discriminadas entre 180 horas teórico-prácticas en la institución o a través de
            la plataforma digitaly 220 horas eminentemente prácticas en escenarios alternativos de aprendizaje (emisoras
            institucionales, comerciales, comunitarias, virtuales, canales de televisión, empresas públicas y/o
            privadas,
            medios impresos, proyectos web, etc.). Total horas de la Fase de Formación Básica: 1.200 (540
            teórico-prácticas y 660 prácticas).
        </p>

        <p>
            Para certificarse {!! $parte1 !!} debe hacer cursado la Fase de Formacion Básica y la Fase de Profundización
            (en la línea elegida) más los
            Protocolos Previos (Diplomado o Monografía o Video y las cuatro Pruebas de Aptitud y Competencias) mediante
            los cuales demuestra plenamente
            sus competencias en el SER, en el SABER y en el SABER HACER.
        </p>

        <p>
            La <b>Formación Básica</b> que se adelanta en {!! $parte1 !!} obedece a la siguiente distribución curricular:
        </p>

        <table style="font-size: 12px" class="table-striped">
            <tr>
                <td style="width: 10%" rowspan="5">Primer Semestre</td>
            </tr>
            <tr>
                <td>LOCUCIÓN RADIAL I </td>
                <td>
                    - Taller de Radio I<br>
                    - Producción y Locución Comercial<br>
                    - Lectura de Noticias I<br>
                    - Locución Deportiva I
                </td>
            </tr>
            <tr>
                <td>TÉCNICA VOCAL I</td>
                <td>
                    - Producción de la Voz I
                </td>
            </tr>

            <tr>
                <td>REDACCIÓN INFORMATIVA I </td>
                <td>
                    - Lecto-Escritura I
                </td>
            </tr>

            <tr>
                <td>FORMACIÓN EN EL SER Y EN EL SABER I </td>
                <td>
                    - Cátedra Insteliana<br>
                    - Cultura General y Actualidad Nacional e Internacional<br>
                    - Inglés I
                </td>
            </tr>
            <tr>
                <td style="width: 10%" rowspan="6">Segundo Semestre</td>
            </tr>
            <tr>
                <td>LOCUCIÓN RADIAL II </td>
                <td>
                    - Taller de Radio II<br>
                    - Lectura de Noticias II<br>
                    - Locución Deportiva II<br>
                    - Locución y Presentación Audiovisual I
                </td>
            </tr>
            <tr>
                <td>TÉCNICA VOCAL II</td>
                <td>- Producción de la Voz II</td>
            </tr>
            <tr>
                <td>REDACCIÓN INFORMATIVA II </td>
                <td>- Lecto-Escritura II</td>
            </tr>
            <tr>
                <td>DESEMPEÑO EN VIVO</td>
                <td>- Presentación de Eventos</td>
            </tr>
            <tr>
                <td>FORMACIÓN EN EL SER Y EN EL SABER II</td>
                <td>
                    - Legislación colombiana de Medios de Comunicación<br>
                    - Inglés II
                </td>
            </tr>
            <tr>
                <td style="width: 10%" rowspan="6">Tercer Semestre</td>
            </tr>

            <tr>
                <td>LOCUCIÓN RADIAL III </td>
                <td>
                    - Taller de Radio III<br>
                    - Lectura de Noticias III<br>
                    - Locución Deportiva III<br>
                    - Locución y Presentación Audiovisual II
                </td>
            </tr>

            <tr>
                <td>REDACCIÓN INFORMATIVA III </td>
                <td>- Redacción Especializada</td>
            </tr>

            <tr>
                <td>DESEMPEÑO REPORTERIL</td>
                <td>- Técnicas de Reportería General (en Radio y Televisión)</td>
            </tr>

            <tr>
                <td>FORMACIÓN EN EL SER Y EN EL SABER III </td>
                <td>
                    - Fundamentos Éticos<br>
                    - Publicidad y Ventas en Medios de Comunicación (énfasis en Emprendimiento en Medios)<br>
                    - Inglés III
                </td>
            </tr>
        </table>
        </div>
        </div>

        </div>

        <div style="font-size: 10px;">* La Fase de Formacion Básica contempla MÓDULOS ESPECIFICOS y MÓDULOS
            TRANSVERSALES.
            El diseño curricular del programa <b>TÉCNICO</b>LABORAL EN LOCUCIÓN de INSTEL </b>está</b>basado en
            las
            siguientes
            NORMAS DE COMPETENCIA LABORAL DE CHILE:</b>NCL: POSCSR1,</b>NCL: POSCSR2,</b>NCL: POSCSR4 y</b>NCL:
            POSCSR012</div>

        <p style="margin-left: 30px">
            <b>PARÁGRAFO 1: </b>Los Protocolos previos a la Certificación se planifican </b>desde el inicio</b> de la
            Fase
            de
            Profundización; estos consisten en un Diplomado de 60 horas en Comunicación Organizacional con énfasis
            en
            Jefatura de Prensa (o si {!! $parte1 !!} prefiere, redacta</b>una Monografía de al menos 40 páginas o
            realiza
            técnicamente un video de al menos 15 minutos de duración) y la presentación ante</b>jurados de cuatro
            (4)
            Pruebas de Aptitud y Competencias: Producción-Locución Radial, Técnica Vocal, Redacción
            Periodistica-Publicitaria
            y Conocimientos de Cultura General-Actualidad Nacional e Internacional.
        </p>

        <p style="margin-left: 30px">
            <b>PÁRAGRAFO 2:</b> Se exonera a {!! $parte1 !!}  de presentar estas cuatro pruebas cuando en su
            desempeño
            académico hubiere obtenido un promedio minimo 4.5 (sin habilitar ninguna materia en ningún semestre) en
            cada
            uno de los tres semestres de la formacion básica y en la fase de profundizacion. En ningún caso estos
            promedios
            son acumulables (cada semestre es diferente y se debe alcanzar en cada uno el promedio minimo de 4.5).
        </p>
        <p>
            <b>- Fase de Profundización (a elegir): </b>corresponde al proceso académico en el que {!! $parte1 !!}
            enfatiza
            en una línea de desempeño de acuerdo con su vocación o necesidades específicas del mercado. Esta fase
            consta
            de 150 horas de trabajo académico especializado en el área elegida entre las siguientes alternativas:

        <ul>
            <li>Locución y Animación Musical</li>
            <li>Locución y Reportería Deportiva</li>
            <li>Locución Informativa y Reportería</li>
            <li>Producción y Locución Comercial</li>
            <li>Locución y Presentación de Televisión</li>
        </ul>

        <b>NOTA: </b>Para autorizar la formación de un grupo en Fase de Profundización</b>es necesario reunir un
        número
        mínimo de doce (12)</b> personas que posibliten la viabilidad</b> y sobre todo el sostenimiento del grupo.
        </p>
        <p style="margin-left: 30px">
            <b>PARÁGRAFO: INSTEL</b> otorga CERTIFICACIÓN a aquellos estudiantes que concluyen exitosamente todos
            sus procesos académicos con sus protocolos y de este modo alcanzan las competencias específicas que les
            permitirán desempeñarse en el mercado laboral de los medios de comunicación (Locución, Producción,
            Presentación en Radio,</b>Televisión y Medios Digitales).
        </p>
        <p>
            <b>SEGUNDO:</b>El valor total del programa es el resultante de sumar los valores que debe pagar por
            cada período semestral más los valores adicionales en que incurra {!! $parte1 !!} por concepto de
            constancias de estudio, alquiler de cabinas en horarios extraclase, supletorios, habilitaciones,
            seminarios, validaciones, etc. El valor de cada semestre al cambiar el año está sujeto al incremento
            señalado en el Índice de Precios al Consumidor, I.P.C. que publica el DANE durante los primeros días
            del nuevo año.

        </p>
        <p style="margin-left: 30px">
            <b>PARÁGRAFO 1:</b> La forma como será cubierto el valor del semestre por parte del estudiante se
            acuerda directamente con él o con su representante; del mismo modo, si se conceden beneficios que
            conduzcan a descuentos, tarifas especiales, convenios, canjes, compensaciones, etc.
        </p>
        <p style="margin-left: 30px">
            <b>PARÁGRAFO 2:</b> En caso que {!! $parte1 !!} no pudiere pagar la totalidad del valor del programa
            de estudio, semestralmente se le desglosarán los valores a efectos de que sepa a qué corresponde
            cada ítem pagado.</b>
        </p>
        
            @php
                $dd = $laMatricula->first()->periodo;
                $mP = substr($dd, -1);
                $aP = substr($dd, 0, -1);
                $periodos = [];
            @endphp
        <p>
            <b>TERCERO:</b> {!! $parte1 !!} ingresa para cursar el <b> {{ Str::upper($semestreNominal[$laMatricula->first()->nivel]) }} </b> y en
            estas
            condiciones se obliga a pagar íntegra y oportunamente el valor total del servicio educativo que
            impartirá {!! $parte2 !!}, durante el período lectivo <b>{{ Session::get('config')['nombrePeriodos'][$mP] }} DE
                {{ $aP }}</b> equivalente a
            <b>${{ number_format($elPrograma->v_total, 0, '', '.') }}
                (la cantidad en letras es: {{ $formatter->toWords($elPrograma->v_total, 0) }} PESOS
                M/CTE
            </b>)

            @if ($datos)

                distribuidos en <b>{{ $datos->cuotas }} cuotas </b>y acordado
                su pago de la siguiente forma:

                <div class="table" style="width: 100%; font-size:13px; margin-top:20px; margin-bottom:20px">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Cuota</th>
                                <th style="width: 20%;">Fecha</th>
                                <th style="width: 20%;">Capital</th>
                                <th style="width: 10%;">Interés</th>
                                <th style="width: 20%;">Cuota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (explode('|', $datos->plan) as $itemPlan)
                                @if ($itemPlan !== '')
                                    <tr class="">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $itemPlan }}</td>
                                        <td>$ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }}</td>
                                        <td>$ 0</td>
                                        <td>$ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                (Ya deducidas tanto inscripción y matrícula como la cuota inicial), cuyo vencimiento se producirá en
                las fechas señaladas en este contrato.
                <br><br>
                El no pago oportuno de estas cuotas por parte del estudiante causará un interés máximo del
                3% mensual sobre la cuota no pagada y facultará automáticamente a {!! $parte2 !!} para iniciar las
                gestiones
                jurídicas pertinentes encaminadas a recaudar el total de la deuda.
                <br><br>
            @endif
            El valor de la Inscripción y de la Estampilla Pro-Cultura Municipal no son reembolsables.
        </p>
        <p>
            <b>CUARTO:</b>{!! $parte1 !!} asume las siguientes obligaciones:
        </p>
        <p>
        <ol>
            <li><b>Asistir y cumplir</b> con las actividades programadas para su plan de estudios, de acuerdo
                con la calendarización proporcionada oportunamente por <b>INSTEL.</b></li>
            <li><b>Ser baluarte de calidad:</b> Como estudiante</b> de una gran organización educativa dentro y
                fuera del plantel para mantener la excelente imagen que la institución se ha ganado durante su
                amplia trayectoria.</li>

            @if ($datos)
                <li><b>Cumplir con el pago de las cuotas:</b> En las fechas que correspondan según lo acordado.
                </li>
            @endif

            <li><b>Cuidar y Mantener</b> en perfecto estado los bienes de la institución.</li>
            <li><b>Velar</b> por el buen nombre de</b>INSTEL, sus directivos, empleados y docentes, dentro y
                fuera
                del plantel</li>
            <li><b>Denunciar</b> ante los directivos de la institución sobre daños y demás atentados que otros
                alumnos o terceras personas ocasionaren.</li>
        </ol>
        </p>
        <p>
            <b>QUINTO: INSTEL</b> en aras de<b> reconocer, estimular y premiar el rendimiento académico </b>de sus
            estudiantes,
            garantiza un <b>beneficio económico</b> a aquellos que obtengan al final del semestre un promedio en
            limpio,
            <b>sin habilitaciones de 4.5 (cuatro punto cinco) </b>en adelante. Este criterio aplica solamente para
            los
            estudiantes
            que pasan de primero a segundo semestre y de segundo a tercer semestre. No aplica para la Fase de
            Profundización ni para los protocolos previos.

        </p>
        <p style="margin-left: 30px">

            <b>PARÁGRAFO:</b> El beneficio consiste en disminuirle al valor estándar o normal establecido del
            semestre,
            entre un 10% hasta un 20% dependiendo del promedio alcanzado: 10% si obtuvo 4.5 o 4.6. Y 20% si obtuvo
            4.7
            en adelante.
        </p>
        <p>
            <b>SEXTO: </b>{!! $parte1 !!} podrá renunciar en cualquier momento al programa académico notificando en
            forma anticipada dicha renuncia por escrito a<b> INSTEL</b>, la que sólo tendrá vigencia y se hará
            efectiva
            desde el tercer día hábil desde la fecha de recepción de la comunicación antes indicada.
            La renuncia firmada por {!! $parte1 !!} lo eximirá de la obligación de pagar en forma íntegra el valor
            restante
            del programa de estudio. Solamente quedará obligado a pagar a<b> INSTEL</b> el cincuenta por ciento
            (50%)
            del
            valor del programa de estudio, o aquella cantidad de dinero que corresponda haber pagado a la fecha de
            notificación
            <b> de la renuncia hecha por escrito</b>, cuando esta última cantidad fuere mayor que el porcentaje
            indicado
            anteriormente.
            El abandono de los estudios por parte del estudiante no le habilita, bajo ningún aspecto, para exigir el
            reintegro
            de lo que haya pagado por concepto del servicio educativo. Se entiende por abandono el que {!! $parte1 !!}
            se
            despreocupe de sus obligaciones académicas, no asista a clases de manera regular y no responda ni a
            evaluaciones
            ni a llamadas de la institución).
            En caso de fallecimiento del estudiante, la deuda se considera extinguida desde el día en que<b>
                INSTEL</b>
            tome
            conocimiento del hecho lo cual debe ser notificado por sus familiares o representantes por escrito a
            este
            último
            con las copias de los documentos que acrediten jurídicamente dicha muerte.
        </p>
        <p>
            <b>SÉPTIMO: </b>{!! $parte1 !!} y/o su avalista o acudiente, se obligan a pagar periódicamente (cada mes)
            el
            valor
            de las cuotas correspondientes al monto del programa de estudio en la época de vencimiento que
            corresponda
            según
            lo indicado a continuación:<b> por norma general en INSTEL</b> los estudiantes deben cancelar sus cuotas
            entre el primero y el cinco de cada mes, salvo que {!! $parte1 !!} y/o su acudiente hubieren notificado
            por
            escrito
            una fecha distinta para pago en razón a la fecha de obtención de sus ingresos; en este caso se tomará
            como
            día
            primero la fecha acordada y se contarán cuatro días más para fijación del límite de pago.
            Pasada esa fecha empezará a causarse el respectivo interés moratorio (3% sobre la cuota impaga).
        </p>
        <p>
            <b>OCTAVO: </b>Sin perjuicio de lo dispuesto en la cláusula tercera de este contrato, se obliga a {!! $parte1 !!} 
            a cancelar a {!! $parte2 !!} el saldo íntegro adeudado, independientemente de los resultados que obtenga
            en
            las
            actividades académicas de que da cuenta el presente instrumento.
        </p>
        <p>
            <b>NOVENO:</b> Para todos los efectos legales derivados del presente contrato, las partes fijan su
            domicilio
            en la ciudad de Cali, Departamento Valle del Cauca, Colombia, (con excepción de quienes residen en otros
            municipios)
            y se someten a la jurisdicción de sus tribunales de justicia.
            Sin perjuicio de lo anterior, {!! $parte1 !!} tiene la obligación de registrar su domicilio y notificar
            por
            escrito
            mediante carta certificada a las oficinas de<b> INSTEL</b> todo cambio al respecto que se presentare.
        </p>
        <p>
            <b>DÉCIMO: </b>Mandato: {!! $parte1 !!} en este instrumento viene a otorgar mandato
            especial
            a<b> INSTEL</b>, a fin de que este último, actuando en nombre y en representación del primero, proceda a
            suscribir
            pagarés, aceptar y/o reconocer deudas en beneficio de<b> INSTEL</b> por los montos de capital e interés
            y gastos de cobranza de los montos adeudados por {!! $parte1 !!} </b> como consecuencia del incumplimiento
            de
            este contrato, así como también para informar sus antecedentes a las entidades de control crediticio
            (DATACREDITO)
            que operan en nuestro país.<b> Dichos documentos no constituirán</b> notación de las obligaciones en
            ellos
            establecidas. El presente mandato tendrá carácter de irrevocable en los términos fijados por el Código
            de
            Comercio,
            mientras esté vigente la deuda. Extinguida la vigencia de ésta por cualquier motivo, y siempre que no
            existan
            créditos pendientes, la revocación del mandato solo tendrá efecto a contar desde el tercer día hábil
            siguiente al aviso dado por escrito en tal sentido al representante legal de<b> {!! $parte2 !!}.</b>
        </p>
        <!-- FIN CONTRATO DE TÉCNICO LABORAL EN LOCUCIÓN -->
    @endif

    @if ($elPrograma->tipo == 'Seminario-Taller')
        <p>
            <b>PRIMERO. Objeto del Contrato:</b> El Proveedor del Servicio (la Institución) se compromete a
            impartir un <b>{{ Str::upper($elPrograma->nombre) }}</b> con duración de {{ $elPrograma->duracion }}, 
            entregando a {!! $parte1 !!} un Certificado de Asistencia y Participación.
        </p>

        <p>
            <b>SEGUNDO. Fechas y Duración:</b> El seminario se llevará a cabo desde el 
            {{ formatearFecha($laMatricula->where('prg', $elPrograma->id)->first()->fechaIngreso) }} hasta el
            {{ formatearFecha($laMatricula->where('prg', $elPrograma->id)->first()->getSesiones()->where('seminarID',$laMatricula->first()->getSesiones()->first()->dataSeminar()->where('prg', $elPrograma->id)->orderBy('sesionID', 'DESC')->first()->id)->first()->fecha) }}.
        </p>

        <p>
            <b>TERCERO. Precio y Pago:</b> {!! $parte1 !!} se compromete a pagar el valor de la inscripción por valor de 
            {{ $formatter->toWords($elPrograma->inscripcion, 0) }}  PESOS MTCE ($ {{ number_format($elPrograma->inscripcion, 0, '', '.') }})
             y el total del <b>{{ Str::upper($elPrograma->nombre) }}</b> por {{ $formatter->toWords($elPrograma->v_total, 0) }} 
            PESOS MCTE. ($ {{ number_format($elPrograma->v_total, 0, '', '.') }}).


            @if ($datos)
                a través de <b>{{ $formatter->toWords($datos->cuotas, 0).' ('.$datos->cuotas.')' }} cuotas </b> mensuales 
                de $ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }} 
                El pago correspondiente se realizará conforme a la siguiente
                <b>PLANEACIÓN FINANCIERA:</b>

                <div class="table" style="width: 100%; font-size:13px; margin-top:20px; margin-bottom:20px">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Cuota</th>
                                <th style="width: 20%;">Fecha</th>
                                <th style="width: 20%;">Capital</th>
                                <th style="width: 10%;">Interés</th>
                                <th style="width: 20%;">Cuota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (explode('|', $datos->plan) as $itemPlan)
                                @if ($itemPlan !== '')
                                    <tr class="">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $itemPlan }}</td>
                                        <td>$ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }}</td>
                                        <td>$ 0</td>
                                        <td>$ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <small>NOTA: El no pago oportuno hasta la fecha límite ocasionará interés moratorio (3%).</small>
            @endif
        </p>

        <p>
            <b>CUARTO. Cancelación: </b>En caso de que {!! $parte1 !!} desee cancelar (suspender) alguno de los
            seminarios, deberá notificar por escrito a la Institución con al menos tres (3) días de
            anticipación o si deseare por alguno motivo modificar las fechas de clases o de pagos.
        </p><p>
            <b>QUINTO. Propiedad Intelectual:</b> Todo el material proporcionado durante los seminarios,
            incluyendo presentaciones, manuales y recursos, son propiedad intelectual de la
            Institución y no podrán ser utilizados con fines comerciales sin el consentimiento expreso
            y por escrito de lNSTEL.
        </p><p>
            <b>SEXTO. Ley Aplicable:</b> Este contrato se regirá por la normatividad civil colombiana vigente y
            cualquier controversia que eventualmente surgiere será dirimida mediante acuerdo entre
            las partes, o a través de conciliación, mediación o cualquiera de las formas dispuestas
            para resolución de conflictos con la finalidad de no congestionar los tribunales de justicia,
            dada la baja cuantía del presente contrato.
        </p>
    @endif

    @if ($elPrograma->tipo == 'Paquete Seminario')
        <!-- DEFINE SI ES UN PAQUETE O VIENE INDIVIDUAL -->
        @php
            $nSeminarios = $user
                    ->misBoxMatriculas()
                    ->where('estado', 'ACTIVO')
                    ->orderBy('fechaIngreso');
            $fechaIniPaq = $user
                    ->misBoxMatriculas()
                    ->where('estado', 'ACTIVO')
                    ->first()
                    ->getSesiones()
                    ->first()->fecha;
            $fechaFinPaq = $user
                    ->misBoxMatriculas()
                    ->where('estado', 'ACTIVO')
                    ->orderBy('id', 'DESC')
                    ->first()
                    ->getSesiones()
                    ->reverse()
                    ->first()->fecha;
                
                $nombreProg = $elPrograma->tipo . ' ' . $elPrograma->nombre;
                $total_part = $formatter->toWords($nSeminarios->count(), 0).' ('.$nSeminarios->count().')';
        @endphp

        <p>
            <b>PRIMERO. Objeto del Contrato:</b> El Proveedor del Servicio (la Institución) se compromete a
            impartir un <b>{{ Str::upper($nombreProg) }}</b> integrado a su vez por {{ $total_part }}
            herramientas de expresión y óptima comunicación. Cada uno de los {{ $total_part }} seminarios se
            llevará a cabo durante un mes aproximadamente y abordará las herramientas especificadas en el programa
            proporcionado por la Institución,  dando inicio el {{ formatearFecha($fechaIniPaq) }} y finalizando el
            {{ formatearFecha($fechaFinPaq) }}, entregando a {!! $parte1 !!} {{ $total_part }}
            Certificado(s) de Asistencia y Participación.
        </p>

        <p>
            <b>SEGUNDO. Fechas y Duración:</b> Los {{ $total_part }} seminarios se llevarán a cabo en las siguientes fechas:
            <ol class="mt-3">
                @foreach ($nSeminarios->get() as $item)
                    <li class="mb-1">
                        <b>{{ Str::upper($item->getPrograma()->tipo . ' ' . $item->getPrograma()->nombre) }}</b>:
                        Desde el {{ formatearFecha($item->fechaIngreso) }} hasta el
                        {{ formatearFecha($item->getSesiones()->where('seminarID',$item->getSesiones()->first()->dataSeminar()->where('prg', $item->getPrograma()->id)->orderBy('sesionID', 'DESC')->first()->id)->first()->fecha) }}.
                    </li>
                @endforeach
            </ol>
        </p>

        <p>
            <b>TERCERO. Precio y Pago:</b> {!! $parte1 !!} se compromete a pagar el valor de  las {{ $total_part }} 
            inscripciones por valor de {{ $formatter->toWords($elPrograma->inscripcion, 0) }}  PESOS MTCE 
            y el total del <b>{{ Str::upper($nombreProg) }}</b> por {{ $formatter->toWords($elPrograma->v_total, 0) }} 
            PESOS MCTE. ($ {{ number_format($elPrograma->v_total, 0, '', '.') }}).


            @if ($datos)
                a través de <b>{{ $formatter->toWords($datos->cuotas, 0).' ('.$datos->cuotas.')' }} cuotas </b> mensuales 
                de $ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }}  (ya está considerado en ese valor el
                descuento del 10% sobre el costo de cada seminario, excluido el valor de la inscripción).
                El pago correspondiente se realizará conforme a la siguiente
                <b>PLANEACIÓN FINANCIERA:</b>

                <div class="table" style="width: 100%; font-size:13px; margin-top:20px; margin-bottom:20px">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Cuota</th>
                                <th style="width: 20%;">Fecha</th>
                                <th style="width: 20%;">Capital</th>
                                <th style="width: 10%;">Interés</th>
                                <th style="width: 20%;">Cuota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (explode('|', $datos->plan) as $itemPlan)
                                @if ($itemPlan !== '')
                                    <tr class="">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $itemPlan }}</td>
                                        <td>$ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }}</td>
                                        <td>$ 0</td>
                                        <td>$ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <small>NOTA: El no pago oportuno hasta la fecha límite ocasionará interés moratorio (3%).</small>
            @endif
        </p>

        <p>
            <b>CUARTO. Cancelación: </b>En caso de que {!! $parte1 !!} desee cancelar (suspender) alguno de los
            seminarios, deberá notificar por escrito a la Institución con al menos tres (3) días de
            anticipación o si deseare por alguno motivo modificar las fechas de clases o de pagos.
        </p><p>
            <b>QUINTO. Propiedad Intelectual:</b> Todo el material proporcionado durante los seminarios,
            incluyendo presentaciones, manuales y recursos, son propiedad intelectual de la
            Institución y no podrán ser utilizados con fines comerciales sin el consentimiento expreso
            y por escrito de lNSTEL.
        </p><p>
            <b>SEXTO. Ley Aplicable:</b> Este contrato se regirá por la normatividad civil colombiana vigente y
            cualquier controversia que eventualmente surgiere será dirimida mediante acuerdo entre
            las partes, o a través de conciliación, mediación o cualquiera de las formas dispuestas
            para resolución de conflictos con la finalidad de no congestionar los tribunales de justicia,
            dada la baja cuantía del presente contrato.
        </p>
    @endif

    @if ($elPrograma->tipo == 'Certificaciones')
        <p>
            <b>PRIMERO: El INSTITUTO NACIONAL DE TELECOMUNICACIONES LTDA., INSTEL LTDA</b> se compromete a prestar el servicio educativo 
            con miras a la <b>{{ Str::upper($elPrograma->nombre) }}</b> durante el periodo lectivo 
            <b>{{ $nombresPeriodos[substr($laMatricula->first()->periodo, -1)] }}</b> (Fase Modular) y <b>{{ $nombresPeriodos[substr($laMatricula->first()->periodo, -1) + 2] }} </b>(Fase Protocolar) 
            de una manera eficiente, oportuna y bajo los parámetros que enmarcan el proceso formativo de Locutores en ejercicio, pero sin calificación
            académica.
        </p>
        <p>
            <b>SEGUNDO:</b> Las partes se obligan a aceptar las normas académicas institucionales vigentes,
            los cuales declaran conocer y aceptar expresamente, y que forman parte integral de este
            Contrato.
        </p>
        <p>
            <b>TERCERO:</b> {!! $parte1 !!} declara haber escogido libremente a el 
            <b>INSTITUTO NACIONAL DE TELECOMUNICACIONES LTDA, INSTEL LTDA</b> para
            <b>CERTIFICARSE</b> en el programa académico descrito; por lo tanto, acepta como parte de dicha
            formación todas las actividades programadas por la institución para tal fin, incluyendo
            ejercicios, evaluaciones, prácticas de campo, grabaciones, pruebas, presencialidades, etc.
        </p>
        <p>
            <b>CUARTO:</b> {!! $parte1 !!} se compromete a cumplir estrictamente el
            Cronograma Académico asignado para esta fase y las particularidades inherentes al programa de
            estudio, el cual corresponde al Área de Educación Informal según el Decreto 4904 de 2009,
            ítem 5.8. El no cumplimiento estricto genera que <b>El INSTITUTO NACIONAL DE
            TELECOMUNICACIONES LTDA, INSTEL LTDA</b> de por terminado unilateralmente este
            Contrato.
        </p>
        <p>
            <b>QUINTO:</b> {!! $parte1 !!} se obliga a pagar el valor
            correspondiente al programa de Estudio en las fechas designadas para tal fin además de los
            costos implícitos por certificado o constancia. El valor del proceso académico se desglosa de la
            siguiente manera: en la <b>FASE MODULAR</b> la inscripción por <b>$ {{ number_format($elPrograma->inscripcion, 0, '', '.') }}
            ({{ $formatter->toWords($elPrograma->inscripcion, 0) }} PESOS MTCE)</b>, el pago de Estampilla
            Pro-Cultura Municipal de Cali y el valor de la Instrucción Académica por <b>$ {{ number_format($elPrograma->v_total, 0, '', '.') }}
            ({{ $formatter->toWords($elPrograma->v_total, 0) }} PESOS MTCE</b> 

            @if ($datos)

                    distribuidos en <b>{{ $datos->cuotas }} cuotas </b>y acordado
                    su pago de la siguiente forma:
            </p>
                    <div class="table" style="width: 100%; font-size:13px; margin-top:20px; margin-bottom:20px">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Cuota</th>
                                    <th style="width: 20%;">Fecha</th>
                                    <th style="width: 20%;">Capital</th>
                                    <th style="width: 10%;">Interés</th>
                                    <th style="width: 20%;">Cuota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (explode('|', $datos->plan) as $itemPlan)
                                    @if ($itemPlan !== '')
                                        <tr class="">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $itemPlan }}</td>
                                            <td>$ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }}</td>
                                            <td>$ 0</td>
                                            <td>$ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                <p>
                    El no pago oportuno de estas cuotas por parte de {!! $parte1 !!} causará un interés máximo del
                    3% mensual sobre la cuota no pagada y facultará automáticamente a <b>INSTEL</b> para iniciar las
                    gestiones
                    jurídicas pertinentes encaminadas a recaudar el total de la deuda
                @endif
                . El valor de la Inscripción y de la Estampilla Pro-Cultura Municipal no son reembolsables.
            </p>

        </p>
            @if ($elPrograma->id !== 28)
            <p>
                El costo de la <b>FASE PROTOCOLAR</b> es de $ 960.000 (NOVECIENTOS SESENTA MIL PESOS MTCE) los cuales incluyen las 
                <b>cuatro (4) Pruebas de Aptitud</b> y los <b>Derechos de Certificación</b>.
            </p>
            @endif
        <p>
            <b>SEXTO: </b>Cuando se paga por cuotas, la no cancelación de la totalidad de las obligaciones
            contraídas con la institución dará derecho a ésta a suspender el proceso académico y a iniciar las
            acciones legales pertinentes para el cobro jurídico.
        </p>
        <p>
            <b>SÉPTIMO: </b>De conformidad con lo establecido en el Artículo 622 del Código de Comercio, el
            usuario del servicio educativo o alumno autoriza en forma irrevocable a el<b>INSTITUTO
            NACIONAL DE TELECOMUNICACIONES LTDA, INSTEL LTDA </b>para llenar el Pagaré
            otorgado a su favor y elaborado el día de la Matrícula con los espacios relativos a la cuantía,
            intereses y fecha de vencimiento en blanco en cualquier tiempo y sin previo aviso, de acuerdo
            con las siguientes instrucciones: 1) La cuantía será igual al monto de todas las sumas adeudadas
            a la institución, hasta el día que sea llenado el Pagaré. 2) Los intereses serán los comerciales
            moratorios que estén vigentes al momento en que se haga exigible la obligación, y se
            acreditarán con la certificación expedida por la Superintendencia Bancaria. 3) La fecha de
            exigibilidad del Pagaré será la del día en que el Título sea llenado. En caso de mora en la
            cancelación de cualquiera de estas obligaciones a cargo de cualquiera de los aceptantes del
            Pagaré, serán exigibles inmediatamente las obligaciones existentes a la fecha sin necesidad de
            requerimientos ni constitución en mora, pues ya se autoriza a el <b>INSTITUTO NACIONAL
            DE TELECOMUNICACIONES LTDA, INSTEL LTDA</b> para exigir de inmediato el pago de
            todos y cada uno de los créditos a cargo de los obligados en el Pagaré, por vía ejecutiva o
            cualquier otro medio legal.
        </p>
        <p>
            <b>OCTAVA:</b> La vigencia del presente Contrato se extiende hasta la finalización del período
            lectivo tal como se especifica en el Cronograma Lectivo correspondiente.
        </p>
    @endif

    @if ($elPrograma->tipo == 'Diplomado')
    <p>
        <b>PRIMERO: El INSTITUTO NACIONAL DE TELECOMUNICACIONES LTDA., INSTEL LTDA</b> se compromete a prestar el servicio educativo 
        del <b>DIPLOMADO {{ Str::upper($elPrograma->nombre) }}</b> en el periodo lectivo 
        <b>{{ $nombresPeriodos[substr($laMatricula->first()->periodo, -1)] }}</b> y realizar las <b>PRUEBAS DE APTITUD Y COMPETENCIAS</b> 
        de una manera eficiente, oportuna y bajo los parámetros que enmarcan el proceso formativo de Locutores para
        Radio y Televisión.
    </p>
    <p>
        <b>SEGUNDO:</b> Las partes se obligan a aceptar las normas académicas institucionales vigentes, los cuales
        declaran conocer y aceptar expresamente, y que forman parte integral de este Contrato.
    </p>
    <p>
        <b>TERCERO: </b>El usuario del servicio o alumno declara haber escogido libremente a el <b>INSTITUTO
        NACIONAL DE TELECOMUNICACIONES LTDA, INSTEL LTDA</b> para capacitarse en el programa
        académico descrito; por lo tanto, acepta como parte de dicha formación todas las actividades
        programadas por la institución para tal fin, incluyendo ejercicios, evaluaciones, prácticas de campo,
        grabaciones, sustentaciones, pruebas, etc.
    </p>
    <p>
        <b>CUARTO:</b> El usuario del servicio o alumno se compromete a cumplir estrictamente el Cronograma
        Académico asignado para estos protocolos y las particularidades inherentes al programa de estudio
        descrito. El no cumplimiento estricto del reglamento genera que el <b>INSTITUTO NACIONAL DE
        TELECOMUNICACIONES LTDA, INSTEL LTDA</b> de por terminado unilateralmente este Contrato.
    </p>
    <p>
        <b>QUINTO:</b> {!! $parte1 !!} se obliga a pagar el valor
        correspondiente al programa de Estudio en las fechas designadas para tal fin. El valor del proceso académico se desglosa de la
        siguiente manera: la inscripción por <b>$ {{ number_format($elPrograma->inscripcion, 0, '', '.') }}
        ({{ $formatter->toWords($elPrograma->inscripcion, 0) }} PESOS MTCE)</b>, el pago de Estampilla
        Pro-Cultura Municipal de Cali y el valor de los <b>Protocolos Previos a la Certificación</b> por 
        <b>$ {{ number_format($elPrograma->v_total, 0, '', '.') }}
        ({{ $formatter->toWords($elPrograma->v_total, 0) }} PESOS MTCE</b>
        @if ($datos)

                    distribuidos en <b>{{ $datos->cuotas }} cuotas </b>y acordado
                    su pago de la siguiente forma:
            </p>
                    <div class="table" style="width: 100%; font-size:13px; margin-top:20px; margin-bottom:20px">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Cuota</th>
                                    <th style="width: 20%;">Fecha</th>
                                    <th style="width: 20%;">Capital</th>
                                    <th style="width: 10%;">Interés</th>
                                    <th style="width: 20%;">Cuota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (explode('|', $datos->plan) as $itemPlan)
                                    @if ($itemPlan !== '')
                                        <tr class="">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $itemPlan }}</td>
                                            <td>$ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }}</td>
                                            <td>$ 0</td>
                                            <td>$ {{ number_format($datos->valor / $datos->cuotas, 0, '', '.') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                <p>
                    El no pago oportuno de estas cuotas por parte de {!! $parte1 !!} causará un interés máximo del
                    3% mensual sobre la cuota no pagada y facultará automáticamente a <b>INSTEL</b> para iniciar las
                    gestiones
                    jurídicas pertinentes encaminadas a recaudar el total de la deuda
                @endif
                . El valor de la Inscripción y de la Estampilla Pro-Cultura Municipal no son reembolsables.
    </p>
    <p style="margin-left: 30px">
        <b>NOTA:</b> Debe estar a paz y salvo para presentar la sustentación del trabajo final del Diplomado.
    </p>
    <p>
        <b>SEXTO: </b> La no cancelación de la totalidad de las obligaciones contraídas con la institución dará derecho
        a ésta a iniciar las acciones legales pertinentes para el cobro jurídico.
    </p>
    <p>
        <b>SÉPTIMO: </b> De conformidad con lo establecido en el Artículo 622 del Código de Comercio, el usuario del
        servicio educativo o alumno autoriza en forma irrevocable a el<b> INSTITUTO NACIONAL DE
        TELECOMUNICACIONES LTDA, INSTEL LTDA </b>para llenar el Pagaré otorgado a su favor y elaborado el
        día de la Matrícula con los espacios relativos a la cuantía, intereses y fecha de vencimiento en blanco en
        cualquier tiempo y sin previo aviso, de acuerdo con las siguientes instrucciones: 1) La cuantía será igual
        al monto de todas las sumas adeudadas a la institución, hasta el día que sea llenado el Pagaré. 2) Los
        intereses serán los comerciales moratorios que estén vigentes al momento en que se haga exigible la
        obligación, y se acreditarán con la certificación expedida por la Superintendencia Bancaria. 3) La fecha de
        exigibilidad del Pagaré será la del día en que el Título sea llenado. En caso de mora en la cancelación de
        cualquiera de estas obligaciones a cargo de cualquiera de los aceptantes del Pagaré, serán exigibles
        inmediatamente las obligaciones existentes a la fecha sin necesidad de requerimientos ni constitución en
        mora, pues ya se autoriza a el <b>INSTITUTO NACIONAL DE TELECOMUNICACIONES LTDA, INSTEL
        LTDA</b> para exigir de inmediato el pago de todos y cada uno de los créditos a cargo de los obligados en el
        Pagaré, por vía ejecutiva o cualquier otro medio legal.
    </p>
    <p>
        <b>OCTAVA: </b> La vigencia del presente Contrato se extiende hasta la finalización de los protocolos previos a 
        la Certificación.
    </p>
    @endif

    <p>
        Ambas partes aceptan y firman este contrato en señal de conformidad el día {{ formatearFecha($laMatricula->first()->created_at) }}:
    </p>

    <table>
        <tr class="">
            <td style="width: 50%"></td>
            <td style="width: 50%"><img src="https://virtual.instel.edu.co/images/20230209_154436.png"
                    style="margin-bottom: -60px; width: 90%"></td>
        </tr>
        <tr class="">
            <td><b>{{ $nombreCompleto }}</b><br>
                {{ $pDoc }} de {{ $pDoc_ex }}</td>
            <td><b>ALEISSY LASSO ÁGREDO</b><br>
                C.C. 6.401.878 de Pradera, Valle</td>
        </tr>
    </table>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>
