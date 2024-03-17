@extends('layouts.admin')

@section('template_title')
    Pruebas de Aptitud - Fase Protocolar
@endsection

@section('content')
    <h3>Pruebas de Aptitud</h3>
    <div class="row">
        <div class="col-md-4">
            Pruebas Creadas
            <table class="table">
                @foreach ($pruebas as $item)
                    <thead>
                        <tr>
                            <th colspan="2" scope="col">{{ $item->nombre }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td>
                                <small>Del <span class="forFecha" dt-f="{{ $item->fecha1}}"></span> al <span class="forFecha" dt-f="{{ $item->fecha2}}"></span> </small>
                                @if(!is_null($item->anexo))
                                    <br><a href="{{ route('ft','pruebas|' . $item->anexo)}}" target="_blank"> Documento</a>
                                @endif
                            </td>
                            <td scope="row" style="text-align: right">
                                <button type="button" class="btn btn-primary btn-sm" onclick="editarPr(this)" dt="{{ $item }}">
                                    Editar Prueba
                                </button>
                            </td>
                        </tr>
                    </tbody>
                @endforeach

            </table>

        </div>
        <div class="col-md-8">
                <table class="table table-stripped" id="usuariosTable">
                    <thead>
                        <tr>
                            <th scope="col">Estudiante</th>
                            <th scope="col">Prueba 1</th>
                            <th scope="col">Prueba 2</th>
                            <th scope="col">Prueba 3</th>
                            <th scope="col">Prueba 4</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matriculas as $item)
                        <tr class="">
                            <td scope="row">
                                <a href="/users/{{ $item->user }}/edit" target="_blank">
                                    {{ $item->getEstudiante()->apellidos }} {{ $item->getEstudiante()->nombres }}
                                    @if ($item->getEstudiante()->getPruebas()->count() == 0)

                                <form action="{{ route('prueba.crear') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user" value="{{ $item->getEstudiante()->id }}">
                                    <button type="submit" class="btn btn-sm btn-primary">Crear Pruebas</button>
                                </form>
                                @else
                                <form action="{{ route('prueba.borrar', $item->getEstudiante()->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Desea eliminar definitivamente las pruebas a este estudiante?')"  class="btn btn-sm btn-link">Eliminar Todas las Pruebas</button>
                                </form>
                            
                                @endif
                                </a>
                            </td>
                            @for ($i = 1; $i <= 4; $i++)
                            @php $pr = $item->getEstudiante()->getPruebas()->where('idPrueba', $i); @endphp
                            <td>
                                @if ($pr->count() == 0)
                                    
                                @else
                                    @if (is_null($pr->first()->valoracion1) && is_null($pr->first()->valoracion2))
                                    <a class="col-12 btn btn-outline-primary btn-sm" href="#" role="button"><i class="fa-solid fa-triangle-exclamation"></i> Sin Evaluar</a>
                                    @else
                                        <a class="col-12 btn btn-primary btn-sm" href="{{route('prueba.ver', $pr->first()->codigo)}}" target="_blank" role="button"><i class="fa fa-fw fa-eye"></i> Resultado</a>
                                        <form action="{{ route('prueba.borrar', 0) }}" method="post">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" name="deleteme" value="{{ $pr->first()->id }}">
                                            <button type="submit" class="col-12 btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar definitivamente este informe?')"><i class="fa fa-fw fa-trash"></i> Eliminar</button>
                                        </form>
                                    @endif
                                @endif

                            </td>
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>




    <div class="modal fade" id="boxEditPrueba" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
            <form action="" id="enviaCambios" method="POST" class="modal-content" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Editar Prueba</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-4">
                        <h5>Datos de la Prueba</h5>
                        <div class="mb-3">
                            <label for="">Nombre de la Prueba</label>
                            <input type="text" class="form-control" id="nombre_ed" name="nombre">
                        </div>
    
                        <div class="mb-3">
                            <label for="">Área de la Prueba</label>
                            <input type="text" class="form-control" id="area_ed" name="area">
                        </div>

                        <h5>Jurados Asignados</h5>
                        <div class="mb-3">
                            <label for="">Jurado 1</label>
                            <select class="form-select form-select-sm" name="jurado1" id="jurado1_ed">
                                <option value="0">No asignado</option>
                                @foreach ($docentes as $doc)
                                    <option value="{{ $doc->id }}" @if ($doc->id == $item->jurado1 ? 'selected' : '') @endif>
                                        {{ $doc->apellidos }} {{ $doc->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="">Jurado 2</label>
                            <select class="form-select form-select-sm" name="jurado2" id="jurado2_ed">
                                <option selected>No asignado</option>
                                @foreach ($docentes as $doc)
                                    <option value="{{ $doc->id }}" @if ($doc->id == $item->jurado2 ? 'selected' : '') @endif>
                                        {{ $doc->apellidos }} {{ $doc->nombres }}</option>
                                @endforeach
                            </select>
                        </div>

                        <h5>Temporalidad de la Prueba</h5>
                        <div class="mb-3">
                            <label for="">Fecha y Hora de Inicio</label>
                            <input type="datetime-local" class="form-control" name="fecha1" id="fecha1_ed">
                        </div>
                        <div class="mb-3">
                            <label for="">Fecha y Hora Finalización</label>
                            <input type="datetime-local" class="form-control" name="fecha2" id="fecha2_ed">
                        </div>

                        <h5>Anexo</h5>
                        <div class="mb-3">
                            <label for="">Cargue documento</label>
                            <input type="file" class="form-control" name="archivo" id="archivo">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <h5>Criterios Evaluación</h5>
                        <div class="row">
                            @for ($i = 0; $i < 5; $i++)
                            <div class="mb-3 col-md-6">
                                <label for="">Criterio Evaluación {{ ($i+1) }}</label>
                                <input type="text" class="form-control form-select-sm" id="criterio_{{ $i }}" name="criterio_{{ $i }}">
                            </div>
                            @endfor
                        </div>

                        <h5>Texto evaluación</h5>
                        <textarea name="texto" id="texto_ed" rows="13"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/44.0.0/classic/ckeditor.js"></script>
    <script>
        function editarPr(dd){
            var datos = JSON.parse($(dd).attr('dt'));
            var idCrt = 0;
            (datos.instruccion).split('|').forEach(element => {
                $('#criterio_' + idCrt).val(element);
                idCrt++;
            });
            $('#jurado1_ed').val(datos.jurado1);
            $('#jurado2_ed').val(datos.jurado2);
            $('#nombre_ed').val(datos.nombre);
            $('#area_ed').val(datos.area);
            $('#fecha1_ed').val(datos.fecha1);
            $('#fecha2_ed').val(datos.fecha2);
            $('#enviaCambios').attr('action','/pa/' + datos.id)
            //
            CKEDITOR.replace('texto_ed');
            CKEDITOR.instances.texto_ed.setData(datos.texto);
            //
            $('#boxEditPrueba').modal('show');
        }
        $("#usuariosTable").DataTable();
    </script>
@endsection