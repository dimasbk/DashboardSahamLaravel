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
      <h2 class="mb-5">Tabel Report Portofolio Beli</h2>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="#">Beli</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/portofoliojual/{{Auth::id()}}">Jual</a>
        </li>
      </ul>
      <div class="table-responsive">
        <table class="table custom-table">
          <thead>
            <tr>
              <th scope="col">No </th>
              <th scope="col">Tahun</th>
              <th scope="col">Detail</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1 ?>
            @foreach ($tahun as $item)
            <tr scope = "row">
              <td>{{$i }}</td>
              <?php $i++ ?>
              <td>{{$item -> tahun}}</td>
              <td>
                
                <button onclick="location.href='/reportbeli/edit/{{Auth::id()}}/{{$item->tahun}}'" type="button" class="btn btn-primary"><i class="far fa-table"></i></button>
              </td>
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