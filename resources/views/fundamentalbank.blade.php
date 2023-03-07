@extends('template.master')

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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
        integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.2/datatables.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" />
    <style>
        th {
            white-space: nowrap;
        }
    </style>
    <link rel="stylesheet" href="{{asset('template')}}/css/Fundamental.css">
    @stop
</head>

<body>
    <div class="content">
        <div class="container">
            <a href="" class="btn btn-default btn-rounded mt-4 mb-4" data-toggle="modal"
                data-target="#modalContactForm">Buat Data Fundamental</a>
            <div class="row">
                @foreach ($input as $item)
                <div class="card">
                    <h4>{{$item -> tahun}}</h4>
                    <p>Aset : {{$item -> aset}}</p>
                    <p>Simpanan : {{$item -> simpanan}}</p>
                    <p>Pinjaman : {{$item -> pinjaman}}</p>
                    <p>{{$item -> saldo_laba}}</p>
                    <p>{{$item -> ekuitas}}</p>
                    <p>{{$item -> jml_saham_edar}}</p>
                    <p>{{$item -> pendapatan}}</p>
                    <p>{{$item -> laba_kotor}}</p>
                    <p>{{$item -> laba_bersih}}</p>
                    <p>{{$item -> harga_saham}}</p>
                    <p>{{$item -> operating_cash_flow}}</p>
                    <p>{{$item -> investing_cash_flow}}</p>
                    <p>{{$item -> total_dividen}}</p>
                    <p>{{$item -> stock_split}}</p>
                    <p>{{$item -> eps}}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</body>

@section('page-js-files')
<script src="{{asset('style')}}/table/js/popper.min.js"></script>
<script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
<script src="{{asset('style')}}/table/js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('template')}}/js/fundamentalBank.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.2/datatables.min.js"></script>
@stop
@endsection