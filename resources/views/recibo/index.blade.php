@php
    $camposFrm = ['documento', 'nombre', 'doc_ex', 'direccion', 'ciudad', 'barrio', 'telefono'];
@endphp

@extends('layouts.admin')

@section('template_title')
    Módulo Financiero
@endsection

@section('content')
    <div class="d-flex justify-content-between" style="background-color: #F23838; color:#FFF">
        <div class="p-2" style="font-weight: 900; font-size: 24px">Módulo de Pagos</div>
        <div class="p-2"><button style="background-color: #00468C" class="btn btn-primary" onclick="pago(0,0)"
                data-fx="">Generar Nuevo Pago</button></div>
    </div>


    <h3 style="margin: 20px; color:rgb(165, 21, 21);" class="text-center">Pagos pendientes por procesar</h3>

    <table class="table table-striped pagosTable">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">Fecha</th>
                <th scope="col">Estudiante</th>
                <th scope="col">Concepto</th>
                <th scope="col">Valor</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendientes->where('status', 0) as $item)
                <tr>
                    <td>
                        <div class="d-grid gap-2">
                            <button onclick="pago({{ $item->user }},0)"
                                data-pr="{{ $item->persona()->nombres . ' ' . $item->persona()->apellidos }}"
                                data-dc="{{ $item->persona()->doc }}" data-fx="{{ $item }}"
                                class="btn btn-success"><i class="fa-solid fa-arrows-rotate"></i></button>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('ft', 'financiero|' . $item->idConcepto) }}" target="_blank"
                            class="btn btn-primary" href="#" role="button">
                            <i class="fa-solid fa-paperclip"></i>
                        </a>
                    </td>
                    <th scope="row" style="width: 13%">{{ $item->fecha }}</th>
                    <td><a href="{{ route('users.edit', $item->user) }}">
                            {{ $item->persona()->nombres . ' ' . $item->persona()->apellidos }}
                        </a><br>
                        {{ $item->persona()->doc}}
                    </td>
                    <td>{{ $item->concept }}<br>{{ $item->observ }}</td>
                    <td>{{ number_format($item->valor, 0, '', '.') }}</td>
                    <td>
                        <form action="{{ route('pago.del', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Desea eliminar este pago del usuario?')"><i
                                    class="fa fa-fw fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="margin: 20px; color:rgb(165, 21, 21);" class="text-center">Pagos procesados los últimos 30 días</h3>

    <table class="table table-striped pagosTable">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">Fecha</th>
                <th scope="col">Estudiante</th>
                <th scope="col">Concepto</th>
                <th scope="col">Pagare</th>
                <th scope="col">Valor</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendientes->where('status', 1) as $item)
                <tr>
                    <td>
                        <div class="d-grid gap-2">
                            <button onclick="pago({{ $item->user }},{{ $item->idRecibo }})"
                                data-pr="{{ $item->persona()->nombres . ' ' . $item->persona()->first()->apellidos }}"
                                data-dc="{{ $item->persona()->first()->doc }}" data-fx="{{ $item }}"
                                class="btn btn-success"><i class="fa-solid fa-arrows-rotate"></i></button>
                        </div>
                    </td>
                    <td>
                        <button onclick="verContratoSE('{{ $item->idRecibo }}','recibo')" class="btn btn-info"
                            href="#" role="button">
                            <i class="fa-solid fa-file-invoice"></i>
                        </button>
                    </td>
                    <th scope="row" style="width: 13%">{{ $item->fecha }}<BR>{{ $item->idRecibo }}</th>
                    <td>
                        <a href="{{ route('users.edit', $item->user) }}">
                            {{ $item->persona()->nombres . ' ' . $item->persona()->apellidos }}
                        </a>
                    </td>
                    <td>{{ $item->concept }}<br>{{ $item->observ }}</td>
                    <td>{{ $item->pagareID }}</td>
                    <td>{{ number_format($item->valor, 0, '', '.') }}</td>
                    <td>
                        <form action="{{ route('pago.del', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Desea eliminar este pago del usuario?')"><i
                                    class="fa fa-fw fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>


    <!-- Modal Recibos -->
    <div class="modal fade" id="verPagareM" tabindex="-1" aria-labelledby="verPagareMLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="printRec" name="printf" src="" width="100%" height="600"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" id="imprimirContrato">Imprimir</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="boxPagoEdit" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body boxPagoEdit">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function pago(tt, ff) {
            $('#boxPagoEdit').modal('show');
            $('.boxPagoEdit').load('/pagos-detalle/' + tt + '-' + ff)
        }
        $(".pagosTable").DataTable();
        var pagare;
    </script>
@endsection
