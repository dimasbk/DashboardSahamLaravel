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
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Edit Fundamental</h6>
            </div>
            <div class="card-body">
                <form id="formFundamental" method="POST" action="/admin/fundamental/update">
                    @csrf
                    <input type="hidden" name="emiten" value="{{$emiten}}">
                    <input type="hidden" name="id_input" value="{{$input->id_input}}">
                    <input type="hidden" name="id_detail_input" value="{{$inputDetail->id_detail_input}}">
                    <input type="hidden" name="id_output" value="{{$output->id_output}}">
                    <input type="hidden" name="id_detail_output" value="{{$outputDetail->id_output}}">
                    <div class="form-group">
                        <label for="aset">Aset:</label>
                        <input data-toggle="tooltip" data-placement="top" title="Total Aset" type="number" id="aset"
                            name="aset" class="form-control" value="{{$inputDetail->aset}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    @if ($check == 1)
                    <div class="form-group">
                        <label for="simpanan">Simpanan:</label>
                        <input data-toggle="tooltip" data-placement="top"
                            title="Total Dana Pihak Ketiga (tabungan, giro, deposito)" type="number" id="simpanan"
                            name="simpanan" class="form-control" value="{{$inputDetail->simpanan}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="pinjaman">Pinjaman:</label>
                        <input data-toggle="tooltip" data-placement="top" title="Total pinjaman" type="number"
                            id="pinjaman" name="pinjaman" class="form-control" value="{{$inputDetail->pinjaman}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <input type="hidden" id="hutang_obligasi">
                    @else
                    <div class="form-group">
                        <label for="hutang_obligasi">Hutang & Obligasi:</label>
                        <input data-toggle="tooltip" data-placement="top"
                            title="Hanya pilih Hutang Bank & Obligasi di Sisi Liabilitas (Jangka pendek + jangka panjang)"
                            type="number" id="hutang_obligasi" name="hutang_obligasi" class="form-control"
                            value="{{$inputDetail->hutang_obligasi}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <input type="hidden" id="simpanan">
                    <input type="hidden" id="pinjaman">
                    @endif

                    <div class="form-group">
                        <label for="saldo-laba">Saldo Laba:</label>
                        <input data-toggle="tooltip" data-placement="top"
                            title="Jumlahkan saldo laba (dicadangkan + belum dicadangkan) di sisi Ekuitas" type="number"
                            id="saldo-laba" name="saldo_laba" class="form-control" value="{{$inputDetail->saldo_laba}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="ekuitas">Ekuitas:</label>
                        <input data-toggle="tooltip" data-placement="top"
                            title="Hanya pilih Ekuitas yang dapat diatribusikan ke pemilik entitas induk" type="number"
                            id="ekuitas" name="ekuitas" class="form-control" value="{{$inputDetail->ekuitas}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah-saham-beredar">Jumlah Saham Beredar:</label>
                        <input data-toggle="tooltip" data-placement="top"
                            title='Lihat keterangan "modal saham" di catatan atas laporan keuangan' type="number"
                            id="jumlah-saham-beredar" name="jumlah_saham_beredar" class="form-control"
                            value="{{$inputDetail->jml_saham_edar}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="pendapatan">Pendapatan:</label>
                        <input data-toggle="tooltip" data-placement="top" title="Total Pendapatan/penjualan"
                            type="number" id="pendapatan" name="pendapatan" class="form-control"
                            value="{{$inputDetail->pendapatan}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="laba-kotor">Laba Kotor:</label>
                        <input data-toggle="tooltip" data-placement="top" title="Total laba kotor" type="number"
                            id="laba-kotor" name="laba_kotor" class="form-control" value="{{$inputDetail->laba_kotor}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="laba-bersih">Laba Bersih:</label>
                        <input data-toggle="tooltip" data-placement="top"
                            title="Hanya pilih laba berjalan yang dapat diatribusikan ke pemilik entitas induk"
                            type="number" id="laba_bersih" name="laba_bersih" class="form-control"
                            value="{{$inputDetail->laba_bersih}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="harga-saham">Harga Saham:</label>
                        <input data-toggle="tooltip" data-placement="top" title="Harga saham di penutupan akhir tahun"
                            type="number" id="harga-saham" name="harga_saham" class="form-control"
                            value="{{$inputDetail->harga_saham}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="operating-cash-flow">Operating Cash Flow:</label>
                        <input data-toggle="tooltip" data-placement="top"
                            title="Kas yang dihasilkan dari aktivitas operasi" type="number" id="operating-cash-flow"
                            name="operating_cash_flow" class="form-control"
                            value="{{$inputDetail->operating_cash_flow}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="investing-cash-flow">Investing Cash Flow:</label>
                        <input data-toggle="tooltip" data-placement="top" title="Kas untuk aktivitas Investasi"
                            type="number" id="investing-cash-flow" name="investing_cash_flow" class="form-control"
                            value="{{$inputDetail->investing_cash_flow}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="total-dividen">Total Dividen:</label>
                        <input data-toggle="tooltip" data-placement="top"
                            title="Total dana dividen yang dikeluarkan pada tahun tersebut (ambil di laporan arus kas)"
                            type="number" id="total-dividen" name="total_dividen" class="form-control"
                            value="{{$inputDetail->total_dividen}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="stock-split">Stock Split:</label>
                        <input data-toggle="tooltip" data-placement="top"
                            title='Diisi angka "1" jika di tahun tersebut tidak melakukan stocksplit, Diisi angka "pemecahan stockcplit" di tahun sebelum perusahaan melakukan stocksplit'
                            type="number" id="stock-split" name="stock_split" class="form-control"
                            value="{{$inputDetail->stock_split}}">
                        <div class=" invalid-feedback">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tahun">Tahun:</label>
                        <input data-toggle="tooltip" data-placement="top" title="Tahun laporan keuangan" type="number"
                            id="tahun" name="tahun" class="form-control" required value="{{$inputDetail->tahun}}"">
                        <div class=" invalid-feedback">
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="radio" name="kuartal" value="">
                            Tahunan
                        </label>
                        <label>
                            <input type="radio" name="kuartal" value="Q1">
                            Q1
                        </label>
                        <label>
                            <input type="radio" name="kuartal" value="Q2">
                            Q2
                        </label>
                        <label>
                            <input type="radio" name="kuartal" value="Q3">
                            Q3
                        </label>
                        <label>
                            <input type="radio" name="kuartal" value="Q4">
                            Q4
                        </label>
                    </div>
            </div>
            <button id="submit-button" type="submit" class="btn btn-primary">Submit</button>
            </form>
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