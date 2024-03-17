@if (Auth::user()->misSesiones()->count() > 0)
    <!-- Sesiones de seminario -->
    <div class="row" style="margin-top: 20px">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Tienes <b>{{ Auth::user()->misSesiones()->count() }} Sesiones</b> de seminario por desarrollar
                </div>
                <div class="card-body row">

                    @foreach (Auth::user()->misSesiones() as $item)
                        @if ($guiaSeminar !== $item->dataSeminar()->programa()->id)
                            @if (!$loop->first)
                </div>
            </div>
@endif
@php $sesionAhora = true @endphp
<div class="col-md-4"
    style="background-repeat: no-repeat; background-position:top center; background-image: url(https://www.instel.edu.co/uploads/{{ $item->dataSeminar()->programa()->imageProfile }})">
    <div style="background-color: #bb2d3b; color:#FFF">SEMINARIO-TALLER</div>
    <div
        style="background-color: #FFF; font-size:30px; background-color: #FFFFFFC2; font-weight: 900; padding: 18px; text-transform:uppercase; line-height:30px; color: #00468C">
        {{ $item->dataSeminar()->programa()->nombre }}</div>
</div>
<div class="col-md-8">
    <div class="list-group">
        @endif
        @php
            $guiaSeminar = $item->dataSeminar()->programa()->id;
        @endphp
        <div class="list-group-item list-group-item-action @if ($item->fecha < date('Y-m-d')) cardSeminarActive @endif"
            aria-current="true">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                    @if ($item->retro)
                        <i class="fa-solid fa-circle-check"></i>
                    @endif {{ $item->dataSeminar()->sesionID }}
                </h5>
                <small class="forFecha" dt-fmt="0" dt-f="{{ $item->fecha }}"></small>
            </div>
            <p class="mb-1">Docente: {{ ($item->docente()->nombres ?? 'Por') . ' ' . ($item->docente()->apellidos ?? ' asignar') }}</p>

            <div class="d-flex flex-row-reverse">
                @if ($item->retro)
                    <button onclick="verRetro(this)" type="button" data-rt="{{ $item->retro }}"
                        data-de="{{ $item->docente()->nombres . ' ' . $item->docente()->apellidos }}"
                        class="btn btn-sm col-md-3 btn-danger">
                        <i class="fa-solid fa-comment-dots"></i> Retroalimentación
                    </button>
                @endif
                @if ($item->fecha < date('Y-m-d'))
                    @if ($item->repositorio != null)
                        <a href="https://drive.google.com/file/d/{{ $item->repositorio }}/view" target="_blank"
                            class="col-6 col-md-3 btn btn-sm btn-outline-primary"><i
                                class="fa-solid fa-clapperboard"></i> Video Clase</a>
                    @endif
                    @if ($item->dataSeminar()->tarea != null)
                        @if ($item->envio != null)
                            <a class="col-12 col-md-3 btn btn-sm btn-success"><i class="fa-solid fa-circle-check"></i>
                                Entregada</a>
                        @else
                            <a href="{{ route('vertarea.seminario', $item->dataSeminar()->id) }}"
                                class=" col-12 col-md-3 btn btn-sm btn-outline-success"><i
                                    class="fa-solid fa-thumbtack"></i> Actividad</a>
                        @endif
                    @endif
                @else
                    @if ($sesionAhora == true)
                        @if ($item->zoom != null)
                            <a href="https://us02web.zoom.us/j/{{ $item->zoom }}"
                                class=" col-12 col-md-3 btn-sm btn btn-warning"><i
                                    class="fa-solid fa-chalkboard-user"></i> Sala Zoom</a>
                        @endif
                        @if (Storage::exists('userfiles/seminarios/' . $item->dataSeminar()->recurso . '.pdf'))
                            <a href="{{ route('ft', 'seminarios|' . $item->dataSeminar()->recurso . '.pdf') }}"
                                target="_blank" class=" col-12 col-md-3 btn-sm btn btn-success"><i
                                    class="fa-regular fa-file-pdf"></i> Lectura</a>
                        @endif
                        @php $sesionAhora = false @endphp
                    @endif
                @endif
            </div>


        </div>
        @endforeach
    </div>
</div>
</div>
</div>
</div>
</div>
@endif
