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
    <div class="content">
        <div class="container">
            <div class="container">
                @if (session('status'))
                <div style="margin-top: 10px" class="alert alert-success alert-dismissible" role="alert">
                    {{session('status')}}
                </div>
                @endif
                @if (session('deleted'))
                <div style="margin-top: 10px" class="alert alert-danger alert-dismissible" role="alert">
                    {{session('deleted')}}
                </div>
                @endif
                <div class="card shadow mb-4" style="margin-top: 10px">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Analyst Request</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="emiten" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">No </th>
                                        <th scope="col">User</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 ?>
                                    @foreach ($data as $item)
                                    <tr scope="row">
                                        <td>{{$i }}</td>
                                        <?php $i++ ?>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->status}}</td>
                                        <td>
                                            <button
                                                onclick="location.href='/admin/request/{{$item->id_request}}/accept'"
                                                class="btn btn-success" type="button">Accept</button>
                                            <button
                                                onclick="location.href='/admin/request/{{$item->id_request}}/reject'"
                                                type="button" class="btn btn-danger">Reject</button>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            {{ $data->links() }}
                        </div>
                    </div>
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
    <script src="https://kit.fontawesome.com/ce0d5ffb27.js" crossorigin="anonymous"></script>
    @vite(['resources/js/emitenAdmin.js'])
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    @stop
</body>

@endsection