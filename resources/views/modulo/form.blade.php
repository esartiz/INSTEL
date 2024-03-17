@php
$moduloFechas = explode('|',$modulo->fechas);
$moduloSemanas = explode('|',$modulo->semanas);
@endphp

<div class="box box-info padding-1">
    <div class="box-body row">
        <div class="col-md-4">
            <img src="{{ route('ft','img|modulos|'.$modulo->image )}}" alt="" id="output" class="img-fluid">
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="mb-3">
                      <label for="" class="form-label">Nombre del Módulo</label>
                      <input type="text" class="form-control" name="titulo" id="titulo" value="{{ $modulo->titulo }}" required>
                    </div>
                </div>
                
                <div class="form-group col-md-12">
                    <div class="mb-3">
                        <label for="programa" class="form-label">Programa Académico</label>
                        <select class="form-select" name="programa" id="prgID">
                            @foreach ($ofertaAcademica as $item)
                            <option value="{{ $item->id }}" myInfo="{{ $item->estructura }}" @if ($modulo->programa == $item->id) selected @endif>{{ $item->nombre }} ({{ $item->tipo }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group col-md-6">
                    <div class="mb-3">
                        <input type="hidden" id="guiaCiclo" value="{{ $modulo->ciclo }}">
                        <label for="" class="form-label">Ciclo Académico</label>
                        <select class="form-select" name="ciclo" id="cicloID"></select>
                    </div>
                </div>
        
                <div class="form-group col-6">
                    <div class="mb-3">
                      <label for="" class="form-label">Imagen del Módulo</label>
                      <input type="file" class="form-control" name="image" onchange="loadFile(event)" id="image" accept="image/*" @if (!$modulo->image) required @endif>
                      <br>
                    </div>
                </div>

                <div class="form-group col-12">
                    <div class="mb-3">
                      <label for="descripcion" class="form-label">Breve descripción del módulo</label>
                      <textarea class="form-control" name="descripcion" id="descripcion" rows="8">{{ $modulo->descripcion }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group col-12">
    <h4>Temporalidad del Módulo</h4>
    <h4>Fechas de Inicio / Semanas</h4>
    <div class="row mb-3">
        @for ($i = 1; $i < count($moduloFechas); $i++)
        <div class="col-md-3">
            Grupo {{ Session::get('config')['gruposNombre'][$i] }} ({{ Session::get('config')['nombrePeriodos'][$i] }})
            <div class="input-group">
                <input type="date" name="fecha_{{ $i }}" id="fechaIniMod_{{ Session::get('config')['gruposNombre'][$i] }}" class="form-control" value="{{ isset($moduloFechas[$i]) ? $moduloFechas[$i] : '' }}">
                <select name="semana_{{ $i }}" id="numSemMod_{{ Session::get('config')['gruposNombre'][$i] }}" onchange="creaSemanas('{{ Session::get('config')['gruposNombre'][$i] }}')" class="custom-select input-group-append" style="width: auto;">
                    @foreach (range(1, 10) as $numero)
                    <option value="{{ $numero }}" {{ isset($moduloSemanas[$i]) && $moduloSemanas[$i] == $numero ? 'selected' : '' }}>{{ $numero }}</option>
                    @endforeach
                </select>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Sm</th>
                        <th scope="col">Fecha</th>
                    </tr>
                </thead>
                <tbody id="resultTime_{{ Session::get('config')['gruposNombre'][$i] }}" style="font-size: 12px">
                </tbody>
            </table>
        </div>
        @endfor
    </div>
</div>

<div class="box-footer mt20">
    <button type="submit" class="btn btn-primary">GUARDAR INFORMACIÓN</button>
</div>