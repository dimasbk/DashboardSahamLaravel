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
    @stop
</head>

<body>
    <div class="content">
        <div class="container">
            <a href="" class="btn btn-default btn-rounded mt-4 mb-4" data-toggle="modal"
                data-target="#modalContactForm">Buat Data Fundamental</a>
            <div class="table-responsive">
                <table id="fundamental" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="display:none;"></th>
                            <th scope="col">No </th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Aset</th>
                            <th scope="col">Simpanan</th>
                            <th scope="col">Pinjaman</th>
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
                            <td>{{$item -> aset}}</td>
                            <td>{{$item -> simpanan}}</td>
                            <td>{{$item -> pinjaman}}</td>
                            <td>{{$item -> saldo_laba}}</td>
                            <td>{{$item -> ekuitas}}</td>
                            <td>{{$item -> jml_saham_edar}}</td>
                            <td>{{$item -> pendapatan}}</td>
                            <td>{{$item -> laba_kotor}}</td>
                            <td>{{$item -> laba_bersih}}</td>
                            <td>{{$item -> harga_saham}}</td>
                            <td>{{$item -> operating_cash_flow}}</td>
                            <td>{{$item -> investing_cash_flow}}</td>
                            <td>{{$item -> total_dividen}}</td>
                            <td>{{$item -> stock_split}}</td>
                            <td>{{$item -> eps}}</td>
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
                    <form id="formBeli">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="aset">Aset:</label>
                            <input type="number" id="aset" name="aset" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="simpanan">Simpanan:</label>
                            <input type="number" id="simpanan" name="simpanan" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="pinjaman">Pinjaman:</label>
                            <input type="number" id="pinjaman" name="pinjaman" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="saldo-laba">Saldo Laba:</label>
                            <input type="number" id="saldo-laba" name="saldo-laba" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="ekuitas">Ekuitas:</label>
                            <input type="number" id="ekuitas" name="ekuitas" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="jumlah-saham-beredar">Jumlah Saham Beredar:</label>
                            <input type="number" id="jumlah-saham-beredar" name="jumlah-saham-beredar"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="pendapatan">Pendapatan:</label>
                            <input type="number" id="pendapatan" name="pendapatan" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="laba-kotor">Laba Kotor:</label>
                            <input type="number" id="laba-kotor" name="laba-kotor" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="laba-bersih">Laba Bersih:</label>
                            <input type="number" id="laba-bersih" name="laba-bersih" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="harga-saham">Harga Saham:</label>
                            <input type="number" id="harga-saham" name="harga-saham" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="operating-cash-flow">Operating Cash Flow:</label>
                            <input type="number" id="operating-cash-flow" name="operating-cash-flow"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="investing-cash-flow">Investing Cash Flow:</label>
                            <input type="number" id="investing-cash-flow" name="investing-cash-flow"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="total-dividen">Total Dividen:</label>
                            <input type="number" id="total-dividen" name="total-dividen" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="stock-split">Stock Split:</label>
                            <input type="number" id="stock-split" name="stock-split" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="eps">EPS:</label>
                            <input type="number" id="eps" name="eps" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="tahun">Tahun:</label>
                            <input type="number" id="tahun" name="tahun" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="clear-form" class="btn btn-light">Clear</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submit-button" type="submit" class="btn btn-primary">Submit</button>
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
<script src="{{asset('template')}}/js/fundamentalBank.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.2/datatables.min.js"></script>
@stop
@endsection