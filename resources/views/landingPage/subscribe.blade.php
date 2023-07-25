@extends('landingPage.template')

@section('content')
@vite(['resources/js/subscribe.js'])

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{config('midtrans.client_key')}}"></script>
</head>

<body>
    <div class="container" style="margin-top: 200px">
        <h1 class="mt-4">Subscription Details</h1>
        <label for="name">Subscription For</label>
        <input type="text" id="name" name="name" value="{{$analystData->name}}" disabled />
        <br />
        <div class="exp-cvc">
            <div class="expiration">
                <label for="expiry">Jumlah Bulan</label>
                <input class="inputCard" name="expiry" id="expiry" type="text" value="{{$prices->month}}" disabled />
                <br />
            </div>
            <div class="security">
                <label for="cvc">Total Harga</label>
                <input type="text" minlength="3" maxlength="4" id="cvc" name="cvc" value="{{$prices->price}}"
                    disabled />
                <br />
            </div>
        </div>
        <button id="getToken" class="btn btn-primary">Pay Now</button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" id="id" value="{{$analystData->id}}">
        <input type="hidden" name="duration" id="duration" value="{{$prices->month}}">
        <input type="hidden" name="price" id="price" value="{{$prices->price}}">

        <div id="snap-container"></div>
    </div>
</body>

@vite(['resources/css/subscribe.css'])
@endsection