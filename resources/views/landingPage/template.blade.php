<head>
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    @yield('page-style-files')
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">SahamKU</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/news">News</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menu1" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Blog</a>
                    <ul class="dropdown-menu" aria-labelledby="menu1">
                        <li><a class="dropdown-item" href="/post">Post</a></li>
                        @auth
                        <li><a class="dropdown-item" href="/analyst">Analysts</a></li>
                        @endauth
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/search">Emiten Saham</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/technical">Technical</a>
                </li>
                <!--
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menu2" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Portofolio</a>
                    <ul class="dropdown-menu" aria-labelledby="menu2">
                        <li><a class="dropdown-item" href="/portofoliobeli/{{Auth::id()}}">Portofolio Beli</a></li>
                        <li><a class="dropdown-item" href="/portofoliojual/{{Auth::id()}}">Portofolio Jual</a></li>
                        <li><a class="dropdown-item" href="/report">Report</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">About Us</a></li>
                    </ul>
                </li>
                @endauth
            -->
            </ul>
            <ul class="navbar-nav">
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">Dashboard</a>
                </li>
                @endauth
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Register</a>
                </li>
                @endguest
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{
                        __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main>
    <div class="content-wrapper">
        @yield('content')
    </div>
</main>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
</body>