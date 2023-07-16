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

    <div class="container">
        <h4>Buat Portofolio Jual</h4>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form id="formBeli" class="needs-validation" novalidate method="post" action="/portofoliojual/addjual">
            @csrf
            <div class="form-group mb-4">
                <label for="emitenSaham">Emiten Saham</label>
                <select class="form-control" id="emitenSaham" name="emitenSaham" required>
                    <option value="">Select Emiten Saham</option>
                    @foreach($emiten as $item)
                    <option value="{{ $item->id_saham}}">{{ $item->nama_saham}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select an emiten saham.</div>
            </div>
            <div class="form-group mb-4">
                <label for="jenisSaham">Jenis Saham</label>
                <select class="form-control" id="jenisSaham" name="jenisSaham" required>
                    <option value="">Select Jenis Saham</option>
                    @foreach($jenis_saham as $item)
                    <option value="{{ $item->id_jenis_saham}}">{{ $item->jenis_saham}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select a jenis saham.</div>
            </div>
            <div class="form-group mb-4">
                <label for="volume">Volume</label>
                <input type="number" class="form-control" id="volume" name="volume" min="0" step="1" required>
                <div class="invalid-feedback">Please enter a valid volume.</div>
            </div>
            <div class="form-group mb-4">
                <label for="tanggalBeli">Tanggal Jual</label>
                <input type="date" class="form-control" id="tanggalJual" name="tanggalJual" required>
                <div class="invalid-feedback">Please enter a valid tanggal beli.</div>
            </div>
            <div class="form-group mb-4">
                <label for="hargaBeli">Harga Jual</label>
                <input type="number" class="form-control" id="hargaJual" name="hargaJual" min="0" step="0.01" required>
                <div class="invalid-feedback">Please enter a valid harga beli.</div>
            </div>
            <div class="form-group mb-4">
                <label for="sekuritas">Sekuritas</label>
                <select class="form-control" id="sekuritas" name="sekuritas" required>
                    <option value="">Select Sekuritas</option>
                    @foreach($sekuritas as $item)
                    <option value="{{ $item->id_sekuritas}}">{{ $item->nama_sekuritas}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select a sekuritas.</div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    @section('page-js-files')
    <script src="{{asset('style')}}/table/js/popper.min.js"></script>
    <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
    <script src="{{asset('style')}}/table/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
    @vite(['resources/js/portofolioBeli.js'])
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    @stop
</body>

@endsection