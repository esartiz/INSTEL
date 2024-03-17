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
                <h3>Bandeja de Mensajes</h3>
            </div>
            <div class="ms-auto p-2 bd-highlight">
                <a href="/" class="btn btn-outline-primary"><i class="fa-solid fa-paper-plane"></i> Nuevo Mensaje</a><br><br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="list-group inboxBandeja" id="list-tab" role="tablist">

                    @foreach ($mensajes as $mensaje)
                    <a class="list-group-item list-group-item-action" href="{{ route('mensajes.show', $mensaje->id ) }}" role="tab">
                        <div class="d-flex w-100 justify-content-between">
                            <img class="card-img-top inboxImage" src="https://virtual.instel.edu.co/storage/profiles/0/t/{{ $mensaje->userDe->cod }}.jpg">
                            <div>
                                <h5 class="mb-1 inboxAsunto">
                                    {{ $mensaje->asunto }}
                                </h5>
                                <p class="mb-1">{!! $mensaje->userDe->apellidos.', '.$mensaje->userDe->nombres !!}</p>
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
                    @endforeach
        
                  </div>
                </div>
                <div class="col-md-8 inboxMsj">
                  <div class="tab-content" id="nav-tabContent">
                    @foreach ($mensajes as $mensaje)
                        <div class="tab-pane fade show @if ($loop->first) active @endif" id="inbox-id-{{ $mensaje->id }}" role="tabpanel" aria-labelledby="inbox-id-{{ $mensaje->id }}-list">
                            <h3>{{ $mensaje->asunto }}</h3>
                            {{ $mensaje->mensaje }}
                            <hr>
                            Responder:
                            <textarea class="ckeditor" name="mensaje" id="mensaje" rows="8"></textarea>
                        </div>
                    @endforeach
                  </div>
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