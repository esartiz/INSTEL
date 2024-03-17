<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('materia') }}
            {{ Form::text('materia', $matricula->materia, ['class' => 'form-control' . ($errors->has('materia') ? ' is-invalid' : ''), 'placeholder' => 'Materia']) }}
            {!! $errors->first('materia', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estudiante') }}
            {{ Form::text('estudiante', $matricula->estudiante, ['class' => 'form-control' . ($errors->has('estudiante') ? ' is-invalid' : ''), 'placeholder' => 'Estudiante']) }}
            {!! $errors->first('estudiante', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('avance') }}
            {{ Form::text('avance', $matricula->avance, ['class' => 'form-control' . ($errors->has('avance') ? ' is-invalid' : ''), 'placeholder' => 'Avance']) }}
            {!! $errors->first('avance', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('status') }}
            {{ Form::text('status', $matricula->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>