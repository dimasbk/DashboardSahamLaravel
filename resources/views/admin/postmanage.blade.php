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
        <div style="margin-top: 10px" class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Manage Post</h6>
            </div>
            @if (session('status'))
            <div style="margin-top: 10px" class="alert alert-success alert-dismissible" role="alert">
                {{session('status')}}
            </div>
            @endif
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No </th>
                            <th class="w-25">Title</th>
                            <th>Creator</th>
                            <th>Tag</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="post-table-body">
                        <?php $i = 1 ?>
                        @foreach ($postData as $item)
                        <tr>
                            <td style="display:none;">{{$item->id_post}}</td>
                            <td>{{$i }}</td>
                            <?php $i++ ?>
                            <td>{{$item->title}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{ucfirst($item->tag)}}</td>
                            <!--
                            <td><img class="pic" src="{{asset('images')}}/public_images/{{$item->picture}}"
                                    alt="My Image"></td>
                                    -->
                            <td>
                                <button onclick="location.href='/admin/post/edit/{{$item->id_post}}'"
                                    class="btn btn-success" type="button"><i class="fas fa-edit"></i></button>
                                <button data-toggle="modal" data-target="#delete" type="button"
                                    class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                <button onclick="location.href='/admin/post/delete/{{$item->id_post}}'" type="button"
                                    class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                            </td>
                            <div id="delete" class="modal fade">
                                <div class="modal-dialog modal-confirm">
                                    <div class="modal-content">
                                        <div class="modal-header flex-column">
                                            <div class="icon-box">
                                                <i class="fa-solid fa-circle-xmark"></i>
                                            </div>
                                            <h4 class="modal-title w-100">Are you sure?</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda Yakin Untuk Menghapus Data?</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <button onclick="location.href='/admin/post/delete/{{$item->id_post}}'"
                                                type="button" class="btn btn-primary">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $postData->links() }}
            </div>
        </div>
        <div class="modal fade" id="modalPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                                <div class="invalid-feedback" id="title-invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="post-content">Content</label>
                                <textarea class="form-control" id="post-content" name="content" rows="4"
                                    required></textarea>
                                <div class="invalid-feedback" id="content-invalid-feedback"></div>
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
                                <div class="invalid-feedback" id="tag-invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="post-image">Image (optional)</label>
                                <input type="file" class="form-control-file" id="post-image" onchange="previewImage()"
                                    name="image">
                                <img id="preview">
                                <div class="invalid-feedback" id="image-invalid-feedback"></div>
                            </div>
                            <div class="float-right">
                                <div>
                                    <div>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
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

                </div>
            </div>
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


        @section('page-js-files')
        <script src="{{asset('style')}}/table/js/popper.min.js"></script>
        <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
        <script src="{{asset('style')}}/table/js/main.js"></script>

        <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
        <script src="{{asset('template')}}/js/post.js"></script>

        @stop
</body>



@endsection