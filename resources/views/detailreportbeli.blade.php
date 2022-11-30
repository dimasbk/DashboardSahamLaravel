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
      <h2 class="mb-5">Tabel Report Portofolio</h2>
      <button onclick="location.href='/reportbeli/{{Auth::id()}}'" class="btn btn-info btn-lg previous">Kembali</button>
      <div class="table-responsive">
        <table class="table custom-table">
          <thead>
            <tr>
              <th scope="col">No </th>
              <th scope="col">Nama Emiten </th>
              <th scope="col">Total volume </th>
              <th scope="col">Total Beli Bersih</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1 ?>
            @foreach ($beli as $item)
            <tr scope = "row">
              <td>{{$i }}</td>
              <?php $i++ ?>
              <td>{{$item -> nama_saham}}</td>
              <td>{{$item -> total_volume}}</td>
              <td>{{$item -> beli_bersih}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="{{asset('style')}}/table/js/jquery-3.3.1.min.js"></script>
  <script src="{{asset('style')}}/table/js/popper.min.js"></script>
  <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
  <script src="{{asset('style')}}/table/js/main.js"></script>
</body>

@endsection