@extends('layouts.app')

@section('template_title')
    {{ $tarea->name ?? 'Show Tarea' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Tarea</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('tareas.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Modulo:</strong>
                            {{ $tarea->modulo }}
                        </div>
                        <div class="form-group">
                            <strong>Enunciado:</strong>
                            {{ $tarea->enunciado }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo Rta:</strong>
                            {{ $tarea->tipo_rta }}
                        </div>
                        <div class="form-group">
                            <strong>Limite:</strong>
                            {{ $tarea->limite }}
                        </div>
                        <div class="form-group">
                            <strong>Ord:</strong>
                            {{ $tarea->ord }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
