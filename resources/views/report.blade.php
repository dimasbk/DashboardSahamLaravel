@extends('template.master')

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
                        <th>Total Volume Beli</th>
                        <th>Average Buy</th>
                        <th>Total Volume Jual</th>
                        <th>Average Sell</th>
                        <th>Lot Remaining</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $report)
                    <tr>

                        <td>{{ $report['nama_saham'] }}</td>
                        <td>{{ $report['total_volume_beli'] }}</td>
                        <td>{{ $report['avg_harga_beli'] }}</td>
                        <td>{{ $report['total_volume_jual'] }}</td>
                        <td>{{ $report['avg_harga_jual'] }}</td>
                        <td>{{ $report['total_volume_beli'] - $report['total_volume_jual']}}</td>
                        <td><button class="btn btn-primary" onclick="location.href='/report/{{$report['nama_saham']}}'"
                                type="button">
                                Detail</button></td>
                    </tr>
                    @endforeach
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