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
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Report Saham</h6>
            </div>
            <div class="card-body">
                <form action="/reportporto/range" method="get">
                    @csrf
                    <div class="form-group">
                        <label for="fromDate">From:</label>
                        <input type="date" class="form-control" id="fromDate" name="from">
                    </div>
                    <div class="form-group">
                        <label for="toDate">To:</label>
                        <input type="date" class="form-control" id="toDate" name="to">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <table style="margin-top: 10px" class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Saham</th>
                            <th>Tanggal</th>
                            <th>Volume Beli</th>
                            <th>Volume Jual</th>
                            <th>Harga</th>
                            <th>Sekuritas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data)
                        @foreach ($data as $report)
                        @if ($report['tag'] == 'beli')
                        <tr>
                            <td>{{ $report['nama_saham'] }}</td>
                            <td>{{ $report['tanggal'] }}</td>
                            <td>{{ $report['volume'] }}</td>
                            <td></td>
                            <td>{{ $report['harga'] }}</td>
                            <td>{{ $report['nama_sekuritas']}}</td>
                        </tr>
                        @else
                        <tr>
                            <td>{{ $report['nama_saham'] }}</td>
                            <td>{{ $report['tanggal'] }}</td>
                            <td></td>
                            <td>{{ $report['volume'] }}</td>
                            <td>{{ $report['harga'] }}</td>
                            <td>{{ $report['nama_sekuritas']}}</td>
                        </tr>
                        @endif

                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
@section('page-js-files')
<script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
@stop

@endsection