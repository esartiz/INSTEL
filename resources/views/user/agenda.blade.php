@php  
    use Carbon\Carbon;
    $semanaIni = strtotime(date('Y-m-d') . '- 7 days');
    $semanaFin = strtotime(date('Y-m-d') . '+ 7 days');
    $laAgenda = [];
    function fWhere($array, $campo, $valor)
    {
        return array_filter($array, function ($item) use ($campo, $valor) {
            return isset($item[$campo]) && $item[$campo] === $valor;
        });
    }
    
    //MODULOS
    foreach ($misModulos as $item) {
        //El docente solo necesita las clases asignadas
        if(Auth::user()->rol == 'Docente'){
            foreach ($item->eventos()->where('fecha', '>=', Carbon::parse($semanaIni))->where('fecha', '<=', Carbon::parse($semanaFin)) as $clase) {
                $elLink = ($clase->fecha == date('Y-m-d') ? $clase->link : '/dmodulo/'.$item->modulo.'/gr/'.$clase->grupo);
                array_push($laAgenda, ['nombre' => $clase->nombre, 'link' => $elLink, 'fecha' => $clase->fecha, 'icono' => 'chalkboard-user', 'color' => '3e8c00']);
            }
        } else {
            //El estudiante
            //Reviso si se encuentra dentro de los tiempos por aquello que se cruza C con D
            $item = Auth::user()->rol == 'Docente' ? $item : $item->modulos_s;
            $tiempos = AppHelper::timeModule($item, $misModulos->first()->grupo);
            $fecha0 = strtotime(date("Y-m-d"));
            $fecha1 = strtotime($tiempos[0][0]);
            $fecha2 = strtotime($tiempos[0][1]);

            //Revisa si tiene clase programada
            foreach ($item->eventos()->where('grupo', $misModulos->first()->grupo)->where('fecha', '>=', Carbon::parse($semanaIni))->where('fecha', '<=', Carbon::parse($semanaFin)) as $clase) {
                $elLink = ($clase->fecha == date('Y-m-d') ? $clase->link : '/modulo/'.$item->id);
                array_push($laAgenda, ['nombre' => $clase->nombre, 'link' => $elLink, 'fecha' => $clase->fecha, 'icono' => 'chalkboard-user', 'color' => '3e8c00']);
            }
            
            //Ingresa fechas de inicio y final de cada autoevaluación
            foreach ($tiempos as $vt) {
                if (isset($vt[3])) {
                    $unidad = Carbon::parse($fecha1)->diffInWeeks(Carbon::parse($vt[0]));
                    //Evita que sea el módulo de las pruebas
                    if($item->id !== 107){
                        array_push($laAgenda, ['nombre' => 'Bienvenidos desde hoy al estudio de la unidad '.($unidad + 1).' del Módulo ' . $item->titulo . '. Feliz aprendizaje!', 'link' => 'modulo/' . $item->id, 'fecha' => explode(' ', $vt[0])[0], 'icono' => 'flag-checkered', 'color' => 'd8721a']);
                        array_push($laAgenda, ['nombre' => 'Inicio Autoevaluación ' . $item->titulo, 'link' => 'modulo/' . $item->id, 'fecha' => explode(' ', $vt[2])[0], 'icono' => 'book', 'color' => '1a88d8']);
                        array_push($laAgenda, ['nombre' => 'Final Autoevaluación ' . $item->titulo, 'link' => 'modulo/' . $item->id, 'fecha' => explode(' ', $vt[3])[0], 'icono' => 'triangle-exclamation', 'color' => 'f23838']);
                    } else {
                        array_push($laAgenda, ['nombre' => 'Prueba ' . $item->titulo, 'link' => 'modulo/' . $item->id, 'fecha' => explode(' ', $vt[2])[0], 'icono' => 'book', 'color' => '1a88d8']);
                    }
                }
            }
        }
    }
    
    //SEMINARIOS SESIONES
    $sesionesSeminario = Auth::user()->rol == 'Docente' ? Auth::user()->sesionesAsignadas() : Auth::user()->misSesiones();
    foreach ($sesionesSeminario as $item) {
        if (strtotime($item->fecha) >= $semanaIni && strtotime($item->fecha) <= $semanaFin) {
            $extraT = Auth::user()->rol == 'Docente' ? 'Estudiante: ' . $item->estudiante()->nombres . ' ' . $item->estudiante()->apellidos : 'Docente: ' . $item->docente()->nombres . ' ' . $item->docente()->apellidos;
            $elLink = 'https://us02web.zoom.us/j/' . $item->zoom;
            array_push($laAgenda, ['nombre' => 'Sesión ' . $item->dataSeminar()->sesionID . ' ' . $extraT, 'link' => $elLink, 'fecha' => $item->fecha, 'icono' => 'pen', 'color' => '64117d']);
        }
    }
    
    //ANUNCIOS
    if($anuncio !== []){
        if ($anuncio->count() > 0) {
            foreach ($anuncio as $item) {
                if (Auth::user()->rol == 'Docente') {
                    if ($item->nivel == null || $item->nivel == 'ROL' . Auth::user()->rol || $item->nivel == 'COD' . Auth::user()->cod) {
                        $idFecha = date('Y-m-d', strtotime($item->vence));
                        if ((strtotime($idFecha) >= $semanaIni && strtotime($idFecha) <= $semanaFin) || $item->vence == '2022-01-01 00:00:00') {
                            array_push($laAgenda, ['nombre' => $item->texto, 'link' => $item->ruta, 'fecha' => $idFecha, 'icono' => 'lightbulb', 'color' => '395490']);
                        }
                    }
                } else {
                    if ($item->nivel == null || $item->nivel == 'GRP' . $dataMatriculaF->periodo || $item->nivel == 'ROL' . Auth::user()->rol || $item->nivel == 'PRG' . $dataMatriculaF->prg || $item->nivel == 'CCL' . $dataMatriculaF->prg . '-' . $dataMatriculaF->nivel || $item->nivel == 'CCL' . $dataMatriculaF->prg . '-' . $dataMatriculaF->nivel . $dataMatriculaF->periodo || $item->nivel == 'COD' . Auth::user()->cod) {
                        $idFecha = date('Y-m-d', strtotime($item->vence));
                        if ((strtotime($idFecha) >= $semanaIni && strtotime($idFecha) <= $semanaFin) || $item->vence == '2022-01-01 00:00:00') {
                            array_push($laAgenda, ['nombre' => $item->texto, 'link' => $item->ruta, 'fecha' => $idFecha, 'icono' => 'lightbulb', 'color' => '395490']);
                        }
                    }
                }
            }
        }
    }
    //ELIMINA REPETIDOS
    $laAgenda = array_map("unserialize", array_unique(array_map("serialize", $laAgenda)));
@endphp

<h3 class="text-center">Tu semana en INSTEL Virtual</h3>

<div class="container overflow-hidden">
    <div class="row g-2">
        <div class="col-md-6">
            <div class="p-3 border text-center text-white" style="background-color: #00468C;">
                <h4>Ten en cuenta:</h4>
                @php
                    $rFiltro = fWhere($laAgenda, 'fecha', '2022-01-01');
                    foreach ($rFiltro as $item) {
                        echo $item['nombre'];
                    }
                @endphp
            </div>
        </div>
        @for ($i = 0; $i < 7; $i++)
            @php
                $fechaCal = strtotime(date('Y-m-d') . '+ ' . $i . ' days');
                $rFiltro = fWhere($laAgenda, 'fecha', date('Y-m-d', $fechaCal));
                $weekDay = ['', 'LUN', 'MAR', 'MIE', 'JUE', 'VIE', 'SÁB', 'DOM'];
                $mesesN = ['', 'ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];
            @endphp
            <div class="col-md-6">
                <div class="p-3 border bg-light d-flex align-content-center">
                    <div class="p-2 bd-highlight text-center @if ($i == 0) bg-success text-white @endif" style="border-right: 1px solid rgb(237, 207, 207)">
                        <div style="font-size: 14px; margin-bottom: -13px">{{ $weekDay[date('N', $fechaCal)] }}</div>
                        <div style="font-weight: bolder; font-size: 28px; margin-bottom: -13px">
                            {{ date('d', $fechaCal) }}
                        </div>
                        <div style="font-weight: bolder; font-size: 18px; margin-bottom: -10px">
                            {{ $mesesN[date('n', $fechaCal)] }}</div>
                        <div style="font-weight: bolder; font-size: 14px">{{ date('Y', $fechaCal) }}</div>
                    </div>
                    <div class="p-2 flex-grow-1 bd-highlight">
                        <div class="list-group">
                            @if (count($rFiltro) > 0)
                                @foreach ($rFiltro as $item)
                                    <a href="{{ $item['link'] }}" class="list-group-item list-group-item-action mb-1"
                                        style="background-color: #{{ $item['color'] }}; border: 0px">
                                        <div class="d-flex align-items-center text-white">
                                            <i class="fa-solid fa-{{ $item['icono'] }}"
                                                style="font-size: 30px; margin-right: 10px"></i>
                                            <span>{{ $item['nombre'] }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                Sin eventos por el momento.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>