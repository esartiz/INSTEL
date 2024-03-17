@extends('layouts.app')

@section('template_title')
    {{ $user->name ?? 'Show User' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show User</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Doc:</strong>
                            {{ $user->doc }}
                        </div>
                        <div class="form-group">
                            <strong>Doc Ex:</strong>
                            {{ $user->doc_ex }}
                        </div>
                        <div class="form-group">
                            <strong>Nombres:</strong>
                            {{ $user->nombres }}
                        </div>
                        <div class="form-group">
                            <strong>Apellidos:</strong>
                            {{ $user->apellidos }}
                        </div>
                        <div class="form-group">
                            <strong>Telefono:</strong>
                            {{ $user->telefono }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Nac:</strong>
                            {{ $user->fecha_nac }}
                        </div>
                        <div class="form-group">
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </div>
                        <div class="form-group">
                            <strong>Rol:</strong>
                            {{ $user->rol }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
