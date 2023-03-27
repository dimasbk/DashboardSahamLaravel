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
    <div class="content">
        <div class="container">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Emiten Saham</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="chartTable" class="table custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">No </th>
                                    <th scope="col">Ticker Emiten</th>
                                    <th scope="col">Nama Emiten</th>
                                    <th scope="col">Detail Chart</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1 ?>
                                @foreach ($data as $item)
                                <tr scope="row">
                                    <td>{{$i }}</td>
                                    <?php $i++ ?>
                                    <td>{{$item['ticker']}}</td>
                                    <td>{{$item['name']}}</td>
                                    <td>
                                        <button onclick="location.href='/chart/{{$item['ticker']}}'"
                                            class="btn btn-success" type="button"><i
                                                class="fas fa-line-chart"></i></button>
                                        <button onclick="location.href='/fundamental/{{$item['ticker']}}'"
                                            class="btn btn-primary" type="button"><i
                                                class="fas fas fa-file-invoice-dollar"></i></button>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('page-js-files')
    <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('template')}}/js/stockData.js"></script>
    @stop

</body>

@endsection