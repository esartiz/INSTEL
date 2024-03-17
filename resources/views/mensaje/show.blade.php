@extends('layouts.app')

@section('template_title')
    {{ $mensaje->name ?? 'Show Mensaje' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Mensaje</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('mensajes.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Start Date:</strong>
                            {{ $mensaje->start_date }}
                        </div>
                        <div class="form-group">
                            <strong>End Date:</strong>
                            {{ $mensaje->end_date }}
                        </div>
                        <div class="form-group">
                            <strong>De:</strong>
                            {{ $mensaje->de }}
                        </div>
                        <div class="form-group">
                            <strong>Para:</strong>
                            {{ $mensaje->para }}
                        </div>
                        <div class="form-group">
                            <strong>Asunto:</strong>
                            {{ $mensaje->asunto }}
                        </div>
                        <div class="form-group">
                            <strong>Mensaje:</strong>
                            {{ $mensaje->mensaje }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
