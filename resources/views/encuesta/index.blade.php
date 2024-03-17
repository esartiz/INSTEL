@extends('layouts.admin')

@section('template_title')
    Resultado de encuestas
@endsection

@section('content')
@php
    $preg = [
        "El contenido visto en el módulo es coherente y pertinente con sus necesidades de aprendizaje.",
        "Los contenidos son facilitados en un ambiente orientado a su aprendizaje y enfocado a los objetivos de cada unidad.",
        "El ambiente de estudio (clases sincrónicas) responde a una planeación estratégica indicada previamente.",
        "La estructura de las actividades realizadas durante esté módulo, le permite adquirir el conocimiento necesario para continuar con su proceso de aprendizaje.",
        "La práctica del módulo le permitió afianzar sus habilidades y conocimientos.",
        "Tus opiniones nos permiten mejorar, indícanos algún comentario y/o sugerencia frente al contenido del módulo.",
        "El docente/tutor facilita los contenidos del Módulo teniendo en cuenta la planeación institucional conocida previamente.",
        "El docente/tutor es puntual, mantiene un trato respetuoso y propicia la participación activa de los estudiantes.",
        "El docente/tutor ejecuta una metodología de clase pertinente, que afianza la motivación y refuerza los logros de los estudiantes.",
        "El docente/tutor demuestra dominio en los contenidos del módulo, y los presenta de forma clara, precisa y con vocabulario técnico.",
        "El docente/tutor utiliza estrategias para crear un ambiente de estudio organizado y dispone de material complementario para el desarrollo de su clase.",
        "Tus opiniones nos permiten mejorar, indícanos algún comentario y/o sugerencia frente al desempeño del/la docente."
];
@endphp

<h2 class="text-center">Evaluaciones de los módulos</h2>



@foreach ($dataEnc->unique('modulo') as $item)

<div class="accordion" id="contMod">
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading{{$item->modulo}}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$item->modulo}}" aria-expanded="true" aria-controls="collapse{{$item->modulo}}">
            {{ $item->elModulo()->first()->titulo }} ({{ (isset($item->elDocente()->first()->nombres) ? $item->elDocente()->first()->nombres : '--') }} {{ (isset($item->elDocente()->first()->apellidos) ? $item->elDocente()->first()->apellidos : '--') }})
        </button>
      </h2>
      <div id="collapse{{$item->modulo}}" class="accordion-collapse collapse" aria-labelledby="heading{{$item->modulo}}" data-bs-parent="#contMod">
        <div class="accordion-body">
            <div class="row">
                <div class="modulo_{{$item->modulo}} row">
                    <div class="col-6">
                        @for ($i = 0; $i < count($preg); $i++)
                        @if ($i == 5 || $i == 11 ) @else
                            <hr>
                            <b>{{ $preg[$i]}}</b>
                            <div class="progress">
                                <div id="gr_{{ $item->modulo }}_prg_{{ $i }}_2" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Siempre</div>
                                <div id="gr_{{ $item->modulo }}_prg_{{ $i }}_1" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">A veces</div>
                                <div id="gr_{{ $item->modulo }}_prg_{{ $i }}_0" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Nunca</div>
                            </div>
                            Nunca:
                            <span id="rtas_{{ $item->modulo }}_prg_{{ $i }}_0">0</span> | 
                            A veces: 
                            <span id="rtas_{{ $item->modulo }}_prg_{{ $i }}_1">0</span> | 
                            Siempre: 
                            <span id="rtas_{{ $item->modulo }}_prg_{{ $i }}_2">0</span>
                            <hr>
                        @endif
                        @endfor
                        
                    </div>
                    <div class="col-6">
                        @for ($i = 0; $i < count($preg); $i++)
                        @if ($i == 5 || $i == 11 )
                            <b>{{ $preg[$i]}}</b>
                            <hr>
                            <div id="rtas_{{ $item->modulo }}_prg_{{ $i }}"></div>
                            <hr>
                        @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>

    @endforeach

@endsection
@section('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    
    function sumaDat(md, pr, rt,stt, stCod){
        if(pr == 5 || pr == 11){
            if(rt != ""){
                $('#rtas_' + md + '_prg_' + pr).append('<div class="comment">' +rt + '(<a href="/inbox/'+stCod+'" target="_blank">'+stt+'</a>)</div>');
            }
        } else {
            var datprev = Number($('#rtas_' + md + '_prg_' + pr + '_' + rt).text()) + 1;
            $('#rtas_' + md + '_prg_' + pr + '_' + rt).text(datprev);
        }
        //Makle progress
            var v0 = Number($('#rtas_' + md + '_prg_' + pr + '_0').text())
            var v1 = Number($('#rtas_' + md + '_prg_' + pr + '_1').text())
            var v2 = Number($('#rtas_' + md + '_prg_' + pr + '_2').text())
            var p0 = (v0 * 100) / (v0 + v1 + v2);
            var p1 = (v1 * 100) / (v0 + v1 + v2);
            var p2 = (v2 * 100) / (v0 + v1 + v2);
            $('#gr_' + md + '_prg_' + pr +'_0').css('width', p0 + '%');
            $('#gr_' + md + '_prg_' + pr +'_1').css('width', p1 + '%');
            $('#gr_' + md + '_prg_' + pr +'_2').css('width', p2 + '%');
            //
            $('#gr_' + md + '_prg_' + pr +'_0').attr('aria-valuenow', p0);
            $('#gr_' + md + '_prg_' + pr +'_1').attr('aria-valuenow', p1);
            $('#gr_' + md + '_prg_' + pr +'_2').attr('aria-valuenow', p2);
            
            console.log('#rtas_' + md + '_prg_' + rt);
    }


        @php
        foreach ($dataEnc as $v) {
            $dt = explode('|',str_replace(["\r", "\n"], "", $v->rtas));
            for ($i=0; $i < count($dt); $i++) {
                echo "sumaDat('".$v->modulo."','".$i."', '".$dt[$i]."', '".$v->elEstudiante()->first()['nombres']." ".$v->elEstudiante()->first()['apellidos']."', '".$v->elEstudiante()->first()['cod']."');";
            }
        }
        @endphp
</script>
@endsection