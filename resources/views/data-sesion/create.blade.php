@extends('layouts.app')

@section('template_title')
    Create Data Sesion
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Data Sesion</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('data-sesions.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('data-sesion.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
