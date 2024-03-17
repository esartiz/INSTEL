@extends('layouts.app')

@section('template_title')
    {{ $modulo->name ?? 'Show Modulo' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Modulo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('modulos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Programa:</strong>
                            {{ $modulo->programa }}
                        </div>
                        <div class="form-group">
                            <strong>Ciclo:</strong>
                            {{ $modulo->ciclo }}
                        </div>
                        <div class="form-group">
                            <strong>Docente:</strong>
                            {{ $modulo->docente }}
                        </div>
                        <div class="form-group">
                            <strong>Titulo:</strong>
                            {{ $modulo->titulo }}
                        </div>
                        <div class="form-group">
                            <strong>Image:</strong>
                            {{ $modulo->image }}
                        </div>
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {{ $modulo->descripcion }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
