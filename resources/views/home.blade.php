@extends('template.master')

@section('content')
<html>

<head>
    <link rel="stylesheet" href="{{asset('template')}}/css/article.css">
</head>

<body>

    <ul class="cards">
        <?php $i = 1 ?>
        @foreach ($data as $item)

        <li class="cards__item">
            <div class="card">
                <div class="card__image card__image--fence{{$i}}"></div>
                <div class="card__content">
                    <div class="card__title">{{$item['title']}}</div>
                    <p class="card__text">{{$item['description']}}</p>
                    <button onclick="location.href='{{$item['url']}}'" class="btn btn--block card__btn">Read
                        More</button>
                </div>
            </div>
        </li>
        <style>
            .card__image--fence{{$i}} {
                background-image: url({{$item['urlToImage']}});
            }
        </style>
        <?php $i++ ?>
        @endforeach
    </ul>

</body>

</html>
@endsection