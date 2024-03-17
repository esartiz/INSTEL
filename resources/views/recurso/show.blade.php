@extends('layouts.app')

@section('template_title')
    {{ $recurso->name ?? 'Show Recurso' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Recurso</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('recursos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Modulo:</strong>
                            {{ $recurso->modulo }}
                        </div>
                        <div class="form-group">
                            <strong>Titulo:</strong>
                            {{ $recurso->titulo }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            {{ $recurso->tipo }}
                        </div>
                        <div class="form-group">
                            <strong>File:</strong>
                            {{ $recurso->file }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
