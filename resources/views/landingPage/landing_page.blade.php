@extends('landingPage.template')

@section('content')
@vite(['resources/css/landingPage.css','resources/sass/landingPage.scss','resources/js/landingPage.js'])
<section>
    <div class="carousel">
        <div class="progress-bar progress-bar--primary hide-on-desktop">
            <div class="progress-bar__fill"></div>
        </div>

        <header class="main-post-wrapper">

            <div class="slides">
                <article class="main-post main-post--active">
                    <div class="main-post__image">
                        <img src="{{asset('images')}}/public_images/{{$post[0]['picture']}}" />
                    </div>
                    <div class="main-post__content">
                        <div class="main-post__tag-wrapper">
                            @if ($post[0]['id_saham'] === null)
                            <span class="main-post__tag">General</span>
                            @endif
                            <span class="main-post__tag">Analisis</span>
                        </div>
                        <h1 class="main-post__title">{{$post[0]['title']}}</h1>
                        <a class="main-post__link" href="/post/view/{{$post[0]['id_post']}}">
                            <span class="main-post__link-text">find out more</span>
                            <svg class="main-post__link-icon main-post__link-icon--arrow" width="37" height="12"
                                viewBox="0 0 37 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 6H36.0001M36.0001 6L31.0001 1M36.0001 6L31.0001 11" stroke="white" />
                            </svg>
                        </a>
                    </div>
                </article>
                <article class="main-post main-post--not-active">
                    <div class="main-post__image">
                        <img src="{{asset('images')}}/public_images/{{$post[1]['picture']}}" />
                    </div>
                    <div class="main-post__content">
                        <div class="main-post__tag-wrapper">
                            @if ($post[0]['id_saham'] === null)
                            <span class="main-post__tag">General</span>
                            @endif
                            <span class="main-post__tag">Analisis</span>
                        </div>
                        <h1 class="main-post__title">{{$post[1]['title']}}</h1>
                        <a class="main-post__link" href="/post/view/{{$post[1]['id_post']}}">
                            <span class="main-post__link-text">find out more</span>
                            <svg class="main-post__link-icon main-post__link-icon--arrow" width="37" height="12"
                                viewBox="0 0 37 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 6H36.0001M36.0001 6L31.0001 1M36.0001 6L31.0001 11" stroke="white" />
                            </svg>
                        </a>
                    </div>
                </article>
                <article class="main-post main-post--not-active">
                    <div class="main-post__image">
                        <img src="{{asset('images')}}/public_images/{{$post[2]['picture']}}" />
                    </div>
                    <div class="main-post__content">
                        <div class="main-post__tag-wrapper">
                            @if ($post[0]['id_saham'] === null)
                            <span class="main-post__tag">General</span>
                            @endif
                            <span class="main-post__tag">Analisis</span>
                        </div>
                        <h1 class="main-post__title">{{$post[2]['title']}}
                        </h1>
                        <a class="main-post__link" href="/post/view/{{$post[2]['id_post']}}">
                            <span class="main-post__link-text">find out more</span>
                            <svg class="main-post__link-icon main-post__link-icon--arrow" width="37" height="12"
                                viewBox="0 0 37 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 6H36.0001M36.0001 6L31.0001 1M36.0001 6L31.0001 11" stroke="white" />
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
{{-- <div class="container">
    <div class="row" style="margin-top: 50px;">
        <div class="col-md-6">
            <h1>Top Gainer Saham</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Ticker</th>
                        <th>Close</th>
                        <th>Change</th>
                        <th>Percent</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topGainers as $topGainer)
                    <tr>
                        <td><a style="text-decoration: none; color: black"
                                href="/emiten/{{$topGainer['ticker']}}">{{$topGainer['ticker']}}</a></td>
                        <td>{{$topGainer['close']}}</td>
                        <td>{{$topGainer['change']}}</td>
                        <td style="color: green">{{round($topGainer['percent'], 2)}}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h1>Top Loser Saham</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Ticker</th>
                        <th>Close</th>
                        <th>Change</th>
                        <th>Percent</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topLosers as $topLoser)
                    <tr>
                        <td>
                            <a style="text-decoration: none; color: black"
                                href="/emiten/{{$topLoser['ticker']}}">{{$topLoser['ticker']}}</a>
                        </td>
                        <td>{{$topLoser['close']}}</td>
                        <td>{{$topLoser['change']}}</td>
                        <td style="color: red">{{round($topLoser['percent'], 2)}}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <h1>Tren Saham</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ticker</th>
                    <th>Trend</th>
                    <th>Change</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trends as $trend)
                <tr>
                    <td><a style="text-decoration: none; color: black"
                            href="/emiten/{{$trend['ticker']}}">{{$trend['ticker']}}</a></td>
                    <td>{{Str::title($trend['trend'])}}</td>
                    @if ($trend['trend'] == 'uptrend')
                    <td style="color: green">{{round($trend['change'], 2)}}%</td>
                    @endif
                    @if ($trend['trend'] == 'downtrend')
                    <td style="color: red">-{{round($trend['change'], 2)}}%</td>
                    @endif
                    @if ($trend['trend'] == 'sideways')
                    <td>{{round($trend['change'], 2)}}%</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> --}}


@endsection
