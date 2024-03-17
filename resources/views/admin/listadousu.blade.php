@php
    $semestreNombre = ['N/A', 'Primer Semestre', 'Segundo Semestre', 'Tercer Semestre', 'Semestre de Profudización Animación Musical y Presentación de Espectáculos', 'Semestre de Profudización Lectura de Noticias y Periodismo Radial', 'Semestre de Profudización Periodismo y Locución Deportiva', 'Semestre de Profudización Locución y Presentación de Televisión', 'Semestre de Profudización Producción y Locución Comercial', 'Diplomado en Comunicación Organizacional con énfasis en Jefatura de Prensa'];
@endphp
@extends('layouts.admin')

@section('template_title')
    Generar listado de usuarios
@endsection

@section('content')
    <div class="row">
        <div class="col-5">
            <div class="mb-3">
                <label for="" class="form-label">Por Programa</label>
                <select class="form-select optList" name="filtraPorPg" id="filtraPorPg" onchange="makeFilter()">
                    <option value="">-Seleccione</option>
                    @foreach ($listado->groupBy('prg') as $item)
                        <option value="{{ $item->first()->prg }}">{{ $item->first()->getPrograma()->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-4">
            <div class="mb-3">
                <label for="" class="form-label">Por Semestre</label>
                <select class="form-select optList" name="semestreList" id="semestreList"  onchange="makeFilter()">
                    <option value="">-Seleccione</option>
                    @foreach ($semestreNombre as $item)
                        <option value="{{ $loop->iteration - 1 }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group col-2">
            <label for="" class="form-label">Grupo</label>
            <select class="form-select form-select optList" id="grupoID"  onchange="makeFilter()">
                <option value="">-TODOS</option>
                @foreach ($listado->groupBy('periodo') as $item)
                    <option value="{{ $item->first()->periodo }}">{{ $item->first()->periodo }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-1 d-flex align-items-center">
            <button class="buttonLista btn btn-primary" href="#" role="button">Ver</button>
        </div>

        <div class="col-4">
        </div>
        <div class="col-4">
            <div class="mb-3 listaLista">
                <div class="d-grid gap-2">
                    <button type="button" name="" id="printLista" class="btn btn-primary">Imprimir Lista</button>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="listaPrint listaLista">
        <div class="row">
            <div class="col-4">
                <img src="/images/logo.png" alt="" class="img-fluid">
            </div>
            <div class="col-8 text-center">
                INSTITUTO NACIONAL DE TELECOMUNICACIONES - INSTEL<br>
                <span style="font-weight: bold" id="txtPrg"></span><br>
                <span id="txtSem"></span> - 
                <span id="txtGrp"></span>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="genteLista">
            </tbody>
        </table>
    </div>
@endsection


@section('scripts')
    <script>
        const datPersonas = [
            @foreach ($listado as $item)
                {
                    id: '{{ $item->user }}',
                    prg: '{{ $item->prg }}',
                    nivel: '{{ $item->nivel }}',
                    periodo: '{{ $item->periodo }}',
                    est: "{{ $item->getEstudiante()->apellidos . ' ' . $item->getEstudiante()->nombres ?? 'xxxx' }}"
                },
            @endforeach
        ];

        function makeFilter() {
            var personaID = 0;
            var tProg, tGrupo, tSemestre = "";
            $('#genteLista').empty();
            var personas = datPersonas;
            if($('#semestreList').val() !== ""){
                tSemestre = $('#semestreList').find('option:selected').text();
                personas = personas.filter(persona => persona.nivel === $('#semestreList').val());
            }
            if($('#grupoID').val() !== ""){
                tGrupo = $('#grupoID').find('option:selected').text();
                personas = personas.filter(persona => persona.periodo === $('#grupoID').val());
            }
            if($('#filtraPorPg').val() !== ""){
                tProg = $('#filtraPorPg').find('option:selected').text();
                personas = personas.filter(persona => persona.prg === $('#filtraPorPg').val());
            }
            personas.sort((a, b) => a.est.localeCompare(b.est));
            personas.forEach(e => {
                if (e != "") {
                    personaID++;
                    $('#genteLista').append('<tr onclick="verPerfil(this)" idEst="' + e.id +
                        '"><th scope="row">' + personaID + '</th><td>' + e.est +
                        '</td><td style="width: 40%"></td></tr>');
                }
            });
            $("#txtPrg").text(tProg);
            $("#txtSem").text(tSemestre);
            $("#txtGrp").text(tGrupo);
        }


        $('.buttonLista').click(function() {
            window.location = '/generarlista/' + $('#' + filtroSel).val() + '-' + $('#grupoID').val();
        })

        $('#printLista').click(function() {
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write(
                '<html><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><link href="/css/app.css" rel="stylesheet"><body onload="window.print()">' +
                $(".listaPrint").html() + '</body></html>');
            newWin.document.close();
            setTimeout(function() {
                newWin.close();
            }, 10);
        })

        function verPerfil(ff){
            const getID = $(ff).attr('idEst');
            window.open('/users/' + getID + '/edit', '_blank');
        }

        function baseFilt(dd) {
            $('#' + dd).each(function() {
                var select = $(this);
                var options = select.find('option');

                options.sort(function(a, b) {
                    if (a.text > b.text) {
                        return 1;
                    } else if (a.text < b.text) {
                        return -1;
                    } else {
                        return 0;
                    }
                });

                select.empty().append(options);
            });
        }

        baseFilt('grupoID');
        baseFilt('filtraPorPg');
    </script>
@endsection
