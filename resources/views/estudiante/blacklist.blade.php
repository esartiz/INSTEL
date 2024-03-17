@extends('layouts.admin')

@section('template_title')
    Lista Habilitaciones
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <h3>Estudiantes para reposición y/o recuperación</h3>
                            </span>
                            
                        </div>
                    </div>

                    <div class="card-body">
                            <table class="table table-striped table-hover dataTable" id="usuariosTable">
                                <thead class="thead">
                                    <tr>
                                        <th>Estudiante</th>
										<th>Módulo</th>
										<th>Nota 1</th>
										<th>Nota 2</th>
										<th>Nota 3</th>
										<th>Defin.</th>
                                        <th>Recup.</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lista as $matricula)
                                    @php
                                        $tiempo = AppHelper::timeModule($matricula->modulos_s, $matricula->grupo);
                                        $notaFinal = ($matricula->n1 * 0.3) + ($matricula->n2 * 0.3) + ($matricula->n3 * 0.4);
                                        $arrayRec = explode(",", $matricula->rem);
                                    @endphp
                                    @if ($tiempo[0][1] < now() && $notaFinal < 3.5)
                                    <tr>
                                        <td>
                                            <a href="{{ route('users.edit', $matricula->user()->first()->id)}}">
                                                {{ $matricula->user()->first()->apellidos.' '.$matricula->user()->first()->nombres }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('modulos.edit', $matricula->modulos_s->id)}}">
                                                {{ $matricula->modulos_s->titulo }}
                                            </a>
                                        </td>
                                        @for ($i = 1; $i <= 3; $i++)
                                        <td>
                                            @php
                                            $colorBtRm = (in_array($i, $arrayRec) ? 'success' : 'outline-dark');
                                            $laEntrega = $matricula->modulos_s->tareas()->where('tipo', $i+2)->first();
                                            $btEntrega = "";
                                            if($laEntrega){
                                                $dataEntrega = $laEntrega->entregasR()->where('de',$matricula->user()->first()->id)->first();
                                                if($dataEntrega){
                                                    $btEntrega = '<a onclick="verEntrega(this)" class="btn btn-danger" data-nt="n'.$i.'" data-fx="'.$dataEntrega->id.'" data-rt="'.$dataEntrega->retro.'"  data-vl="'.$matricula['n'.$i].'" href="#" role="button">'.$matricula['n'.$i].'</a>';
                                                }
                                            }
                                        @endphp
                                        @if ($btEntrega == "")
                                        <button onclick="switchRc({{ $matricula->id }}, {{ $i }}, '{{$colorBtRm}}',this)" class="btn btn-{{$colorBtRm}}" role="button">
                                            {{ $matricula['n'.$i] }}
                                        </button>
                                        @else
                                            {!! $btEntrega !!}
                                        @endif
                                        </td>
                                        @endfor



                                        
                                        <td>{{ $notaFinal }}</td>
                                        <td>
                                            @if ($matricula->hab == NULL)
                                            <a name="" id="" class="btn btn-outline-primary" href="{{ route('blacklist', $matricula->id) }}" role="button">NO</a>
                                            @else
                                            @if ($matricula->hab == "0.0")
                                            @php
                                            $laEntrega = $matricula->modulos_s->tareas()->where('tipo', 2)->first();
                                            if($laEntrega){
                                                $dataEntrega = $laEntrega->entregasR()->where('de',$matricula->user()->first()->id)->first();
                                                if($dataEntrega){
                                                    echo '<a onclick="verEntrega(this)" data-nt="hab" data-fx="'.$dataEntrega->id.'" data-rt="'.$dataEntrega->retro.'"  data-vl="'.$matricula->hab.'" href="#" role="button">Ver</a><hr>';
                                                }
                                            }
                                            @endphp
                                            <a name="" id="" class="btn btn-primary" href="{{ route('blacklist', $matricula->id) }}" role="button">SI</a>
                                            @else
                                                {{ $matricula->hab }}
                                            @endif
                                            @endif
                                        </td>
                                        <td>
                                           
                                            
                                        </td>
                                    </tr>
                                    @endif
                                        
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revisión de la Recuperación -->
    <form method="POST" action="" class="idT" role="form" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input type="hidden" name="campo" id="campo">
          @csrf
          <div class="modal fade" id="revisaTarea" tabindex="-1" role="dialog" aria-labelledby="boxRecursoLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tareaTT">Revisar Habilitación</h5>
                <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              
              <div class="modal-body">
                <div class="entregaData"></div>
              </div>
                    
              <div class="modal-footer">
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
        function verEntrega(t){
            console.log("/entregashow/" + $(t).attr('data-fx'));
            $('#campo').val($(t).attr('data-nt'));
            $('.entregaData').load("/entregashow/" + $(t).attr('data-fx'));
            $('#revisaTarea').modal('show');
            $('#retroalimentacion').val($(t).attr('data-rt'));
            $('#laNota').val($(t).attr('data-vl'));
            $('.idT').attr('action', '/revision/' + $(t).attr('data-fx'))
        }

        $("#revTarea").submit(function(event){
            $('.revisionFooter').html('Guardando, espere por favor...');
            event.preventDefault();
            $.ajax({
                url: '/revision/' + tareaSel,
                type:'POST',
                data:$(this).serialize(),
                success:function(result){
                $('#revisaTarea').modal('hide');
                $(btSel).removeClass('btn-warning').addClass('btn-outline-success');
                $(btSel).html('<i class="fa-regular fa-square-check"></i> Revisada');
                $(btSel).attr('onclick', '#');
                }
            });
            console.log($(this).serialize());
        });

        function switchRc(idTarea,act,clr, dd){
            $(dd).hide();
            let nColor = (clr == 'outline-dark' ? 'success' : 'outline-dark');
            $(dd).removeClass('btn-' + clr);
            $(dd).addClass('btn-' + nColor);
            $.get("/repone/" + idTarea + "|" + act, function(data, status){
                $(dd).show();
            });
        }
        
    </script>
@endsection