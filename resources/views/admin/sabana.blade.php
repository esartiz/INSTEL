
@extends('layouts.admin')

@section('template_title')
    Sábana General de Notas
@endsection

@section('content')

@foreach ($programas as $elPrograma)
    <h2>{{ $elPrograma->nombre }}</h2>
    <hr>

    @for ($i = 1; $i < count(explode('|',$elPrograma->estructura)); $i++)
        <h5>{{ explode('|',$elPrograma->estructura)[$i] }}</h5>

        <table class="table table-bordered border-secondary" style="min-width: 2500px">
            <thead>
                <tr>
                    <th scope="col" style="width: 20%">Estudiante</th>
                    @foreach ($elPrograma->moduloPrograma->where('ciclo',$i) as $item)
                    <th scope="col" style="font-size: 10px; width: {{ 80 / $elPrograma->moduloPrograma->where('ciclo',$i)->count()}}%">{{ $item->titulo }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($estudiantes->where('ciclo',$i)->where('prg',$elPrograma->id) as $elEst)
                <tr class="">
                    <td scope="row">{{ $elEst->apellidos.' '.$elEst->nombres}}</td>
                    @foreach ($elPrograma->moduloPrograma->where('ciclo',$i) as $item2)
                    <td>
                        <table class="table table-bordered border-primary" style="width: 100%">
                            <tr>
                                <td><div style="text-align: center" id="m{{$item2->id}}_e{{$elEst->id}}_1">0.0</div></td>
                                <td><div style="text-align: center" id="m{{$item2->id}}_e{{$elEst->id}}_2">0.0</div></td>
                                <td><div style="text-align: center" id="m{{$item2->id}}_e{{$elEst->id}}_3">0.0</div></td>
                                <td><div style="text-align: center" id="m{{$item2->id}}_e{{$elEst->id}}_4">0.0</div></td>
                            </tr>
                        </table>
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>



            
    @endfor
    

@endforeach

@endsection

@section('scripts')
<script>
@foreach ($matricula as $item)
@php
    $def = number_format(($item->n1 * 0.3) + ($item->n2 * 0.3) + ($item->n3 * 0.4), 1, '.', '');
@endphp
$('#m{{$item->materia}}_e{{$item->estudiante}}_1').text('{{$item->n1}}');
$('#m{{$item->materia}}_e{{$item->estudiante}}_2').text('{{$item->n2}}');
$('#m{{$item->materia}}_e{{$item->estudiante}}_3').text('{{$item->n3}}');
$('#m{{$item->materia}}_e{{$item->estudiante}}_4').text('{{$def}}');
//
$('#m{{$item->materia}}_e{{$item->estudiante}}_1').addClass(colorPromNt('{{$item->n1}}'));
$('#m{{$item->materia}}_e{{$item->estudiante}}_2').addClass(colorPromNt('{{$item->n2}}'));
$('#m{{$item->materia}}_e{{$item->estudiante}}_3').addClass(colorPromNt('{{$item->n3}}'));
$('#m{{$item->materia}}_e{{$item->estudiante}}_4').addClass(colorPromNt('{{$def}}'));

@endforeach 
</script>
@endsection
