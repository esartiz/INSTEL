@extends('layouts.admin')

@section('template_title')
    Entrega
@endsection

@section('content')

<h4>Se han cargado {{ $entregas->count() }} entregas </h4>

<table class="table table-striped table-hover" id="entregasTable">
    <thead class="thead">
        <tr>
            <th>Fecha</th>
            <th>De</th>
            <th>Modulo</th>
            <th>Actividad</th>
            <th>Tipo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entregas as $entrega)
        @php
            $datoEntrega = ($entrega->tarea()->first()->tipo_rta == "link|" ? $entrega->link : ($entrega->tarea()->first()->tipo_rta == "texto|" ? $entrega->respuesta : ($entrega->tarea()->first()->tipo_rta == "pdf|" ? route('ft','entregas|pdf|'.$entrega->idUnico.'.pdf') : route('ft','entregas|audio|'.$entrega->idUnico.'.mp3'))));
            $datoPos = ($entrega->tarea()->first()->tipo_rta == "link|" ? 0 : ($entrega->tarea()->first()->tipo_rta == "texto|" ? 1 : ($entrega->tarea()->first()->tipo_rta == "pdf|" ? 0 : 2)));
        @endphp
            <tr>
                <td>{{ $entrega->created_at }}</td>
                <td>{{ $entrega->user->apellidos.' '.$entrega->user->nombres }}</td>
                <td>{{ $entrega->modulo()->first()->titulo }}</td>
                <td>{{ $entrega->tarea()->first()->enunciado }}</td>
                <td>
                    <a onclick="openModal(this)" data-e="{{ $entrega->id }}" class="btn btn-primary" role="button">{{ $entrega->tarea()->first()->tipo_rta }}</a>
                </td>
                <td>
                    <form action="{{ route('entr.destroy',$entrega->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar y volver a activar esta entrega?')"><i class="fa fa-fw fa-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    <div class="modal fade" id="viewTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Entrega:</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    
@endsection


@section('scripts')
<script>
function openModal(dt){
    $('.modal-body').load("/entregashow/" + $(dt).attr('data-e'));
    $('#viewTask').modal('show');
}


$(document).ready(function() {
    $("#entregasTable").DataTable();
    $('.btwToolt').tooltip();
});
</script>
@endsection