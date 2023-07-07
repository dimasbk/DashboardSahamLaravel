@extends('landingPage.template')

@section('content')
@vite(['resources/css/plan.css'])

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{config('midtrans.client_key')}}"></script>
</head>

<body>
    <div class="container" style="margin-top: 200px">
        <div id="generic_price_table">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <!--PRICE HEADING START-->
                            <div class="price-heading clearfix">
                                <h1>Subscribing to {{$analystData->name}}</h1>
                            </div>
                            <!--//PRICE HEADING END-->
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        @foreach ($prices as $price)
                        <div class="col-md-4" style="margin-bottom: 20px">
                            <div class="generic_content clearfix">
                                <div class="generic_head_price clearfix">
                                    <div class="generic_head_content clearfix">
                                        <div class="head_bg"></div>
                                        <div class="head">
                                            <span>{{$price->month}} Bulan</span>
                                        </div>
                                    </div>
                                    <div class="generic_price_tag clearfix">
                                        <span class="price">
                                            <span class="sign">Rp.</span>
                                            <span class="currency">{{number_format($price->price)}}</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="generic_feature_list">
                                    @if ($analystData->id_roles==1)
                                    <ul>
                                        <li><span>Financial</span> Data</li>
                                        <li><span>Fundamental</span> Calculation</li>
                                    </ul>
                                    @else
                                    <ul>
                                        <li><span>Stock</span> Analysis</li>
                                        <li><span>Portofolio</span> Preview</li>
                                        <li><span>General</span> Analysis</li>
                                        @if ($price->month == 1)
                                        <li><span>{{$price->month}} Month </span> Subcription</li>
                                        @else
                                        <li><span>{{$price->month}} Months </span> Subcription</li>
                                        @endif
                                    </ul>
                                    @endif
                                </div>
                                <div class="generic_price_btn clearfix">
                                    <form id="form_{{$price->id_price}}" action="/subscribe" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$analystData->id}}">
                                        <input type="hidden" name="id_price" value="{{$price->id_price}}">

                                        <a href="javascript:$('#form_{{$price->id_price}}').submit();">Subscribe</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>


@endsection