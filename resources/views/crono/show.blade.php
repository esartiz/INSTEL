@extends('layouts.app')

@section('template_title')
    {{ $crono->name ?? 'Show Crono' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Crono</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('cronos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Ini:</strong>
                            {{ $crono->ini }}
                        </div>
                        <div class="form-group">
                            <strong>Fin:</strong>
                            {{ $crono->fin }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $crono->nombre }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
