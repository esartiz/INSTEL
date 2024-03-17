@extends('layouts.admin')

@section('template_title')
    Editar Certificado
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Editar Certificado de {{ $graduando->nombre }}</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('certificado.update', $graduando->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('certificados.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
