<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('user') }}
            {{ Form::text('user', $fConcepto->user, ['class' => 'form-control' . ($errors->has('user') ? ' is-invalid' : ''), 'placeholder' => 'User']) }}
            {!! $errors->first('user', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('idRecibo') }}
            {{ Form::text('idRecibo', $fConcepto->idRecibo, ['class' => 'form-control' . ($errors->has('idRecibo') ? ' is-invalid' : ''), 'placeholder' => 'Idrecibo']) }}
            {!! $errors->first('idRecibo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('idConcepto') }}
            {{ Form::text('idConcepto', $fConcepto->idConcepto, ['class' => 'form-control' . ($errors->has('idConcepto') ? ' is-invalid' : ''), 'placeholder' => 'Idconcepto']) }}
            {!! $errors->first('idConcepto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha') }}
            {{ Form::text('fecha', $fConcepto->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
            {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $fConcepto->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('documento') }}
            {{ Form::text('documento', $fConcepto->documento, ['class' => 'form-control' . ($errors->has('documento') ? ' is-invalid' : ''), 'placeholder' => 'Documento']) }}
            {!! $errors->first('documento', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('formaPago') }}
            {{ Form::text('formaPago', $fConcepto->formaPago, ['class' => 'form-control' . ($errors->has('formaPago') ? ' is-invalid' : ''), 'placeholder' => 'Formapago']) }}
            {!! $errors->first('formaPago', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('observ') }}
            {{ Form::text('observ', $fConcepto->observ, ['class' => 'form-control' . ($errors->has('observ') ? ' is-invalid' : ''), 'placeholder' => 'Observ']) }}
            {!! $errors->first('observ', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('dto') }}
            {{ Form::text('dto', $fConcepto->dto, ['class' => 'form-control' . ($errors->has('dto') ? ' is-invalid' : ''), 'placeholder' => 'Dto']) }}
            {!! $errors->first('dto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('valor') }}
            {{ Form::text('valor', $fConcepto->valor, ['class' => 'form-control' . ($errors->has('valor') ? ' is-invalid' : ''), 'placeholder' => 'Valor']) }}
            {!! $errors->first('valor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('concept') }}
            {{ Form::text('concept', $fConcepto->concept, ['class' => 'form-control' . ($errors->has('concept') ? ' is-invalid' : ''), 'placeholder' => 'Concept']) }}
            {!! $errors->first('concept', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>