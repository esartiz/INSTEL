@extends('layouts.app')

@section('content')


<div class="container" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);background-color: #f0f8ffcb;">
    <div class="row d-flex align-items-center p-3">
        <div class="col-md-6 text-center">
            <img src="{{ asset('images/logo_instel.png') }}" style="margin-bottom: 20px">
            <h2>Ingresa a INSTEL Virtual</h2>
        </div>
        <div class="col-md-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <label for="email">Correo Electrónico</label>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="form-floating mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    <label for="password">Contraseña</label>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="form-check mb-3 d-flex justify-content-center">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        Mantenerse conectado    
                    </label>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary col-8">
                        ENTRAR
                    </button>
                </div>
                
                <div class="text-center" style="margin-top: 20px">
                    <a href="#" id="verVideo" style="color: rgb(94, 94, 94);">
                        <i class="fa-solid fa-circle-question"></i> No sé como ingresar [Ver Video Ayuda]
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="inicioHelp" tabindex="-1" role="dialog" aria-labelledby="inicioHelpLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="inicioHelpLabel">Cómo ingresar a la Plataforma / Recuperar contraseña </h5>
          <button type="button" class="close cerrarVideo" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cerrarVideo" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
    $('#verVideo').click(function(){
        $('#inicioHelp').modal('show');
        $('.modal-body').html('<iframe width="100%" height="480" src="https://www.youtube.com/embed/PG6fVnG7d2k?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>')
    })
    $(".cerrarVideo").click(function () {
        $('.modal-body').html('Cerrando...');
        $(".modal").modal("hide");
    });
    $("#inicioHelp").on("hidden.bs.modal", function (e) {
        $('.modal-body').html('Cerrando...');
    });
</script>
@endsection