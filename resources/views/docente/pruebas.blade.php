@extends('layouts.instel')
@section('template_title') Pruebas de Aptitud @endsection
@section('content')
<div class="container">
    @if ($pruebas == "")
        No tienes pruebas asignadas
    @else

    @php
        $criterios = explode('|', $prb->instruccion);
        $juradoID = ($prb->jurado1 == Auth::user()->id ? 1 : 2);
    @endphp
    <h3>{{ $prb->nombre }}</h3>
    Sírvase a ingresar los criterios de evaluación de cada estudiante:<br>
    Los criterios van desde D (Deficiente) hasta E (Excelente) pasando por A (Aceptable) B (Bueno) y MB (Muy Bueno).
    <table class="table table-stripped">
        <thead>
            <tr>
                <th scope="col" style="width: 25%">Estudiante</th>
                @foreach ($criterios as $elCriterio)
                <th scope="col" class="text-center" style="width: 15%">{{ $elCriterio }}</th>
                @endforeach
                <th scope="col" style="width: 10%">x</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pruebas as $item)
            @if (is_null($item->{'valoracion'.$juradoID}))
             <form action="{{ route('pruebas-aptitud.valorar', $item->id) }}" method="post">
                @csrf
                @method('POST')
            <tr class="">
                <td scope="row">{{ $item->getEstudiante()->apellidos }} {{ $item->getEstudiante()->nombres }}</td>
                @foreach ($criterios as $elCriterio)
                <td>
                    <div class="mb-3">
                        <input type="hidden" name="idJurado" value="{{ $juradoID }}">
                        <select class="form-select form-select-sm" name="criterio_{{ $loop->iteration }}" id="" required>
                            <option value="E">Excelente</option>
                            <option value="MB">Muy Bueno</option>
                            <option value="B">Bueno</option>
                            <option value="A">Aceptable</option>
                            <option value="D">Deficiente</option>
                        </select>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Observacion</label>
                      <textarea class="form-control" name="obs_{{ $loop->iteration }}" id="" rows="3"></textarea>
                    </div>
                </td>
                @endforeach
                <td>
                    <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('¿Desea enviar esta valoración?. Una vez enviada saldrá del listado')" >Enviar</button>
                </td>
            </tr>
            @endif
        </form>
            @endforeach
        </tbody>
    </table>
    
    @endif
</div>
@endsection