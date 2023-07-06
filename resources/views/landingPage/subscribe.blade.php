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
        <div class="alert alert-info">
            <p><strong>Subscription for :</strong> <span id="subscriptionName">{{$analystData->name}}</span></p>
            <p><strong>Harga per bulan :</strong> <span id="subscriptionPrice">{{$analystData->price_per_month}}</span>
            </p>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" id="id" value="{{$analystData->id}}">
        <input type="hidden" name="price" id="price" value="{{$analystData->price_per_month}}">
        <div class="form-group">
            <label for="duration">Select Duration:</label>
            <select class="form-control" name="duration" id="duration">
                <option value="1">1 month</option>
                <option value="3">3 months</option>
                <option value="6">6 months</option>
                <option value="12">12 months</option>
            </select>
        </div>
        <button id="getToken" class="btn btn-primary" style="margin-top: 10px">Pay Now</button>
        <div id="snap-container"></div>
    </div>
</body>


@endsection