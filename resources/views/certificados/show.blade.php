@extends('layouts.app')

@section('template_title')
    {{ $graduando->name ?? 'Show Graduando' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Graduando</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('certificado.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $graduando->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Documento:</strong>
                            {{ $graduando->documento }}
                        </div>
                        <div class="form-group">
                            <strong>Tipodoc:</strong>
                            {{ $graduando->tipoDoc }}
                        </div>
                        <div class="form-group">
                            <strong>Lugar Exp:</strong>
                            {{ $graduando->lugar_exp }}
                        </div>
                        <div class="form-group">
                            <strong>Tel:</strong>
                            {{ $graduando->tel }}
                        </div>
                        <div class="form-group">
                            <strong>Correo:</strong>
                            {{ $graduando->correo }}
                        </div>
                        <div class="form-group">
                            <strong>Programa:</strong>
                            {{ $graduando->programa }}
                        </div>
                        <div class="form-group">
                            <strong>Intensidad:</strong>
                            {{ $graduando->intensidad }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $graduando->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Idunico:</strong>
                            {{ $graduando->idUnico }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
