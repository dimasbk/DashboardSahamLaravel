@extends('landingPage.template')

@section('content')
@vite(['resources/js/subscribe.js', 'resources/css/subscribe.css'])

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{config('midtrans.client_key')}}"></script>
</head>

<body>
    <div class="container" style="margin-top: 200px">
        <h1 class="mt-4">Subscription Details</h1>
        <div class="alert alert-info">
            <p><strong>Subscription for :</strong> <span id="subscriptionName">{{$analystData->name}}</span></p>
            <p><strong>Jumlah Bulan :</strong> <span id="subscriptionPrice">{{$prices->month}}</span>
            <p><strong>Harga :</strong> <span id="subscriptionPrice">{{$prices->price}}</span>
            </p>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" id="id" value="{{$analystData->id}}">
        <input type="hidden" name="duration" id="duration" value="{{$prices->month}}">
        <input type="hidden" name="price" id="price" value="{{$prices->price}}">
        <button id="getToken" class="btn btn-primary" style="margin-top: 10px">Pay Now</button>
        <div id="snap-container"></div>
    </div>
</body>


@endsection