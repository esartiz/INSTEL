@extends('layouts.instel')
@section('template_title') {{ $mensaje['txt'] }} @endsection
@section('content')
<div class="container">
    <div class="d-flex bd-highlight mb-3">
        <div class="p-2 bd-highlight">
              <h3><i class="fa-solid fa-circle-xmark fa-fade"></i> {{ $mensaje['txt'] }} <span class="forFecha" dt-f="{{ $mensaje['fecha'] }}"></span> </h3>
            <small class="text-muted">No es posible visibilizar la información requerida. Contáctese con la Coordinación Académica</small>
        </div>
        <div class="ms-auto p-2 bd-highlight">
            <a href="/" class="btn btn-outline-info"><i class="fa-solid fa-circle-chevron-left"></i> Regresar</a>
        </div>
    </div>
</div>
@endsection
