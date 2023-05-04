<head>
    @vite(['resources/js/landing.js','resources/sass/landing.scss'])
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    @yield('page-style-files')
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">SahamKU</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li class="nav-item">
                        <a class="nav-link" href="/landing-page">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/news">News</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Post
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="/post">Post</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                    href="/portofoliojual/{{Auth::id()}}">Analysts</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/search">Emiten Saham</a>
                    </li>
                    @auth
                    <li class="nav-item dropdown">
                        <a class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Portofolio
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                    href="/portofoliobeli/{{Auth::id()}}">Portofolio Beli</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                    href="/portofoliojual/{{Auth::id()}}">Portofolio Beli</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="/report">Report</a></li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">About Us</a></li>
                        </ul>
                    </li>
                    @endauth
                </ul>
                <ul class="nav navbar-nav navbar-right">
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
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>

    <main>
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>