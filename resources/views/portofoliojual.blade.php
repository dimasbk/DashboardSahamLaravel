@extends('template.master')


@section('content')

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @section('page-style-files')
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

  <script src="{{asset('style')}}/table/js/jquery-3.5.1.js"></script>

  <link rel="stylesheet" href="{{asset('style')}}/table/fonts/icomoon/style.css">

  <link rel="stylesheet" href="{{asset('style')}}/table/css/owl.carousel.min.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{asset('style')}}/table/css/bootstrap.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="{{asset('style')}}/table/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" />
  @stop
</head>

<body>
  <div class="content">

    <div class="container">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link" href="/portofoliobeli/{{Auth::id()}}">Beli</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Jual</a>
        </li>
      </ul>
      <div class="container">
        <a href="" class="btn btn-default btn-rounded mb-4 mt-4" data-toggle="modal"
          data-target="#modalContactForm">Buat Data Portofolio</a>
      </div>

      <div class="table-responsive">

        <table id="portofolioJual" class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">No </th>
              <th scope="col">Nama Emiten</th>
              <th scope="col">Volume Jual</th>
              <th scope="col">Tanggal Jual</th>
              <th scope="col">Harga Jual</th>
              <th scope="col">Fee Jual(%)</th>
              <th scope="col">Laba Rugi Jual(%)</th>
              <th scope="col"></th>

            </tr>
          </thead>
          <tbody>
            <?php $i = 1 ?>
            @foreach ($dataporto as $item)
            <tr scope="row">
              <td>{{$i }}</td>
              <?php $i++ ?>
              <td>{{$item -> nama_saham}}</td>
              <td>{{$item -> volume}}</td>
              <td>{{$item -> tanggal_jual}}</td>
              <td>{{$item -> harga_jual}}</td>
              <td>{{$item -> fee_jual_persen}}%</td>
              <td>{{$item -> close_persen}}%</td>
              <td>
                <button onclick="location.href='/portofoliojual/edit/{{$item->id_portofolio_jual}}'"
                  class="btn btn-success" type="button"><i class="fas fa-edit"></i></button>
                <button data-toggle="modal" data-target="#deletemodal" type="button" class="btn btn-danger"><i
                    class="far fa-trash-alt"></i></button>
              </td>

            </tr>
            <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel"
              aria-hidden="true">
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
                    <button onclick="location.href='/portofoliojual/delete/{{$item->id_portofolio_jual}}'" type="button"
                      class="btn btn-primary">Delete Data</button>
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
  <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Stock Purchase</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formBeli">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="emitenSaham">Emiten Saham</label>
              <select id="emitenSaham" name="emitenSaham">
                <option value="">Select Emiten Saham</option>
                @foreach($emiten as $item)
                <option value="{{ $item->id_saham}}">{{ $item->nama_saham}}</option>
                @endforeach
              </select>
              <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
              <label for="jenisSaham">Jenis Saham</label>
              <select id="jenisSaham" name="jenisSaham">
                <option value="">Select Jenis Saham</option>
                @foreach($jenis_saham as $item)
                <option value="{{ $item->id_jenis_saham}}">{{ $item->jenis_saham}}</option>
                @endforeach
              </select>
              <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
              <label for="volume">Volume</label>
              <input type="number" class="form-control" id="volume" name="volume" min="0" step="1">
              <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
              <label for="tanggalBeli">Tanggal Beli</label>
              <input type="date" class="form-control" id="tanggalBeli" name="tanggalBeli">
              <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
              <label for="hargaBeli">Harga Beli</label>
              <input type="number" class="form-control" id="hargaBeli" name="hargaBeli" min="0" step="0.01">
              <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
              <label for="feeBeli">Fee Beli</label>
              <input type="number" class="form-control" id="feeBeli" name="feeBeli" min="0" step="0.01">
              <div class="invalid-feedback"></div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button id="clear-form" class="btn btn-light">Clear</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="submit-button" type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>

  @section('page-js-files')
  <script src="{{asset('style')}}/table/js/popper.min.js"></script>
  <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
  <script src="{{asset('style')}}/table/js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{asset('template')}}/js/portofolioJual.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
  @stop
</body>

@endsection