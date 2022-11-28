@extends('template.master')

@section('content')
<form action="/portofoliojual/editjual" id="form_jual" name="formjual"  method="post">
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
        </div>

        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form29">Jenis Saham</label><br>
            <select name="id_jenis_saham" id="id_jenis_saham" class="category">
                <option disable selected>--Pilih Jenis--</option>
                        
                @foreach($jenis_saham as $item)
                    <option value="{{ $item->id_jenis_saham}}">{{$item->jenis_saham}}</option>
                @endforeach
                     
            </select>
        </div>
        
        <div>
            @foreach ($dataporto as $item)
            <input name="id_portofolio_jual" type="hidden" id="id_portofolio_beli" value="{{$item->id_portofolio_beli}}" class="form-control validate">
            @endforeach
        </div>
        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form32">Volume</label>
            @foreach ($dataporto as $item)
            <input name="volume" type="number" id="volume" value="{{$item->volume}}" class="form-control validate">
            @endforeach
        </div>

        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form32">Tanggal Jual</label>
            @foreach ($dataporto as $item)
            <input name="tanggal_jual" type="date" id="tanggal_jual" value="{{$item->tanggal_jual}}" class="form-control validate">
            @endforeach
        </div>

        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form32">Harga Jual</label>
            @foreach ($dataporto as $item)
            <input name="harga_beli" type="number" id="harga_jual" value="{{$item->harga_jual}}" class="form-control validate">
            @endforeach
        </div>
        <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="form32">Fee Jual</label>
            @foreach ($dataporto as $item)
            <input name="fee_beli_persen" type="number" id="fee_beli_persen" value="{{$item->fee_jual_persen}}" class="form-control validate">
            @endforeach
            <label data-error="wrong" data-success="right" for="form32">%</label>
        </div>
    </div>
    <div class="modal-footer d-flex justify-content-center">
        <button id="btn_send" type="submit" class="btn btn-unique">Send <i class="fas fa-paper-plane-o ml-1"></i></button>
    </div>
</form>
@endsection