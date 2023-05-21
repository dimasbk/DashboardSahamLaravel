<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        </div>
        <div class="card-body">
            <ul id="posts">
                <div id="image" class="col-md-4 d-flex aligns-items-center">
                    @if (!empty($postData->picture))
                    <img src="{{asset('images')}}/public_images/{{$postData->picture}}" alt="Post Header Image"
                        class="img-fluid rounded-start">
                    @endif
                </div>
                <article>
                    <header>
                        <h1>{{$postData->title}}</h1>
                    </header>

                    <p>{{$postData->content}}</p>
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