<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('ini') }}
            {{ Form::text('ini', $crono->ini, ['class' => 'form-control' . ($errors->has('ini') ? ' is-invalid' : ''), 'placeholder' => 'Ini']) }}
            {!! $errors->first('ini', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fin') }}
            {{ Form::text('fin', $crono->fin, ['class' => 'form-control' . ($errors->has('fin') ? ' is-invalid' : ''), 'placeholder' => 'Fin']) }}
            {!! $errors->first('fin', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $crono->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>