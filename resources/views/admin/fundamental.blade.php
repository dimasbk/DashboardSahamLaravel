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
    @stop
</head>

<body>
    <div class="content">
        <div class="container">
            <h3 class="mt-3">Data Fundamental {{$emiten}}</h3>
            <a class="btn btn-default btn-rounded mt-4 mb-4" data-bs-toggle="modal"
                data-bs-target="#modalContactForm">Buat
                Data Fundamental</a>
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
            <h3>Tabel Keuangan</h3>
            <div style="overflow-x:auto;">
                <table id="input" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th style="display:none;"></th>
                            <th scope="col">No </th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Aset</th>
                            @if ($check == 1)
                            <th scope="col">Simpanan</th>
                            <th scope="col">Pinjaman</th>
                            @else
                            <th scope="col">Hutang & Obligasi</th>
                            @endif
                            <th scope="col">Saldo Laba</th>
                            <th scope="col">Ekuitas</th>
                            <th scope="col">Jumlah Saham Beredar</th>
                            <th scope="col">Pendapatan</th>
                            <th scope="col">Laba Kotor</th>
                            <th scope="col">Laba Bersih</th>
                            <th scope="col">Harga Saham</th>
                            <th scope="col">Operating Cash Flow</th>
                            <th scope="col">Investing Cash Flow</th>
                            <th scope="col">Total Dividen</th>
                            <th scope="col">Stock Split</th>
                            <th scope="col">EPS</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>

                        @foreach ($input as $item)
                        <tr scope="row">
                            <td style="display:none;">{{$item->id_detail_input}}</td>
                            <td>{{$i }}</td>
                            <?php $i++ ?>
                            <td>{{$item -> tahun}}</td>
                            <td>Rp.{{number_format($item -> aset)}}</td>
                            @if ($check == 1)
                            <td>Rp.{{number_format($item -> simpanan)}}</td>
                            <td>Rp.{{number_format($item -> pinjaman)}}</td>
                            @else
                            <td>Rp.{{number_format($item -> hutang_obligasi)}}</td>
                            @endif
                            <td>Rp.{{number_format($item -> saldo_laba)}}</td>
                            <td>Rp.{{number_format($item -> ekuitas)}}</td>
                            <td>{{number_format($item -> jml_saham_edar)}}</td>
                            <td>Rp.{{number_format($item -> pendapatan)}}</td>
                            <td>Rp.{{number_format($item -> laba_kotor)}}</td>
                            <td>Rp.{{number_format($item -> laba_bersih)}}</td>
                            <td>{{number_format($item -> harga_saham)}}</td>
                            <td>Rp.{{number_format($item -> operating_cash_flow)}}</td>
                            <td>Rp.{{number_format($item -> investing_cash_flow)}}</td>
                            <td>{{number_format($item -> total_dividen)}}</td>
                            <td>{{$item -> stock_split}}</td>
                            <td>{{$item -> eps}}</td>
                            <td>
                                <button onclick="location.href='/admin/fundamental/edit/{{$item->id_input}}'"
                                    class="btn btn-success" type="button"><i class="fas fa-edit"></i></button>
                                <button data-toggle="modal" data-target="#delete" type="button"
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
                                            <button
                                                onclick="location.href='/admin/fundamental/delete/{{$item->id_input}}'"
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
            <h3 style="margin-top: 20px">Tabel Fundamental</h3>
            <div style="overflow-x:auto;">
                <table id="output" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th style="display:none;"></th>
                            <th scope="col">No </th>
                            <th scope="col">Tahun</th>
                            @if ($check == 1)
                            <th scope="col">Loan to Deposit Ratio</th>
                            @else
                            <th scope="col">DER</th>
                            @endif
                            <th scope="col">Annualized ROE</th>
                            <th scope="col">Dividen</th>
                            <th scope="col">Dividen Yield</th>
                            <th scope="col">Dividen Payout Ratio</th>
                            <th scope="col">Price to Book</th>
                            <th scope="col">Annualized PER</th>
                            <th scope="col">Annualized ROA</th>
                            <th scope="col">Gross to Profit Margin</th>
                            <th scope="col">Net Profit Margin</th>
                            <th scope="col">Earnings to Equity Ratio</th>
                            <th scope="col">Earnings to Asset Ratio</th>
                            <th scope="col">Market Cap</th>
                            <th scope="col">Market Cap to Asset Ratio</th>
                            <th scope="col">CFO to Sales Ratio</th>
                            <th scope="col">Capex to CFO Ratio</th>
                            <th scope="col">Market Cap to CFO Ratio</th>
                            <th scope="col">PER to EPS Growth</th>
                            <th scope="col">Harga Saham+Dividen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>

                        @foreach ($output as $item)
                        <tr scope="row">
                            <td style="display:none;">{{$item->id_detail_input}}</td>
                            <td>{{$i }}</td>
                            <?php $i++ ?>
                            <td>{{$item -> tahun}}</td>
                            @if ($check == 1)
                            <td>{{$item->loan_to_depo_ratio}}%</td>
                            @else
                            <td>{{$item->der}}%</td>
                            @endif
                            <td>{{$item->annualized_roe}}%</td>
                            <td>{{$item->dividen}}</td>
                            <td>{{$item->dividen_yield}}%</td>
                            <td>{{$item->dividen_payout_ratio}}%</td>
                            <td>{{$item->pbv}}</td>
                            <td>{{$item->annualized_per}}</td>
                            <td>{{$item->annualized_roa}}%</td>
                            <td>{{$item->gpm}}%</td>
                            <td>{{$item->npm}}%</td>
                            <td>{{$item->eer}}%</td>
                            <td>{{$item->ear}}%</td>
                            <td>{{$item->market_cap}}</td>
                            <td>{{$item->market_cap_asset_ratio}}%</td>
                            <td>{{$item->cfo_sales_ratio}}%</td>
                            <td>{{$item->capex_cfo_ratio}}%</td>
                            <td>{{$item->market_cap_cfo_ratio}}</td>
                            <td>{{$item->peg}}</td>
                            <td>{{$item->harga_saham_sum_dividen}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Stock Purchase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formFundamental" method="POST" action="/admin/fundamental/insert">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="emiten" name="emiten" value="{{ $emiten }}">
                        <div class="form-group">
                            <label for="aset">Aset:</label>
                            <input data-toggle="tooltip" data-placement="top" title="Total Aset" type="number" id="aset"
                                name="aset" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        @if ($check == 1)
                        <div class="form-group">
                            <label for="simpanan">Simpanan:</label>
                            <input data-toggle="tooltip" data-placement="top"
                                title="Total Dana Pihak Ketiga (tabungan, giro, deposito)" type="number" id="simpanan"
                                name="simpanan" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="pinjaman">Pinjaman:</label>
                            <input data-toggle="tooltip" data-placement="top" title="Total pinjaman" type="number"
                                id="pinjaman" name="pinjaman" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <input type="hidden" id="hutang_obligasi">
                        @else
                        <div class="form-group">
                            <label for="hutang_obligasi">Hutang & Obligasi:</label>
                            <input data-toggle="tooltip" data-placement="top"
                                title="Hanya pilih Hutang Bank & Obligasi di Sisi Liabilitas (Jangka pendek + jangka panjang)"
                                type="number" id="hutang_obligasi" name="hutang_obligasi" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <input type="hidden" id="simpanan">
                        <input type="hidden" id="pinjaman">
                        @endif

                        <div class="form-group">
                            <label for="saldo-laba">Saldo Laba:</label>
                            <input data-toggle="tooltip" data-placement="top"
                                title="Jumlahkan saldo laba (dicadangkan + belum dicadangkan) di sisi Ekuitas"
                                type="number" id="saldo-laba" name="saldo_laba" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="ekuitas">Ekuitas:</label>
                            <input data-toggle="tooltip" data-placement="top"
                                title="Hanya pilih Ekuitas yang dapat diatribusikan ke pemilik entitas induk"
                                type="number" id="ekuitas" name="ekuitas" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="jumlah-saham-beredar">Jumlah Saham Beredar:</label>
                            <input data-toggle="tooltip" data-placement="top"
                                title='Lihat keterangan "modal saham" di catatan atas laporan keuangan' type="number"
                                id="jumlah-saham-beredar" name="jumlah_saham_beredar" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="pendapatan">Pendapatan:</label>
                            <input data-toggle="tooltip" data-placement="top" title="Total Pendapatan/penjualan"
                                type="number" id="pendapatan" name="pendapatan" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="laba-kotor">Laba Kotor:</label>
                            <input data-toggle="tooltip" data-placement="top" title="Total laba kotor" type="number"
                                id="laba-kotor" name="laba_kotor" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="laba-bersih">Laba Bersih:</label>
                            <input data-toggle="tooltip" data-placement="top"
                                title="Hanya pilih laba berjalan yang dapat diatribusikan ke pemilik entitas induk"
                                type="number" id="laba_bersih" name="laba_bersih" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="harga-saham">Harga Saham:</label>
                            <input data-toggle="tooltip" data-placement="top"
                                title="Harga saham di penutupan akhir tahun" type="number" id="harga-saham"
                                name="harga_saham" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="operating-cash-flow">Operating Cash Flow:</label>
                            <input data-toggle="tooltip" data-placement="top"
                                title="Kas yang dihasilkan dari aktivitas operasi" type="number"
                                id="operating-cash-flow" name="operating_cash_flow" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="investing-cash-flow">Investing Cash Flow:</label>
                            <input data-toggle="tooltip" data-placement="top" title="Kas untuk aktivitas Investasi"
                                type="number" id="investing-cash-flow" name="investing_cash_flow" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="total-dividen">Total Dividen:</label>
                            <input data-toggle="tooltip" data-placement="top"
                                title="Total dana dividen yang dikeluarkan pada tahun tersebut (ambil di laporan arus kas)"
                                type="number" id="total-dividen" name="total_dividen" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="stock-split">Stock Split:</label>
                            <input data-toggle="tooltip" data-placement="top"
                                title='Diisi angka "1" jika di tahun tersebut tidak melakukan stocksplit, Diisi angka "pemecahan stockcplit" di tahun sebelum perusahaan melakukan stocksplit'
                                type="number" id="stock-split" name="stock_split" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="tahun">Tahun:</label>
                            <input data-toggle="tooltip" data-placement="top" title="Tahun laporan keuangan"
                                type="number" id="tahun" name="tahun" class="form-control" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="submit-button" type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
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
@vite(['resources/js/fundamentalBank.js'])
<script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.2/datatables.min.js"></script>
@stop
@endsection