@extends('layouts.admin')

@section('template_title')
    Certificados
@endsection

@section('content')
    <div class="container-fluid">

        <!-- INICIO DE CERTIFICACIONES -->
        <div class="card" style="margin-top: 20px">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3>Certificaciones Internacionales</h3>
                </div>
            </div>
        </div>
        <!-- FINAL DE CERTIFICACIONES -->


        <h3 style="margin-top: 20px">{{ $cert->count() }} Certificaciones expedidas</h3>

        <table class="table table-striped table-hover" id="usuariosTable">
            <thead class="thead">
                <tr>
                    <th>Registro</th>
                    <th>Estudiante</th>
                    <th>Certificado</th>
                    <th>Fecha</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cert as $graduando)
                @php
                    $data = explode('|', $graduando->descr );
                @endphp
                    <tr>
                        <td><a href="/crt/{{ $graduando->file }}" target="_blank">{{ $data[0] }}</a></td>
                        <td>
                            <a href="/users/{{ $graduando->user }}/edit" target="_blank">
                                {{ $graduando->getEstudiante()->apellidos.' '.$graduando->getEstudiante()->nombres }}
                            </a>
                        </td>
                        <td>{{ $data[2] }}</td>
                        <td>{{ $data[4] }}</td>

                        <td>
                            <button type="button" class="btn btn-sm btn-success botonEdit"
                                data-bs-toggle="modal"
                                data-bs-target="#modalId"
                                infoCtf="{{ $graduando->descr }}|{{ $graduando->id }}"
                            ><i class="fa fa-fw fa-edit"></i> Edit</a>
                        </td><td>
                            <div
                                class="modal fade"
                                id="modalId"
                                tabindex="-1"
                                data-bs-backdrop="static"
                                data-bs-keyboard="false"
                                
                                role="dialog"
                                aria-labelledby="modalTitleId"
                                aria-hidden="true"
                            >
                                <div
                                    class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
                                    role="document"
                                >
                                    <form class="modal-content" action="{{ route('certificados-int-create') }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Editar Certificado
                                            </h5>
                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"
                                            ></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                @php
                                                    $datosCertForm = ['Consecutivo', 'Tipo Estudio', 'Estudio', 'Intensidad', 'Fecha'];
                                                @endphp
                                                <input type="hidden" name="dform_6" id="dform_6">
                                                @for ($i = 0; $i < count($datosCertForm); $i++)
                                                <div class="col-md-12">
                                                    {!! Form::label('dform_'.$i, $datosCertForm[$i]) !!}
                                                    {!! Form::text('dform_'.$i, null, ['class' => 'form-control mb-3']) !!}
                                                </div>
                                                @endfor
                                                
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal"
                                            >
                                                Cerrar
                                            </button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            

                            <form action="{{ route('docMatr.delete') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="file" value="{{ $graduando->id }}">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Desea eliminar este certificado?')"><i class="fa fa-fw fa-trash"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
<script>
    $('.botonEdit').click(function(){
        let dd = ($(this).attr('infoCtf')).split('|');
        let ff = 0;
        dd.forEach(element => {
            $('#dform_' + ff).val(element);
            ff++;
            console.log(element)
        });
        console.table(dd)
    })
</script>
@endsection