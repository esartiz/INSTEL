<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('user') }}
            {{ Form::text('user', $fBill->user, ['class' => 'form-control' . ($errors->has('user') ? ' is-invalid' : ''), 'placeholder' => 'User']) }}
            {!! $errors->first('user', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('valor') }}
            {{ Form::text('valor', $fBill->valor, ['class' => 'form-control' . ($errors->has('valor') ? ' is-invalid' : ''), 'placeholder' => 'Valor']) }}
            {!! $errors->first('valor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cuotas') }}
            {{ Form::text('cuotas', $fBill->cuotas, ['class' => 'form-control' . ($errors->has('cuotas') ? ' is-invalid' : ''), 'placeholder' => 'Cuotas']) }}
            {!! $errors->first('cuotas', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('saldo') }}
            {{ Form::text('saldo', $fBill->saldo, ['class' => 'form-control' . ($errors->has('saldo') ? ' is-invalid' : ''), 'placeholder' => 'Saldo']) }}
            {!! $errors->first('saldo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha') }}
            {{ Form::text('fecha', $fBill->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
            {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>