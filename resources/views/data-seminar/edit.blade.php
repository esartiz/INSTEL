@extends('layouts.admin')

@section('template_title')
    Update Data Seminar
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title"> <a href="/data-seminars"> < Regresar | </a>Modificar Sesión de Seminario</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('data-seminars.update', $dataSeminar->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('data-seminar.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
