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
    <link rel="stylesheet" href="{{asset('style')}}/table/css/style.css">
    <link rel="stylesheet" href="{{asset('style')}}/portoBeli.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
        integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" />
    @stop

</head>

<body>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Edit Post</h6>
        </div>
        <div class="card-body">
            <form action="/admin/post/edit" id="form_beli" name="postedit" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$post[0]['id_post']}}">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{$post[0]['title']}}"
                        placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label>Visibility</label>
                    @if ($post[0]['tag']=='public')
                    <div class="form-check">
                        <input class="form-check-input" checked type="radio" name="tag" id="public" value="public">
                        <label class="form-check-label" for="public">
                            Public
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tag" id="private" value="private">
                        <label class="form-check-label" for="private">
                            Private
                        </label>
                    </div>
                    @else
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tag" id="public" value="public">
                        <label class="form-check-label" for="public">
                            Public
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" checked type="radio" name="tag" id="private" value="private">
                        <label class="form-check-label" for="private">
                            Private
                        </label>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea style="height: auto" class="form-control" name="content" id="content"
                        rows="3">{{$post[0]['content']}}</textarea>
                </div>
                <div class="form-group">
                    <img id="preview" style="max-height: 200px"
                        src="{{asset('images')}}/public_images/{{$post[0]['picture']}}" alt="" /><br>
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control-file" id="image" onchange="previewImage()">
                </div>
                <button type=" submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    @section('page-js-files')
    <script>
        $(document).ready(function() {
            $('#content').trigger('input');
        });
        // Dynamically adjust the height of the textarea based on its content
        $('#content').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        function previewImage() {
                const preview = document.getElementById("preview");
                const file = document.getElementById("image").files[0];
                const reader = new FileReader();

                reader.addEventListener(
                "load",
                function () {
                    preview.src = reader.result;
                },
                false
                );

                if (file) {
                reader.readAsDataURL(file);
                }
            }
    </script>

    <script src="{{asset('style')}}/table/js/popper.min.js"></script>
    <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
    <script src="{{asset('style')}}/table/js/main.js"></script>
    <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
    @stop
</body>
@endsection