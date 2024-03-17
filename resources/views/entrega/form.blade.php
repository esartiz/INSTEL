<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('de') }}
            {{ Form::text('de', $entrega->de, ['class' => 'form-control' . ($errors->has('de') ? ' is-invalid' : ''), 'placeholder' => 'De']) }}
            {!! $errors->first('de', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('modulo') }}
            {{ Form::text('modulo', $entrega->modulo, ['class' => 'form-control' . ($errors->has('modulo') ? ' is-invalid' : ''), 'placeholder' => 'Modulo']) }}
            {!! $errors->first('modulo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tarea') }}
            {{ Form::text('tarea', $entrega->tarea, ['class' => 'form-control' . ($errors->has('tarea') ? ' is-invalid' : ''), 'placeholder' => 'Tarea']) }}
            {!! $errors->first('tarea', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('respuesta') }}
            {{ Form::text('respuesta', $entrega->respuesta, ['class' => 'form-control' . ($errors->has('respuesta') ? ' is-invalid' : ''), 'placeholder' => 'Respuesta']) }}
            {!! $errors->first('respuesta', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('retro') }}
            {{ Form::text('retro', $entrega->retro, ['class' => 'form-control' . ($errors->has('retro') ? ' is-invalid' : ''), 'placeholder' => 'Retro']) }}
            {!! $errors->first('retro', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('status') }}
            {{ Form::text('status', $entrega->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>