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

    @vite(['resources/css/landingPage.css'])

    <title>SahamKU</title>
</head>



<body>
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-scroll">
            <div class="container-fluid">
                <a class="navbar-brand" href="#!">SahamKU</a>
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#!">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#!">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#!">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#!">Attractions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#!">Opinions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#!">Contact</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav d-flex flex-row">
                        <li class="nav-item me-3 me-lg-0">
                            <a class="nav-link" href="#!">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                        <li class="nav-item me-3 me-lg-0">
                            <a class="nav-link" href="#!">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li class="nav-item me-3 me-lg-0">
                            <a class="nav-link" href="#!">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar -->

        <!--Section: Design Block-->
        <section>
            <div id="intro" class="bg-image" style="
              background-image: url('{{asset('images')}}/6256878.jpg');
              height: 100vh;
            ">
                <div class="mask" style="background-color: rgba(0, 0, 0, 0.2);">
                    <div class="container d-flex justify-content-center align-items-center h-100">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h1 class="mb-0 text-white display-1">Saham</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Section: Design Block-->
    </header>


    <main>
        <div class="container">
            <div class="owl-carousel owl-1">
                @foreach ($post as $item)
                <div class="media-29121 overlay"
                    style="background-image: url('{{asset('images')}}/public_images/{{$item->picture}}');backdrop-filter: blur(5px); ">
                    <div class="container">
                        <div class="row justify-content-center align-items-center text-center">
                            <div class="col-md-7">
                                <h2>{{$item->title}}</h2>
                                <a href="">Read More...</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
    <script src="{{asset('carousel-13')}}/js/jquery-3.3.1.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/popper.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/bootstrap.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/owl.carousel.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/main.js"></script>
    <script src="{{asset('mdb')}}/js/mdb.min.js"></script>
    <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
</body>

</html>