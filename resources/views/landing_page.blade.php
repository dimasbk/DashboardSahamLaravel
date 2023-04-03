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

    @vite(['resources/css/landingPage.css','resources/sass/landingPage.scss','resources/js/landingPage.js'])

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
            <div class="carousel">
                <div class="progress-bar progress-bar--primary hide-on-desktop">
                    <div class="progress-bar__fill"></div>
                </div>

                <header class="main-post-wrapper">

                    <div class="slides">
                        <article class="main-post main-post--active">
                            <div class="main-post__image">
                                <img src="{{asset('images')}}/public_images/{{$post[0]['picture']}}"
                                    alt="New McLaren wind tunnel 'critical' to future performance, says Tech Director Key" />
                            </div>
                            <div class="main-post__content">
                                <div class="main-post__tag-wrapper">
                                    <span class="main-post__tag">Article</span>
                                </div>
                                <h1 class="main-post__title">{{$post[0]['title']}}</h1>
                                <a class="main-post__link" href="/post/view/{{$post[0]['id_post']}}">
                                    <span class="main-post__link-text">find out more</span>
                                    <svg class="main-post__link-icon main-post__link-icon--arrow" width="37" height="12"
                                        viewBox="0 0 37 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 6H36.0001M36.0001 6L31.0001 1M36.0001 6L31.0001 11"
                                            stroke="white" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                        <article class="main-post main-post--not-active">
                            <div class="main-post__image">
                                <img src="{{asset('images')}}/public_images/{{$post[1]['picture']}}"
                                    alt="What To Watch For in the 2019 Hungarian Grand Prix" />
                            </div>
                            <div class="main-post__content">
                                <div class="main-post__tag-wrapper">
                                    <span class="main-post__tag">Article</span>
                                </div>
                                <h1 class="main-post__title">{{$post[1]['title']}}</h1>
                                <a class="main-post__link" href="/post/view/{{$post[1]['id_post']}}">
                                    <span class="main-post__link-text">find out more</span>
                                    <svg class="main-post__link-icon main-post__link-icon--arrow" width="37" height="12"
                                        viewBox="0 0 37 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 6H36.0001M36.0001 6L31.0001 1M36.0001 6L31.0001 11"
                                            stroke="white" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                        <article class="main-post main-post--not-active">
                            <div class="main-post__image">
                                <img src="{{asset('images')}}/public_images/{{$post[2]['picture']}}" alt="Hamilton wants harder championship fight from Leclerc and
                          Verstappen" />
                            </div>
                            <div class="main-post__content">
                                <div class="main-post__tag-wrapper">
                                    <span class="main-post__tag">Article</span>
                                </div>
                                <h1 class="main-post__title">{{$post[2]['title']}}
                                </h1>
                                <a class="main-post__link" href="/post/view/{{$post[2]['id_post']}}">
                                    <span class="main-post__link-text">find out more</span>
                                    <svg class="main-post__link-icon main-post__link-icon--arrow" width="37" height="12"
                                        viewBox="0 0 37 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 6H36.0001M36.0001 6L31.0001 1M36.0001 6L31.0001 11"
                                            stroke="white" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    </div>
                </header>

                <div class="posts-wrapper hide-on-mobile">
                    <article class="post post--active">
                        <div class="progress-bar">
                            <div class="progress-bar__fill"></div>
                        </div>
                        <header class="post__header">
                            <span class="post__tag">News</span>
                            <p class="post__published">{{date('M j Y g:i A', strtotime($post[0]['created_at']))}}</p>
                        </header>
                        <h2 class="post__title">{{substr($post[0]['content'], 0, 200)}}...
                        </h2>
                    </article>
                    <article class="post">
                        <div class="progress-bar">
                            <div class="progress-bar__fill"></div>
                        </div>
                        <header class="post__header">
                            <span class="post__tag">News</span>
                            <p class="post__published">{{date('M j Y g:i A', strtotime($post[1]['created_at']))}}</p>
                        </header>
                        <h2 class="post__title">{{substr($post[1]['content'], 0, 200)}}...
                        </h2>
                    </article>
                    <article class="post">
                        <div class="progress-bar">
                            <div class="progress-bar__fill"></div>
                        </div>
                        <header class="post__header">
                            <span class="post__tag">News</span>
                            <p class="post__published">{{date('M j Y g:i A', strtotime($post[2]['created_at']))}}</p>
                        </header>
                        <h2 class="post__title">{{substr($post[0]['content'], 0, 200)}}...
                        </h2>
                    </article>
                </div>
            </div>
        </section>
        <!--Section: Design Block-->
    </header>


    <main></main>

    <script src="{{asset('carousel-13')}}/js/jquery-3.3.1.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/popper.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/bootstrap.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/owl.carousel.min.js"></script>
    <script src="{{asset('carousel-13')}}/js/main.js"></script>
    <script src="{{asset('mdb')}}/js/mdb.min.js"></script>
    <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
</body>

</html>