@extends('layouts.instel')

@section('template_title')
    Mensajes
@endsection

@section('content')
    <div class="container">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        
        <div class="d-flex bd-highlight">
            <div class="p-2 bd-highlight">
                <h3>Conversaciones</h3>
                <small><i class="fa-regular fa-user"></i> Estudiante | <i class="fa-solid fa-chalkboard-user"></i> Docente | <i class="fa-solid fa-key"></i> Administrador</small>
            </div>
            <div class="ms-auto p-2 bd-highlight">
                <a href="/" class="btn btn-outline-info"><i class="fa-solid fa-circle-chevron-left"></i> Regresar</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="list-group inboxBandeja" id="list-tab" role="tablist">
                    @php $listaBandeja = array() @endphp
                    @foreach($bandeja as $mensaje)
                    @php
                        $displayCod = $mensaje->userDe->cod;
                        $displayNm = $mensaje->userDe->apellidos.', '.$mensaje->userDe->nombres;
                        $displayRol = $mensaje->userDe->rol;
                        if($displayCod == Auth::user()->cod){
                            $displayCod = $mensaje->userPara->cod;
                            $displayNm = $mensaje->userPara->apellidos.', '.$mensaje->userPara->nombres;
                            $displayRol = $mensaje->userPara->rol;
                        }
                    @endphp
                    @if (in_array($displayCod, $listaBandeja))
                    @else
                    @php array_push($listaBandeja, $displayCod) @endphp
                    <a @if ($mensaje->status == 0) style="font-weight: 900;" @endif class="list-group-item list-group-item-action @if($displayCod == $guia) active @endif" href="{{ route('inbox.show', $displayCod ) }}" role="tab">
                        <div class="d-flex w-100 justify-content-between">
                            <img class="card-img-top inboxImage" src="{{ route('ft', 'profiles|0|t|'.$displayCod.'.jpg') }}" onerror="this.src='{{ route('ft', 'profiles|0|no-pic.jpg') }}';" >
                            <div>
                                <p class="mb-1 inboxAsunto">
                                    {{ $mensaje->mensaje }}
                                </p>
                                <i class="fa-solid fa-{{ ($displayRol == "Administrador" ? "key" : ($displayRol == "Estudiante" ? "user" : "chalkboard-user")) }}"></i> <small class="mb-1">{!! $displayNm !!}</small> 
                            </div>
                            <small>
                                @if (date('Y-m-d', strtotime($mensaje->start_date)) == date('Y-m-d', strtotime(Carbon\Carbon::now() )))
                                    {{ date('H:i', strtotime($mensaje->start_date)) }}
                                @else
                                    {{ date('d/m/Y', strtotime($mensaje->start_date)) }}
                                @endif
                            </small>
                          </div>
                    </a>
                    @endif
                    @endforeach
                  </div>
                </div>
                <div class="col-md-8 inboxMsj">
                    @if ($msj != "")
                    @php $checkForMe = (empty($msj->first()->para)) ? "" : $msj->first()->para @endphp
                        @if ((Auth::user()->id == $checkForMe) || $msj->count() == 0 || Auth::user()->rol == "Administrador")
                        <form class="form-inline my-2 my-lg-0" action="{{ route('inbox.store')}}" method="post">
                            @csrf
                            <small>Escribir mensaje a {{ Session::get('de_nombre') }} </small>
                            <input type="hidden" name="getTok" id="fcmTokens" value="">
                            <input class="form-control mr-sm-2" type="search" name="mensaje" placeholder="Escriba el mensaje aquí..." aria-label="Search">
                        </form>
                        @else
                            <small>Para enviar otro mensaje a {{ Session::get('de_nombre') }} debes esperar que te responda</small>
                        @endif
                    
                    <hr>
                    @foreach ($msj as $item)
                        @if ($item->de == Auth::user()->id)

                        <div class="outgoing_msg">
                            <div class="sent_msg">
                              <p>{!! $item->mensaje !!}</p>
                              <span class="time_date">{{ date('H:i', strtotime($item->start_date)) }} | {{ date('d/m/Y', strtotime($item->start_date)) }}</span>
                            </div>
                        </div>

                        @else

                        <div class="incoming_msg">
                            <div class="incoming_msg_img"> <img src="{{ route('ft', 'profiles|0|t|'.$item->userDe->cod.'.jpg') }}" onerror="this.src='{{ route('ft', 'profiles|0|no-pic.jpg') }}';"> </div>
                            <div class="received_msg">
                              <div class="received_withd_msg">
                                <p>{!! $item->mensaje !!}</p>
                                <span class="time_date">{{ date('H:i', strtotime($item->start_date)) }} | {{ date('d/m/Y', strtotime($item->start_date)) }}</span>
                            </div>
                            </div>
                        </div>

                        @endif
                    @endforeach
                    @endif
                </div>
              </div>
        </div>
        
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#inboxTable").DataTable({
            order: [[0, 'desc']],
        });
    });
</script>
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection