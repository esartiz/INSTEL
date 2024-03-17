@extends('layouts.admin')

@section('template_title')
    Modulos
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                               <h3>Módulos registrados en la plataforma</h3>
                            </span>

                             <div class="float-right">
                                <a href="{{ route('modulos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  CREAR NUEVO MÓDULO
                                </a>
                              </div>
                        </div>
                    </div>

                    <div class="card-body">
                            <table class="table table-striped table-hover" id="tablaModulos">
                                <thead class="thead">
                                    <tr>
                                        <th>Inicio</th>
                                        <th></th>
										<th>Titulo</th>
										<th>Programa</th>
										<th>Docente</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modulos as $modulo)
                                    @php
                                    $modInicios = explode('|', $modulo->fechas);
                                    $modSemanas = explode('|', $modulo->semanas);
                                    $gruposN = array('', 'A','B','C','D','AS','BS','CS','DS');
                                    $txtStats = "";
                                    $cssExtra = "";
                                    for($a=1; $a<count($gruposN); $a++){
                                        $tiempos = AppHelper::timeModule($modulo, $a);
                                        if (now() >= $tiempos[0][0] && now() <= $tiempos[$modSemanas[$a]][1]){
                                            $txtStats = "<b>ACTIVO<br>Grupo".$gruposN[$a]."</b><br>";
                                            $cssExtra = ' style=background-color:gold';
                                        }
                                    }
                                    @endphp
                                        <tr {{$cssExtra}}>    
                                            <td>
                                                {!! $txtStats !!}
                                                @for($a=1; $a<count($gruposN); $a++)
                                                {{ $gruposN[$a] }}:{{ date('m/d', strtotime( $modInicios[$a])) }}<br>
                                                @endfor
                                            </td>     
											<td>
                                                <a href="{{ route('modulos.edit',$modulo->id) }}">
                                                    <img src="{{ route('ft','img|modulos|'.$modulo->image )}}" alt="" width="100" >
                                                </a>
                                            </td>
											<td>
                                                <a href="{{ route('modulos.edit',$modulo->id) }}">
                                                    {{ $modulo->titulo }}
                                                </a>
                                            </td>
											<td>
                                                <b>{{ explode('|', $modulo->programas->estructura)[$modulo->ciclo] }}</b><br>
                                                {{ $modulo->programas->tipo.' '.$modulo->programas->nombre }}
                                            </td>
                                            <td>
                                            @if ($modulo->docente != NULL)
											{{ $modulo->user->nombres.' '.$modulo->user->apellidos }}
                                            @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('modulos.destroy',$modulo->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar este módulo del sistema?')"><i class="fa fa-fw fa-trash"></i>ELIMINAR</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $("#tablaModulos").DataTable();
    });
</script>
@endsection