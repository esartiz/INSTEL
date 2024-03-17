@php
    header('Cross-Origin-Opener-Policy: same-origin');
    header('Cross-Origin-Embedder-Policy: require-corp');
@endphp

<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/2.9.7/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/2.9.7/css/react-select.css" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="origin-trial" content="">

    <style>
      html, body {height: 100%}
      .asistenciaF{
        position: relative;
        width: 500px;
        z-index: 1;
      }
      .attendance{
        background: white;
        height: 500px;
        overflow-y:scroll;
        overflow-x:hidden;
      }
    </style>

</head>

<body>

  @if ($estudiantes !== 0)
  <form method="POST" class="idT" id="tomarAsistencia" role="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="totalAtt" value="{{ $estudiantes->count() }}">
  <div class="asistenciaF">
      <button type="button" name="" id="verListado" class="btn btn-primary"><span id="elMsj" role="alert">Tomar Asistencia</span></button>
      <button type="button" name="" id="cerrarListado" class="btn btn-primary">X Cerrar y Guardar</button>
      <div class="attendance">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Apellidos</th>
              <th scope="col">Nombre</th>
              <th scope="col">Asistencia</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($estudiantes as $item)
            <tr>
              <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $item->user()->first()->apellidos }}</td>
              <td>{{ $item->user()->first()->nombres }}</td>
              <td>
                <div class="d-flex justify-content-center">
                  <input type="hidden" name="ast_id_{{ $loop->iteration }}" value="{{ $item->estudiante }}">

                  <input class="form-check-input" type="radio" name="ast_v_{{ $loop->iteration }}" id="btAsis_{{ $loop->iteration }}_1" value="1" checked>
                  <label class="form-check-label" for="btAsis_{{ $loop->iteration }}_1">Si</label>
                  <input class="form-check-input" type="radio" name="ast_v_{{ $loop->iteration }}" id="btAsis_{{ $loop->iteration }}_2" value="0">
                  <label class="form-check-label" for="btAsis_{{ $loop->iteration }}_2">No</label>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
  </div>
  </form>
  @endif

    <script src="https://source.zoom.us/2.9.7/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/2.9.7/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/2.9.7/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/2.9.7/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/2.9.7/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-2.9.7.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-embedded-2.9.7.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

    <script src="{{ asset('js/zoom-js/tool.js') }}" defer></script>
    <script src="{{ asset('js/zoom-js/vconsole.min.js') }}" defer></script>
    <script src="{{ asset('js/zoom-js/meeting.js') }}" defer></script>

    <script>
let meetingSDKElement = document.getElementById('meetingSDKElement')

let meetingSDKChatElement = document.getElementById('meetingSDKChatElement')

const client = ZoomMtgEmbedded.createClient()

client.init({
  zoomAppRoot: meetingSDKElement,
  language: 'es-ES',
  customize: {
    video: {
      isResizable: true,
      viewSizes: {
        default: {
          width: 1000,
          height: 600
        },
        ribbon: {
          width: 300,
          height: 700
        }
      }
    }
  }
});

$('.attendance').hide();
$('#cerrarListado').hide();

$('#verListado').click(function(){
  $('#verListado').hide();
  $('#cerrarListado').show();
  $('.attendance').show();
})

$('#cerrarListado').click(function(){
  $('#verListado').show();
  $('#cerrarListado').hide();
  $('.attendance').hide();
  var data = $('#tomarAsistencia').serialize();
  $.ajax({
    type: "post",
    url: "{{route('asistencia')}}",
    data: data,
    success: function (msg) {
    $('#elMsj').text(msg)
    console.log(msg)
    }
  });
})
    </script>
</body>

</html>