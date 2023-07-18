@extends('landingPage.template')

@section('content')
@vite(['resources/sass/newsArticle.scss', 'resources/css/userProfile.css', 'resources/js/analyst.js'])

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script></script>
</head>

<body>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <div class="content-profile-page">
        <div class="profile-user-page card">
            <div class="img-user-profile">
                <div class="profile-bgHome" style="background-color: black"></div>
                @if ($data['profileData']['profile_picture'])
                <img class="avatar" src="{{$data['profileData']['profile_picture']}}" alt="profile_picture" />
                @else
                <img class="avatar" src="{{asset('default.jpg')}}" alt="profile_picture" />
                @endif
            </div>
            <div class="user-profile-data">
                <h1>{{$data['profileData']['name']}}</h1>
                <p>Analyst</p>
            </div>
            {{-- <div class="description-profile">Harga Per Bulan : Rp.
                {{number_format($data['profileData']['price_per_month'])}}</div> --}}
            <ul class="data-user">
                <li><a><strong>{{$data['postCount']}}</strong><span>Posts</span></a></li>
                <li><a><strong>{{$data['followers']}}</strong><span>Followers</span></a></li>
            </ul>
            <div class="description-profile" style="margin-bottom: 10px">
                <p class="lead fw-normal mb-0">Recent stock transaction</p>
                @if (Auth::id() == $data['profileData']['id'])
                <p class="mb-0"><a href="/portofoliobeli/" class="text-muted">Show
                        all</a></p>
                @else
                <p class="mb-0"><a href="/portofoliobeli/analyst/{{$data['profileData']['id']}}" class="text-muted">Show
                        all</a></p>
                @endif
            </div>
            <div class="row">
                <div class="col-xl-12">
                    @if ($data['porto'] == null)
                    <div class="d-flex align-items-center justify-content-center">
                        <h6><strong>Belum ada transaksi</strong></h6>
                    </div>
                    @endif
                    @foreach ($data['porto'] as $dataPorto)
                    <div class="card mb-3 card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <a href="#!.html">
                                    @if ($dataPorto['status'] == 'buy')
                                    <h2 style="color: green">BUY</h2>
                                    @else
                                    <h2 style="color: red">SELL</h2>
                                    @endif
                                </a>
                            </div>
                            <div class=" col">
                                <div class="overflow-hidden flex-nowrap">
                                    <h4 class="mb-1">
                                        {{$dataPorto['nama_saham']}}
                                    </h4>
                                    <h6 class=" mb-1">
                                        {{$dataPorto['harga']}}
                                    </h6>
                                    <span class="text-muted d-block mb-2 small">
                                        {{$dataPorto['time']}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="description-profile" style="margin-bottom: 10px">
                    <p class="lead fw-normal mb-0">Recent post</p>
                    <p class="mb-0"><a href="" class="text-muted">Show all</a></p>
                </div>
                <div class="row g-2">
                    @foreach ($data['post'] as $posts)
                    <div class="news-card">
                        <a href="#" class="news-card__card-link"></a>
                        <img src="{{asset('images')}}/public_images/{{$posts['picture']}}" alt=""
                            class="news-card__image">
                        <div class="news-card__text-wrapper">
                            <h2 class="news-card__title">{{$posts['title']}}</h2>
                            <div class="news-card__post-date">{{date('M d, Y', strtotime($posts['created_at']))}}</div>
                            <div class="news-card__details-wrapper">
                                <p class="news-card__excerpt">{{Str::limit($posts['content'], 100)}}</p>
                                <a href="/post/view/{{$posts['id_post']}}" class="news-card__read-more">Read more <i
                                        class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>



@endsection
