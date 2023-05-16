@extends('landingPage.template')

@section('content')
@vite(['resources/sass/newsArticle.scss', 'resources/css/analyst.css', 'resources/js/analyst.js'])

<head>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
        integrity="sha384-1dM6U4ne6U2xZUMgX9hgeS0S1vTTpG6luUP/oA4dSl6m4l6FQJnhC/3XeyQTrxrW" crossorigin="anonymous">

    <!-- JavaScript and dependencies -->
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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
                        <div class="follow-buttons-container">
                            @foreach ($toFollow as $follow)
                            <li class="person">
                                <span class="person-name">{{$follow['name']}}</span>
                                <button class="follow-button btn" data-user-id="{{$follow['id']}}">Subscribe</button>
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
                        <div class="follow-buttons-container">
                            @foreach ($existing as $existings)
                            <li class="person">
                                <span class="person-name">{{$existings['name']}}</span>
                                <div class="buttonProp">
                                    <button class="follow-button btn">view profile</button>
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

@endsection