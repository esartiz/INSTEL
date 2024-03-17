<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group">
            {{ Form::hidden('seminarID', $dataSesion->seminarID, ['class' => 'form-control' . ($errors->has('seminarID') ? ' is-invalid' : ''), 'placeholder' => 'Seminarid']) }}
            {!! $errors->first('seminarID', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('repositorio') }}
            {{ Form::text('repositorio', $dataSesion->repositorio, ['id' => 'g_ruta', 'class' => 'form-control' . ($errors->has('repositorio') ? ' is-invalid' : ''), 'placeholder' => 'Repositorio url', 'onchange' => 'formatURLDrive()']) }}
            {!! $errors->first('repositorio', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('fecha de la sesión') }}
            {{ Form::text('fecha', $dataSesion->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
            {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::hidden('envio', $dataSesion->envio, ['class' => 'form-control' . ($errors->has('envio') ? ' is-invalid' : ''), 'placeholder' => 'Envio']) }}
            {!! $errors->first('envio', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('retroalimentación') }}
            {{ Form::text('retro', $dataSesion->retro, ['class' => 'form-control' . ($errors->has('retro') ? ' is-invalid' : ''), 'placeholder' => 'Retro']) }}
            {!! $errors->first('retro', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::hidden('status', $dataSesion->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>