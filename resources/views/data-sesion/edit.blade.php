@php
    $cuentas = ['aleissy1@gmail.com', 'lassoa037@gmail.com', 'info@instel.edu.co', 'docente2@instel.edu.co'];
@endphp
<form class="row changeSessionSem" method="POST" action="{{ route('data-sesions.update', $dataSesion->id) }}"
    dtInf="{{ $dataSesion->id }}" enctype="multipart/form-data">
    {{ method_field('PATCH') }}
    @csrf
    <div class="col-6">
        <label class="text-muted">Link Zoom:</label>
        <div class="input-group mb-3">
            <select class="form-select form-select-sm" name="cuentaZoom">
                <option value="">Cuenta Zoom</option>
                @foreach ($cuentas as $item)
                    <option value="{{ $item }}" @if ($item == $dataSesion->cuentaZoom) selected @endif>
                        {{ $item }}</option>
                @endforeach
            </select>
            <input type="number" class="form-control input-sm" name="zoom" value="{{ $dataSesion->zoom }}">
        </div>
    </div>
    <div class="col-6">
        <label class="text-muted">Docente:</label>
        <select class="form-select form-select-sm" name="docente">
            @php
                foreach ($listaDocente as $item) {
                    echo '<option value="' . $item->id . '"' . ($item->id == $dataSesion->docente ? ' selected' : '') . '>' . $item->apellidos . ' ' . $item->nombres . '</option>';
                }
            @endphp
        </select>
    </div>
    <div class="col-4">
        <label class="text-muted">Fecha:</label>
        <input type="date" class="form-control" name="fecha" value="{{ $dataSesion->fecha }}">
    </div>
    <div class="col-8">
        <label class="text-muted">Repositorio:</label>
        <input type="text" class="form-control" name="repositorio" value="{{ $dataSesion->repositorio }}">
    </div>
    <div class="col-12">
        <label class="text-muted">Retroalimentación:</label>
        <textarea class="form-control" name="retro" rows="3">{{ $dataSesion->retro }}</textarea>
    </div>
    <div class="d-grid gap-2" style="margin: 10px">
        <button type="submit" class="btn btn-success" id="bt_{{ $dataSesion->id }}">Modificar</button>
    </div>
</form>
