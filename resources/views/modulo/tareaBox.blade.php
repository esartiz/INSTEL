@php
    if ($tarea->desde == null) {
        $idSemanaT = explode('|', $tarea->fechas)[$myGroupModule];
        $tDesde = $tiempos[$idSemanaT][2];
        $tLimite = $tiempos[$idSemanaT][3];
    } else {
        $tDesde = $tarea->desde;
        $tLimite = $tarea->limite;
    }
@endphp

    <tr>
        <td>
            @if ($tDesde < now())
                @if ($tLimite > now())
                    <a href="{{ route('ft', 'files|au|' . $tarea->isAU) }}" target="_blank">
                        <b>{{ $tarea->enunciado }}</b> [Descargue aquí las indicaciones]
                    </a>
                @else
                    <b>{{ $tarea->enunciado }}</b>
                @endif
                <div class="alert alert-warning" role="alert" style="font-size: 12px; padding:2px; margin:0px">
                    <span id="timer_{{ $tarea->id }}"></span>
                </div>
                <small>Disponible hasta el <span class="forFecha" dt-f="{{ $tLimite }}"></small>
                <script>
                    setInterval(function() {
                        var ddt = makeTimer("{{ $tLimite }}");
                        if (ddt == "0") {
                            $('.btEnviar_{{ $tarea->id }}').hide();
                            $("#timer_{{ $tarea->id }}").html("Plazo cumplido");
                        } else {
                            $("#timer_{{ $tarea->id }}").html("Tienes " + ddt + " para realizar la entrega.");
                        }
                    }, 1000);
                </script>
            @else
                {{ $tarea->enunciado }}
                <br>
                <small>Disponible desde el <span class="forFecha" dt-f="{{ $tDesde }}"><br>
                        hasta el <span class="forFecha" dt-f="{{ $tLimite }}"></small>
            @endif

            <div class="d-flex justify-content-between">
                @if (!$tarea->entregas)
                    @if ($tLimite < now())
                        <div></div>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-fw fa-circle-check"></i> Se acabó el
                            tiempo límite de entrega</button>
                    @else
                        <small class="text-center" style="color: #00468C">
                            {!! $tarea->kindSend($tarea->tipo_rta) !!}
                        </small>
                        @if ($tDesde < now())
                            <a href="{{ route('vertarea', $tarea->id) }}"
                                class="btn btn-sm btn-success btEnviar_{{ $tarea->id }}"><i
                                    class="fa fa-fw fa-paper-plane"></i> Entregar</a>
                        @endif
                    @endif
                @else
                    @if ($tarea->retroAlimentacion->retro)
                        <div class="alert alert-success col-12" role="alert">
                            <h5 class="alert-heading">Retroalimentación:</h5>
                            {{ $tarea->retroAlimentacion->retro }}
                        </div>
                    @else
                        <button onclick="verEntrega(this)" data-fx="{{ $tarea->entregas->id }}"
                            data-fch="{{ $tLimite }}" class="btn btn-sm btn-info"><i
                                class="fa fa-fw fa-circle-check"></i> Ver entrega realizada
                            {{ $tarea->entregas->created_at }}</button>
                    @endif
                @endif
            </div>
        </td>
    </tr>