@php
    $criterios = ["Conocimiento del tema", "Solvencia Expresiva", "Calidad del Trabajo", "Orden y Coherencia", "Calidad de las estrategias formuladas"];
@endphp

@extends('layouts.instel')
@section('template_title') Pruebas de Aptitud @endsection
@section('content')
<div class="container">
    <h3>Informe Final de Resultado Académico</h3>
    <form action="{{ route('pruebas-aptitud.valorar', 0) }}" method="post">
        @csrf
        @method('POST')
    <div class="row">
        <div class="col-md-4">
            <b>Seleccione el/los estudiante/s</b>
            <div id="listaEstudiantes" class="d-flex flex-column">
            @foreach ($estudiantes as $estudiante)
                @if ($estudiante->getEstudiante()->misDocumentos()->where('descr', 'LIKE', '%INFINRSAC%')->count() == 0)
                <label style="font-weight: bold">
                @else
                <label style="color: rgb(160, 160, 160)">
                @endif
                <input type="checkbox" name="opciones[]" value="{{ $estudiante->getEstudiante()->id }}|{{ $estudiante->periodo }}"> {{ $estudiante->getEstudiante()->apellidos }} {{ $estudiante->getEstudiante()->nombres }}</label>

            @endforeach
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-8">
                    <b>Titulo del Trabajo:</b>
                    <input type="text" class="form-control" name="empresa" id="" placeholder="Nombre de la Empresa / Organización">
                </div>
                <div class="col-md-4">
                    <b>Fecha de la evaluación:</b>
                    <input type="date" class="form-control" name="fecha" id="" value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Criterio</th>
                            <th scope="col">Evaluación</th>
                            <th scope="col">Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($criterios as $item)
                        <tr class="">
                            <td scope="row">{{ $item }}</td>
                            <td>
                                <select class="form-select form-select-sm" name="criterio[]" id="" required>
                                    <option value="E">Excelente</option>
                                    <option value="MB">Muy Bueno</option>
                                    <option value="B">Bueno</option>
                                    <option value="A">Aceptable</option>
                                    <option value="D">Deficiente</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="obs[]" id="">
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td scope="row">Observación General</td>
                            <td colspan="2">
                                <div class="mb-3">
                                  <label for="" class="form-label"></label>
                                  <textarea class="form-control" name="observacion" id="" rows="3"></textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right">
                                <button type="submit" onclick="return confirm('¿Desea enviar esta valoración?.')" class="btn btn-primary">Guardar Resultado</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    </form>
</div>
@endsection

@section('scripts')
    <script>
        window.addEventListener('load', function() {
        // Obtén todas las etiquetas <label> que rodean las casillas de verificación
        const labels = document.querySelectorAll('label');

        // Convierte la NodeList en un arreglo y ordénalo alfabéticamente
        const labelsArray = Array.from(labels);
        labelsArray.sort((a, b) => {
            const textA = a.textContent.trim().toLowerCase();
            const textB = b.textContent.trim().toLowerCase();
            return textA.localeCompare(textB);
        });

        // Elimina las etiquetas <label> del documento
        labels.forEach(label => label.remove());
        $('#listaEstudiantes').empty();
        // Agrega las etiquetas ordenadas nuevamente al formulario
        labelsArray.forEach(label => {
            $('#listaEstudiantes').append(label);
        });
    });
    </script>
@endsection