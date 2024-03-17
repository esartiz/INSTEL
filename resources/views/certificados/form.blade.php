<div class="box box-info padding-1">
    <div class="box-body row">
        
        <div class="form-group col-md-12">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $graduando->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group col-md-2">
            {{ Form::label('tipoDoc') }}
            {{ Form::text('tipoDoc', $graduando->tipoDoc, ['class' => 'form-control' . ($errors->has('tipoDoc') ? ' is-invalid' : ''), 'placeholder' => 'Tipodoc']) }}
            {!! $errors->first('tipoDoc', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group col-md-5">
            {{ Form::label('documento') }}
            {{ Form::text('documento', $graduando->documento, ['class' => 'form-control' . ($errors->has('documento') ? ' is-invalid' : ''), 'placeholder' => 'Documento']) }}
            {!! $errors->first('documento', '<div class="invalid-feedback">:message</div>') !!}
        </div>
       
        <div class="form-group col-md-5">
            {{ Form::label('lugar_exp') }}
            {{ Form::text('lugar_exp', $graduando->lugar_exp, ['class' => 'form-control' . ($errors->has('lugar_exp') ? ' is-invalid' : ''), 'placeholder' => 'Lugar Exp']) }}
            {!! $errors->first('lugar_exp', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('tel') }}
            {{ Form::text('tel', $graduando->tel, ['class' => 'form-control' . ($errors->has('tel') ? ' is-invalid' : ''), 'placeholder' => 'Tel']) }}
            {!! $errors->first('tel', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-8">
            {{ Form::label('correo') }}
            {{ Form::text('correo', $graduando->correo, ['class' => 'form-control' . ($errors->has('correo') ? ' is-invalid' : ''), 'placeholder' => 'Correo']) }}
            {!! $errors->first('correo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-6">
            <div class="mb-3">
                <label for="" class="form-label">Programa</label>
                <select class="form-select" name="programa" id="">
                    @foreach ($programas as $item)
                        <option value="{{ $item->nombre }}" @if ($item->nombre == $graduando->programa) selected @endif>{{ $item->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group col-md-3">
            {{ Form::label('intensidad') }}
            {{ Form::text('intensidad', $graduando->intensidad, ['class' => 'form-control' . ($errors->has('intensidad') ? ' is-invalid' : ''), 'placeholder' => 'Intensidad']) }}
            {!! $errors->first('intensidad', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-3">
            {{ Form::label('fecha') }}
            {{ Form::date('fecha', $graduando->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
            {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        
        <input type="hidden" name="idUnico" value="{{$graduando->idUnico}}">

    </div>

    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">GUARDAR</button>
    </div>
</div>