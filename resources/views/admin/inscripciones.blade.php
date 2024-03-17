@php
    $i = 0;
@endphp
@extends('layouts.admin')

@section('template_title')
    {{ $req->count() }} inscripciones registradas
@endsection

@section('content')
    <h3>{{ $req->count() }} inscripciones registradas</h3>

    <table class="table table-striped table-hover" id="usuariosTable">
        <thead class="thead">
            <tr>
                <th style="min-width: 100px">Fecha</th>
                <th style="min-width: 200px">Nombre</th>
                <th style="width: 200px">Programa</th>
                <th>Ciudad</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th style="min-width: 100px"></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($req as $inscripcione)
                <tr>
                    <td>{{ $inscripcione->fechaForm }}</td>
                    <td>
                        {!! ($inscripcione->checkUser()->count() > 0 ? '<a href="/users/'.$inscripcione->checkUser()->first()->id.'/edit" target="_blank">'.$inscripcione->nombre.'</b>' : $inscripcione->nombre) !!}
                    </td>
                    <td>{{ 
                    ((is_object($inscripcione->getPrograma())) ? $inscripcione->getPrograma()->nombre : $inscripcione->programa)
                    }}
                    <br><small>{{$inscripcione->tipo_programa}}</small>    
                </td>
                    <td>{{ $inscripcione->lugarReside }}</td>
                    <td>{{ $inscripcione->telefono }}</td>
                    <td>{{ $inscripcione->correo }}</td>
                    <td>
                        <button type="button" datos="{{ $inscripcione }}" onclick="verDatos(this)" class="btn btn-sm btn-link">Ver Ficha</button>
                    </td>
                    <td>
                        <form action="{{ route('inscripciones.destroy', $inscripcione->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i>Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
   
    <div class="modal fade" id="formDatos" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Fecha</th>
                                <td colspan="2" id="d_fechaForm">R1C2</td>
                                <th>Nombre:</th>
                                <td colspan="2" id="d_nombre"></td>
                            </tr>
                            <tr>
                                <th>Programa</th>
                                <td colspan="5" id="d_programa"></td>
                            </tr>
                            <tr>
                                <th>Lugar Residencia</th>
                                <td id="d_lugarReside"></td>
                                <th>Telefono</th>
                                <td id="d_telefono"></td>
                                <th>Correo</th>
                                <td id="d_correo"></td>
                            </tr>
                            <tr>
                                <th>Fecha Nacimiento</th>
                                <td id="d_fechaNace"></td>
                                <th>Edad</th>
                                <td id="d_edad"></td>
                                <th>Lugar Nacimiento</th>
                                <td id="d_lugarNace"></td>
                            </tr>
                            <tr>
                                <th>Documento</th>
                                <td id="d_doc"></td>
                                <th>Estado Civil</th>
                                <td id="d_estadoCivil"></td>
                                <th>Direccion</th>
                                <td id="d_direccion"></td>
                            </tr>
                            <tr>
                                <th>Último Año de Estudio</th>
                                <td id="d_ultAnoEstudio"></td>
                                <th>Año Estudio Curso</th>
                                <td id="d_anoCursoEstudio"></td>
                                <th>Institución Educativa</th>
                                <td id="d_ie_estudios"></td>
                            </tr>
                            <tr>
                                <th>Ciudad de Estudio</th>
                                <td id="d_ciudadEstudios"></td>
                                <th>Experiencia Ed. Virtual</th>
                                <td id="d_exper_virtual"></td>
                                <th>Paquetes Informáticos</th>
                                <td id="d_paqCompManeja"></td>
                            </tr>
                            <tr>
                                <th>Título Obtenido</th>
                                <td id="d_tituloObtenido"></td>
                                <th>Duración Estudio</th>
                                <td id="d_duracionEstudio"></td>
                                <th>Disponibilidad hrs/día</th>
                                <td id="d_hrsxDiaDisp"></td>
                            </tr>
                            <tr>
                                <th>Estudios en Locución</th>
                                <td id="d_cursadoLoc"></td>
                                <th>Experiencia en Medios</th>
                                <td id="d_experienciaMedios"></td>
                                <th>Experiencia (tiempo)</th>
                                <td id="d_tiempoExperiencia"></td>
                            </tr>
                            <tr>
                                <th>Trabaja Actualmente</th>
                                <td id="d_trabaja"></td>
                                <th>Empresa</th>
                                <td id="d_nombreEmpresa"></td>
                                <th>Actividad empresa</th>
                                <td id="d_actividadEmpresa"></td>
                            </tr>
                            <tr>
                                <th>Funciones Empresa</th>
                                <td id="d_funcionesEmpresa"></td>
                                <th>Tiempo Serv. Empresa</th>
                                <td id="d_tiempoSerEmpresa"></td>
                                <th>Sobre INSTEL</th>
                                <td id="d_tiempoSerEmpresa"></td>
                            </tr>
                            <tr>
                                <th>Motivación</th>
                                <td id="d_motivacionInstel"></td>
                                <th>Aporte INSTEL</th>
                                <td id="d_aporteInstel"></td>
                                <th>Estudios Prev.</th>
                                <td id="d_estudioAntesTema"></td>
                            </tr>
                            <tr>
                                <th>Necesidades Especiales</th>
                                <td id="d_necesidadEsp"></td>
                                <th>Ventajas</th>
                                <td id="d_ventajas"></td>
                                <th>Desventajas</th>
                                <td id="d_desventajas"></td>
                            </tr>
                            <tr>
                                <th>Personas Dep.</th>
                                <td id="d_dependientes"></td>
                                <th>Ingresos mes</th>
                                <td id="d_ingresos"></td>
                                <th>Tipo Vivienda</th>
                                <td id="d_casaTipo"></td>
                            </tr>
                            <tr>
                                <th>Medio conoció INSTEL</th>
                                <td colspan="5" id="d_medioConocerInstel"></td>
                            </tr>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        verDatos = function(btn){
            var datos = JSON.parse( $(btn).attr('datos'));
            console.log(datos.nombre);
            $('#formDatos').modal('show');
            $('#modalTitleId').text("Inscripción de " + datos.nombre);
            $('#d_nombre').text(datos.nombre);
            $('#d_fechaForm').text(datos.fechaForm);
            $('#d_programa').text(datos.programa + ' (' + datos.tipo_programa + ')');
            $('#d_fechaNace').text(datos.fechaNac);
            $('#d_edad').text(datos.edad);
            $('#d_lugarNace').text(datos.lugarNace);
            $('#d_doc').text(datos.doc);
            $('#d_estadoCivil').text(datos.estadoCivil);
            $('#d_direccion').text(datos.direccion + ' (Barrio: ' + datos.barrio + ')');
            $('#d_lugarReside').text(datos.lugarReside);
            $('#d_telefono').text(datos.telefono);
            $('#d_correo').text(datos.correo);
            $('#d_ultAnoEstudio').text(datos.ultAnoEstudio);
            $('#d_anoCursoEstudio').text(datos.anoCursoEstudio);
            $('#d_ie_estudios').text(datos.ie_estudios);
            $('#d_ciudadEstudios').text(datos.ciudadEstudios);
            $('#d_exper_virtual').text(datos.exper_virtual);
            $('#d_paqCompManeja').text(datos.paqCompManeja);
            $('#d_tituloObtenido').text(datos.tituloObtenido);
            $('#d_duracionEstudio').text(datos.duracionEstudio);
            $('#d_hrsxDiaDisp').text(datos.hrsxDiaDisp);
            $('#d_cursadoLoc').text(datos.cursadoLoc);
            $('#d_experienciaMedios').text(datos.experienciaMedios);
            $('#d_tiempoExperiencia').text(datos.tiempoExperiencia);
            $('#d_trabaja').text(datos.trabaja);
            $('#d_nombreEmpresa').text(datos.nombreEmpresa);
            $('#d_actividadEmpresa').text(datos.actividadEmpresa);
            $('#d_funcionesEmpresa').text(datos.funcionesEmpresa);
            $('#d_tiempoSerEmpresa').text(datos.tiempoSerEmpresa);
            $('#d_instelPrAc').text(datos.instelPrAc);
            $('#d_motivacionInstel').text(datos.motivacionInstel);
            $('#d_aporteInstel').text(datos.aporteInstel);
            $('#d_estudioAntesTema').text(datos.estudioAntesTema);
            $('#d_necesidadEsp').text(datos.necesidadEsp);
            $('#d_ventajas').text(datos.ventajas);
            $('#d_desventajas').text(datos.desventajas);
            $('#d_dependientes').text(datos.dependientes);
            $('#d_ingresos').text(datos.ingresos);
            $('#d_casaTipo').text(datos.casaTipo);
            $('#d_medioConocerInstel').text(datos.medioConocerInstel);

        }

        $('#usuariosTable').DataTable({
            order: [[0, 'desc']]
        });
    </script>
@endsection
