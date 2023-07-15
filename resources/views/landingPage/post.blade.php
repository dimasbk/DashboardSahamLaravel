@extends('landingPage.template')

@section('content')
@vite(['resources/sass/post.scss', 'resources/js/app.js'])
@vite(['resources/sass/post.scss', 'resources/css/newsArticle.css'])

<div class="container">
    <div style="margin-top: 100px">
        @auth
        <div>
            @if (Auth::user()->id_roles == 2)
            <a href="/post/manage" class="btn btn-primary">Manage Post</a>
            @endif
        </div>
        @endauth

        <section class="articles">
            @foreach ($postData as $item)
            <article>
                <div class="article-wrapper">
                    <figure>
                        <img src="{{asset('images')}}/public_images/{{$item->picture}}" alt="" />
                    </figure>
                    <div class="article-body">
                        <h2>{{$item->title}}</h2>
                        <h6>By {{$item->name}}</h6>
                        <p>
                            {{Str::limit($item->content, 100)}}
                        </p>
                        <h6>Last updated {{\Carbon\Carbon::parse($item->updated_at)->diffForHumans()}}</h6>
                        <a href="/post/view/{{$item->id_post}}" class="read-more">
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
</div>

@endsection