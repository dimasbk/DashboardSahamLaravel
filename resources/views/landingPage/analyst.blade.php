@extends('landingPage.template')

@section('content')
@vite(['resources/sass/newsArticle.scss', 'resources/css/analyst.css', 'resources/js/analyst.js'])

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="container">
        <div style="margin-top: 100px">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="link1" href="#">Who To Follow</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link2" href="#">Following</a>
                </li>
            </ul>
            <div id="page1">
                <!-- Content of page 1 -->
                @if ($toFollow == null)
                <h1>No One To Follow</h1>
                @else
                <div class="people" style="margin-top: 10px">
                    <ul class="people-list">
                        <div class="follow-btn-container">
                            @foreach ($toFollow as $follow)
                            <li class="person">
                                <span class="person-name">{{$follow['name']}}</span>
                                <div class="buttonProp">
                                    <button type="button" class="btn btn-primary profile-button"
                                        data-user-id="{{$follow['id']}}">
                                        Launch demo modal
                                    </button>
                                    <button class="follow-button follow-btn btn"
                                        data-user-id="{{$follow['id']}}">Subscribe</button>
                                </div>
                            </li>
                            @endforeach
                        </div>
                    </ul>
                </div>
                @endif

            </div>

            <div id="page2" style="display: none;">
                <!-- Content of page 2 -->
                @if ($existing == null)
                <h1>You dont follow anyone</h1>
                @else
                <div class="people" style="margin-top: 10px">
                    <ul class="people-list">
                        <div class="follow-btn-container">
                            @foreach ($existing as $existings)
                            <li class="person">
                                <span class="person-name">{{$existings['name']}}</span>
                                <div class="buttonProp">
                                    @if ($existings['status']=='subscribed')
                                    <a type="button" href="/profile/{{$existings['id']}}" class="follow-button btn">view
                                        profile</a>
                                    @endif
                                    <button class="profile-button btn"
                                        disabled>{{ucwords($existings['status'])}}</button>
                                </div>
                            </li>
                            @endforeach
                        </div>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>

<div class="modal fade" id="detailFollow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mt-5 d-flex justify-content-center">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <div class="image">
                                <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=80"
                                    id="pic" class="rounded" width="155">
                            </div>
                            <div style="margin-left: 10px" class="ml-3 w-100">
                                <h4 class="mb-0 mt-0" id="name">Alex HMorrision</h4>
                                <span>Analyst</span>
                                <div
                                    class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                                    <div class="d-flex flex-column">
                                        <span class="articles">Articles</span>
                                        <span class="number1" id="post">38</span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="followers">Followers</span>
                                        <span class="number2" id="followers">980</span>
                                    </div>
                                </div>
                                <div class="button mt-2 d-flex flex-row align-items-center">
                                    <div class="follow-btn-container">
                                        <button id="followBtn"
                                            class="follow-btn btn btn-sm btn-primary w-100 ml-2">Subscribe</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection