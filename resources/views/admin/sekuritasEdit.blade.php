@extends('layouts.master')

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
    <link rel="stylesheet" href="{{asset('style')}}/table/css/style.css">
    <link rel="stylesheet" href="{{asset('style')}}/portoBeli.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
        integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" />
    @stop

</head>

<body>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Edit Post</h6>
        </div>
        <div class="card-body">
            <form action="/admin/sekuritas/update" method="post">
                @csrf
                <input type="hidden" value="{{$data->id_sekuritas}}" name="idSekuritas">
                <div class="form-group">
                    <label for="namaSekuritas">Nama Sekuritas</label>
                    <input type="text" class="form-control" id="namaSekuritas" name="namaSekuritas"
                        value="{{$data->nama_sekuritas}}">
                </div>
                <div class="form-group">
                    <label for="feeBeli">Fee Beli</label>
                    <input type="number" class="form-control" id="feeBeli" value="{{$data->fee_beli}}" name="feeBeli">
                </div>
                <div class="form-group">
                    <label for="feeJual">Fee Jual</label>
                    <input type="number" class="form-control" id="feeJual" value="{{$data->fee_jual}}" name="feeJual">
                </div>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
        </div>
    </div>
    @section('page-js-files')
    <script>
        $(document).ready(function() {
            $('#content').trigger('input');
        });
        // Dynamically adjust the height of the textarea based on its content
        $('#content').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        function previewImage() {
                const preview = document.getElementById("preview");
                const file = document.getElementById("image").files[0];
                const reader = new FileReader();

                reader.addEventListener(
                "load",
                function () {
                    preview.src = reader.result;
                },
                false
                );

                if (file) {
                reader.readAsDataURL(file);
                }
            }
    </script>

    <script src="{{asset('style')}}/table/js/popper.min.js"></script>
    <script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
    <script src="{{asset('style')}}/table/js/main.js"></script>
    <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
    @stop
</body>
@endsection