@extends('layouts.admin')

@section('template_title')
    Usuarios Registrados
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            
                            <h3>{{ $users->count() }} {{ $tipoDato }}</h3>

                             <div class="float-right">
                                <form action="{{ route('users.check')}}" method="post">
                                    @csrf
                                    <input type="number" name="checkID" id="" required placeholder="No. Documento">
                                    <input type="hidden" name="rol" value="{{ $tipoDato }}">
                                    <button type="submit" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                        Registrar nuevo {{ $tipoDato }}
                                    </button>
                                </form>
                                
                              </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            @if ($tipoDato == "Estudiante")
                            <div class="row">
                                <div class="col-12">
                                    <label for="" class="form-label">Programa</label>
                                    <select class="form-select" name="" id="filtraPorPg">
                                        <option value="">Seleccione</option>
                                        @foreach ($listaFiltro as $item)
                                            <option value="{{ $item->id }}" myInfo="{{ $item->estructura }}">{{ $item->tipo.' '.$item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-8">
                                    <label for="" class="form-label">Semestre</label>
                                    <select class="form-select" name="ciclo" onchange="buscaenLista()" id="cicloID"></select>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label">Grupo</label>
                                    <select class="form-select" name="grupo" onchange="buscaenLista()" id="grupoID">
                                        <option value="1">Grupo A</option>
                                        <option value="2">Grupo B</option>
                                        <option value="3">Grupo C</option>
                                        <option value="4">Grupo D</option>
                                    </select>
                                </div>
                            </div>
                            
                            @endif
                        </div>
                            <table class="table table-striped table-hover" id="usuariosTable">
                                <thead class="thead">
                                    <tr>
										<th class="col-3">Usuario</th>
                                        <th class="col-2"></th>
										<th class="col-3">Datos</th>
                                        <th class="col-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
											<td style="width: 30%">
                                                <div style="font-size: 1px">filt_{{ $user->prg }}_{{ $user->ciclo }}_{{ substr($user->grupo,-1)}}</div>
                                                <a href="{{ route('users.edit',$user->id) }}">
                                                {{ $user->apellidos }} {{ $user->nombres }}
                                                </a>
                                                <br>
                                            </td>
                                            <td style="width: 10%">
                                                <small style="font-weight: bold; color:#053d6f">
                                                    {{ $user->rol }}
                                                </small><br>
                                            @if ($tipoDato == "Estudiante")
                                                <small>
                                                    {{ explode('|', $user->getPrograma()->first()->estructura)[$user->ciclo]}} <span style="font-size: 1px">{{$user->ciclo}}</span><br>
                                                    <b>Grupo {{ Session::get('config')['gruposNombre'][substr($user->grupo,-1)] }}</b>
                                                </small>
											@endif
                                            </td>
                                            <td style="width: 30%">{{ $user->telefono }}<br>{{ $user->email }}
                                                <br>{{ $user->tipoDoc }} {{ $user->doc }} de {{ $user->doc_ex }}<br>{{ $user->fecha_nac }}<br>Cód: {{ $user->cod }}</td>
                                            <td style="width: 20%">
                                                <form class="row" action="{{ route('users.destroy',$user->id) }}" method="POST">
                                                    <a class="col-4 btn btn-sm btn-info btwToolt" href="/inbox/{{ $user->cod }}" data-toggle="tooltip" data-placement="top" title="Escribir"><i class="fa-solid fa-square-envelope"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="col-4 btn btn-danger btn-sm btwToolt" onclick="return confirm('¿Desea deshabilitar este usuario?')" data-toggle="tooltip" data-placement="top" title="Deshabilitar"><i class="fa fa-fw fa-trash"></i> </button>
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

    <form action="{{ route('enviarMSJ') }}" method="POST">
        @csrf
        <div class="modal fade" id="boxMsj" tabindex="-1" role="dialog" aria-labelledby="boxMsjLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="boxActividad_tt"></h5>
                    <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
    
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Asunto:</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="asunto">
                        </div>
                    </div>
    
                    <br>
    
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Mensaje:</label>
                        <div class="col-sm-10">
                        <textarea class="form-control" name="mensaje" id="" rows="10"></textarea>
                        </div>
                    </div>
    
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="msjIDto" id="msjIDto" value="">
                    <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
                </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('scripts')
<script>

    function sendmsj(dt,nf){
        $('#boxActividad_tt').text("Enviar Mensaje a " + nf);
        $('#msjIDto').val(dt);
        $('#boxMsj').modal('show');
    }
    $('.cerrarModal').click(function(){
        $('.modal').modal('hide')
    })

    $(document).ready(function() {
        $("#usuariosTable").DataTable();
        $('.btwToolt').tooltip();
    });

    $('#filtraPorPg').change(function() {
        buscaSemestre($('option:selected', '#filtraPorPg').attr('myInfo'));
    });

    function buscaenLista() {
        var table = $('#usuariosTable').DataTable();
        var searchMe = 'filt_' + $('#filtraPorPg').val() + '_' + $('#cicloID').val() + '_' + $('#grupoID').val();
        console.log(searchMe)
        table.column(0).
            search(searchMe, true, false).
            draw();
    }
    
</script>
@endsection