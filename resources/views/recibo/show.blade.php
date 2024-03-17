@extends('layouts.app')

@section('template_title')
    {{ $fConcepto->name ?? 'Show F Concepto' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show F Concepto</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('f-conceptos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>User:</strong>
                            {{ $fConcepto->user }}
                        </div>
                        <div class="form-group">
                            <strong>Idrecibo:</strong>
                            {{ $fConcepto->idRecibo }}
                        </div>
                        <div class="form-group">
                            <strong>Idconcepto:</strong>
                            {{ $fConcepto->idConcepto }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $fConcepto->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $fConcepto->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Documento:</strong>
                            {{ $fConcepto->documento }}
                        </div>
                        <div class="form-group">
                            <strong>Formapago:</strong>
                            {{ $fConcepto->formaPago }}
                        </div>
                        <div class="form-group">
                            <strong>Observ:</strong>
                            {{ $fConcepto->observ }}
                        </div>
                        <div class="form-group">
                            <strong>Dto:</strong>
                            {{ $fConcepto->dto }}
                        </div>
                        <div class="form-group">
                            <strong>Valor:</strong>
                            {{ $fConcepto->valor }}
                        </div>
                        <div class="form-group">
                            <strong>Concept:</strong>
                            {{ $fConcepto->concept }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
