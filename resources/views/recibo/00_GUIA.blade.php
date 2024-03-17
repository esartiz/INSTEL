@php
        $camposFrm = ['documento', 'nombre', 'doc_ex', 'direccion', 'ciudad', 'barrio', 'telefono'];
@endphp

@extends('layouts.admin')

@section('template_title')
    Módulo Financiero
@endsection

@section('content')

<h3>Módulo Financiero</h3>

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="btn-outline-primary btn active" id="f-pagos-p-tab" data-bs-toggle="pill" data-bs-target="#f-pagos-p" type="button" role="tab" aria-controls="f-pagos-p" aria-selected="true">
        {{ $pendientes->where('status',0)->count() }} PAGOS PEND.
    </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="btn-outline-success btn" id="f-pagos-n-tab" data-bs-toggle="pill" data-bs-target="#f-pagos-n" type="button" role="tab" aria-controls="f-pagos-n" aria-selected="false">
          + NUEVO PAGO
        </button>
      </li>

    <li class="nav-item" role="presentation">
      <button class="btn-outline-primary btn" id="f-pagare-c-tab" data-bs-toggle="pill" data-bs-target="#f-pagare-c" type="button" role="tab" aria-controls="f-pagare-c" aria-selected="false">
        {{ $pagares->count() }} PAGARÉS
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="btn-outline-success btn" id="f-pagare-n-tab" data-bs-toggle="pill" data-bs-target="#f-pagare-n" type="button" role="tab" aria-controls="f-pagare-n" aria-selected="false">
        + NUEVO PAGARÉ
      </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="btn-outline-primary btn" id="f-credito-c-tab" data-bs-toggle="pill" data-bs-target="#f-credito-c" type="button" role="tab" aria-controls="f-credito-c" aria-selected="false">
          {{ $creditos->count() }} CRÉDITOS
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="btn-outline-success btn" id="f-credito-n-tab" data-bs-toggle="pill" data-bs-target="#f-credito-n" type="button" role="tab" aria-controls="f-credito-n" aria-selected="false">
          + NUEVO CRÉDITO
        </button>
      </li>
  </ul>

  <div class="tab-content" id="pills-tabContent">

    <!-- PAGOS PENDIENTES LISTADO -->
    <div class="tab-pane fade show active" id="f-pagos-p" role="tabpanel" aria-labelledby="f-pagos-p-tab">

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
                @foreach ($pendientes->where('status',0) as $item)
                    <tr>
                        <td>
                            <div class="d-grid gap-2">
                                <a href="{{ route('procesarPago', $item->id) }}" class="btn btn-success"><i
                                        class="fa-solid fa-arrows-rotate"></i></a>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('ft','financiero|' . $item->idConcepto) }}" target="_blank" class="btn btn-primary" href="#" role="button">
                                <i class="fa-solid fa-paperclip"></i>
                            </a>
                        </td>
                        <th scope="row" style="width: 13%">{{ $item->fecha }}</th>
                        <td><a href="{{ route('users.edit', $item->user) }}">
                            {{ $item->persona()->first()['nombres'] . ' ' . $item->persona()->first()['apellidos'] }}
                            </a><br>
                            {{ $item->persona()->first()['doc'] }}
                        </td>
                        <td>{{ $item->concept }}<br>{{ $item->observ }}</td>
                        <td>{{ number_format($item->valor, 0, '','.') }}</td>
                        <td>
                            <form action="{{ route('pago.del',$item->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar este pago del usuario?')"><i class="fa fa-fw fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 style="margin: 20px; color:rgb(165, 21, 21);" class="text-center">Pagos procesados</h3>

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
                @foreach ($pendientes->where('status',1) as $item)
                    <tr>
                        <td>
                            <div class="d-grid gap-2">
                                <a href="{{ route('procesarPago', $item->id) }}" class="btn btn-success"><i
                                        class="fa-solid fa-arrows-rotate"></i></a>
                            </div>
                        </td>
                        <td>
                            <a onclick="verContratoSE('{{$item->idRecibo}}','recibo')" class="btn btn-info" href="#" role="button">
                                <i class="fa-solid fa-file-invoice"></i>
                            </a>
                        </td>
                        <th scope="row" style="width: 13%">{{ $item->fecha }}<BR>{{$item->idRecibo}}</th>
                        <td>
                            <a href="{{ route('users.edit', $item->user )}}">
                                {{ $item->persona()->first()['nombres'] . ' ' . $item->persona()->first()['apellidos'] }}
                            </a>
                        </td>
                        <td>{{ $item->concept }}<br>{{ $item->observ }}</td>
                        <td>{{ $item->pagareID }}</td>
                        <td>{{ number_format($item->valor, 0, '','.') }}</td>
                        <td>
                            <form action="{{ route('pago.del',$item->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar este pago del usuario?')"><i class="fa fa-fw fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- GENERAR PAGO  -->
    <div class="tab-pane fade" id="f-pagos-n" role="tabpanel" aria-labelledby="f-pagos-n-tab">
        <form method="POST" action="{{ route('financieroAddEst') }}"  role="form" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-2">
                  <label for="" class="form-label">Recibo</label>
                  <input type="text" class="form-control" name="idRecibo" value="{{ $pendientes->sortByDesc('idRecibo')->first()->idRecibo + 1 }}" required>
                </div>

                <div class="col-3">
                    <label for="" class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha" value="" required>
                </div>

                <div class="col-4">
                  <label for="" class="form-label">Forma de Pago</label>
                  <input type="text" class="form-control" name="formaPago" value="" required>
                </div>

                <div class="col-3">
                    <label for="" class="form-label">Valor</label>
                    <input type="number" class="form-control" name="valor" value="" required>
                </div>
                
                <div class="col-4">
                  <label for="" class="form-label">Documento</label>
                  <input type="text" class="form-control" id="docNPay" aria-describedby="helpId" placeholder="" required>
                  <small id="helpIdDoc" class="form-text text-muted"></small>
                  <input type="hidden" name="userPay" id="idUserNpay" required>
                </div>

                <div class="col-4">
                    <label for="" class="form-label">Concepto</label>
                    <input type="text" class="form-control" name="concepto" value="" required>
                </div>

                <div class="col-4">
                    <label for="" class="form-label">Observaciones</label>
                    <input type="text" class="form-control" name="observ" value="" required>
                </div>

                <div class="col-3">
                    <label class="form-check-label form-label" for="isPagare">
                       ¿Abona a Pagaré?
                   </label>
                   <input class="form-check-input" type="checkbox" value="" id="isPagare">
                       
                   <div class="input-group" id="pagareBoxCont">
                       <select class="form-control" name="pagareID" id="refID"></select>
                       <div class="input-group-append">
                           <select class="form-select" name="cuota" id="pagoID">                                                   
                               @for ($i = 1; $i <= 10; $i++)
                               <option value="{{ $i }}">{{ $i }}</option>
                               @endfor
                           </select>
                       </div>
                     </div>
                </div>
                
                <div class="col-6">
                    <label for="" class="form-label">Comprobante</label>
                    <input type="file" class="form-control" name="comprobante" accept="image/*, application/pdf">
                </div>
                
            </div>

            <div class="row justify-content-center" id="cajaBtProcesar">
                <div class="d-grid gap-2 col-6" style="margin-top: 25px;">
                    <button type="submit" name="" id="" class="btn btn-primary">PROCESAR PAGO</button>
                  </div>
            </div>
        </form>
    </div>

    <!-- PAGARÉ LISTADOS -->
    <div class="tab-pane fade" id="f-pagare-c" role="tabpanel" aria-labelledby="f-pagare-c-tab">
        <table class="table table-striped pagosTable">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Estudiante</th>
                    <th scope="col">Sem</th>
                    <th scope="col">Pagos<br>/Cuotas</th>
                    <th scope="col">Cuota</th>
                    <th scope="col">Prox. Cuota</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Saldo</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pagares as $item)
                @php
                    $pagosSobrePagare = $item->pagosHechos()->get();
                    $nCuotasPagas = $pagosSobrePagare->count();
                    $cuotaValor = $item->valor / $item->cuotas;
                    $nextFechaPago = strtotime($item->fecha. ' + '.($nCuotasPagas).' months');
                    //Recuenta cuanto ha pagado hasta hoy
                    $pagoTotalaHoy = 0;
                    foreach ($pagosSobrePagare as $cashFlow) {
                        $pagoTotalaHoy += $cashFlow->valor;
                    }
                    $hoy = strtotime(date('Y-m-d'));
                    //
                    $nuevoSaldo = $item->valor - $pagoTotalaHoy;
                @endphp
                    <tr>
                        <td style="width: 10% !important">
                            <button onclick="verContratoSE('{{$item->id}}','pagare')"  type="button" class="btn btn-outline-primary">
                                {{ $item->contratoID }}
                            </button>
                        </td>
                        <td style="width: 30% !important">
                            <a href="{{ route('users.edit', $item->user) }}">
                            {{ $item->pagEstudiante()['nombres'].' '.$item->pagEstudiante()['apellidos']}}
                            </a><br>
                            {{ $item->pagEstudiante()['doc']}}
                        </td>
                        <td class="text-center" style="width: 5% !important">
                            {{ $item->semestre }}
                        </td>
                        <td class="text-center" style="width: 5% !important">
                            {{ $nCuotasPagas.'/'.$item->cuotas }}
                        </td>
                        <td style="text-align: right; width: 10%;">
                            $ {{ number_format($item->valor / $item->cuotas, 0, '','.') }}
                        </td>
                        <td style="width: 10% !important">
                            @if ($nextFechaPago < $hoy)
                            <span style="font-weight: bold; color:rgb(158, 21, 21)">
                            @else
                            <span>
                            @endif
                            {{ date('Y-m-d', $nextFechaPago) }}
                            </span>
                        </td>
                        <td>{{ number_format($item->valor, 0, '','.') }}</td>
                        <td>{{ number_format($nuevoSaldo, 0, '','.') }}</td>
                        <td>
                            <button type="button" data-fx="{{$item}}" class="btn btn-success btn-sm" onclick="editPagare(this)"><i class="fa fa-fw fa-pen"></i></button>
                            <form action="{{ route('pagare.del',$item->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea cancelar este pagaré de usuario?')"><i class="fa fa-fw fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- GENERAR PAGARÉ -->
    <div class="tab-pane fade" id="f-pagare-n" role="tabpanel" aria-labelledby="f-pagare-n-tab">
        <form action="{{ route('pagareAdd')}}" method="post">
            @csrf  
    
            <label for="" class="form-label">Documento estudiante</label>
            <input type="number" class="form-control docEst" name="docEst" id="docEst">
            <input type="hidden" name="user" class="idUser">
            <hr>
    
    
            <div class="row">
                <div class="col-md-4">
                    <h5 class="text-center">Tomador</h5>
                    @foreach ($camposFrm as $item)
                        <small id="helpId" class="form-text text-muted">{{ ucfirst($item) }}</small>
                        <input type="text" class="form-control t_{{ $item }}" name="t_{{ $item }}" id="t_{{ $item }}" required>
                    @endforeach
                </div>
    
                <div class="col-md-4">
                    <h5 class="text-center">Avalista / Co-Deudor</h5>
                    @foreach ($camposFrm as $item)
                        <small id="helpId" class="form-text text-muted">{{ ucfirst($item) }}</small>
                        <input type="text" class="form-control" name="c_{{ $item }}" id="c_{{ $item }}" required>
                    @endforeach
                </div>
    
                <div class="col-md-4">
                    <h5 class="text-center">Crédito</h5>
                    <div class="row">
                        <div class="col-6">
                            <small id="helpId" class="form-text text-muted">N. Pagaré</small>
                            <input type="text" class="form-control" name="contratoID" id="contratoID" required>
                        </div>
                        <div class="col-6">
                            <small id="helpId" class="form-text text-muted">Semestre</small>
                            <input type="number" class="form-control pagare_semestre" name="semestre" required>
                        </div>
                    </div>
    
                    <small id="helpId" class="form-text text-muted">Ciclo Académico</small>
                    <select class="form-select" name="cicloAc" id="cicloAc" onchange="generarIDPag()">
                        @for ($y = date('Y'); $y < date('Y')+2; $y++)
                            @for ($i = 1; $i < count(Session::get('config')['nombrePeriodos']); $i++)
                                <option value="{{ $y.$i }}">{{ Session::get('config')['nombrePeriodos'][$i] . ' DE ' . $y }}</option>
                            @endfor
                        @endfor
                    </select>
    
                    <small id="helpId" class="form-text text-muted">Valor $</small>
                    <input type="number" class="form-control pagare_valor" name="valor" required>
    
                    <div class="row">
                        <div class="col-6">
                            <small id="helpId" class="form-text text-muted"># Cuotas</small>
                    <input type="number" class="form-control" name="cuotas" required>
                        </div>
                        <div class="col-6">
                            <small id="helpId" class="form-text text-muted">Fecha Pagaré</small>
                    <input type="date" class="form-control" name="fecha" required>
                        </div>
                    </div>
    
                    <br>
                    <div class="d-grid gap-2">
                      <button type="submit" name="" id="" class="btn btn-primary">Crear Pagaré</button>
                    </div>
    
                    
    
                    </div>
    
                </div>
    
        </form>
    </div>

    <!-- CRÉDITOS LISTADO -->
    <div class="tab-pane fade" id="f-credito-c" role="tabpanel" aria-labelledby="f-credito-c-tab">
        <table class="table table-striped pagosTable">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Estudiante</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Saldo</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($creditos as $item)
                @php
                    $pagosSobrePagare = $item->pagEstudiante()->misPagos()->where('pagareID', 'LIKE', '%'.$item->contratoID.'%')->orderBy('pagareID','DESC')->get();
                    //Recuenta cuanto ha pagado hasta hoy
                    $pagoTotalaHoy = 0;
                    foreach ($pagosSobrePagare as $cashFlow) {
                        $pagoTotalaHoy += $cashFlow->valor;
                    }
                    $nuevoSaldo = $item->valor - $pagoTotalaHoy;
                @endphp
                    <tr>
                        <td>{{ $item->fecha }}</td>
                        <td style="width: 30% !important">
                            <a href="{{ route('users.edit', $item->user) }}">
                            {{ $item->pagEstudiante()['nombres'].' '.$item->pagEstudiante()['apellidos']}}
                            </a><br>
                            {{ $item->pagEstudiante()['doc']}}
                        </td>
                        <td>{{ number_format($item->valor, 0, '','.') }}</td>
                        <td>{{ number_format($nuevoSaldo, 0, '','.') }}</td>
                        <td>
                            <form action="{{ route('pagare.del',$item->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea cancelar este crédito al usuario?')"><i class="fa fa-fw fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- GENERAR CRÉDITO -->
    <div class="tab-pane fade" id="f-credito-n" role="tabpanel" aria-labelledby="f-credito-n-tab">
        <form action="{{ route('pagareAdd')}}" method="post">
            @csrf  
            <div class="row">
                <div class="col-4">
                    <small id="helpId" class="form-text text-muted">Documento</small>
                    <input type="number" class="form-control docEst" name="docEst">
                    <input type="hidden" name="user" class="idUser">
                    <input type="hidden" name="contratoID" value="NOTAC">
                </div>
                <div class="col-4">
                    <small id="helpId" class="form-text text-muted">Valor $</small>
                    <input type="number" class="form-control pagare_valor" name="valor" required>
                </div>
                <div class="col-4">
                    <small id="helpId" class="form-text text-muted">Fecha Crédito</small>
                    <input type="date" class="form-control" name="fecha" value="{{date('Y-m-d')}}" required>
                </div>
            </div>
            <div class="row" style="margin-top: 20px">
                <div class="d-grid gap-2">
                    <button type="submit" name="" id="" class="btn btn-primary">Crear Crédito</button>
                </div>
            </div>
    
        </form>
    </div>


  </div>

 











    <!-- Modal -->
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


    <!-- Modal de edición de Pagaré -->
    <div class="modal fade" id="editaPagare" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="editaPagareTitulo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editaPagareTitulo">Editar Pagaré</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Lalalala
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    

@endsection

@section('content')

@section('scripts')
    <script>
        var estudianteCod;
        $('.docEst').change(function() {
            const d = new Date();
            $.getJSON("/buscaest/" + $(this).val(), function(data) {
                $('.t_documento').val(data.doc)
                $('.t_nombre').val((data.nombres + ' ' + data.apellidos).toUpperCase())
                $('.t_doc_ex').val(data.doc_ex)
                $('.t_telefono').val(data.telefono)
                $('.t_direccion').val(data.direccion)
                $('.t_ciudad').val(data.ciudad)
                $('.t_barrio').val(data.barrio)
                $('.idUser').val(data.id)
                $('.pagare_semestre').val(data.ciclo)
                $('.pagare_valor').val(data.valor)
                estudianteCod = data.codUnicoEstu;
                console.log(data)
                generarIDPag();
            });
        })

        $('#docNPay').change(function() {
            $('#cajaBtProcesar').hide();
            $('#refID').empty();
            $('#helpIdDoc').text("")

            $.getJSON("/buscaest/" + $(this).val(), function(data) {
                $('#helpIdDoc').text((data.nombres + ' ' + data.apellidos).toUpperCase())
                $('#idUserNpay').val(data.id);
                data.refID.forEach(element => {
                    $('#refID').append('<option value="'+element.contratoID+'">'+element.contratoID+'</option>');
                });
                $('#cajaBtProcesar').show();
            });
        })

        $(".pagosTable").DataTable();

        function generarIDPag(){
            $("#contratoID").val(estudianteCod + '-' + $('#cicloAc').val())
        }

        //Crear nuevo Pago
        $('#isPagare').change(function(){
        if ($('#isPagare').is(':checked')) {
            $('#pagareBoxCont').show();
            getPagareData();
        } else {
            $('#pagareBoxCont').hide();
            $('#pagareID').val('');
        }
        })
        $('#pagareBoxCont').hide()

        function getPagareData(){
            $('#pagareID').val($('#refID').val()+$('#pagoID').val())
        }

        $('#cajaBtProcesar').hide();

        //Bill edit
        function editPagare(tt){
            var dt = JSON.parse($(tt).attr('data-fx'));
            console.log("dt---> " + dt.contratoID);
            $('#editaPagare').modal('show');
        }

    </script>
@endsection
