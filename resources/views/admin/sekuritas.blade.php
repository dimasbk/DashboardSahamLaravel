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
        @if (session('status'))
        <div style="margin-top: 10px" class="alert alert-success alert-dismissible" role="alert">
            {{session('status')}}
        </div>
        @endif
        @if (session('deleted'))
        <div style="margin-top: 10px" class="alert alert-danger alert-dismissible" role="alert">
            {{session('deleted')}}
        </div>
        @endif
        <div style="margin-top: 10px" class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Manage Sekuritas</h6>
            </div>
            <div class="card-body">
                <a href="" class="btn btn-default btn-rounded mt-4 mb-4" data-toggle="modal"
                    data-target="#modalSekuritas">Buat Sekuritas Baru</a>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No </th>
                            <th class="w-25">Nama Sekuritas</th>
                            <th>Fee Beli</th>
                            <th>Fee Jual</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="post-table-body">
                        <?php $i = 1 ?>
                        @foreach ($data as $item)
                        <tr>
                            <td style="display:none;">{{$item->id_sekuritas}}</td>
                            <td>{{$i }}</td>
                            <?php $i++ ?>
                            <td>{{$item->nama_sekuritas}}</td>
                            <td>{{$item->fee_beli*100}}%</td>
                            <td>{{$item->fee_jual*100}}%</td>
                            <td>
                                <button onclick="location.href='/admin/sekuritas/edit/{{$item->id_sekuritas}}'"
                                    class="btn btn-success" type="button"><i class="fas fa-edit"></i></button>
                                <button data-toggle="modal" data-target="#delete" type="button"
                                    class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                <button onclick="location.href='/admin/sekuritas/delete/{{$item->id_sekuritas}}'"
                                    type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
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
                                            <button
                                                onclick="location.href='/admin/sekuritas/delete/{{$item->id_sekuritas}}'"
                                                type="button" class="btn btn-primary">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modalSekuritas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Input Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/sekuritas/create" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="namaSekuritas">Nama Sekuritas</label>
                                <input type="text" class="form-control" id="namaSekuritas" name="namaSekuritas"
                                    placeholder="Enter Nama Sekuritas">
                            </div>
                            <div class="form-group">
                                <label for="feeBeli">Fee Beli</label>
                                <input type="number" class="form-control" id="feeBeli" placeholder="Enter Fee Beli"
                                    name="feeBeli">
                            </div>
                            <div class="form-group">
                                <label for="feeJual">Fee Jual</label>
                                <input type="number" class="form-control" id="feeJual" placeholder="Enter Fee Jual"
                                    name="feeJual">
                            </div>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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