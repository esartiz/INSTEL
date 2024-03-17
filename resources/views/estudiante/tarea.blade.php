@php $i=1; $nDeEntregas = count(explode('|', $tarea->tipo_rta))-1; @endphp
@extends('layouts.instel')
@section('template_title')
    Entregar Actividad
@endsection
@section('content')

    @if ($tarea->modulo != "0")
    <form method="POST" action="{{ route('entregar') }}" class="container" enctype="multipart/form-data">
    @else
    <form method="POST" action="{{ route('entregar.seminario') }}" class="container" enctype="multipart/form-data">
    @endif

        @csrf
        <div class="card">
            <div class="card-header">
                <div class="d-flex bd-highlight">
                    <div class="p-2 bd-highlight">
                        <h3>{{ $tarea->enunciado }}</h3>
                        <small id="helpId" class="form-text text-muted">
                            Esta actividad debes entregarla entre el <span class="forFecha"
                                dt-f="{{ $tDesde }}"></span> hasta el <span class="forFecha"
                                dt-f="{{ $tLimite }}"></span>
                        </small>
                        <div class="alert alert-warning" role="alert" style="font-size: 12px; padding:2px; margin:0px">
                            <span id="timer_{{ $tarea->id }}"></span>
                        </div>

                        <script>
                            setInterval(function() {
                                var ddt = makeTimer("{{ $tLimite }}");
                                if (ddt == "0") {
                                    $('.entregaBody').html(" ");
                                    $("#timer_{{ $tarea->id }}").html("Se venció el plazo. Ya no es posible realizar la entrega.");
                                } else {
                                    $("#timer_{{ $tarea->id }}").html("Tienes " + ddt + " para realizar la entrega.");
                                }
                            }, 1000);
                        </script>

                        </small>
                    </div>
                    <div class="ms-auto p-2 bd-highlight">
                        @if ($tarea->modulo != "0")
                        <a href="{{ route('estudiante.md', $tarea->modulo) }}" class="btn btn-outline-primary">
                        @else
                        <a href="/" class="btn btn-outline-primary">
                        @endif
                            <i class="fa-solid fa-circle-chevron-left"></i> Regresar
                        </a><br><br>
                    </div>
                </div>
            </div>
            <div class="card-body row d-flex entregaBody">
                <div class="col-12 p-3">
                    @if ($tarea->tipo == 1)
                    <a href="{{ route('ft', 'files|au|'.$tarea->isAU) }}" target="_blank">
                        <h4>Ver indicaciones de la actividad</h4>
                    </a>
                    @endif
                    <p>Tenga en cuenta que al dar <b>REALIZAR ENTREGA</b> se enviarán todas las entregas, por lo tanto debe estar seguro(a) de realizar el envío.</p>
                    <div class="accordion accordion-flush" id="kindTask">

                        @if ((str_contains($tarea->tipo_rta, 'pdf')) || (str_contains($tarea->tipo_rta, 'texto')))
                        <input type="hidden" name="totalPDF" id="totalPDF">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                        aria-controls="flush-collapseTwo">
                                        {{ $i++ }}. ENTREGAR ARCHIVO EN PDF (Portable Document Format)
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#kindTask">
                                    <div class="accordion-body">
                                        <b>Tenga en cuenta que</b>
                                        <ul>
                                            <li>Si ha creado la actividad en Word puede guardar el archivo como PDF a través
                                                de la función "Imprimir" y luego
                                                "Imprimir como PDF"</li>
                                            <li>Puede convertir su documento de Word a través de un conversor gratuito en
                                                internet,
                                                como lo es por ejemplo
                                                <a href="https://www.ilovepdf.com/es/word_a_pdf" target="_blank">I love
                                                    PDF</a>
                                            </li>
                                            <li>Si ha realizado su trabajo en algún servicio de la nube como Google
                                                Documents o One
                                                Drive, puede
                                                descargar una copia en PDF.</li>
                                            <li><b>Recuerde que si carga un archivo que no sea PDF, la entrega no la podrá visualizar el docente</b></li>
                                        </ul>
                                        <hr>
                                        <div class="mb-3 boxPDF"></div>
                                        <div style="text-align: right">
                                            <button onclick="addPDF()" type="button" id="pdfCounter" class="btn btn-primary" role="button">Cargar otro PDF</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ((str_contains($tarea->tipo_rta, 'link')) || (str_contains($tarea->tipo_rta, 'audio')))
                        <input type="hidden" name="totalLink" id="totalLink">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseFour" aria-expanded="false"
                                        aria-controls="flush-collapseFour">
                                        {{ $i++ }}. ENTREGUE LINK EXTERNO (Ej. de YouTube)
                                    </button>
                                </h2>
                                <div id="flush-collapseFour" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-headingFour" data-bs-parent="#kindTask">
                                    <div class="accordion-body">
                                        Esta actividad requiere que pegue un link externo. <br>
                                        Si se trata de un video de <b>YouTube</b>, tenga en cuenta pegar la dirección 
                                        del video como aparece en el navegador. Ejemplo: https://www.youtube.com/watch?v=VeHxgX67J3s<br><br>
                                        Si desea cargar un <b>Audio</b> y compartir el link de la grabación puede hacerlo en cualquier
                                        plataforma. Sugerimos 
                                        <a href="https://www.soundcloud.com" target="_blank" style="font-weight:bold; color: orangered;">
                                        SoundCloud</a> aquí te compartimos una 
                                        <a href="https://virtual.instel.edu.co/uploads/ayuda-soundcloud.pdf" target="_blank" style="font-weight:bold; color: orangered;">
                                        ayuda sencilla que te guiará
                                        </a>
                                        paso a paso.
                                        <hr>
                                        <div class="mb-3 boxLink"></div>
                                        <div style="text-align: right">
                                            <button onclick="addLink()" type="button" id="pdfCounter" class="btn btn-primary" role="button">Cargar otro Link</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <button type="submit" class="btn btn-success" onclick="return confirm('¿Está seguro de agregar la información suficiente para la entrega?')">REALIZAR ENTREGA</button>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('scripts')
    <script>
        let nPDF = 0;
        let nLink = 0;
        let limite = 4;
        function addPDF(){
            if(nPDF <= limite){
                nPDF++;
                $('.boxPDF').append('<label for="" class="form-label">Archivo ' + nPDF + '</label><input type="file" class="form-control" onchange="upFileTemp(this)" name="pdf_' + nPDF + '" placeholder="" accept="application/pdf">');
            } else {
                alert("No se pueden cargar más de 5 archivos")
            }
            $('#totalPDF').val(nPDF);
        }
        function addLink(){
            if(nLink <= limite){
                nLink++;
                $('.boxLink').append('<label for="" class="form-label">Link ' + nLink + '</label><input type="text" class="form-control" name="link_' + nLink + '" required>');
            } else {
                alert("No se pueden cargar más de 5 links")
            }
            $('#totalLink').val(nLink);
        }

        function upFileTemp(tt){
            const fileName = tt.value;
            const fileExtension = fileName.split('.').pop().toLowerCase();
            const allowedExtensions = ['pdf'];

            if (!allowedExtensions.includes(fileExtension)) {
                alert('El archivo cargado NO ES PDF. Si envía un archivo distinto a PDF, el docente no podrá visualizarlo. Convierta el archivo en PDF e inténtelo de nuevo.');
                fileInput.value = ''; // Clear the file input
                return false;
            }

            // Submit the form or perform any other necessary action
            return true;
        }
        
        addPDF();
        addLink();
        
    </script>
@endsection
