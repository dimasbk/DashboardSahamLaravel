@extends('layouts.master')

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @section('page-style-files')
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <script src="{{asset('style')}}/table/js/jquery-3.5.1.js"></script>

    <link rel="stylesheet" href="{{asset('style')}}/table/fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{asset('style')}}/table/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('style')}}/table/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="{{asset('style')}}/table/css/style.css">
    @vite(['resources/sass/post.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('style')}}/post.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" />
    @vite(['resources/sass/post.scss', 'resources/css/newsArticle.css'])
    @stop
</head>

<body>
    <div class="container">
        @if (Auth::user()->id_roles == 3)

        @else
        <a href="/post/manage" class="btn btn-default btn-rounded mt-4 mb-4">Manage Post</a>
        @endif

        <section class="articles">
            @foreach ($postData as $item)
            <article>
                <div class="article-wrapper">
                    <figure>
                        <img src="{{asset('images')}}/public_images/{{$item->picture}}" alt="" />
                    </figure>
                    <div class="article-body">
                        <h2>{{$item->title}}</h2>
                        <p>
                            {{Str::limit($item->content, 100)}}
                        </p>
                        <a href="/post/view" class="read-more">
                            Read more <span class="sr-only">about this is some title</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </section>
    </div>
    @section('page-js-files')
    <script src="{{asset('style')}}/table/js/popper.min.js"></script>
    <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
    <script src="{{asset('style')}}/table/js/main.js"></script>

    <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>

    @stop
</body>



@endsection