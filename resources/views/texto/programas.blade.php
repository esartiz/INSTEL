@php
    $clave = '';
@endphp
@extends('layouts.admin')

@section('template_title')
    Oferta Académica INSTEL
@endsection

@section('content')




<form action="{{route('textoedicion')}}" method="POST" class="modal fade" id="cajaEdicion" tabindex="-1" role="dialog" aria-hidden="true">
  @csrf
  <input type="hidden" id="idCategoria" name="categoria">
  <input type="hidden" name="id" id="idTexto">
  <div class="modal-dialog" role="document" style="min-width: 1000px">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <a href="" onclick="return confirm('¿Desea eliminar este texto?')" class="btDelete btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</a>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="" class="form-label">Título sección</label>
          <input type="text"
            class="form-control" name="nombre" id="nombre">
        </div>
        <div class="mb-3">
          <label for="" class="form-label">Texto introductorio sección</label>
          <input type="text"
            class="form-control" name="pretexto" id="pretexto">
        </div>
        <div class="mb-3">
          <label for="" class="form-label">Texto</label>
          <textarea class="ckeditor" name="texto" id="texto" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
        <button type="submit" class="btn btn-primary">GUARDAR</button>
      </div>
    </div>
  </div>
</form>




<form action="{{ route('savePrograma')}}" method="POST" class="modal fade" id="cajaPrograma" tabindex="-1" role="dialog" aria-hidden="true">
  @csrf
  <input type="hidden" name="id" id="idPrograma">
  <div class="modal-dialog" role="document" style="min-width: 1000px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-8">
            <div class="row">
              <div class="mb-3 col-12">
                <label for="" class="form-label">Nombre programa</label>
                <input type="text"
                  class="form-control" name="nombre" id="pNombre">
              </div>

              <div class="mb-3">
                  <label for="" class="form-label">Texto introductorio</label>
                <textarea class="form-control" name="pretexto" id="pPretexto" rows="5"></textarea>
              </div>

              <div class="mb-3 col-4">
                  <label for="" class="form-label">Modalidad</label>
                  <input type="text"
                    class="form-control" name="modalidad" id="pModalidad">
              </div>

              <div class="mb-3 col-4">
                  <label for="" class="form-label">Inscripcion</label>
                  <input type="number"
                    class="form-control" name="inscripcion" id="pInscripcion">
              </div>

              <div class="mb-3 col-4">
                  <label for="" class="form-label">Valor Total</label>
                  <input type="number"
                    class="form-control" name="v_total" id="pValor">
              </div>

              <div class="mb-3 col-3">
                  <label for="" class="form-label"># Pagos</label>
                  <input type="number"
                    class="form-control" name="n_pagos" id="pPagos">
              </div>

              <div class="mb-3 col-3">
                  <label for="" class="form-label">Orden</label>
                  <input type="text"
                    class="form-control" name="distr_pagos" id="pOrden">
              </div>

              <div class="mb-3 col-6">
                  <label for="" class="form-label">Certificado</label>
                  <input type="text"
                    class="form-control" name="certificado" id="pCertificado">
              </div>

              <div class="mb-3 col-8">
                  <label for="" class="form-label">Duración</label>
                  <input type="text"
                    class="form-control" name="duracion" id="pDuracion">
              </div>

              <div class="mb-3 col-4">
                  <label for="" class="form-label">Fecha de Inicio</label>
                  <input type="date"
                    class="form-control" name="fechaIni" id="pInicio">
              </div>
          </div>
          </div>
          <div class="col-4">
            Estructura temporal del programa<br>
            <div class="listaSem"></div>
            <a onclick="addTemp()">+ Agregar</a>
            <input type="hidden" name="estructura" id="laEstructura">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
        <button type="submit" class="btn btn-primary">GUARDAR</button>
      </div>
    </div>
  </div>
</form>


    <div class="row">
        @foreach ($oferta as $item)
            @if ($item->tipo != $clave)
    </div>
    <hr>
    <div class="row">
        <h2>{{ $item->tipo }}</h2>
        @endif

        @php
            $clave = $item->tipo;
        @endphp
        <div class="col-md-4" style="text-decoration: none; color:#000">
            <img class="card-img-top" src="https://www.instel.edu.co/uploads/{{ $item->imageProfile }}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{ $item->nombre }}</h5>
                <p class="card-text">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-primary editarPrograma" data="{{ $item }}" d-seccion="{{ $item->nombre }}">INFORMACIÓN GENERAL</li>
                        @foreach ($textos->where('categoria',$item->url) as $tt)
                        <li class="list-group-item editarData" data="{{ $tt }}" d-seccion="{{ $item->nombre}}">{{ $tt->nombre }}</li>
                        @endforeach
                        <li class="list-group-item list-group-item-danger nuevoTextoPr" data-n="{{ $item->nombre }}" data="{{ $item->url }}">+ Agregar Sección {{ $item->categoria }}</li>
                      </ul>
                </p>
            </div>
        </div>
        @endforeach

    </div>

@endsection

@section('scripts')
<script>
  var ttSem = 0;
    $('.editarData').click(function() {
        var ft = JSON.parse($(this).attr('data'));
        $('#nombre').val(ft.nombre)
        $('.modal-title').text($(this).attr('d-seccion'))
        $('#pretexto').val(ft.pretexto)
        $('#idTexto').val(ft.id)
        $('#idCategoria').val(ft.categoria)
        CKEDITOR.instances['texto'].setData(ft.texto)
        $('#cajaEdicion').modal('show')
        $('.btDelete').show();
        $('.btDelete').attr('href','/texto-del/' + ft.id);
    })

    $('.nuevoTextoPr').click(function() {
      $('.btDelete').hide();
        $('#nombre').val("")
        $('.modal-title').text("Agregar nuevo texto en " + $(this).attr('data-n'))
        $('#pretexto').val("")
        $('#idTexto').val(0)
        $('#idCategoria').val($(this).attr('data'));
        CKEDITOR.instances['texto'].setData("")
        $('#cajaEdicion').modal('show')
    });

    $('.editarPrograma').click(function() {
        var ft = JSON.parse($(this).attr('data'));
        $('#idPrograma').val(ft.id)
        $('#pNombre').val(ft.nombre)
        $('#pPretexto').val(ft.pretexto)
        $('#pTipo').val(ft.tipo)
        $('#pModalidad').val(ft.modalidad)
        $('#pInscripcion').val(ft.inscripcion)
        $('#pValor').val(ft.v_total)
        $('#pPagos').val(ft.n_pagos)
        $('#pOrden').val(ft.distr_pagos)
        $('#pCertificado').val(ft.certificado)
        $('#pDuracion').val(ft.duracion)
        $('#pInicio').val(ft.fechaIni)

        var estr = (ft.estructura == null ? '|' : ft.estructura)
        $('#laEstructura').val(ft.estructura)

        //Estructura
        var ctSem = estr.split("|");
        ttSem = 0;
        $('.listaSem').empty();
        ctSem.forEach(element => {
          if(element != ""){
            ttSem++;
            $('.listaSem').append('<input type="text" onchange="generateEstr()" class="form-control estrSem" id="sem_'+ttSem+'" value="'+element+'">');
          }
        });

        $('.modal-title').text($(this).attr('d-seccion'))
        $('#cajaPrograma').modal('show');
    })

    function addTemp(){
      ttSem++;
      $('.listaSem').append('<input type="text" onchange="generateEstr()" class="form-control estrSem" id="sem_'+ttSem+'" value="">');
    }

    function generateEstr(){
      var ftFinal = "";
      for (let i = 1; i <= ttSem; i++) {
        if($('#sem_' + i).val() != ""){
          ftFinal += '|' + $('#sem_' + i).val();
        }
      }
      $('#laEstructura').val(ftFinal)
    }
</script>
@endsection