<!-- Pruebas de Aptitud -->
@if (Auth::user()->getPruebas()->count() > 0)
<div class="row m-4" style="margin-top: 20px">
    <h3 style="border-bottom: #00468C 1px solid">Resultados Pruebas de Aptitud</h3>
    <div class="row">
        @foreach (Auth::user()->getPruebas()  as $item)
            <div class="col-md-3 text-center">
                <a href="{{ ($item->valoracion1 == NULL ? '#' : route('prueba.ver', $item->codigo)) }}" target="_blank">
                    <div style="position: relative; display: inline-block;">
                        <img src="{{ asset('images/portadas/papq-'.$item->idPrueba.'.jpg') }}" class="img-fluid">
                        @if ($item->valoracion1 == NULL)
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(7, 28, 92, 0.9); opacity: 0.5; z-index: 1;"></div>
                        <br>[ No Disponible ]
                        @else
                        {{ $item->laPrueba()->nombre }}
                        @endif
                    </div>
                </a>
                <br>
                @php
                    $visibleDesde = \Carbon\Carbon::parse($item->laPrueba()->fecha1)->subDays(3);
                    $visibleHasta = \Carbon\Carbon::parse($item->laPrueba()->fecha2);
                @endphp
                @if(!is_null($item->laPrueba()->anexo) && $visibleDesde < now() && $visibleHasta > now())
                    <a href="{{ route('ft','pruebas|' . $item->laPrueba()->anexo)}}" target="_blank" class="btn btn-sm btn-primary mt-2">Documento Guía</a>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endif