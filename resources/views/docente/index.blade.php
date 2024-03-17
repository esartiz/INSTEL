@extends('layouts.instel')
@section('template_title') Bienvenido(a) @endsection
@section('content')
<div class="container">

    @include('user.agenda')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>Se te han asignado <b>{{ $misModulos->count() }} Módulos</b></div>
                    <div><a href="https://us02web.zoom.us/j/83868265619" target="_blank" class="btn btn-primary" role="button">REUNIÓN DOCENTES</a></div>
                </div>
                <div class="card-body row">
                    @foreach ($misModulos->unique('modulo') as $item)
                        <div class="col-md-4">
                        <div class="productCardContainer">
                            <div class="productCardContent">
                            <div class="productCardImage">
                                <img src="{{ route('ft','img|modulos|'.$item->modulo()->image) }}" alt="" />
                                <a class="imageCardEffect"></a>
                            </div>
                            <div class="productCardDetails">
                                <div class="productCardModel">
                                <span class="modelCardEffect"></span>
                                <a href="{{ route('modulo.view', ['id' => $item->modulo, 'grupo' => $item->grupo]) }}">{{$item->modulo()->titulo}}</a>
                                
                                </div>
                                
                                <div class="productCardPrice">
                                    @foreach ($misModulos->where('modulo',$item->modulo) as $itemGroup)
                                        <a href="{{ route('modulo.view', ['id' => $item->modulo, 'grupo' => $itemGroup->grupo]) }}" class="btn">GRUPO <span class="forGrupo" dt-f="{{ $itemGroup->grupo }}"></span></a>
                                    @endforeach
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
    
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{route('responder')}}" method="post">
    @csrf
    <div class="modal fade" id="msjView" tabindex="-1" aria-labelledby="msjViewLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="t_msj">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 id="d_msj"></h6>
            <small>Mensaje del: <span id="f_msj"></span></small>
            <hr>
            <p id="m_msj"></p>
            <hr>
            <div class="mb-3">
                <label for="respuesta" class="form-label">Responder:</label>
                <textarea class="form-control" name="respuesta" id="respuesta" rows="10"></textarea>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Responder</button>
            </div>
        </div>
        </div>
    </div>
</form>

@endsection


@section('scripts')
<script>
   function openMsj(tt, deMsj){
    var url = "getMsj/"+tt
    $.get( url , function( data ) {
        if(data == 0){
            alert("Función no permitida")
        } else {
            $('#msjView').modal('show');
            //const gtDt = JSON.parse(data);
            $('#t_msj').text(data.asunto);
            $('#f_msj').text(data.start_date);
            $('#d_msj').text("De: " + deMsj);
            $('#m_msj').text(data.mensaje);
            //
        }
    });
   }
</script>
@endsection