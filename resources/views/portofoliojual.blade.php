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
                  @foreach ($dataporto as $item)
                  <tr scope = "row">
                      <td>{{$i }}</td>
                      <?php $i++ ?>
                      <td>{{$item -> nama_saham}}</td>
                      <td>{{$item -> volume}}</td>
                      <td>{{$item -> tanggal_jual}}</td>
                      <td>{{$item -> harga_jual}}</td>
                      <td>{{$item -> fee_jual_persen}}</td>
                      <td>
                        <button onclick="location.href='/portofoliojual/edit/{{$item->id_portofolio_jual}}'" class="btn btn-success" type="button"><i class="fas fa-edit"></i></button>
                        <button data-toggle="modal" data-target="#deletemodal" type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                      </td>
                      
                  </tr>
                   <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="deletemodalLabel">WARNING!</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h3>Apakah Anda Yakin Untuk Menghapus Data?</h3>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button onclick="location.href='/portofoliojual/delete/{{$item->id_portofolio_jual}}'" type="button" class="btn btn-primary">Delete Data</button>
                            </div>
                          </div>
                        </div>
                      </div>
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
                <h4 class="modal-title w-100 font-weight-bold">Input Data Portofolio jual</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="/portofoliojual/addjual" id="form_jual" name="formjual"  method="post">
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
                    <label data-error="wrong" data-success="right" for="form32">Tanggal jual</label>
                    <input name="tanggal_jual" type="date" id="tanggl_jual" class="form-control validate">
                  </div>

                  <div class="md-form mb-5">
                    <label data-error="wrong" data-success="right" for="form32">Harga jual</label>
                    <input name="harga_jual" type="number" id="harga_jual" class="form-control validate">
                  </div>
                  <div class="md-form mb-5">
                    <label data-error="wrong" data-success="right" for="form32">Fee jual</label>
                    <input name="fee_jual_persen" type="number" id="fee_jual_persen" class="form-control validate">
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