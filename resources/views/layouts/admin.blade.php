@php
    $menuG = [
        ['Comunicaciones', ['/anuncios', 'fa-bullhorn', 'Anuncio']],
        ['Usuarios', ['/users/estudiante', 'fa-book', 'Estudiantes'], ['/users/docente ', 'fa-person-chalkboard', 'Docentes'], ['/users/egresados', 'fa-graduation-cap', 'Egresados'], ['/inscripciones', 'fa-pen', 'Inscritos'], ['/certificados-int', 'fa-certificate', 'C. Internacional']],
        ['Académico', ['/modulos', 'fa-book-open-reader', 'Módulos'], ['/data-seminars', 'fa-lightbulb', 'Sesiones Seminario'], ['#promedios', 'fa-trophy', 'Promedios Semestre'], ['/promedios-totales', 'fa-medal', 'Promedios Carrera'], ['/info-gral', 'fa-paperclip', 'Información General'], ['/entr', 'fa-book', 'Ver Entregas'], ['/blacklist/list', 'fa-triangle-exclamation', 'Repos. / Recup.'], ['/salas', 'fa-person-chalkboard', 'SalasPráctica'], ['/listazoom/0', 'fa-video', 'Programación Clases'], ['/pa', 'fa-cube', 'Pruebas de Aptitud']],
        ['Financiero', ['/financiero/pagos-realizados', 'fa-cash-register', 'Pagos Realizados'], ['/financiero/pagares-creditos', 'fa-credit-card', 'Financiamiento']],
        ['Administrador', ['/log', 'fa-key', 'Rastreo Login'], ['/generarlista/0', 'fa-list', 'Generar Listado'], ['/sabana', 'fa-check', 'Sábana General'], ['/encuestas', 'fa-chart-pie', 'Encuestas'], ['/oferta', 'fa-star', 'Oferta Académica'], ['/textos/convenios/0', 'fa-handshake', 'Convenios'], ['/textos/noticias/0', 'fa-newspaper', 'Noticias']],
    ];
    $periodosLetra = Session::get('config')['gruposNombre'];
@endphp

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="font-weight: bold">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" height="50" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Inicio</a>
                    </li>
                    @for ($i = 0; $i < count($menuG); $i++)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $menuG[$i][0] }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                                @for ($j = 1; $j < count($menuG[$i]); $j++)
                                    <li>
                                        <a href="{{ $menuG[$i][$j][0] }}" class="dropdown-item">
                                            <i class="fa-solid {{ $menuG[$i][$j][1] }}" style="margin-right: 10px"></i>
                                            {{ $menuG[$i][$j][2] }}
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </li>
                    @endfor

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            [ Salir ]
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 90px">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">{!! $message !!}</div>
        @endif
        <main class="py-4">
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
                                <a href="index.html"><img src="https://instel.edu.co/images/logo.svg" class="img-fluid"
                                        alt="logo"></a>
                            </div>

                            <div class="footer-text">
                                <h3>Misión Institucional</h3>
                                Hacer de los Medios de Comunicación el camino expedito para promover iniciativas de
                                paz para un país como Colombia en un ambiente de sana convivencia, participación
                                democrática y respetuosos de nuestros principios y de nuestra nacionalidad sin
                                abandonar los propósitos esenciales de informar, educar y entretener.
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
                                <li><a href="https://www.instel.edu.co/admisiones" target="_blank">Admisiones</a>
                                </li>
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

    </div>


    <form action="/promedio" method="POST" class="modal fade" id="promediosFiltroSearch" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        @csrf
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Criterios de Filtro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="fecha">Grupo:</label>
                    <select class="form-select form-select" name="grupo">
                        @for ($i = 2000; $i <= date('Y') + 1; $i++)
                            @for ($j = 1; $j < count($periodosLetra); $j++)
                                <option value="{{ $i . $j }}"{{ $i == date('Y') ? ' selected' : '' }}>
                                    {{ $i }} - {{ $periodosLetra[$j] }}
                                </option>
                            @endfor
                        @endfor
                    </select>

                    <label for="" class="form-label">Semestre</label>
                    <select class="form-select" name="ciclo" onchange="buscaLista()" id="cicloID">
                        <option value="">Seleccione</option>
                        <option value="1">Semestre 1</option>
                        <option value="2">Semestre 2</option>
                        <option value="3">Semestre 3</option>
                        <option value="4">Semestre de Profudización Animación Musical y Presentación de
                            Espectáculos</option>
                        <option value="5">Semestre de Profudización Lectura de Noticias y Periodismo Radial
                        </option>
                        <option value="6">Semestre de Profudización Periodismo y Locución Deportiva</option>
                        <option value="7">Semestre de Profudización Locución y Presentación de Televisión</option>
                        <option value="8">Semestre de Profudización Producción y Locución Comercial</option>
                        <option value="9">Diplomado en Comunicación Organizacional con énfasis en Jefatura de
                            Prensa</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </div>
    </form>



    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/instel.js') }}"></script>


    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
    https://firebase.google.com/docs/web/setup#available-libraries -->

    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyCBVYziGDCS2sMLxrGGm7PtG83XeJedfAE",
            authDomain: "instel-cali.firebaseapp.com",
            projectId: "instel-cali",
            storageBucket: "instel-cali.appspot.com",
            messagingSenderId: "1068845546830",
            appId: "1:1068845546830:web:ade61255df7944da75321f"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function startFCM() {
            messaging
                .requestPermission()
                .then(function() {
                    return messaging.getToken()
                })
                .then(function(response) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route('fcmToken') }}',
                        type: 'POST',
                        data: {
                            token: response
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            console.log('Token stored.');
                        },
                        error: function(error) {
                            console.log(error);
                        },
                    });
                }).catch(function(error) {
                    console.log(error);
                });
        }

        startFCM();

        messaging.onMessage(function(payload) {
            const title = payload.notification.title;
            const options = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(title, options);
        });

        $('a[href="#promedios"]').on('click', function() {
            $('#promediosFiltroSearch').modal('show');
        });
    </script>

    @yield('scripts')
</body>

</html>
