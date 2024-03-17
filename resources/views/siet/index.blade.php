@extends('layouts.instel')
@section('template_title') Datos SIET @endsection
@section('content')

    <div class="container">
        @if ($message = Session::get('success'))
                    <div class="alert alert-success">{!! $message !!}</div>
                @endif
        <form action="{{ route('sietAdd')}}" method="post">
            @csrf
            <div class="text-center">
                <h2>Bienestar Institucional</h2>
                A continuación ingresa la información requerida. Tiempo estimado de diligenciamiento: 3 minutos
            </div>
            <hr>
        <div class="row justify-content-md-center">
            <div class="col-md-2">
                <h5>Datos Personales</h5>
                <small>Datos necesarios para completar tu proceso de matrícula y ser parte de INSTEL</small>
            </div>
            <div class="col-md-10">
                <div class="row">
    
                    <div class="col-md-2">
                        <label for="" class="form-label">Estado Civil</label>
                        <select class="form-select estadoCivil" name="estadoCivil" id="" required>
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="" class="form-label">Tipo Sangre</label>
                        <select class="form-select tipoSangre" name="tipoSangre" id="" required>
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Nivel Educación</label>
                        <select class="form-select nivelFormacion" name="nivelFormacion" id="" required>
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Ocupacion</label>
                        <select class="form-select ocupacion" name="ocupacion" id="" required>
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Discapacidad</label>
                        <select class="form-select discapacidad" name="discapacidad" id="" required>
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">¿Qué medio de transporte usas más?</label>
                        <select class="form-select transporte" name="transporte" id="" required>
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">A cuál de los siguientes grupos perteneces</label><br>
                        <div class="multicultural">
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <hr>

        <div class="row justify-content-md-center">
            <div class="col-md-2">
                <h5>Dónde naciste</h5>
                <small>Indícanos el lugar donde naciste</small>
            </div>
            <div class="col-md-10">
                <div class="row">
                    
                    <div class="col-md-4">
                        <label for="" class="form-label">En qué país naciste</label>
                        <select class="form-select fPaisN" name="" id="lugarNace1" required>
                            <option value="">--Seleccione--</option>
                            <option value="Colombia">COLOMBIA</option>
                        </select>
                    </div>
    
                    <div class="col-md-4">
                        <label for="" class="form-label">Estado/Departamento</label>
                        <select class="form-select fEstadoN" name="" id="lugarNace2" required>
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>
    
                    <div class="col-md-4">
                        <label for="" class="form-label">Ciudad</label>
                        <select class="form-select fCiudadN" name="lugarNace" id="lugarNace" required>
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        <hr>

        <div class="row justify-content-md-center">
            <div class="col-md-2">
                <h5>¿Dónde vives?</h5>
                <small>Indica los datos de residencia</small>
            </div>
            <div class="col-md-10">
                <div class="row">
                    
                    <div class="col-md-4">
                        <label for="" class="form-label">País</label>
                        <select class="form-select fPais" name="pais" id="" required>
                            <option value="">--Seleccione--</option>
                            <option value="Colombia">COLOMBIA</option>
                        </select>
                    </div>
    
                    <div class="col-md-4">
                        <label for="" class="form-label">Estado/Departamento</label>
                        <select class="form-select fEstado" name="estado" id="" required>
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>
    
                    <div class="col-md-4">
                        <label for="" class="form-label">Ciudad</label>
                        <select class="form-select fCiudad" name="ciudad" id="" required>
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>
    
                    <div class="col-md-4">
                        <label for="" class="form-label">Barrio</label>
                        <select class="form-select fBarrio" name="barrio" id="">
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>
    
                    <div class="col-md-4">
                        <label for="" class="form-label">Dirección Residencia</label>
                        <input type="text" class="form-control" name="direccion" value="{{$datasiet->direccion}}" required>
                    </div>

                    <div class="col-md-2">
                        <label for="" class="form-label">Estrato</label>
                        <select class="form-select estrato" name="estrato" id="" required>
                            <option value="SD">--Seleccione--</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="" class="form-label">Zona</label>
                        <select class="form-select zona" name="zona" id="" required>
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        <hr>

        <div class="row justify-content-md-center">
            <div class="col-md-2">
                <h5>Datos de Seguridad Social</h5>
                <small>Afiliaciones al Régimen de Seguridad Social</small>
            </div>
            <div class="col-md-10">
                <div class="row align-items-end">
                    
                    <div class="col-md-3">
                        <label for="" class="form-label">Entidad Promotora de Salud - EPS</label>
                        <select class="form-select eps" name="eps" id="">
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="" class="form-label">Administradora de Régimen Subsidiado - ARS</label>
                        <select class="form-select ars" name="ars" id="">
                            <option value="">--No Aplica--</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="" class="form-label">Aseguradora</label>
                        <select class="form-select aseguradora" name="aseguradora" id="">
                            <option value="">--No Aplica--</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="" class="form-label">Nivel SISBÉN</label>
                        <select class="form-select sisben" name="sisben" id="">
                            <option value="">--No Aplica--</option>
                        </select>
                    </div>

                    <input type="hidden" name="multicult" id="multicult_txt">

                    <div class="d-grid gap-2" style="margin-top:30px">
                      <button type="submit" class="btn btn-primary">GUARDAR</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/datasiet.js') }}"></script>

@php
    $creaVariablesSiet = "";
    $datosT = ['zona','estadoCivil','tipoSangre','nivelFormacion','ocupacion','discapacidad','transporte','multicult','lugarNace','ciudad','barrio','estrato','eps','ars','aseguradora','sisben'];
    foreach($datosT as $item){
        $creaVariablesSiet .= "var dt_".$item." = '".$datasiet[$item]."'
        ";
    }
@endphp

<script>
    {!! $creaVariablesSiet !!}

    $( document ).ready(function() {
        cityBorn((dt_lugarNace == "" ? 'Cali' : dt_lugarNace))
        cityLive((dt_ciudad == "" ? 'Cali' : dt_ciudad))
        townLive((dt_barrio == "" ? '' : dt_barrio))
        checkMult()
    });

    var categories = ['zona','estadoCivil','tipoSangre','nivelFormacion','ocupacion','discapacidad','transporte','estrato','eps','ars','aseguradora','sisben'];
    for (let t = 0; t < categories.length; t++) {
        eval(categories[t]).sort();
        eval(categories[t]).forEach(element => {
            var extraDt = (eval('dt_' + categories[t]) == element ? 'selected' : '');
            $('.' + categories[t]).append('<option value="'+element+'" '+extraDt+'>'+ element.toUpperCase() +'</option>')
        })
    }

    //Opciones multuculturalidad
    var mltCod = 0;
    multiculturalidad.forEach(element => {
        mltCod++;
        var extraCod = (dt_multicult.includes(element) ? 'checked' : '')
        $('.multicultural').append('<input class="form-check-input multicult" type="checkbox" onclick="checkMult()" value="'+element+'" id="mt_'+mltCod+'" '+extraCod+'><label class="form-check-label" for="mt_'+mltCod+'"> &nbsp&nbsp&nbsp'+element+'</label><br>')
    });
    var valMult;
    function checkMult(){
        varMult = "";
        $(".multicult:checked").each(function(){
            varMult += $(this).val() + ',';
        });
        $('#multicult_txt').val(varMult)
    }

    //Function onChange
    $('.fPaisN').change(function(){
        $('.fCiudadN').empty()
        cargaList(buscaEstado($(this).val()),$(this).val(),'fEstadoN');
    })
    $('.fEstadoN').change(function(){
        $('.fCiudadN').empty()
        $('.fBarrio').empty()
        cargaList(buscaCiudad($(this).val()),$(this).val(),'fCiudadN');
    })
    $('.fPais').change(function(){
        $('.fCiudad').empty()
        $('.fBarrio').empty()
        cargaList(buscaEstado($(this).val()),$(this).val(),'fEstado');
    })
    $('.fEstado').change(function(){
        $('.fCiudad').empty()
        $('.fBarrio').empty()
        cargaList(buscaCiudad($(this).val()),$(this).val(),'fCiudad');
    })
    $('.fCiudad').change(function(){
        $('.fBarrio').empty()
        cargaList(buscaBarrio($(this).val()),$(this).val(),'fBarrio');
    })
    //DataC
    function cityBorn(cc){
        var ff = data.filter( element => element.city == cc);
        cargaList(buscaEstado(ff[0]['pais']),ff[0]['desc'],'fEstadoN');
        cargaList(buscaCiudad(ff[0]['desc']),ff[0]['city'],'fCiudadN');
        cargaList(buscaPais(),ff[0]['pais'],'fPaisN');
    }
    function cityLive(cc){
        var ff = data.filter( element => element.city == cc);
        cargaList(buscaEstado(ff[0]['pais']),ff[0]['desc'],'fEstado');
        cargaList(buscaCiudad(ff[0]['desc']),ff[0]['city'],'fCiudad');
        cargaList(buscaPais(),ff[0]['pais'],'fPais');
    }
    function townLive(bb){
        var ff = barrios.filter( element => element.text == bb);
        cargaList(buscaBarrio(ff[0]['desc']),ff[0]['text'],'fBarrio');
    }
    //GeoFields
    function cargaList(lista, valGeneral,campo){
        $('.' + campo).html('<option value="">--Seleccione--</option>');
        lista.forEach(element => {
            var extraDt = (valGeneral == element ? 'selected' : '');
            $('.' + campo).append('<option value="'+element+'" '+extraDt+'>'+ element.toUpperCase() +'</option>')
        })
    }
    //Opciones ciudad
    function buscaBarrio(dd){
        var rta = [];
        $(barrios).filter(function(i,n){
            if(n.desc === dd){
                if (!rta.includes(n.text)) {
                    rta.push(n.text);
                }
            }
        })
        return rta.sort();
    }
    function buscaCiudad(dd){
        var rta = [];
        $(data).filter(function(i,n){
            if(n.desc === dd){
                if (!rta.includes(n.city)) {
                    rta.push(n.city);
                }
            }
        })
        return rta.sort();
    }
    function buscaEstado(dd){
        var rta = [];
        $(data).filter(function(i,n){
            if(n.pais === dd){
                if (!rta.includes(n.desc)) {
                    rta.push(n.desc);
                }
            }
        })
        return rta.sort();
    }
    function buscaPais(){
        var rta = [];
        $(data).filter(function(i,n){
            if (!rta.includes(n.pais)) {
                rta.push(n.pais);
            }
        })
        return rta.sort();
    }
</script>
@endsection