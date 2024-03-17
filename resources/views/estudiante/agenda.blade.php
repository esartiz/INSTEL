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
    foreach ($matricula as $boxM) {
        if ($boxM->getPrograma()->tipo == 'Seminario-Taller') {
            $sesionesSeminario = $boxM->getSesiones();
            foreach ($sesionesSeminario as $item) {
                if (strtotime($item->fecha) >= $semanaIni && strtotime($item->fecha) <= $semanaFin) {
                    $elLink = 'https://us02web.zoom.us/j/' . $item->zoom;
                    array_push($laAgenda, ['nombre' => 'Sesión ' . $item->dataSeminar()->sesionID . ' ' . 'Docente: ' . ($item->docente()->nombres ?? ' Por ') . ' ' . ($item->docente()->apellidos ?? ' asignar'), 'link' => $elLink, 'fecha' => $item->fecha, 'icono' => 'pen', 'color' => '64117d']);
                }
            }
        } else {
            $modulosM = $boxM->materias();
            foreach ($modulosM as $vv) {
                foreach (
                    $vv
                        ->modulos_s()
                        ->first()
                        ->eventos()
                        ->where('grupo', $boxM->periodo)
                        ->where('fecha', '>=', Carbon::parse($semanaIni))
                        ->where('fecha', '<=', Carbon::parse($semanaFin))
                    as $clase
                ) {
                    $elLink = $clase->fecha == date('Y-m-d') ? $clase->link : '/modulo/' . $clase->modulo;
                    array_push($laAgenda, ['nombre' => $clase->nombre, 'link' => $elLink, 'fecha' => $clase->fecha, 'icono' => 'chalkboard-user', 'color' => '3e8c00']);
                }
            }
        }
    }
    if ($anuncio->count() > 0) {
        foreach ($anuncio as $item) {
            if ($item->nivel == null || $item->nivel == 'GRP' . $dataMatriculaF->periodo || $item->nivel == 'ROL' . Auth::user()->rol || $item->nivel == 'PRG' . $dataMatriculaF->prg || $item->nivel == 'CCL' . $dataMatriculaF->prg . '-' . $dataMatriculaF->nivel || $item->nivel == 'CCL' . $dataMatriculaF->prg . '-' . $dataMatriculaF->nivel . $dataMatriculaF->periodo || $item->nivel == 'COD' . Auth::user()->cod) {
                $idFecha = date('Y-m-d', strtotime($item->vence));
                if ((strtotime($idFecha) >= $semanaIni && strtotime($idFecha) <= $semanaFin) || $item->vence == '2022-01-01 00:00:00') {
                    array_push($laAgenda, ['nombre' => $item->texto, 'link' => $item->ruta, 'fecha' => $idFecha, 'icono' => 'lightbulb', 'color' => '395490']);
                }
            }
        }
    }
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
                    <div class="p-2 bd-highlight text-center @if ($i == 0) bg-success text-white @endif"
                        style="border-right: 1px solid rgb(237, 207, 207)">
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
