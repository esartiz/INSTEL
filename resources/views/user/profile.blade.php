@php
    $miPrograma = (Auth::user()->misBoxMatriculas()->count() > 0 ? Auth::user()->misBoxMatriculas()->first()->getPrograma() : '' );
    $elPeriodo = (Auth::user()->misBoxMatriculas()->count() > 0 ? Auth::user()->misBoxMatriculas()->where('estado','ACTIVO')->first()->periodo : '' );
@endphp


@extends('layouts.instel')

@section('template_title')
    {{ Auth::user()->nombres . ' ' . Auth::user()->apellidos }} - Perfil
@endsection
@section('content')


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="container">
    <div class="row">
        <div class="col-md-4">
            Mis Documentos:
            <ul class="list-group list-group-numbered">
                <a class="list-group-item active" href="https://www.instel.edu.co/file/manual_convivencia.pdf" target="_blank">
                    Manual de Convivencia
                </a>

                @if($miPrograma->tipo !== "Seminario-Taller")
                <a class="list-group-item" href="/carne-estudiantil" target="_blank">
                    Carné Estudiantil
                </a>
                @endif

                @foreach (Auth::user()->misDocumentos()->get() as $itemDoc)
                @if (strpos($itemDoc->descr, '|') !== false)
                <a class="list-group-item" href="{{ route('verCertificado' , $itemDoc->file) }}" target="_blank">
                    @if(strpos($itemDoc->descr, 'pruebacomp') !== false)
                        Resultado Prueba {{ explode('|', $itemDoc->descr)[9] }}
                    @else
                    @if(strpos($itemDoc->descr, 'INFINRSAC') !== false)
                        Informe Final de Resultado Académico
                    @else
                        Certificado {{ explode('|', $itemDoc->descr)[0] }}
                    @endif
                    @endif
                </a>
                @else
                <a class="list-group-item" href="{{ route('ft', 'profiles|' . $itemDoc->file) }}" target="_blank">Ver Archivo
                    {{ $itemDoc->descr }}</a>
                @endif
                @endforeach
            </ul>
        </div>
        <div class="col-md-8">
            <div class="modal-body">
                <div class="row"
                    style="border-radius: 25px; background-image:url(/images/bg_blue1.jpg); padding: 20px; box-shadow: 10px 10px 5px rgb(203, 203, 203);">
                    <div class="col-4">
                        <div class="mb-3">
                            <img id="output"
                                src="{{ route('ft', 'profiles|0|' . Auth::user()->cod) }}.jpg?{{ date('YmdHis') }}"
                                class="img-fluid" onerror="this.src='{{ route('ft', 'profiles|0|no-pic.jpg') }}';" />
                            <div id="fileHelpId" class="form-text">La foto debe ser vertical</div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-12 text-center" style="margin: 15px 0px;">
                                <img src="/images/logo.png" class="img-fluid" style="margin-bottom: 10px">
                                @if (Auth::user()->rol == 'Estudiante')
                                    <h5>{{ $miPrograma->nombre }}</h5>
                                @endif
                            </div>
                            <div class="col-12 text-center">
                                <h3 style="font-weight: 900">{{ Auth::user()->nombres . ' ' . Auth::user()->apellidos }}
                                </h3>
                            </div>
                            <div class="col-6">
                                <small style="font-weight: 700">Documento de Identidad</small><br>
                                {{ Auth::user()->tipoDoc . ' ' . Auth::user()->doc . ' ' . ' de ' . Auth::user()->doc_ex }}
                            </div>
                            <div class="col-6">
                                <small style="font-weight: 700">Teléfono</small><br>
                                {{ Auth::user()->telefono }}
                            </div>
                            <div class="col-6">
                                <small style="font-weight: 700">Correo Electrónico</small><br>
                                {{ Auth::user()->email }}
                            </div>
                            <div class="col-6">
                                <small style="font-weight: 700">Fecha Nacimiento</small><br>
                                {{ Auth::user()->fecha_nac }}
                            </div>
                            <div class="col-12 text-center">
                                <small style="font-weight: 700">Código Estudiante</small><br>
                                <span style="font-size: 18px">{{ substr(Auth::user()->cod, -4) }}</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="container">
        <form method="POST" role="form" enctype="multipart/form-data" action="{{ route('estudiantedocs') }}" id="myProfile">
            @csrf
            <div class="col-md-4">
                @if(!Storage::exists("userfiles/profiles/0/".Auth::user()->cod.".jpg"))
                Foto 3x4<br>
                <small>La foto debe ser vertical con el rostro de frente y con un fondo de color blanco.<b> Si la foto no cumple con estos requisitos será devuelta</b></small>
                <input type="file" onchange="loadFile(event)" class="form-control" name="fotoPerfil" accept="image/*"
                    id="" placeholder="" aria-describedby="fileHelpId">
                @endif
            </div>
            <br>
            @if (Auth::user()->rol == 'Estudiante' && count($docReq) > 0)
                <h5>Documentos de matrícula</h5>
                <small>Seleccione los documentos que desea cargar y de clic en Guardar</small>
                <div class="row align-items-center">
                    @foreach ($docReq as $item)
                    @if ($item !== "Foto 3x4 tipo Carné")
                    <div class="col-md-4">
                        {{ $item }}<br>
                        <input type="file" class="form-control" name="file{{ $loop->iteration }}" accept=".pdf"
                            id="">
                        <input type="hidden" name="fileName{{ $loop->iteration }}" value="{{ $item }}">
                    </div>
                    @endif
                    @endforeach
                </div>
            <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
            @endif
            <br>
        </form>

        <hr>

        @php
            $codDoc = substr(Auth::user()->cod, -4) . '-' . $elPeriodo;
            $isCPS = Auth::user()
                ->misDocumentos()
                ->where('descr', 'LIKE', 'CSE ' . $codDoc);
            $isPag = Auth::user()
                ->misDocumentos()
                ->where('descr', 'LIKE', '%Pagaré ' . substr(Auth::user()->cod, -4) . '%');
        @endphp

        @if ($isCPS->count() + $isPag->count() > 0)
            <div class="container">
                <h5>Documentos para firma</h5>
                A continuación aparecerán los documentos requeridos con su firma, para ello debe completar los siguientes
                dos pasos:
                <ol>
                    <li>Descargue el documento a través del botón "Descargar"</li>
                    <li>Imprima el documento y fírmelo. Recuerde que puede también firmarlo digitalmente.</li>
                    <li>Una vez firmado el documento, haga clic en la ranura de "Seleccionar archivo" y cargue el documento
                        PDF firmado, una vez seleccionado se cargará automáticamente y será enviado.</li>
                    <li></li>
                </ol>

                @if ($isCPS->count() == 1)
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            Contrato de Prestación de Servicios Educativos
                        </div>
                        <div class="col-md-4">
                            <div class="d-grid gap-2">
                                <a href="{{ route('ft', 'profiles|' . $isCPS->first()->file) }}" target="_blank"
                                    type="button" name="" id=""
                                    class="btn btn-outline-primary">Descargar</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            Cargar Documento Firmado<br>
                            <form method="POST" role="form" enctype="multipart/form-data"
                                action="{{ route('estudiantedocs') }}">
                                @csrf
                                <input type="hidden" name="theFile" value="{{ $isCPS->first()->file }}">
                                <input type="file" class="form-control cargaDocFl" name="fileFirmado" accept=".pdf"
                                    id="">
                            </form>
                        </div>
                    </div>
                @endif
                @if ($isPag->count() == 1)
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            Pagaré
                        </div>
                        <div class="col-md-4">
                            <div class="d-grid gap-2">
                                <a href="{{ route('ft', 'profiles|' . $isPag->first()->file) }}" target="_blank"
                                    type="button" name="" id=""
                                    class="btn btn-outline-primary">Descargar</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <form method="POST" role="form" enctype="multipart/form-data"
                                action="{{ route('estudiantedocs') }}">
                                @csrf
                                Cargar Documento Firmado<br>
                                <input type="hidden" name="theFile" value="{{ $isPag->first()->file }}">
                                <input type="file" class="form-control cargaDocFl" name="fileFirmado" accept=".pdf"
                                    id="">
                            </form>
                        </div>
                    </div>
                @endif


            </div>
    </div>
    @endif


    <div class="modal fade" id="verPagareM" tabindex="-1" aria-labelledby="verPagareMLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="printRec" name="printf" src="" width="100%" height="600"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" id="imprimirContrato">Imprimir</button>
                </div>
            </div>
        </div>
    </div>

@endsection
