@extends('landingPage.template')

@section('content')


@section('page-style-files')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@stop
<style>
    .display-none {
        display: none !important;
    }
</style>




<div style="margin-top: 100px;">
    <div class="container">
        <button display="none" type="button" class="btn btn-dark btn-round mr-md-3 mb-md-0 mb-2 display-none"
            id="oneWeek"></button>
        <input type="hidden" name="emiten" id="emiten" value="{{$ticker}}">
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        <div class="d-flex justify-content-center align-items-center">
            <div id="loader" class="spinner-border display-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="row">
            <div class="h-100 d-flex align-items-center justify-content-center">
                <h3>Fundamental {{$ticker}}</h3>
            </div>
            <div id="chart_div2" style="width: 100%; height: 500px;"></div>
            <div id="chart_div1" style="width: 100%; height: 500px;"></div>
            <div id="chart_div" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
</div>


@vite(['resources/js/chartFundamental.js', 'resources/sass/chart.scss'])
@section('page-js-files')
<script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
@stop



@endsection