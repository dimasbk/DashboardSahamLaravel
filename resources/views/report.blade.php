@extends('template.master')


@section('content')
<head>
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
          <h2 class="mb-5">Tabel Portofolio Jual</h2>
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link" href="/portofoliobeli/{{Auth::id()}}">Beli</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="#">Jual</a>
            </li>
          </ul>
          <div class="container">
            <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#modalContactForm">Buat Data Portofolio</a>
          </div>
    
          <div class="table-responsive">
    
            <table class="table custom-table">
              <thead>
                <tr>
                    <th scope="col">No </th>
                    <th scope="col">Nama Emiten</th>
                    <th scope="col">Volume Jual</th>
                    <th scope="col">Tanggal Jual</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">Fee Jual(%)</th>
                </tr>
              </thead>
              <tbody>
              <?php $i = 1 ?>
                @foreach ($dataporto as $data)
                  @foreach ($data as $item)
                  <tr scope = "row">
                      <td>{{$i }}</td>
                      <?php $i++ ?>
                      <td>{{$item -> nama_saham}}</td>
                      <td>{{$item -> volume}}</td>
                      <td>{{$item -> tanggal_jual}}</td>
                      <td>{{$item -> harga_jual}}</td>
                      <td>{{$item -> fee_jual_persen}}</td>
                  </tr>
                  @endforeach
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