@php
    $cuentas = ['', 'aleissy1@gmail.com', 'lassoa037@gmail.com', 'info@instel.edu.co', 'docente2@instel.edu.co'];
@endphp
<div class="box box-info padding-1">
    <div class="box-body row">
        
        <div class="form-group col-4">
            <label for="">Seminario</label>
            <select class="form-select" name="prg" id="prg" required>
                <option selected>Seleccionar</option>
                @foreach ($seminarList as $item)
                <option value="{{ $item->id }}"@if ($item->id == $dataSeminar->prg) selected @endif>{{ $item->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-4">
            {{ Form::label('sesionID') }}
            {{ Form::text('sesionID', $dataSeminar->sesionID, ['class' => 'form-control' . ($errors->has('sesionID') ? ' is-invalid' : ''), 'placeholder' => 'Sesionid']) }}
            {!! $errors->first('sesionID', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group col-4">
            <label for="">Docente</label>
            <select class="form-select" name="docente" id="docente" required>
                <option selected>Seleccionar</option>
                @foreach ($docentes as $item)
                    <option value="{{$item->id}}"@if ($item->id == $dataSeminar->docente) selected @endif>{{$item->nombres.' '.$item->apellidos}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-4">
              <label for="" >Instructivo de la Sesión en PDF</label>
              <input type="file" class="form-control" name="documento" accept="application/pdf">
        </div>
        <div class="form-group col-4">
            {{ Form::label('Sala Zoom') }}
            {{ Form::text('zoom', $dataSeminar->zoom, ['class' => 'form-control' . ($errors->has('zoom') ? ' is-invalid' : ''), 'placeholder' => 'zoom']) }}
            {!! $errors->first('zoom', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        
        <div class="form-group col-4">
            <label for="">Cuenta Zoom</label>
            <select class="form-select" name="cuentaZoom" id="cuentaZoom">
                @foreach ($cuentas as $item)
                    <option value="{{ $item }}"@if ($item == $dataSeminar->cuentaZoom) selected @endif>{{ $item }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group col-4">
            {{ Form::label('tipo de actividad') }}
            {!! Form::select('tareaTipo', ['texto' => 'Texto','audio' => 'audio','pdf' => 'PDF','link' => 'Link de YouTube'], $dataSeminar->tareaTipo, ['class' => 'form-control']) !!}
            {!! $errors->first('tareaTipo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        
        <div class="form-group col-12">
            {{ Form::label('enunciado de la actividad') }}
            {!! Form::textarea('tarea', $dataSeminar->tarea, ['class' => 'form-control']) !!}
            {!! $errors->first('tarea', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>