@php
    $nCouta = ($fConcepto->pagareID ? substr($fConcepto->pagareID,-1) : 1);
@endphp
@extends('layouts.admin')

@section('template_title')
    PROCESAR PAGO
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title" style="font-weight: bold">Procesar pago de {{ $fConcepto->persona()->first()['nombres'] }} {{ $fConcepto->persona()->first()['apellidos'] }} <a href="{{ route('ft','financiero|'.$fConcepto->idConcepto)}}" target="_blank">[ Ver Comprobante]</a></span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('updatePago', $fConcepto->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            <div class="row">
                                <div class="col-2">
                                  <label for="" class="form-label">Recibo</label>
                                  <input type="text" class="form-control" name="idRecibo" value="{{ $fConcepto->idRecibo == NULL ? $lastRecibo+1 : $fConcepto->idRecibo }}">
                                </div>

                                <div class="col-3">
                                    <label for="" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" name="fecha" value="{{$fConcepto->fecha}}">
                                </div>

                                <div class="col-4">
                                  <label for="" class="form-label">Forma de Pago</label>
                                  <input type="text" class="form-control" name="formaPago" value="{{$fConcepto->formaPago}}">
                                </div>

                                <div class="col-3">
                                    <label for="" class="form-label">Valor</label>
                                    <input type="number" class="form-control" name="valor" value="{{$fConcepto->valor}}" required>
                                </div>

                                <div class="col-4">
                                    <label for="" class="form-label">Concepto</label>
                                    <input type="text" class="form-control" name="concept" value="{{$fConcepto->concept}}">
                                </div>

                                <div class="col-5">
                                    <label for="" class="form-label">Observaciones</label>
                                    <input type="text" class="form-control" name="observ" value="{{$fConcepto->observ}}">
                                </div>

                                @if ($elPagare['contratoID'])

                                <div class="col-3">
                                     <label class="form-check-label form-label" for="isPagare">
                                        ¿Abona a Deuda?
                                    </label>
                                    <input class="form-check-input" type="checkbox" value="" id="isPagare">
                                        
                                    <div class="input-group" id="pagareBoxCont">
                                        <input type="hidden" name="pagareID" id="pagareID">
                                        <input type="text" class="form-control" id="refID" value="{{ $elPagare['contratoID'] }}" disabled>
                                        <div class="input-group-append">
                                            <select class="form-select" onchange="getPagareData()" name="" id="pagoID">                                                   
                                                @for ($i = 1; $i <= $elPagare->cuotas; $i++)
                                                <option value="-{{ $i }}" @if ($nCouta == $i) selected @endif>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                      </div>
                                </div>
                                @endif

                                
                            </div>

                            <div class="row justify-content-center">
                                <div class="d-grid gap-2 col-6" style="margin-top: 25px;">
                                    <button type="submit" name="" id="" class="btn btn-primary">PROCESAR PAGO</button>
                                  </div>
                            </div>
                            

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
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

    var idContrt = "{{ $fConcepto->pagareID }}";
    if(idContrt != ""){
        $('#isPagare').prop('checked',true)
        $('#pagareBoxCont').show();
        getPagareData();
    }

</script>

@endsection
