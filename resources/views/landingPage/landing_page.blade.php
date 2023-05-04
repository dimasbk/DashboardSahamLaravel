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
                            <span class="main-post__tag">Article</span>
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
                            <span class="main-post__tag">Article</span>
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
                            <span class="main-post__tag">Article</span>
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
<div class="container">
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
                    <tr>
                        <td>AAPL</td>
                        <td>130.48</td>
                        <td>-1.12</td>
                        <td>-0.85%</td>
                    </tr>
                    <tr>
                        <td>GOOG</td>
                        <td>2393.57</td>
                        <td>+1.89</td>
                        <td>+0.08%</td>
                    </tr>
                    <tr>
                        <td>FB</td>
                        <td>316.30</td>
                        <td>+2.56</td>
                        <td>+0.82%</td>
                    </tr>
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
                    <tr>
                        <td>AMZN</td>
                        <td>3467.42</td>
                        <td>-6.57</td>
                        <td>-0.19%</td>
                    </tr>
                    <tr>
                        <td>TSLA</td>
                        <td>709.44</td>
                        <td>-5.21</td>
                        <td>-0.73%</td>
                    </tr>
                    <tr>
                        <td>NFLX</td>
                        <td>496.08</td>
                        <td>+2.11</td>
                        <td>+0.43%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection