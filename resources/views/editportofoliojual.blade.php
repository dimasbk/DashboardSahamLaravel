@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<form action="/portofoliojual/editjual" id="form_jual" name="formjual" method="post">
    @csrf

    <div class="modal-body mx-3">
        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form34">Emiten Saham</label><br>
            <select name="emitenSaham" id="id_saham" class="category">
                <option disable selected @error('id_saham') is-invalid @enderror>--Pilih Saham--</option>

                @foreach($emiten as $item)
                <option value="{{ $item->id_saham}}">{{ $item->nama_saham}}</option>
                @endforeach

            </select>

            <input name="id_saham_hidden" type="hidden" id="id_saham_hidden" value="{{$dataporto->id_saham}}"
                class="form-control validate">

            @if ($errors->any())
            <strong style="color: red">{{ $errors->first('emitenSaham') }}</strong>
            @endif

        </div>

        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form29">Jenis Saham</label><br>
            <select name="jenisSaham" id="id_jenis_saham" class="category">
                <option disable selected>--Pilih Jenis--</option>

                @foreach($jenis_saham as $item)
                <option value="{{ $item->id_jenis_saham}}">{{ $item->jenis_saham}}</option>
                @endforeach

            </select>

            <input name="id_jenis_saham_hidden" type="hidden" id="id_jenis_saham_hidden"
                value="{{ $dataporto->jenis_saham}}" class="form-control validate">

            @if ($errors->any())
            <strong style="color: red">{{ $errors->first('jenisSaham') }}</strong>
            @endif
        </div>

        <div>

            <input name="id_portofolio_jual" type="hidden" id="id_portofolio_jual"
                value="{{$dataporto->id_portofolio_jual}}" class="form-control validate">

        </div>
        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form32">Volume</label>

            <input name="volume" type="number" id="volume" value="{{$dataporto->volume}}" class="form-control validate">
            @if ($errors->any())
            <strong style="color: red">{{ $errors->first('volume') }}</strong>
            @endif
        </div>

        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form32">Tanggal jual</label>

            <input name="tanggal_jual" type="date" id="tanggal_jual" value="{{$dataporto->tanggal_jual}}"
                class="form-control validate">
            @if ($errors->any())
            <strong style="color: red">{{ $errors->first('tanggal_jual') }}</strong>
            @endif
        </div>

        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form32">Harga jual</label>

            <input name="harga_jual" type="number" id="harga_jual" value="{{$dataporto->harga_jual}}"
                class="form-control validate">
            @if ($errors->any())
            <strong style="color: red">{{ $errors->first('harga_jual') }}</strong>
            @endif
        </div>
        <div class="md-form mb-5">
            <label for="sekuritas">Sekuritas</label>
            <select id="sekuritas" name="sekuritas">
                <option value="">Select Sekuritas</option>
                @foreach($sekuritas as $item)
                <option value="{{ $item->id_sekuritas}}">{{ $item->nama_sekuritas}}</option>
                @endforeach

                <input name="id_sekuritas" type="hidden" id="id_sekuritas" value="{{ $dataporto->id_sekuritas}}"
                    class="form-control validate">

            </select>
        </div>
        @if ($errors->any())
        <strong style="color: red">{{ $errors->first('sekuritas') }}</strong>
        @endif
    </div>
    <div class="modal-footer d-flex justify-content-center">
        <button id="btn_send" type="submit" class="btn btn-unique">Send <i
                class="fas fa-paper-plane-o ml-1"></i></button>
    </div>
</form>
<script src="{{asset('style')}}/table/js/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@vite(['resources/js/editPortofolioJual.js'])
@endsection