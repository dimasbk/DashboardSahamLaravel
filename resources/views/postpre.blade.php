@extends('landingPage.template')

@section('content')

<div class="">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        </div>
        <div class="card-body">
            <ul id="posts">
                <div id="image" style=" width:560px; height:315px" class="col-md-4 d-flex aligns-items-center">
                    @if (!empty($postData->picture))
                    <img id="img" style="aspect-ratio: 16/9; object-fit:contain;"
                        src="{{asset('images')}}/public_images/{{$postData->picture}}" alt="Post Header Image"
                        class="img-fluid rounded-start">
                    @endif
                </div>
                <article>
                    <header>
                        <h1 style="margin-top: 25px">{{$postData->title}}</h1>
                    </header>
                    <h4>By : {{$postData->name}}</h4>
                    <p style="margin-top: 10px">{{$postData->content}}</p>
                </article>
            </ul>
        </div>
    </div>
</div>

<style>
    body {
        margin: 0;
        font-family: 'Liberation Sans', Arial, sans-serif;
    }

    p {
        white-space: pre-line;
    }

    h1 {
        text-align: center;
    }

    #image {
        display: block;
        margin-left: auto;
        margin-top: 10px;
        margin-right: auto;
    }

    img {
        height: 63%;
    }

    #posts {
        margin: 0 auto;
        padding: 0;
        width: 700px;
        list-style-type: none;
    }

    article h1 {
        text-align: left;
        border-bottom: 1px dotted #E3E3E3;
    }

    article p {
        text-align: justify;
        line-height: 1.5;
        font-size: 1.1em;
    }
</style>
@endsection