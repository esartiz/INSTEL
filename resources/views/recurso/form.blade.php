<div class="box box-info padding-1">
    <div class="box-body row">
        <div class="form-group">
            <div class="mb-3">
              <label for="titulo" class="form-label">Nombre del Recurso</label>
              <input type="text" class="form-control" name="titulo" id="titulo" value="{{$recurso->titulo}}">
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('titulo') }}
            {{ Form::text('titulo', $recurso->titulo, ['class' => 'form-control' . ($errors->has('titulo') ? ' is-invalid' : ''), 'placeholder' => 'Titulo']) }}
            {!! $errors->first('titulo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tipo') }}
            {{ Form::text('tipo', $recurso->tipo, ['class' => 'form-control' . ($errors->has('tipo') ? ' is-invalid' : ''), 'placeholder' => 'Tipo']) }}
            {!! $errors->first('tipo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('file') }}
            {{ Form::text('file', $recurso->file, ['class' => 'form-control' . ($errors->has('file') ? ' is-invalid' : ''), 'placeholder' => 'File']) }}
            {!! $errors->first('file', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>