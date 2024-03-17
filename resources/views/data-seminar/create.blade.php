@extends('layouts.admin')

@section('template_title')
    Crear sesión de seminario
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title"><a href="/data-seminars"> < Regresar | </a>Crear sesión de seminario</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('data-seminars.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('data-seminar.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
