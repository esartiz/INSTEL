@extends('layouts.admin')

@section('template_title')
    Crear Módulo
@endsection

@section('content')
    <section class="content container">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Crear Módulo</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('modulos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('modulo.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
