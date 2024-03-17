@php
    if (Auth::user()->cod !== null) {
        $menuGeneral = ['Estudiante' => [['PERFIL', 'profile'], ['BIENESTAR', 'siet'], ['ACADÉMICO', 'estudiante'], ['FINANCIERO', 'financiero']], 'Docente' => [['ACADÉMICO', 'docente'], ['SEMINARIOS', 'seminarios'], ['PRUEBAS', 'pruebas-aptitud']], 'Administrador' => [['MENSAJES', 'inbox']]];
    } else {
        $menuGeneral = ['Estudiante' => [['', '#']]];
    }
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('template_title') | INSTEL Virtual</title>

    <!-- Fonts -->
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9XQ241DLJE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-9XQ241DLJE');
    </script>
</head>

<body>
    @impersonating($guard = null)
        <div class="alert alert-info" role="alert">
            <a href="/salir">Regresar a la vista como <strong>Administrador</strong></a>
        </div>
    @endImpersonating
    <div id="app">
        <div style="background-color: #f23838;">
            <div class="container">
                <div class="row  align-items-center">
                    <!-- Emisora -->
                    <div class="col-md-4 col-12">
                        <div class="audio-player">
                            <div class="audioPlay" style="">
                                <i class="fa fa-play"></i> &nbsp;&nbsp;&nbsp; <b>INSTEL RADIO</b>
                            </div>
                            <div class="audioStop" style="display: none;">
                                <i class="fa fa-pause"></i> &nbsp;&nbsp;&nbsp; PAUSAR <b>INSTEL RADIO</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 text-center">
                        <a href="https://www.instel.edu.co" class="text-white"
                            target="_blank"><b>www.instel.edu.co</b></a>
                    </div>
                    <div class="col-md-4 col-12 d-flex justify-content-end align-items-center">
                        <div class="me-2">
                            <img class="card-img-top"
                                style="border-radius: 50%; width:50px; height:50px; object-fit:cover"
                                src="{{ route('ft', 'profiles|0|t|' . Auth::user()->cod . '.jpg') }}" />
                        </div>
                        <div class="me-2 text-white"><b>{!! Auth::user()->nombres . '<br>' . Auth::user()->apellidos !!}</b>
                        </div>
                        <div class="p-2">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <div class="d-grid gap-2">
                                    <button type="submit" name="" id=""
                                        class="btn btn-sm btn-light">Salir</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/" style="height: 90px">
                    <img src="{{ asset('images/logo_instel.png') }}" alt="">
                </a>
                <div class="justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        @foreach ($menuGeneral[Auth::user()->rol] as $item)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is($item[1] . '*') ? 'menuActive' : '' }}"
                                    href="/{{ $item[1] }}">{{ $item[0] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4" style="min-height: 800px">
            @yield('content')
        </main>
    </div>

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
                                <a href="index.html"><img src="https://instel.edu.co/images/logo.svg"
                                        class="img-fluid" alt="logo"></a>
                            </div>

                            <div class="footer-text">
                                <h3>Misión Institucional</h3>
                                Hacer de los Medios de Comunicación el camino expedito para promover iniciativas de paz
                                para un país como Colombia en un ambiente de sana convivencia, participación democrática
                                y respetuosos de nuestros principios y de nuestra nacionalidad sin abandonar los
                                propósitos esenciales de informar, educar y entretener.
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
                                <li><a href="https://www.instel.edu.co/inscripciones"
                                        target="_blank">Inscripciones</a></li>
                                <li><a href="https://aclcolombia.com/" target="_blank">Asociación Colombiana de
                                        Locutores</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                        <div class="footer-widget">
                            <div class="footer-social-icon">
                                <span>Síguenos</span>
                                <a href="https://www.facebook.com/instelvirtual/" target="_blank"><i
                                        class="fab fa-facebook-f facebook-bg"></i></a>
                                <a href="https://www.twitter.com/instelvirtual/" target="_blank"><i
                                        class="fab fa-twitter twitter-bg"></i></a>
                                <a href="https://www.instagram.com/instelColombia/" target="_blank"><i
                                        class="fab fa-instagram google-bg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/instel.js') }}" defer></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    @yield('scripts')

    <script>
        function openProfile() {
            $('#myProfile').modal('show');
        }
        $('.cerrarModal').click(function() {
            $('.modal').modal('hide')
        })
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            if (output.width < output.height) {
                $('#fileHelpId').text("Recuerde que la foto debe ser vertical")
            }
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };
    </script>
</body>

</html>
