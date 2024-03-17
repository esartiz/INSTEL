@extends('layouts.app')

@section('template_title')
    {{ $dataSesion->name ?? 'Show Data Sesion' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Data Sesion</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('data-sesions.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Seminarid:</strong>
                            {{ $dataSesion->seminarID }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $dataSesion->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Envio:</strong>
                            {{ $dataSesion->envio }}
                        </div>
                        <div class="form-group">
                            <strong>Retro:</strong>
                            {{ $dataSesion->retro }}
                        </div>
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $dataSesion->status }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
