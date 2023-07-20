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
    @stop
</head>

<body>
    <div class="container">

        <div style="margin-top: 10px" class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Manage Plan</h6>
            </div>
            @if (session('status'))
            <div style="margin-top: 10px" class="alert alert-success alert-dismissible" role="alert">
                {{session('status')}}
            </div>
            @endif
            <div class="card-body">
                <a href="/plan/create" class="btn btn-default btn-rounded mt-4 mb-4" data-toggle="modal"
                    data-target="#modalplan">Buat Plan Baru</a>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No </th>
                            <th class="w-25">Harga</th>
                            <th>Jumlah Bulan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="post-table-body">
                        <?php $i = 1 ?>
                        @foreach ($prices as $price)
                        <tr>
                            <td>{{$i }}</td>
                            <?php $i++ ?>
                            <td>{{$price->price}}</td>
                            <td>{{$price->month}}</td>
                            <td>
                                <button onclick="location.href='/plan/edit/{{$price->id_price}}'"
                                    class="btn btn-success" type="button"><i class="fas fa-edit"></i></button>
                                <button onclick="location.href='/plan/delete/{{$price->id_price}}'" type="button"
                                    class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $prices->links() }}
            </div>
        </div>
        <div class="modal fade" id="modalplan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="plan-form" method="post" action="/plan/create">
                            @csrf
                            <div class="form-group">
                                <label for="monthInput">Month:</label>
                                <input type="number" class="form-control" id="priceInput" placeholder="Masukkan Bulan">
                            </div>
                            <div class="form-group">
                                <label for="priceInput">Price:</label>
                                <input type="number" class="form-control" id="priceInput" placeholder="Masukkan Harga">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @section('page-js-files')
        <script src="{{asset('style')}}/table/js/popper.min.js"></script>
        <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
        <script src="{{asset('style')}}/table/js/main.js"></script>

        <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>

        @stop
</body>



@endsection