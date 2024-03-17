<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('template_title') | INSTEL Virtual</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                   <img src="{{ asset('images/logo.png') }}" height="35" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="openProfile()">PERFIL</a>
                        </li>
                        <li class="nav-item active">
                          <a class="nav-link" href="/">ACADÉMICO</span></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="/inbox">MENSAJES</span></a>
                          </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">AYUDA</a>
                        </li>
                      </ul>

                    <!-- Right Side Of Navbar -->
                    <div class="navbar-nav ms-auto">
                        <div class="d-flex align-items-center">
                            <div class="p-2">
                                <img class="card-img-top" style="border-radius: 50%; width:50px; height:50px; object-fit:cover" src="{{ asset('storage/profiles/0/t/'.Auth::user()->cod.'.jpg') }}" />
                            </div>
                            <div class="p-2">{{ Auth::user()->nombres.' '.Auth::user()->apellidos }}</div>
                            <div class="p-2"><form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <div class="d-grid gap-2">
                                  <button type="submit" name="" id="" class="btn btn-danger">Salir</button>
                                </div>
                            </form></div>
                          </div>
                        </div>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="footer-section">
            <div class="container">
                <div class="footer-cta pt-5 pb-5">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 mb-30">
                            <div class="single-cta">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="cta-text">
                                    <h4>Sede Cali, Colombia</h4>
                                    <span>Calle 15N # 8N-54 Barrio Granada</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 mb-30">
                            <div class="single-cta">
                                <i class="fas fa-phone"></i>
                                <div class="cta-text">
                                    <h4>Teléfonos</h4>
                                    <span>(602) 402 1082 <br>302 861 7186 - 311 310 4159</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 mb-30">
                            <div class="single-cta">
                                <i class="far fa-envelope-open"></i>
                                <div class="cta-text">
                                    <h4>Correo</h4>
                                    <span>info@instel.edu.co</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-content pt-5 pb-5">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 mb-50">
                            <div class="footer-widget">
                                <div class="footer-logo">
                                    <a href="index.html"><img src="https://instel.edu.co/images/logo.svg" class="img-fluid" alt="logo"></a>
                                </div>
    
                                <div class="footer-text">
                                  <h3>Misión Institucional</h3>
                                  Hacer de los Medios de Comunicación el camino expedito para promover iniciativas de paz para un país como Colombia en un ambiente de sana convivencia, participación democrática y respetuosos de nuestros principios y de nuestra nacionalidad sin abandonar los propósitos esenciales de informar, educar y entretener.
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                            <div class="footer-widget">
                                <div class="footer-widget-heading">
                                    <h3>Links de Interés</h3>
                                </div>
                                <ul>
                                    <li><a href="https://www.instel.edu.co/" target="_blank">INSTEL</a></li>
                                    <li><a href="https://www.instel.edu.co/admisiones" target="_blank">Admisiones</a></li>
                                    <li><a href="https://www.instel.edu.co/inscripciones" target="_blank">Inscripciones</a></li>
                                    <li><a href="https://aclcolombia.com/" target="_blank">Asociación Colombiana de Locutores</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                            <div class="footer-widget">
                              <div class="footer-social-icon">
                                <span>Síguenos</span>
                                <a href="https://www.facebook.com/instelvirtual/" target="_blank"><i class="fab fa-facebook-f facebook-bg"></i></a>
                                <a href="https://www.twitter.com/instelvirtual/" target="_blank"><i class="fab fa-twitter twitter-bg"></i></a>
                                <a href="https://www.instagram.com/instelColombia/" target="_blank"><i class="fab fa-instagram google-bg"></i></a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>


    <!-- Profile -->
    <form method="POST" role="form" enctype="multipart/form-data" action="{{ route('estudiantedocs')}}" class="modal fade" id="myProfile" tabindex="-1" role="dialog" aria-labelledby="myProfileLabel" aria-hidden="true">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="boxActividad_tt">{{ Auth::user()->nombres.' '.Auth::user()->apellidos }}</h5>
                    <button type="button" class="btn btn-primary cerrarModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <img id="output" src="{{ asset('storage/profiles/0/'.Auth::user()->cod) }}.jpg" class="img-fluid" onerror="this.src='{{ asset('storage/profiles/0/no-pic.jpg') }}';" />
                                <div id="fileHelpId" class="form-text">La foto debe ser vertical</div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-6">
                                    <small style="font-weight: 700">Documento de Identidad</small><br>
                                    {{Auth::user()->doc. ' de '.Auth::user()->doc_ex}}
                                </div>
                                <div class="col-6">
                                    <small style="font-weight: 700">Teléfono</small><br>
                                    {{Auth::user()->telefono}}
                                </div>
                                <div class="col-6">
                                    <small style="font-weight: 700">Correo Electrómico</small><br>
                                    {{Auth::user()->email}}
                                </div>
                                <div class="col-6">
                                    <small style="font-weight: 700">Fecha Nacimiento</small><br>
                                    {{Auth::user()->fecha_nac}}
                                </div>
                            </div>
                            <hr>
                        
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    Foto de Perfil
                                </div>
                                <div class="col-md-8">
                                    <input type="file" onchange="loadFile(event)" class="form-control" name="fotoPerfil" accept="image/*" id="" placeholder="" aria-describedby="fileHelpId">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary enviarBt">GUARDAR</button>
                </div>
            </div>
        </div>
    </form>
    
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js')}}"></script>
    @yield('scripts')

    <script>
        function openProfile(){
            $('#myProfile').modal('show');
        }
        $('.cerrarModal').click(function(){
            $('.modal').modal('hide')
        })
        var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        if(output.width < output.height){
            $('#fileHelpId').text("Recuerde que la foto debe ser vertical")
        }
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }
    };
    </script>
</body>
</html>
