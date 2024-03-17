@extends('layouts.app')

@section('template_title')
    {{ $inscripcione->name ?? 'Show Inscripcione' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Inscripcione</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('inscripciones.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $inscripcione->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Programa:</strong>
                            {{ $inscripcione->programa }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo Programa:</strong>
                            {{ $inscripcione->tipo_programa }}
                        </div>
                        <div class="form-group">
                            <strong>Fechanac:</strong>
                            {{ $inscripcione->fechaNac }}
                        </div>
                        <div class="form-group">
                            <strong>Edad:</strong>
                            {{ $inscripcione->edad }}
                        </div>
                        <div class="form-group">
                            <strong>Lugarnace:</strong>
                            {{ $inscripcione->lugarNace }}
                        </div>
                        <div class="form-group">
                            <strong>Estadocivil:</strong>
                            {{ $inscripcione->estadoCivil }}
                        </div>
                        <div class="form-group">
                            <strong>Doc:</strong>
                            {{ $inscripcione->doc }}
                        </div>
                        <div class="form-group">
                            <strong>Lugarreside:</strong>
                            {{ $inscripcione->lugarReside }}
                        </div>
                        <div class="form-group">
                            <strong>Telefono:</strong>
                            {{ $inscripcione->telefono }}
                        </div>
                        <div class="form-group">
                            <strong>Correo:</strong>
                            {{ $inscripcione->correo }}
                        </div>
                        <div class="form-group">
                            <strong>Direccion:</strong>
                            {{ $inscripcione->direccion }}
                        </div>
                        <div class="form-group">
                            <strong>Ultanoestudio:</strong>
                            {{ $inscripcione->ultAnoEstudio }}
                        </div>
                        <div class="form-group">
                            <strong>Anocursoestudio:</strong>
                            {{ $inscripcione->anoCursoEstudio }}
                        </div>
                        <div class="form-group">
                            <strong>Ie Estudios:</strong>
                            {{ $inscripcione->ie_estudios }}
                        </div>
                        <div class="form-group">
                            <strong>Ciudadestudios:</strong>
                            {{ $inscripcione->ciudadEstudios }}
                        </div>
                        <div class="form-group">
                            <strong>Exper Virtual:</strong>
                            {{ $inscripcione->exper_virtual }}
                        </div>
                        <div class="form-group">
                            <strong>Paqcompmaneja:</strong>
                            {{ $inscripcione->paqCompManeja }}
                        </div>
                        <div class="form-group">
                            <strong>Tituloobtenido:</strong>
                            {{ $inscripcione->tituloObtenido }}
                        </div>
                        <div class="form-group">
                            <strong>Duracionestudio:</strong>
                            {{ $inscripcione->duracionEstudio }}
                        </div>
                        <div class="form-group">
                            <strong>Hrsxdiadisp:</strong>
                            {{ $inscripcione->hrsxDiaDisp }}
                        </div>
                        <div class="form-group">
                            <strong>Cursadoloc:</strong>
                            {{ $inscripcione->cursadoLoc }}
                        </div>
                        <div class="form-group">
                            <strong>Experienciamedios:</strong>
                            {{ $inscripcione->experienciaMedios }}
                        </div>
                        <div class="form-group">
                            <strong>Tiempoexperiencia:</strong>
                            {{ $inscripcione->tiempoExperiencia }}
                        </div>
                        <div class="form-group">
                            <strong>Trabaja:</strong>
                            {{ $inscripcione->trabaja }}
                        </div>
                        <div class="form-group">
                            <strong>Nombreempresa:</strong>
                            {{ $inscripcione->nombreEmpresa }}
                        </div>
                        <div class="form-group">
                            <strong>Actividadempresa:</strong>
                            {{ $inscripcione->actividadEmpresa }}
                        </div>
                        <div class="form-group">
                            <strong>Funcionesempresa:</strong>
                            {{ $inscripcione->funcionesEmpresa }}
                        </div>
                        <div class="form-group">
                            <strong>Tiemposerempresa:</strong>
                            {{ $inscripcione->tiempoSerEmpresa }}
                        </div>
                        <div class="form-group">
                            <strong>Instelprac:</strong>
                            {{ $inscripcione->instelPrAc }}
                        </div>
                        <div class="form-group">
                            <strong>Motivacioninstel:</strong>
                            {{ $inscripcione->motivacionInstel }}
                        </div>
                        <div class="form-group">
                            <strong>Aporteinstel:</strong>
                            {{ $inscripcione->aporteInstel }}
                        </div>
                        <div class="form-group">
                            <strong>Estudioantestema:</strong>
                            {{ $inscripcione->estudioAntesTema }}
                        </div>
                        <div class="form-group">
                            <strong>Necesidadesp:</strong>
                            {{ $inscripcione->necesidadEsp }}
                        </div>
                        <div class="form-group">
                            <strong>Ventajas:</strong>
                            {{ $inscripcione->ventajas }}
                        </div>
                        <div class="form-group">
                            <strong>Desventajas:</strong>
                            {{ $inscripcione->desventajas }}
                        </div>
                        <div class="form-group">
                            <strong>Dependientes:</strong>
                            {{ $inscripcione->dependientes }}
                        </div>
                        <div class="form-group">
                            <strong>Ingresos:</strong>
                            {{ $inscripcione->ingresos }}
                        </div>
                        <div class="form-group">
                            <strong>Casatipo:</strong>
                            {{ $inscripcione->casaTipo }}
                        </div>
                        <div class="form-group">
                            <strong>Medioconocerinstel:</strong>
                            {{ $inscripcione->medioConocerInstel }}
                        </div>
                        <div class="form-group">
                            <strong>Fechaform:</strong>
                            {{ $inscripcione->fechaForm }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
