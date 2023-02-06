@extends('template.master')

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('style')}}/table/fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{asset('style')}}/table/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('style')}}/table/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="{{asset('style')}}/table/css/style.css">
</head>
<body>
    <div class="content">
        <div class="container">
            <h2 class="mb-5">Tabel Emiten Saham</h2>
            <div class="table-responsive">
                <table class="table custom-table">
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
                        <tr scope = "row">
                            <td>{{$i }}</td>
                            <?php $i++ ?>
                            <td>{{$item['ticker']}}</td>
                            <td>{{$item['name']}}</td>
                            <td>
                                <button onclick="location.href='/chart/{{$item['ticker']}}'" class="btn btn-success" type="button"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        @endforeach
               
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

@endsection