@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<form action="/admin/portofoliobeli/editbeli" id="form_beli" name="formbeli" method="post">
    @csrf

    <div class="modal-body mx-3">
        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form34">Emiten Saham</label><br>
            <select name="id_saham" id="id_saham" class="category">
                <option disable selected @error('id_saham') is-invalid @enderror>--Pilih Saham--</option>

                @foreach($emiten as $item)
                <option value="{{ $item->id_saham}}">{{ $item->nama_saham}}</option>
                @endforeach

            </select>
            @foreach ($dataporto as $item)
            <input name="id_saham_hidden" type="hidden" id="id_saham_hidden" value="{{$item->id_saham}}"
                class="form-control validate">
            @endforeach
            @if ($errors->any())
            <strong style="color: red">{{ $errors->first('id_saham') }}</strong>
            @endif

        </div>

        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form29">Jenis Saham</label><br>
            <select name="id_jenis_saham" id="id_jenis_saham" class="category">
                <option disable selected>--Pilih Jenis--</option>

                @foreach($jenis_saham as $item)
                <option value="{{ $item->id_jenis_saham}}">{{ $item->jenis_saham}}</option>
                @endforeach

            </select>
            @foreach ($dataporto as $item)
            <input name="id_jenis_saham_hidden" type="hidden" id="id_jenis_saham_hidden" value="{{ $item->jenis_saham}}"
                class="form-control validate">
            @endforeach
            @if ($errors->any())
            <strong style="color: red">{{ $errors->first('id_jenis_saham') }}</strong>
            @endif
        </div>

        <div>
            @foreach ($dataporto as $item)
            <input name="id_portofolio_beli" type="hidden" id="id_portofolio_beli" value="{{$item->id_portofolio_beli}}"
                class="form-control validate">
            @endforeach
        </div>
        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form32">Volume</label>
            @foreach ($dataporto as $item)
            <input name="volume" type="number" id="volume" value="{{$item->volume}}" class="form-control validate">
            @endforeach
            @if ($errors->any())
            <strong style="color: red">{{ $errors->first('volume') }}</strong>
            @endif
        </div>

        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form32">Tanggal Beli</label>
            @foreach ($dataporto as $item)
            <input name="tanggal_beli" type="date" id="tanggal_beli" value="{{$item->tanggal_beli}}"
                class="form-control validate">
            @endforeach
            @if ($errors->any())
            <strong style="color: red">{{ $errors->first('tanggal_beli') }}</strong>
            @endif
        </div>

        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form32">Harga Beli</label>
            @foreach ($dataporto as $item)
            <input name="harga_beli" type="number" id="harga_beli" value="{{$item->harga_beli}}"
                class="form-control validate">
            @endforeach
            @if ($errors->any())
            <strong style="color: red">{{ $errors->first('harga_beli') }}</strong>
            @endif
        </div>
        <div class="md-form mb-5">
            <label for="sekuritas">Sekuritas</label>
            <select id="sekuritas" name="sekuritas">
                <option value="">Select Sekuritas</option>
                @foreach($sekuritas as $item)
                <option value="{{ $item->id_sekuritas}}">{{ $item->nama_sekuritas}}</option>
                @endforeach
                @foreach ($dataporto as $item)
                <input name="id_sekuritas" type="hidden" id="id_sekuritas" value="{{ $item->id_sekuritas}}"
                    class="form-control validate">
                @endforeach
            </select>
            @if ($errors->any())
            <strong style="color: red">{{ $errors->first('sekuritas') }}</strong>
            @endif
        </div>
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
@vite(['resources/js/editPortofolioBeli.js'])

@endsection