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
    <style>
        .pic {
            max-height: 100px;
            width: auto;
        }

        img {
            margin-top: 10px;
            max-width: 450px;
            height: auto;
        }
    </style>
    @stop
</head>

<body>
    <div class="container">
        <form id="post-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="first-dropdown">Post type:</label>
                <select id="first-dropdown" class="form-select">
                    <option value="a">General</option>
                    <option value="b">Analisis</option>
                </select>
            </div>
            <div class="form-group">
                <label for="emitenSaham">Emiten Saham</label>
                <select id="emitenSaham" name="emitenSaham" disabled>
                    <option value="">Select Emiten Saham</option>
                    @foreach($saham as $item)
                    <option value="{{ $item->id_saham}}">{{ $item->nama_saham}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="post-title">Title</label>
                <input type="text" class="form-control" id="post-title" name="title" required>
                @if ($errors->any())
                <strong style="color: red">{{ $errors->first('title') }}</strong>
                @endif
            </div>
            <div class="form-group">
                <label for="post-content">Content</label>
                <textarea class="form-control" id="post-content" name="content" rows="4" required></textarea>
                @if ($errors->any())
                <strong style="color: red">{{ $errors->first('content') }}</strong>
                @endif
            </div>
            <div class="form-group">
                <label>
                    <input type="radio" name="tag" value="public">
                    Public
                </label>

                <label>
                    <input type="radio" name="tag" value="private">
                    Private
                </label>
                @if ($errors->any())
                <strong style="color: red">{{ $errors->first('tag') }}</strong>
                @endif
            </div>
            <div class="form-group">
                <label for="post-image">Image (optional)</label>
                <input type="file" class="form-control-file" id="post-image" onchange="previewImage()" name="image">
                <br>
                <img id="preview">
                <div class="invalid-feedback" id="image-invalid-feedback"></div>
            </div>
            <div class="float-right">
                <div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submit-button">Submit</button>
                    </div>
                    <div id="loading-spinner" style="display:none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        function previewImage() {
                const preview = document.getElementById("preview");
                const file = document.getElementById("post-image").files[0];
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
    @vite(['resources/js/post.js'])


    @section('page-js-files')
    <script src="{{asset('style')}}/table/js/popper.min.js"></script>
    <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
    <script src="{{asset('style')}}/table/js/main.js"></script>

    <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
    <script src="{{asset('template')}}/js/post.js"></script>

    @stop
</body>



@endsection