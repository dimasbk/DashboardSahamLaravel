@extends('template.master')

@section('content')
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <script src="{{asset('style')}}/table/js/jquery-3.5.1.js"></script>

    <link rel="stylesheet" href="{{asset('style')}}/table/fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{asset('style')}}/table/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('style')}}/table/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="{{asset('style')}}/table/css/style.css">
    <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
  integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
/>

<div class="modal-body mx-3">
    <form id= formEditBeli">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div  class="md-form mb-5">
            <label for="emitenSaham">Emiten Saham</label>
            <select id="emitenSaham" name="emitenSaham">
            <option value="">Select Emiten Saham</option>
            @foreach($emiten as $item)
            <option value="{{ $item->id_saham}}">{{ $item->nama_saham}}</option>
            @endforeach
            </select>
            @foreach ($dataporto as $item)
            <input name="id_saham_hidden" type="hidden" id="id_saham_hidden" value="{{$item->id_saham}}" class="form-control validate">
            @endforeach
            <div class="invalid-feedback"></div>
        </class=>
        <div class="md-form mb-5">
            <label for="jenisSaham">Jenis Saham</label>
            <select id="jenisSaham" name="jenisSaham">
            <option value="">Select Jenis Saham</option>
            @foreach($jenis_saham as $item)
            <option value="{{ $item->id_jenis_saham}}">{{ $item->jenis_saham}}</option>
            @endforeach
            </select>
            @foreach ($dataporto as $item)
            <input name="id_jenis_saham_hidden" type="hidden" id="id_jenis_saham_hidden" value="{{ $item->jenis_saham}}" class="form-control validate">
            @endforeach
            <div class="invalid-feedback"></div>
        </div>
        <div>
            @foreach ($dataporto as $item)
            <input name="id_portofolio_beli" type="hidden" id="id_portofolio_beli" value="{{$item->id_portofolio_beli}}" class="form-control validate">
            @endforeach
        </div>
        <div class="md-form mb-5">
            <label for="volume">Volume</label>
            @foreach ($dataporto as $item)
            <input name="volume" type="number" id="volume" value="{{$item->volume}}" class="form-control validate">
            @endforeach
            <div class="invalid-feedback"></div>
        </div>
        <div class="md-form mb-5">
            <label for="tanggalBeli">Tanggal Beli</label>
            @foreach ($dataporto as $item)
            <input name="tanggal_beli" type="date" id="tanggal_beli" value="{{$item->tanggal_beli}}" class="form-control validate">
            @endforeach
        <div class="invalid-feedback"></div>
        </div>
        <div class="md-form mb-5">
            <label for="hargaBeli">Harga Beli</label>
            @foreach ($dataporto as $item)
            <input name="harga_beli" type="number" id="harga_beli" value="{{$item->harga_beli}}" class="form-control validate">
            @endforeach
            <div class="invalid-feedback"></div>
        </div>
        <div class="md-form mb-5">
            <label for="feeBeli">Fee Beli</label>
            @foreach ($dataporto as $item)
            <input name="fee_beli_persen" type="number" id="fee_beli_persen" value="{{$item->fee_beli_persen}}" class="form-control validate">
            @endforeach
            <div class="invalid-feedback"></div>
        </div>
    </form>
</div>
<div class="modal-footer d-flex justify-content-center">
    <button id="clear-form" class="btn btn-light">Clear</button>
    <button id="submit-button" type="submit" class="btn btn-primary">Submit</button>
    <button id="btn_send" type="submit" class="btn btn-unique">Send <i class="fas fa-paper-plane-o ml-1"></i></button>
</div>
<script src="{{asset('style')}}/table/js/popper.min.js"></script>
        <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
        <script src="{{asset('style')}}/table/js/main.js"></script>
        <script
  src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
  integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
></script>
        <script src="{{asset('template')}}/js/editPortofolioBeli.js"></script> 

@endsection