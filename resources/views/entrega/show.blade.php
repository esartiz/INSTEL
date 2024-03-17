@php
    $tiposTarea = explode("|", $entrega->tarea()->first()->tipo_rta);
@endphp

<div class="card">
    <div class="card-header">
        <div class="float-left">
            <span class="card-title">Entrega realizada por <b>{{ $entrega->user()->first()->nombres }} {{ $entrega->user()->first()->apellidos }}</b></span>
        </div>
        <div class="float-right">
        </div>
    </div>

    <div class="card-body">

        <div class="form-group">
            <strong>Fecha:</strong>
            {{ $entrega->created_at }}
        </div>
        <div class="form-group">
            <strong>Tipo de actividad:</strong>
            
        </div>
        <div class="form-group">
            <strong>Tarea:</strong>
            {{ $entrega->tarea()->first()->enunciado }}
        </div>


        @if ($entrega->created_at > '2023-05-03')
            @if ($entrega->respuesta !== NULL)
                <hr>
                <h4>PDF cargados:</h4>
                @php
                    $dataPDF = explode('||',$entrega->respuesta);
                    $htmlPDF = '<ul>';
                    $idPDF = 0;
                    foreach ($dataPDF as $item) {
                        if($item !== ""){
                            $idPDF++; 
                            $htmlPDF .= '<li><a href="'.route('ft', 'entregas|pdf|'.$item).'" target="_blank">ABRIR ARCHIVO PDF '.$idPDF.'</a></li>';
                        }
                    }
                    $htmlPDF .= '</ul>';
                    echo $htmlPDF;
                @endphp
            @endif
            @if ($entrega->link !== NULL)
                <hr>
                <h4>Links incluídos:</h4>
                @php
                    $dataLink = explode('||',$entrega->link);
                    $htmlLink = '<ul>';
                    foreach ($dataLink as $item) {
                        if($item !== ""){
                            $htmlLink .= '<li><a href="'.$item.'" target="_blank">'.$item.'</a></li>';
                        }
                    }
                    $htmlLink .= '</ul>';
                    echo $htmlLink;
                @endphp
            @endif
        @else
        <!-- INICIO --- Entregas antes del 03 de Mayo de 2023 -->
            @if (in_array("texto", $tiposTarea))
            <div class="form-group">
                <h3 style="text-align: center"><i class="fa-solid fa-align-justify"></i> Texto entregado:</h3>
                {!! $entrega->respuesta !!}
            </div>
            @endif

            @if (in_array("audio", $tiposTarea))
            <div class="form-group">
                <h3 style="text-align: center"><i class="fa-solid fa-microphone"></i> Audio cargado:</h3>
                <audio controls="" style="width: 100%" class="entregaData" id="entrega_audio"><source src="{{ route('ft', 'entregas|audio|'.$entrega->idUnico.'.mp3') }}" type="audio/mpeg"></audio>
            </div>
            @endif

            @if (in_array("link", $tiposTarea))
            <div class="form-group">
                <h3 style="text-align: center"><i class="fa-brands fa-youtube"></i>Link Agregado:</h3>
                <a href="{{ $entrega->link }}" target="_blank">{{ $entrega->link }}</a>
            </div>
            @endif

            @if (in_array("pdf", $tiposTarea))
            <div class="form-group">
                <h3 style="text-align: center"><i class="fa-solid fa-file-pdf"></i>PDF Cargado:</h3>
                <a href="{{ route('ft', 'entregas|pdf|'.$entrega->idUnico.'.pdf') }}" target="_blank">ABRIR ARCHIVO PDF</a>
            </div>
            @endif
        <!-- FINAL --- Entregas antes del 03 de Mayo de 2023 -->
        @endif



        @if (Auth::user()->rol != "Estudiante")
            
        <hr>
            <div class="row">
              <div class="col-md-9">
                <h5>Retroalimentación:</h5>
                <div class="mb-3">
                    <input type="hidden" id="audioBlob" name="audioBlob">
                    <a id="startButton">Iniciar grabación</a>
                    <a id="stopButton" disabled>Detener grabación</a>
                    <audio id="audioPreview" controls></audio>
                </div>
                <div class="mb-3">
                  <textarea class="form-control" name="retroalimentacion" id="retroalimentacion" rows="8">{{ $entrega->retro }}</textarea>
                </div>
              </div>
              <div class="col-md-3">
                <h5>Asignar nota a parcial:</h5>
                Primer Parcial 30%:<br>
                <input type="number" name="revN1" onchange="revisionCambiaNota()" class="form-control" step="0.1" min="0" max="5" value="{{ $entrega->matriculaMod($entrega->de)->first()->n1 }}"/><br>
                Segundo Parcial 30%:<br>
                <input type="number" name="revN2" onchange="revisionCambiaNota()" class="form-control" step="0.1" min="0" max="5" value="{{ $entrega->matriculaMod($entrega->de)->first()->n2 }}"/><br>
                Tercer Parcial 40%:<br>
                <input type="number" name="revN3" onchange="revisionCambiaNota()" class="form-control" step="0.1" min="0" max="5" value="{{ $entrega->matriculaMod($entrega->de)->first()->n3 }}"/><br>
                @if (Auth::user()->rol == "Administrador")
                Recuperación:<br>
                <input type="number" name="hab" class="form-control" step="0.1" min="0" max="5" value="{{ $entrega->matriculaMod($entrega->de)->first()->hab }}"/><br>
                @endif
              </div>
            </div>

            <script>
                let mediaRecorder_{{ $entrega->id }};
                let chunks_{{ $entrega->id }} = [];
        
                navigator.mediaDevices.getUserMedia({ audio: true })
                    .then(function(stream) {
                        mediaRecorder_{{ $entrega->id }} = new MediaRecorder(stream);
        
                        mediaRecorder_{{ $entrega->id }}.ondataavailable = function(e) {
                            chunks_{{ $entrega->id }}.push(e.data);
                        };
        
                        mediaRecorder_{{ $entrega->id }}.onstop = function() {
                            let audioBlob = new Blob(chunks_{{ $entrega->id }}, { type: 'audio/wav' });
                            let audioUrl = URL.createObjectURL(audioBlob);
                            document.getElementById('audioPreview').src = audioUrl;
                            document.getElementById('audioBlob').value = audioBlob;
                        };
                    });
        
                document.getElementById('startButton').addEventListener('click', function() {
                    chunks_{{ $entrega->id }} = [];
                    mediaRecorder_{{ $entrega->id }}.start();
                    document.getElementById('startButton').disabled = true;
                    document.getElementById('stopButton').disabled = false;
                });
        
                document.getElementById('stopButton').addEventListener('click', function() {
                    mediaRecorder_{{ $entrega->id }}.stop();
                    document.getElementById('startButton').disabled = false;
                    document.getElementById('stopButton').disabled = true;
                });
            </script>
        
            @endif

    </div>
</div>
