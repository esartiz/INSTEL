<div class="accordion" id="deudasBoxT">
    @foreach ($deuda->sortBy('fecha')->reverse(); as $dataDeb)
    @php
            $totalPago = $financiero
                ->where('pagareID', $dataDeb->contratoID)
                ->where('cuota', '<', 100)
                ->sum('valor');
            $totalPagoMora = $financiero
                ->where('pagareID', $dataDeb->contratoID)
                ->where('cuota', '>', 100)
                ->sum('valor');
            $moraTotal = 0;
            $estadoMatricula = ($dataDeb->matricula == NULL ? '' : $dataDeb->matriculaCredito()->estado)
    @endphp
    <div class="accordion-item">
      <h2 class="accordion-header" id="cred_{{ $dataDeb->contratoID }}">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#boxCr_{{ preg_replace('/\D/', '', $dataDeb->contratoID) }}" aria-expanded="true" aria-controls="boxCr_{{ preg_replace('/\D/', '', $dataDeb->contratoID) }}">
            @if (strpos($dataDeb->contratoID, 'NOTAC-') === false)
            PAGARÉ
            @endif
            {{ $dataDeb->contratoID }}
        </button>
      </h2>
      <div id="boxCr_{{ preg_replace('/\D/', '', $dataDeb->contratoID) }}" class="accordion-collapse collapse {{ ($estadoMatricula == "ACTIVO" ? "show" : "") }}" aria-labelledby="cred_{{ $dataDeb->contratoID }}" data-bs-parent="#deudasBoxT">
        <div class="accordion-body">
          
            @if (Auth::user()->rol === 'Administrador')
        @if ($estadoMatricula == "ACTIVO")
        <!-- Box con Matrícula activa -->
        <div class="row">
            @if (strpos($dataDeb->contratoID, 'NOTAC-') === false)
                <button onclick="verContratoSE('0-{{ $dataDeb->id }}','pagare')" type="button" class="btn btn-sm btn-info col-md-4">
                    Documento
                </button>
            @endif

            <button type="button" data-fx="{{ $dataDeb }}" data-dc=""
                data-pr="" class="btn btn-success btn-sm col-md-4 ml-3"
                onclick="editPagare(this)"><i class="fa fa-fw fa-pen"></i>Editar</button>

            <form action="{{ route('pagare.del', $dataDeb->id) }}" method="POST" class="col-md-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm col-md-12"
                    onclick="return confirm('¿Desea cancelar este financiamiento al usuario?. Se desvincularán los pagos relacionados a él.')"><i
                        class="fa fa-fw fa-trash"></i>Eliminar</button>
            </form>
        </div>
        @else
        <div class="text-center text-muted">FINANCIAMIENTO MATRÍCULA {{ $dataDeb->matricula }} INACTIVA</div>
        @endif
        @endif

        @if ($estadoMatricula !== "")
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Cuota</th>
                    <th scope="col">Fecha Límite</th>
                    <th scope="col">Fecha Pago</th>
                    <th scope="col">Recibo</th>
                    <th scope="col" style="text-align: right">Valor</th>
                    <th scope="col" style="text-align: right">Interés</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= $dataDeb->cuotas; $i++)
                    @php
                        $fechaLimite = explode('|', $dataDeb->plan)[$i-1];
                        //$fechaLimite = date('Y-m-d', strtotime($dataDeb->fecha . ' + ' . ($i - 1) . ' months'));
                        $valorCuota = $dataDeb->cuotas == null ? 0 : $dataDeb->valor / $dataDeb->cuotas;
                        $interesGenerado = 0;
                        $pagosHechos = $financiero->where('cuota', $i)->where('pagareID', $dataDeb->contratoID);
                        $pagosTotalesCuota = $pagosHechos->where('fecha', '<=', $fechaLimite)->sum('valor');
                        $saldoCuota = $valorCuota - $pagosTotalesCuota;
                        $styleMora = '';
                        //Calculo del valor de Mora
                        if ($fechaLimite < now() && $dataDeb->cuotas != null && $valorCuota > $pagosTotalesCuota) {
                            $styleMora = 'fw-bolder text-danger';
                            $interesGenerado = $saldoCuota * 0.03;
                            $moraTotal += $interesGenerado;
                        }
                    @endphp
                    <tr>
                        <td rowspan="{{ $pagosHechos->count() == 0 ? 1 : $pagosHechos->count() }}" scope="row"
                            class="text-center">{{ $i }}</td>
                        <td rowspan="{{ $pagosHechos->count() == 0 ? 1 : $pagosHechos->count() }}">{{ $fechaLimite }}
                        </td>
                        @foreach ($pagosHechos as $item)
                            @if (!$loop->first)
                    </tr>
                    <tr>
                @endif
                <td>{{ $item->fecha }}</td>
                <td><button onclick="verContratoSE('{{ $item->idRecibo }}','recibo')" class="btn btn-sm btn-secondary"
                        role="button">
                        {{ $item->idRecibo }}
                    </button></td>
                <td style="text-align: right">$ {{ number_format($item->valor, 0, '', '.') }}</td>
                @if ($loop->first)
                    <td class="{{ $financiero->where('pagareID', $dataDeb->contratoID)->where('cuota', $i + 100)->sum('valor') == 0? $styleMora: '' }}"
                        rowspan="{{ $pagosHechos->count() }}" style="text-align: right">$
                        {{ number_format($interesGenerado, 0, '', '.') }}</td>
                @endif
                @endforeach

                @if ($pagosHechos->count() == 0)
                    <td>{!! $fechaLimite < now()
                        ? '<span class="' . $styleMora . '">VENCIDA</span>'
                        : 'En ' . now()->diffInDays($fechaLimite) . ' días' !!}</td>
                    <td></td>
                    <td style="text-align: right">$ {{ number_format($valorCuota, 0, '', '.') }}</td>
                    <td class="{{ $styleMora }}" rowspan="{{ $pagosHechos->count() == 0 ? 1 : $pagosHechos->count() }}"
                        style="text-align: right">$ {{ number_format($interesGenerado, 0, '', '.') }}</td>
                @endif
                </tr>
                @endfor
                </tbody>
            </table>


            <!-- Data of Debt -->
            <div class="container px-2">
                <div class="row gx-2 row-cols-2">
                    <div class="col p-2 border bg-light d-flex justify-content-between">
                        <span>Fecha: </span> <span class="fw-bold">{{ $dataDeb->fecha }}</span>
                    </div>
                    <div class="col p-2 border bg-light d-flex justify-content-between">
                        <span>Cuotas: </span> <span class="fw-bold">{{ $dataDeb->cuotas == null ? 'N/A' : $dataDeb->cuotas }} de
                            {{ $dataDeb->cuotas == null ? 'N/A' : '$ ' . number_format($valorCuota, 0, '', '.') }}</span>
                    </div>
                    <div class="col p-2 border bg-light d-flex justify-content-between">
                        <span>Valor inicial: </span> <span class="fw-bold">$
                            {{ number_format($dataDeb->valor, 0, '', '.') }}</span>
                    </div>
                    <div class="col p-2 border bg-light d-flex justify-content-between">
                        <span>Total Mora: </span> <span class="fw-bold">$
                            {{ number_format($moraTotal, 0, '', '.') }}</span>
                    </div>
                    <div class="col p-2 border bg-light d-flex justify-content-between">
                        <span>Pagos a capital: </span> <span class="fw-bold">$
                            {{ number_format($totalPago, 0, '', '.') }}</span>
                    </div>
                    <div class="col p-2 border bg-light d-flex justify-content-between">
                        <span>Pagos mora: </span> <span class="fw-bold">$
                            {{ number_format($totalPagoMora, 0, '', '.') }}</span>
                    </div>

                    <div class="col p-2 border bg-light d-flex justify-content-between">
                        <span>Saldo capital: </span> <span class="fw-bold">$
                            {{ number_format($dataDeb->valor - $totalPago, 0, '', '.') }}</span>
                    </div>
                    <div class="col p-2 border bg-light d-flex justify-content-between">
                        <span>Saldo mora: </span> <span class="fw-bold">$
                            {{ number_format($moraTotal - $totalPagoMora, 0, '', '.') }}</span>
                    </div>

                    @php
                        $saldoFinal = $moraTotal + $dataDeb->valor - ($totalPago + $totalPagoMora);
                    @endphp

                    <div class="col p-2 border bg-light d-flex justify-content-between">
                    </div>
                    <div class="col p-2 border bg-light d-flex justify-content-between">
                        <span>SALDO: </span> <span class="fw-bold">$
                            {{ number_format($saldoFinal, 0, '', '.') }}</span>
                    </div>
                </div>
            </div>

        @else

        <!-- Data PAGARES DE Q10  -->
        <div class="container px-2">
            <div class="row gx-2 row-cols-2">
                <div class="col p-2 border bg-light d-flex justify-content-between">
                    <span>Fecha: </span> <span class="fw-bold">{{ $dataDeb->fecha }}</span>
                </div>
                <div class="col p-2 border bg-light d-flex justify-content-between">
                    <span>Cuotas: </span> <span class="fw-bold">{{ $dataDeb->cuotas }}</span>
                </div>
                <div class="col p-2 border bg-light d-flex justify-content-between">
                    <span>Valor inicial: </span> <span class="fw-bold">$
                        {{ number_format($dataDeb->valor, 0, '', '.') }}</span>
                </div>
                <div class="col p-2 border bg-light d-flex justify-content-between">
                    <span>Pagos relacionados: </span> <span class="fw-bold">$
                        {{ number_format($dataDeb->pagosHechos()->where('pagareID', $dataDeb->contratoID)->sum('valor'), 0, '', '.') }}</span>
                </div>
                <div class="col p-2 border bg-light d-flex justify-content-between">
                    <span>Ciclo Académico: </span> <span class="fw-bold">
                        {{ $dataDeb->cicloAc }}</span>
                </div>
            </div>
        </div>

        @endif
            

        </div>
      </div>
    </div>
    @endforeach
</div>