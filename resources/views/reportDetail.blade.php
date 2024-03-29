@extends('layouts.master')

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @section('page-style-files')
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('style')}}/table/fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{asset('style')}}/table/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('style')}}/table/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="{{asset('style')}}/table/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" />

    @stop
</head>

<body>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Report Saham</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Nama Saham</th>
                        <th>Tanggal</th>
                        <th>Lot</th>
                        <th>Beli</th>
                        <th>Jual</th>
                        <th>Sekuritas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $report)
                    @if ($report['tag'] == 'beli')
                    <tr>
                        <td>{{ $report['nama_saham'] }}</td>
                        <td>{{ $report['tanggal'] }}</td>
                        <td>{{ $report['volume'] }}</td>
                        <td>{{ $report['harga'] }}</td>
                        <td></td>
                        <td>{{ $report['nama_sekuritas']}}</td>
                    </tr>
                    @endif
                    @if($report['tag'] == 'jual')
                    <tr>
                        <td>{{ $report['nama_saham'] }}</td>
                        <td>{{ $report['tanggal'] }}</td>
                        <td>{{ $report['volume'] }}</td>
                        <td></td>
                        <td>{{ $report['harga'] }}</td>
                        <td>{{ $report['nama_sekuritas']}}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Parameter</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Keuntungan</td>
                        <td>Rp.{{number_format($keuntungan)}}</td>
                    </tr>
                    <tr>
                        <td>Realisasi</td>
                        <td>Rp.{{number_format($realisasi)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
@section('page-js-files')
<script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
@stop

@endsection