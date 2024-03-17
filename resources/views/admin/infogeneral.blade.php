
@extends('layouts.admin')

@section('template_title')
    Información general de los semestres
@endsection

@section('content')


    <form class="row" method="POST" action="{{ route('infogeneral.store') }}"  role="form" enctype="multipart/form-data">
        @csrf

    <h4>Seleccione alguna de estas dos opciones:</h4>

    <div class="col-12">
      <label for="" class="form-label">Nombre</label>
      <input type="text"
        class="form-control" name="nombre" id="" aria-describedby="helpId" placeholder="">
      <small id="helpId" class="form-text text-muted">Nombre del Recurso</small>
    </div>
    <div class="col-6">
      <label for="" class="form-label">Cargar documento PDF</label>
      <input type="file" class="form-control" name="documento" accept="application/pdf" id="" placeholder="" aria-describedby="fileHelpId">
      <div id="fileHelpId" class="form-text">Cargar información en PDF</div>
    </div>

    <div class="col-6">
      <label for="" class="form-label">Poner video reunión</label>
      <input type="text"
        class="form-control" onchange="formatURLDrive()" name="link" id="g_ruta" aria-describedby="helpId" placeholder="">
      <small id="helpId" class="form-text text-muted">Agregue el link que arroja Google Drive</small>
    </div>
    
    <div class="col-9">
        <div class="mb-3">
            <label for="" class="form-label">Por Programa / Semestre</label>
            <select class="form-select optList" name="programa">
                <option value="0">Seleccione</option>
                @foreach ($losProgramas as $item)
                @foreach (explode("|",$item->estructura) as $item2)
                @if ($loop->first) @else
                <option value="{{ $item->id }}|{{ $loop->iteration-1 }}">{{ ($item->tipo == "Técnico Laboral" ? "TL" : $item->tipo).' '.($item->nombre == "Locución con énfasis en Radio, Presentación de Televisión y Medios Digitales" ? "LRPTV" : $item->nombre) }} - Sem {{ $item2 }}</option>s
                @endif
                @endforeach
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="form-group col-2">
        <label for="" class="form-label">Grupo</label>
        <select class="form-select form-select optList" name="grupo" id="grupoID">
            @for ($i = date('Y')-1; $i <= (date('Y')+1); $i++)
                @for ($j = 1; $j < count(Session::get('config')['gruposNombre']); $j++)
                    <option value="{{ $i.$j }}" @if (date('Y')."1" == $i.$j) selected @endif>{{ $i }} - {{ Session::get('config')['gruposNombre'][$j]}}</option>
                @endfor
            @endfor
        </select>
    </div>

    <div class="form-group col-1 d-flex align-items-center">
        <button class="buttonLista btn btn-primary" href="#" role="button">Cargar</button>
    </div>

    </form>

    <div class="row">
        <div class="col-md-12">
            <h3>Documentos Cargados</h3>
            <table class="table table-striped" id="usuariosTable">
                <thead>
                  <tr>
                    <th scope="col">Tipo</th>
                    <th scope="col">Programa</th>
                    <th scope="col">Recurso</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($recursos as $item)
                  <tr>
                    <td>
                        {{ explode('|',$item->nombre)[0] }}
                    </td>
                    <td>
                        <small>
                            {{ explode('|',$losProgramas->where('id',explode('|',$item->nombre)[1])->first()->estructura)[explode('|',$item->nombre)[2]]}} - Grupo {{ $item->grupo }}<br>
                            {{ $losProgramas->where('id',explode('|',$item->nombre)[1])->first()->nombre}}</td>
                        </small>
                    <td>
                        @if (explode('|',$item->nombre)[0] == "pdf")
                        <a href="{{ route('ft', 'files|'.$item->ruta)}}" target="_blank">
                        @else
                        <a href="https://drive.google.com/file/d/{{$item->ruta}}/preview" target="_blank">
                        @endif
                        {{ explode('|', $item->nombre)[3]}}
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('infoGeneral.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Desea eliminar este recurso?')" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i>Borrar</button>
                        </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
</div>


@endsection


@section('scripts')
<script>
    $(document).ready(function() {
        $("#usuariosTable").DataTable();
        $('.btwToolt').tooltip();
    });
</script>
@endsection
