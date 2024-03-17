@extends('layouts.admin')

@section('template_title')
    Bienvenido al módulo administrador
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Últimos accesos a la plataforma en las últimas 72 horas
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            @php $ingreso = []; @endphp
                            @foreach ($dataLog as $item)
                                @php
                                if(!isset($ingreso["d_" . $item->userLog->cod])){
                                    $ingreso["d_" . $item->userLog->cod]['nombre'] = $item->userLog->nombres.' '.$item->userLog->apellidos;
                                    $ingreso["d_" . $item->userLog->cod]['visitas'] = 1;
                                    $ingreso["d_" . $item->userLog->cod]['codigo'] = $item->userLog->cod;
                                    $date1 = new DateTime($item->fecha);
                                    $date2 = new DateTime("now");
                                    $ingreso["d_" . $item->userLog->cod]['fecha'] = $item->fecha;
                                    $ingreso["d_" . $item->userLog->cod]['diff'] = $date1->diff($date2);
                                } else {
                                    $ingreso["d_" . $item->userLog->cod]['visitas']++;
                                }
                            @endphp
                            @endforeach

                            @foreach ($ingreso as $item)
                            <div class="col-md-3 text-center">
                                <img id="output" src="{{ route('ft', 'profiles|0|t|'.$item['codigo']) }}.jpg" style="max-height: 100px" class="img-fluid" onerror="this.src='{{ route('ft', 'profiles|0|no-pic.jpg') }}';" /><br>
                                {{ $item['nombre'] }}<br>
                                <small><b>Ha ingresado {{ $item['visitas'] }} veces.</b><br>
                                Ultimo ingreso {{ $item['fecha'] }}<br>
                                Hace {{ $item['diff']->h.'horas, '.$item['diff']->m.' minutos y '.$item['diff']->s.' segundos' }}</small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
