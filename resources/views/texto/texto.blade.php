@php
    $clave = '';
    if($slug){
      $titulo = $textos->where('id',$slug)->first()->nombre;
      $elID = $slug;
      $preTxt = $textos->where('id',$slug)->first()->pretexto;
      $elTxt = $textos->where('id',$slug)->first()->texto;
      $btTxt = "Editar ".$titulo;
    } else {
      $titulo = "";
      $elID = 0;
      $preTxt = "";
      $elTxt = "";
      $btTxt = "Crear nuevo";
    }
@endphp
@extends('layouts.admin')

@section('template_title')
{{ strtoupper($textos->first()->categoria) }} - INSTEL
@endsection

@section('content')
<h1>{{ strtoupper($textos->first()->categoria) }}</h1>

  <form action="{{ route('textoedicion') }}" method="post" class="row" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $elID }}">
    <input type="hidden" name="categoria" value="{{ $textos->first()->categoria }}">
    <h4>{{ $titulo }}</h4>
    <div class="col-6">
      <label for="" class="form-label">Nombre</label>
      <input type="text" class="form-control" name="nombre" value="{{ $titulo }}">
    </div>
    <div class="col-6">
      <label for="" class="form-label">Foto (Opcional)</label>
      <input class="form-control" type="file" name="fotoTxt" id="">
    </div>
    <div class="col-12">
      <label for="" class="form-label">Pretexto</label>
      <input type="text" class="form-control" name="pretexto" value="{{ $preTxt }}">
    </div>
    <div class="col-12">
    <textarea required="required" class="ckeditor" style="width: 100%" name="texto" id="texto" rows="13">
      {{ $elTxt }}
    </textarea>
    </div>
    <button type="submit" class="btn btn-primary">{{ $btTxt }}</button>
  </form>
  <hr>



<div class="row">
  <h4>Listado de {{ $textos->first()->categoria }}</h4>
  @foreach($textos as $item)
  <a href="/textos/{{ $item->categoria }}/{{ $item->id }}">{{ $item->nombre }}</a> | 
  @endforeach
</div>
  
@endsection
