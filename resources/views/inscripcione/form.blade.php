<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $inscripcione->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('programa') }}
            {{ Form::text('programa', $inscripcione->programa, ['class' => 'form-control' . ($errors->has('programa') ? ' is-invalid' : ''), 'placeholder' => 'Programa']) }}
            {!! $errors->first('programa', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tipo_programa') }}
            {{ Form::text('tipo_programa', $inscripcione->tipo_programa, ['class' => 'form-control' . ($errors->has('tipo_programa') ? ' is-invalid' : ''), 'placeholder' => 'Tipo Programa']) }}
            {!! $errors->first('tipo_programa', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fechaNac') }}
            {{ Form::text('fechaNac', $inscripcione->fechaNac, ['class' => 'form-control' . ($errors->has('fechaNac') ? ' is-invalid' : ''), 'placeholder' => 'Fechanac']) }}
            {!! $errors->first('fechaNac', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('edad') }}
            {{ Form::text('edad', $inscripcione->edad, ['class' => 'form-control' . ($errors->has('edad') ? ' is-invalid' : ''), 'placeholder' => 'Edad']) }}
            {!! $errors->first('edad', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('lugarNace') }}
            {{ Form::text('lugarNace', $inscripcione->lugarNace, ['class' => 'form-control' . ($errors->has('lugarNace') ? ' is-invalid' : ''), 'placeholder' => 'Lugarnace']) }}
            {!! $errors->first('lugarNace', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estadoCivil') }}
            {{ Form::text('estadoCivil', $inscripcione->estadoCivil, ['class' => 'form-control' . ($errors->has('estadoCivil') ? ' is-invalid' : ''), 'placeholder' => 'Estadocivil']) }}
            {!! $errors->first('estadoCivil', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('doc') }}
            {{ Form::text('doc', $inscripcione->doc, ['class' => 'form-control' . ($errors->has('doc') ? ' is-invalid' : ''), 'placeholder' => 'Doc']) }}
            {!! $errors->first('doc', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('lugarReside') }}
            {{ Form::text('lugarReside', $inscripcione->lugarReside, ['class' => 'form-control' . ($errors->has('lugarReside') ? ' is-invalid' : ''), 'placeholder' => 'Lugarreside']) }}
            {!! $errors->first('lugarReside', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('telefono') }}
            {{ Form::text('telefono', $inscripcione->telefono, ['class' => 'form-control' . ($errors->has('telefono') ? ' is-invalid' : ''), 'placeholder' => 'Telefono']) }}
            {!! $errors->first('telefono', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('correo') }}
            {{ Form::text('correo', $inscripcione->correo, ['class' => 'form-control' . ($errors->has('correo') ? ' is-invalid' : ''), 'placeholder' => 'Correo']) }}
            {!! $errors->first('correo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('direccion') }}
            {{ Form::text('direccion', $inscripcione->direccion, ['class' => 'form-control' . ($errors->has('direccion') ? ' is-invalid' : ''), 'placeholder' => 'Direccion']) }}
            {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ultAnoEstudio') }}
            {{ Form::text('ultAnoEstudio', $inscripcione->ultAnoEstudio, ['class' => 'form-control' . ($errors->has('ultAnoEstudio') ? ' is-invalid' : ''), 'placeholder' => 'Ultanoestudio']) }}
            {!! $errors->first('ultAnoEstudio', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('anoCursoEstudio') }}
            {{ Form::text('anoCursoEstudio', $inscripcione->anoCursoEstudio, ['class' => 'form-control' . ($errors->has('anoCursoEstudio') ? ' is-invalid' : ''), 'placeholder' => 'Anocursoestudio']) }}
            {!! $errors->first('anoCursoEstudio', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ie_estudios') }}
            {{ Form::text('ie_estudios', $inscripcione->ie_estudios, ['class' => 'form-control' . ($errors->has('ie_estudios') ? ' is-invalid' : ''), 'placeholder' => 'Ie Estudios']) }}
            {!! $errors->first('ie_estudios', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ciudadEstudios') }}
            {{ Form::text('ciudadEstudios', $inscripcione->ciudadEstudios, ['class' => 'form-control' . ($errors->has('ciudadEstudios') ? ' is-invalid' : ''), 'placeholder' => 'Ciudadestudios']) }}
            {!! $errors->first('ciudadEstudios', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('exper_virtual') }}
            {{ Form::text('exper_virtual', $inscripcione->exper_virtual, ['class' => 'form-control' . ($errors->has('exper_virtual') ? ' is-invalid' : ''), 'placeholder' => 'Exper Virtual']) }}
            {!! $errors->first('exper_virtual', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('paqCompManeja') }}
            {{ Form::text('paqCompManeja', $inscripcione->paqCompManeja, ['class' => 'form-control' . ($errors->has('paqCompManeja') ? ' is-invalid' : ''), 'placeholder' => 'Paqcompmaneja']) }}
            {!! $errors->first('paqCompManeja', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tituloObtenido') }}
            {{ Form::text('tituloObtenido', $inscripcione->tituloObtenido, ['class' => 'form-control' . ($errors->has('tituloObtenido') ? ' is-invalid' : ''), 'placeholder' => 'Tituloobtenido']) }}
            {!! $errors->first('tituloObtenido', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('duracionEstudio') }}
            {{ Form::text('duracionEstudio', $inscripcione->duracionEstudio, ['class' => 'form-control' . ($errors->has('duracionEstudio') ? ' is-invalid' : ''), 'placeholder' => 'Duracionestudio']) }}
            {!! $errors->first('duracionEstudio', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('hrsxDiaDisp') }}
            {{ Form::text('hrsxDiaDisp', $inscripcione->hrsxDiaDisp, ['class' => 'form-control' . ($errors->has('hrsxDiaDisp') ? ' is-invalid' : ''), 'placeholder' => 'Hrsxdiadisp']) }}
            {!! $errors->first('hrsxDiaDisp', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cursadoLoc') }}
            {{ Form::text('cursadoLoc', $inscripcione->cursadoLoc, ['class' => 'form-control' . ($errors->has('cursadoLoc') ? ' is-invalid' : ''), 'placeholder' => 'Cursadoloc']) }}
            {!! $errors->first('cursadoLoc', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('experienciaMedios') }}
            {{ Form::text('experienciaMedios', $inscripcione->experienciaMedios, ['class' => 'form-control' . ($errors->has('experienciaMedios') ? ' is-invalid' : ''), 'placeholder' => 'Experienciamedios']) }}
            {!! $errors->first('experienciaMedios', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tiempoExperiencia') }}
            {{ Form::text('tiempoExperiencia', $inscripcione->tiempoExperiencia, ['class' => 'form-control' . ($errors->has('tiempoExperiencia') ? ' is-invalid' : ''), 'placeholder' => 'Tiempoexperiencia']) }}
            {!! $errors->first('tiempoExperiencia', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('trabaja') }}
            {{ Form::text('trabaja', $inscripcione->trabaja, ['class' => 'form-control' . ($errors->has('trabaja') ? ' is-invalid' : ''), 'placeholder' => 'Trabaja']) }}
            {!! $errors->first('trabaja', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombreEmpresa') }}
            {{ Form::text('nombreEmpresa', $inscripcione->nombreEmpresa, ['class' => 'form-control' . ($errors->has('nombreEmpresa') ? ' is-invalid' : ''), 'placeholder' => 'Nombreempresa']) }}
            {!! $errors->first('nombreEmpresa', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('actividadEmpresa') }}
            {{ Form::text('actividadEmpresa', $inscripcione->actividadEmpresa, ['class' => 'form-control' . ($errors->has('actividadEmpresa') ? ' is-invalid' : ''), 'placeholder' => 'Actividadempresa']) }}
            {!! $errors->first('actividadEmpresa', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('funcionesEmpresa') }}
            {{ Form::text('funcionesEmpresa', $inscripcione->funcionesEmpresa, ['class' => 'form-control' . ($errors->has('funcionesEmpresa') ? ' is-invalid' : ''), 'placeholder' => 'Funcionesempresa']) }}
            {!! $errors->first('funcionesEmpresa', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tiempoSerEmpresa') }}
            {{ Form::text('tiempoSerEmpresa', $inscripcione->tiempoSerEmpresa, ['class' => 'form-control' . ($errors->has('tiempoSerEmpresa') ? ' is-invalid' : ''), 'placeholder' => 'Tiemposerempresa']) }}
            {!! $errors->first('tiempoSerEmpresa', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('instelPrAc') }}
            {{ Form::text('instelPrAc', $inscripcione->instelPrAc, ['class' => 'form-control' . ($errors->has('instelPrAc') ? ' is-invalid' : ''), 'placeholder' => 'Instelprac']) }}
            {!! $errors->first('instelPrAc', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('motivacionInstel') }}
            {{ Form::text('motivacionInstel', $inscripcione->motivacionInstel, ['class' => 'form-control' . ($errors->has('motivacionInstel') ? ' is-invalid' : ''), 'placeholder' => 'Motivacioninstel']) }}
            {!! $errors->first('motivacionInstel', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('aporteInstel') }}
            {{ Form::text('aporteInstel', $inscripcione->aporteInstel, ['class' => 'form-control' . ($errors->has('aporteInstel') ? ' is-invalid' : ''), 'placeholder' => 'Aporteinstel']) }}
            {!! $errors->first('aporteInstel', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estudioAntesTema') }}
            {{ Form::text('estudioAntesTema', $inscripcione->estudioAntesTema, ['class' => 'form-control' . ($errors->has('estudioAntesTema') ? ' is-invalid' : ''), 'placeholder' => 'Estudioantestema']) }}
            {!! $errors->first('estudioAntesTema', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('necesidadEsp') }}
            {{ Form::text('necesidadEsp', $inscripcione->necesidadEsp, ['class' => 'form-control' . ($errors->has('necesidadEsp') ? ' is-invalid' : ''), 'placeholder' => 'Necesidadesp']) }}
            {!! $errors->first('necesidadEsp', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ventajas') }}
            {{ Form::text('ventajas', $inscripcione->ventajas, ['class' => 'form-control' . ($errors->has('ventajas') ? ' is-invalid' : ''), 'placeholder' => 'Ventajas']) }}
            {!! $errors->first('ventajas', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('desventajas') }}
            {{ Form::text('desventajas', $inscripcione->desventajas, ['class' => 'form-control' . ($errors->has('desventajas') ? ' is-invalid' : ''), 'placeholder' => 'Desventajas']) }}
            {!! $errors->first('desventajas', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('dependientes') }}
            {{ Form::text('dependientes', $inscripcione->dependientes, ['class' => 'form-control' . ($errors->has('dependientes') ? ' is-invalid' : ''), 'placeholder' => 'Dependientes']) }}
            {!! $errors->first('dependientes', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ingresos') }}
            {{ Form::text('ingresos', $inscripcione->ingresos, ['class' => 'form-control' . ($errors->has('ingresos') ? ' is-invalid' : ''), 'placeholder' => 'Ingresos']) }}
            {!! $errors->first('ingresos', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('casaTipo') }}
            {{ Form::text('casaTipo', $inscripcione->casaTipo, ['class' => 'form-control' . ($errors->has('casaTipo') ? ' is-invalid' : ''), 'placeholder' => 'Casatipo']) }}
            {!! $errors->first('casaTipo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('medioConocerInstel') }}
            {{ Form::text('medioConocerInstel', $inscripcione->medioConocerInstel, ['class' => 'form-control' . ($errors->has('medioConocerInstel') ? ' is-invalid' : ''), 'placeholder' => 'Medioconocerinstel']) }}
            {!! $errors->first('medioConocerInstel', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fechaForm') }}
            {{ Form::text('fechaForm', $inscripcione->fechaForm, ['class' => 'form-control' . ($errors->has('fechaForm') ? ' is-invalid' : ''), 'placeholder' => 'Fechaform']) }}
            {!! $errors->first('fechaForm', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>