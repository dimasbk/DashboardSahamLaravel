@extends('template.master')

@section('content')
<html>

<head>
  <script src="{{asset('style')}}/table/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>

  <div class="btn-group mr-2 d-flex justify-content-center flex-nowrap" role="group" aria-label="First group">
    <button id="oneWeek" type="button" class="btn btn-info">1</button>
    <button id="oneMonth" type="button" class="btn btn-info">2</button>
    <button id="oneYear" type="button" class="btn btn-info">3</button>
    <button id="threeYear" type="button" class="btn btn-info">4</button>
  </div>
  <h4 hidden id="ticker">{{$ticker}}</h4>
  <div id="chart_div" style="width: 100%; height: 500px;"></div>
  <script src="{{asset('template')}}/js/chart.js"></script>
</body>

</html>




@endsection