<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('carousel-13')}}/fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{asset('carousel-13')}}/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('carousel-13')}}/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="{{asset('carousel-13')}}/css/style.css">

    <link rel="stylesheet" href="{{asset('mdb')}}/css/mdb.min.css">

    @vite(['resources/css/landingPage.css','resources/sass/landingPage.scss'])
    @yield('page-style-files')
    <title>SahamKU</title>
</head>



<body>
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
            <div class="container">
                <a class="navbar-brand" href="#!"><span style="color: #5e9693;">Saham</span><span
                        style="color: #4f4f4f;">KU</span></a>
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/landing-page">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/news">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/post">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/search">Emiten Saham</a>
                        </li>
                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Portofolio
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                        @endauth
                    </ul>
                    <ul class="navbar-nav d-flex flex-row">
                        @guest
                        <li class="nav-item me-3 me-lg-0">
                            <a class="nav-link" href="/login">
                                Login
                            </a>
                        </li>
                        <li class="nav-item me-3 me-lg-0">
                            <a class="nav-link" href="/register">
                                Register
                            </a>
                        </li>
                        @endguest
                        @auth
                        <li class="nav-item me-3 me-lg-0">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                        </li>
                        @endauth
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            </div>
        </nav>

        <!-- Navbar -->

        <!--Section: Design Block-->

    </header>


    <main>
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>
    @yield('page-js-files')
    <script src="{{asset('carousel-13')}}/js/jquery-3.3.1.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/popper.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/bootstrap.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/owl.carousel.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/main.js"></script>
    <script src="{{asset('mdb')}}/js/mdb.min.js"></script>
    <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
</body>

</html>