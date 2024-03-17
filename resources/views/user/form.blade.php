@php
    //LISTA OPCIONES
    $tipodoc = Session::get('config')['tipodoc'];
    $sexo = Session::get('config')['sexo'];
    $rol = Session::get('config')['rol'];
    $nombrePeriodos = Session::get('config')['nombrePeriodos'];
    $periodosLetra = Session::get('config')['gruposNombre'];
    $ciclo = Session::get('config')['ciclos'];
    
    $codPYY = substr($user->cod, 0, 4);
    $codPPP = substr($user->cod, 4, 1);
    $codEst = substr($user->cod, -4);
    $isEdit = '';
@endphp
{!! $user->msjIni !!}
<div class="box box-info padding-1 row">
    <div class="col-md-3">
        <img id="output" src="{{ route('ft', 'profiles|0|' . $user->cod . '.jpg?' . date('YmdHis')) }}" class="img-fluid"
            onerror="this.src='{{ route('ft', 'profiles|0|no-pic.jpg') }}';" />
    </div>
    <div class="col-md-9">
        <div class="box-body row justify-content-md-center">

            <div class="form-group col-4">
                <select class="form-select" name="rol" id="">
                    @foreach ($rol as $item)
                        <option value="{{ $item }}" @if ($item == $user->rol) selected @endif>
                            {{ $item }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Rol Usuario</small>
            </div>

            <div class="form-group col-4">
                <input type="text" class="form-control" name="nombres" value="{{ $user->nombres }}" id=""
                    onchange="generarCodigo()" required>
                <small class="form-text text-muted">Nombres</small>
            </div>

            <div class="form-group col-4">
                <input type="text" class="form-control" name="apellidos" value="{{ $user->apellidos }}"
                    id="" required>
                <small class="form-text text-muted">Apellidos</small>
            </div>

            <div class="form-group col-3">
                <select class="form-select" name="tipoDoc" id="tipoDoc">
                    @foreach ($tipodoc as $item)
                        <option value="{{ $item }}" @if ($item == $user->tipoDoc) selected @endif>
                            {{ $item }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Tipo Doc</small>
            </div>

            <div class="form-group col-5">
                <input type="text" class="form-control" name="doc" value="{{ $user->doc }}" id=""
                    required>
                <small class="form-text text-muted">Número Documento</small>
            </div>

            <div class="form-group col-4">
                <input type="text" class="form-control" name="doc_ex" value="{{ $user->doc_ex }}" id=""
                    required>
                <small class="form-text text-muted">Lugar de Expedición</small>
            </div>

            @php
                $otraPer1 = '';
                $otraPer2 = '';
                $otraPer3 = '';
                if ($user->otraPer != null) {
                    $otraPer1 = json_decode($user->otraPer)->nombre;
                    $otraPer2 = json_decode($user->otraPer)->doc;
                    $otraPer3 = json_decode($user->otraPer)->doc_ex;
                }
            @endphp
            <div class="row hide" id="extraDoc" style="background-color: rgb(249, 249, 234)">
                <div class="col-4">
                    <input type="text" class="form-control" name="otPr1" value="{{ $otraPer1 }}"
                        id="">
                    <small class="form-text text-muted">Representante legal</small>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" name="otPr2" value="{{ $otraPer2 }}"
                        id="">
                    <small class="form-text text-muted">Documento Representante</small>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" name="otPr3" value="{{ $otraPer3 }}"
                        id="">
                    <small class="form-text text-muted">Expedición Doc Rep.</small>
                </div>
            </div>

            <div class="form-group col-4">
                <input type="date" class="form-control" name="fecha_nac" value="{{ $user->fecha_nac }}"
                    id="" required>
                <small class="form-text text-muted">Fecha de Nacimiento</small>
            </div>

            <div class="form-group col-4">
                <select class="form-select" name="sexo" id="">
                    @foreach ($sexo as $item)
                        <option value="{{ $item }}" @if ($item == $user->sexo) selected @endif>
                            {{ $item }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Sexo</small>
            </div>

            <div class="form-group col-4">
                <input type="file" onchange="loadFile(event)" class="form-control" name="fotoPerfil" accept="image/*"
                    id="" placeholder="" aria-describedby="fileHelpId">
                <div id="fileHelpId" class="form-text">Foto 3x4</div>
            </div>

            <div class="form-group col-6">
                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                <small class="form-text text-muted">Correo Electrónico</small>
            </div>

            <div class="form-group col-6">
                <input type="number" class="form-control" name="telefono" value="{{ $user->telefono }}" required>
                <small class="form-text text-muted">Teléfono</small>
            </div>

            <div class="form-group col-4">
                <select class="form-select form-select" name="" id="cod1" onchange="generarCodigo()"
                    {{ $isEdit }}>
                    @for ($i = 2000; $i <= date('Y') + 1; $i++)
                        @for ($j = 1; $j < count($nombrePeriodos); $j++)
                            <option value="{{ $i . $j }}" @if ($i == $codPYY && $j == $codPPP) selected @endif>
                                {{ $i }} - {{ $nombrePeriodos[$j] }}</option>
                        @endfor
                    @endfor
                    <option value="20001" @if ($codPYY . $codPPP == '20001') selected @endif>DOCENTE</option>
                    <option value="20000" @if ($codPYY . $codPPP == '20000') selected @endif>ADMIN</option>
                </select>
                <small class="form-text text-muted">Periodo de Ingreso</small>
            </div>
        
            <div class="form-group col-2">
                <input type="number" onchange="generarCodigo()" id="cod2" maxlength="4" placeholder="1234"
                    value="{{ $codEst }}" class="form-control" id="codTxt" required {{ $isEdit }}>
                <small class="form-text text-muted">Cód. Matrícula</small>
            </div>
        
            <input type="hidden" name="cod" id="elCodigo">
        </div>
    </div>
</div>

<div class="box-footer mt20" style="text-align: right">
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> GUARDAR
        INFORMACIÓN</button>
</div>
