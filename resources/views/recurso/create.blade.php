@extends('layouts.app')

@section('template_title')
    Create Recurso
@endsection

@section('content')
    <section class="content container">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title"><h3>Crear nuevo recurso para el módulo</h3></span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('recursos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('recurso.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
