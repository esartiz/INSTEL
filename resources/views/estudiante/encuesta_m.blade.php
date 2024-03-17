@php
    $modulo = Session::get('idModulo');
@endphp

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>

  <div class="progress">
    <div class="progress-bar progress-bar-striped bg-success" id="progreso" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
  
  <div class="text-center">
    <h3>Valoración del proceso de aprendizaje. <br> Módulo {{ $modulo->titulo }}</h3>Docente: {{ $modulo->user()->first()->nombres }} {{ $modulo->user()->first()->apellidos }}
  </div>

  <div class="container-fluid">
    <div class="textoInicial">
    Para INSTEL es fundamental conocer tus perspectiva en torno al proceso de aprendizaje
    que actualmente adelantas, por ello te solicitamos amablemente nos permitas conocer un
    poco más sobre tu experiencia en el módulo que finaliza, en cuánto a:
    <ul>
      <li>Contenido del Módulo</li>
      <li>Desempeño Docente</li>
    </ul>
    Te solicitamos amablemente responder estas breves preguntas de manera consciente y
    propositiva, enfocado/a en el mejoramiento continuo de los procesos de aprendizaje.
    <b>No cierres la ventana hasta terminar</b>
  </div>

    <div class="text-center caja" style="margin-top: 20px">
      <div class="d-grid gap-2">
        <button type="button" onclick="encuesta()" class="btn btn-primary">INICIAR (12 PREGUNTAS)</button>
      </div>
    </div>

    <div class="text-center cajaRta row" style="margin-top: 20px">
        <button value="2" class="btn btn-success rtaBt col-4">Siempre</button>
        <button value="1" class="btn btn-warning rtaBt col-4">A veces</button>
        <button value="0" class="btn btn-danger rtaBt col-4">Nunca</button>
    </div>

    <div class="mb-3 cajaTexto">
      <label for="" class="form-label"></label>
      <textarea class="form-control" name="" id="comentario" rows="6"></textarea>
      <div class="d-grid gap-2">
        <button type="button" name="" id="" class="btn btn-primary addComent">Siguiente</button>
      </div>
    </div>

    <form action="/escuesta-save" target="_parent" method="post" id="dataSend">
      @csrf
      <input type="hidden" name="rtas" id="lasRt">
    </form>
  </div>
    
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

  <script>
    var options = ["Nunca", "A veces", "Siempre"];
    var secciones = ["CONTENIDO DEL MÓDULO", "DOCENTE/TUTOR DEL MÓDULO"];
    var preguntas = [
      [
        "El contenido visto en el módulo es coherente y pertinente con sus necesidades de aprendizaje.",
        "Los contenidos son facilitados en un ambiente orientado a su aprendizaje y enfocado a los objetivos de cada unidad.",
        "El ambiente de estudio (clases sincrónicas) responde a una planeación estratégica indicada previamente.",
        "La estructura de las actividades realizadas durante esté módulo, le permite adquirir el conocimiento necesario para continuar con su proceso de aprendizaje.",
        "La práctica del módulo le permitió afianzar sus habilidades y conocimientos.",
        "Tus opiniones nos permiten mejorar, indícanos algún comentario y/o sugerencia frente al contenido del módulo."
      ],
      [
        "El docente/tutor facilita los contenidos del Módulo teniendo en cuenta la planeación institucional conocida previamente.",
        "El docente/tutor es puntual, mantiene un trato respetuoso y propicia la participación activa de los estudiantes.",
        "El docente/tutor ejecuta una metodología de clase pertinente, que afianza la motivación y refuerza los logros de los estudiantes.",
        "El docente/tutor demuestra dominio en los contenidos del módulo, y los presenta de forma clara, precisa y con vocabulario técnico.",
        "El docente/tutor utiliza estrategias para crear un ambiente de estudio organizado y dispone de material complementario para el desarrollo de su clase.",
        "Tus opiniones nos permiten mejorar, indícanos algún comentario y/o sugerencia frente al desempeño del/la docente."
      ]
    ];

    $('.cajaTexto').hide()
    $('.cajaRta').hide()

    var sc = 0;
    var idPreg = 0;
    var guiaPreg = 1;
    var rtasC = "";
    var avance = 0;

    function encuesta(){
      $(".caja").fadeTo("slow", 1);
      if(idPreg < 5){
        $('.rtaBt').fadeTo("slow",1);
        $('.cajaRta').show()
      } else {
        $('.cajaTexto').fadeTo("slow",1);
        $('.addComent').show();
      }

      $('.caja').html('<h5>'+ secciones[sc] + '</h5>' + guiaPreg + '.' + preguntas[sc][idPreg]);
      $('.textoInicial').hide()
      idPreg++;
      guiaPreg++;
      avance += 8.3;
      $('#progreso').css('width', avance + '%');
    }

    $('.rtaBt').click(function(){
      $('.rtaBt').hide();
      rtasC += $(this).val() + "|";
      $('#lasRt').val(rtasC)

      $(".caja").fadeTo("slow", 0);

      var intervalId = window.setInterval(function(){
        clearInterval(intervalId)
        encuesta();
      }, 1000);
    })

    $('.addComent').click(function(){
      $(this).hide();
      $(".caja").fadeTo("slow", 0);
      rtasC += $('#comentario').val() + "|";
      $(".cajaTexto").fadeTo("slow", 0);
      $('#lasRt').val(rtasC);
      
      idPreg = 0;

      var intervalId = window.setInterval(function(){
      $("#comentario").val("");
      $(".cajaTexto").hide();
        clearInterval(intervalId)
        if(sc == 0){
          sc = 1;
          encuesta();
        } else {
          $('#dataSend').submit();
        }
      }, 1000);
    });

    
  </script>
</body>

</html>