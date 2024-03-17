@extends('layouts.app')

@section('template_title')
    Inscripcione
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Inscripcione') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('inscripciones.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Nombre</th>
										<th>Programa</th>
										<th>Tipo Programa</th>
										<th>Fechanac</th>
										<th>Edad</th>
										<th>Lugarnace</th>
										<th>Estadocivil</th>
										<th>Doc</th>
										<th>Lugarreside</th>
										<th>Telefono</th>
										<th>Correo</th>
										<th>Direccion</th>
										<th>Ultanoestudio</th>
										<th>Anocursoestudio</th>
										<th>Ie Estudios</th>
										<th>Ciudadestudios</th>
										<th>Exper Virtual</th>
										<th>Paqcompmaneja</th>
										<th>Tituloobtenido</th>
										<th>Duracionestudio</th>
										<th>Hrsxdiadisp</th>
										<th>Cursadoloc</th>
										<th>Experienciamedios</th>
										<th>Tiempoexperiencia</th>
										<th>Trabaja</th>
										<th>Nombreempresa</th>
										<th>Actividadempresa</th>
										<th>Funcionesempresa</th>
										<th>Tiemposerempresa</th>
										<th>Instelprac</th>
										<th>Motivacioninstel</th>
										<th>Aporteinstel</th>
										<th>Estudioantestema</th>
										<th>Necesidadesp</th>
										<th>Ventajas</th>
										<th>Desventajas</th>
										<th>Dependientes</th>
										<th>Ingresos</th>
										<th>Casatipo</th>
										<th>Medioconocerinstel</th>
										<th>Fechaform</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inscripciones as $inscripcione)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $inscripcione->nombre }}</td>
											<td>{{ $inscripcione->programa }}</td>
											<td>{{ $inscripcione->tipo_programa }}</td>
											<td>{{ $inscripcione->fechaNac }}</td>
											<td>{{ $inscripcione->edad }}</td>
											<td>{{ $inscripcione->lugarNace }}</td>
											<td>{{ $inscripcione->estadoCivil }}</td>
											<td>{{ $inscripcione->doc }}</td>
											<td>{{ $inscripcione->lugarReside }}</td>
											<td>{{ $inscripcione->telefono }}</td>
											<td>{{ $inscripcione->correo }}</td>
											<td>{{ $inscripcione->direccion }}</td>
											<td>{{ $inscripcione->ultAnoEstudio }}</td>
											<td>{{ $inscripcione->anoCursoEstudio }}</td>
											<td>{{ $inscripcione->ie_estudios }}</td>
											<td>{{ $inscripcione->ciudadEstudios }}</td>
											<td>{{ $inscripcione->exper_virtual }}</td>
											<td>{{ $inscripcione->paqCompManeja }}</td>
											<td>{{ $inscripcione->tituloObtenido }}</td>
											<td>{{ $inscripcione->duracionEstudio }}</td>
											<td>{{ $inscripcione->hrsxDiaDisp }}</td>
											<td>{{ $inscripcione->cursadoLoc }}</td>
											<td>{{ $inscripcione->experienciaMedios }}</td>
											<td>{{ $inscripcione->tiempoExperiencia }}</td>
											<td>{{ $inscripcione->trabaja }}</td>
											<td>{{ $inscripcione->nombreEmpresa }}</td>
											<td>{{ $inscripcione->actividadEmpresa }}</td>
											<td>{{ $inscripcione->funcionesEmpresa }}</td>
											<td>{{ $inscripcione->tiempoSerEmpresa }}</td>
											<td>{{ $inscripcione->instelPrAc }}</td>
											<td>{{ $inscripcione->motivacionInstel }}</td>
											<td>{{ $inscripcione->aporteInstel }}</td>
											<td>{{ $inscripcione->estudioAntesTema }}</td>
											<td>{{ $inscripcione->necesidadEsp }}</td>
											<td>{{ $inscripcione->ventajas }}</td>
											<td>{{ $inscripcione->desventajas }}</td>
											<td>{{ $inscripcione->dependientes }}</td>
											<td>{{ $inscripcione->ingresos }}</td>
											<td>{{ $inscripcione->casaTipo }}</td>
											<td>{{ $inscripcione->medioConocerInstel }}</td>
											<td>{{ $inscripcione->fechaForm }}</td>

                                            <td>
                                                <form action="{{ route('inscripciones.destroy',$inscripcione->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('inscripciones.show',$inscripcione->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('inscripciones.edit',$inscripcione->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $inscripciones->links() !!}
            </div>
        </div>
    </div>
@endsection
