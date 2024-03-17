@extends('layouts.app')

@section('template_title')
    {{ $dataSeminar->name ?? 'Show Data Seminar' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Data Seminar</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('data-seminars.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Prg:</strong>
                            {{ $dataSeminar->prg }}
                        </div>
                        <div class="form-group">
                            <strong>Sesionid:</strong>
                            {{ $dataSeminar->sesionID }}
                        </div>
                        <div class="form-group">
                            <strong>Docente:</strong>
                            {{ $dataSeminar->docente }}
                        </div>
                        <div class="form-group">
                            <strong>Repositorio:</strong>
                            {{ $dataSeminar->repositorio }}
                        </div>
                        <div class="form-group">
                            <strong>Recurso:</strong>
                            {{ $dataSeminar->recurso }}
                        </div>
                        <div class="form-group">
                            <strong>Tareatipo:</strong>
                            {{ $dataSeminar->tareaTipo }}
                        </div>
                        <div class="form-group">
                            <strong>Tarea:</strong>
                            {{ $dataSeminar->tarea }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
