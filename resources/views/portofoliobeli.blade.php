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
          <h2 class="mb-5">Tabel Portofolio Beli</h2>
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" href="#">Beli</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/portofoliojual/{{Auth::id()}}">Jual</a>
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
                    <th scope="col">Volume Beli</th>
                    <th scope="col">Tanggal Beli</th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Fee Beli(%)</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1 ?>
                
                  @foreach ($dataporto as $item)
                  <tr scope = "row">
                      <td style="display:none;">{{$item->id_portofolio_beli}}</td>
                      <td>{{$i }}</td>
                      <?php $i++ ?>
                      <td>{{$item -> nama_saham}}</td>
                      <td>{{$item -> volume}}</td>
                      <td>{{$item -> tanggal_beli}}</td>
                      <td>{{$item -> harga_beli}}</td>
                      <td>{{$item -> fee_beli_persen}}</td>
                      <td><button onclick="location.href='/portofoliobeli/edit/{{$item->id_portofolio_beli}}'" class="btn btn-success" type="button"><i class="fas fa-edit"></i></button></td>

                  </tr>
                  @endforeach
                
              </tbody>
            </table>
          </div>
    
    
        </div>
    
      </div>

      <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="alert alert-danger" style="display:none"></div>
              <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Input Data Portofolio Jual</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="/portofoliobeli/addbeli" id="form_beli" name="formbeli"  method="post">
                @csrf
                <div class="modal-body mx-3">
                  <div class="md-form mb-5">
                    <label data-error="wrong" data-success="right" for="form34">Emiten Saham</label><br>
                    <select name="id_saham" id="id_saham" class="category">
                      <option disable selected @error('id_saham') is-invalid @enderror>--Pilih Saham--</option>
                      
                        @foreach($emiten as $item)
                          <option value="{{ $item->id_saham}}">{{ $item->nama_saham}}</option>
                        @endforeach
                      
                    </select>
                  </div>

                  <div class="md-form mb-5">
                    <label data-error="wrong" data-success="right" for="form29">Jenis Saham</label><br>
                    <select name="id_jenis_saham" id="id_jenis_saham" class="category">
                      <option disable selected>--Pilih Jenis--</option>
                      
                        @foreach($jenis_saham as $item)
                          <option value="{{ $item->id_jenis_saham}}">{{ $item->jenis_saham}}</option>
                        @endforeach
                     
                    </select>
                  </div>

                  <div class="md-form mb-5">
                    <label data-error="wrong" data-success="right" for="form32">Volume</label>
                    <input name="volume" type="number" id="volume" class="form-control validate">
                  </div>

                  <div class="md-form mb-5">
                    <label data-error="wrong" data-success="right" for="form32">Tanggal Beli</label>
                    <input name="tanggal_beli" type="date" id="tanggl_beli" class="form-control validate">
                  </div>

                  <div class="md-form mb-5">
                    <label data-error="wrong" data-success="right" for="form32">Harga Beli</label>
                    <input name="harga_beli" type="number" id="harga_beli" class="form-control validate">
                  </div>
                  <div class="md-form mb-5">
                    <label data-error="wrong" data-success="right" for="form32">Fee Beli</label>
                    <input name="fee_beli_persen" type="number" id="fee_beli_persen" class="form-control validate">
                    <label data-error="wrong" data-success="right" for="form32">%</label>
                  </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                  <button id="btn_send" type="submit" class="btn btn-unique">Send <i class="fas fa-paper-plane-o ml-1"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>
        
        
    
        <script src="{{asset('style')}}/table/js/jquery-3.3.1.min.js"></script>
        <script src="{{asset('style')}}/table/js/popper.min.js"></script>
        <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
        <script src="{{asset('style')}}/table/js/main.js"></script>

</body>

@endsection