@extends('layouts.master')

@section('content')
<html>

<head>
  @section('page-style-files')
  <script src="{{asset('style')}}/table/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link rel="stylesheet" href="{{asset('style')}}/table/css/bootstrap.min.css">
  @stop


</head>

<body>
  <h4 hidden id="ticker">{{$ticker}}</h4>
  <div class="container">
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
    <div class="btn-group m-3" role="group" aria-label="First group">
      <button type="button" class="btn btn-dark btn-round mr-md-3 mb-md-0 mb-2" id="oneWeek">Satu Minggu</button>
      <button type="button" class="btn btn-dark btn-round mr-md-3 mb-md-0 mb-2" id="oneMonth">Satu Bulan</button>
      <button type="button" class="btn btn-dark btn-round mr-md-3 mb-md-0 mb-2" id="oneYear">Satu Tahun</button>
      <button type="button" class="btn btn-dark btn-round mr-md-3 mb-md-0 mb-2" id="threeYear">Tiga Tahun</button>
    </div>
    <div class="row">
      <div class="col-md-6">
        <h3>Analisis (2022)</h3>
        <a href="/fundamental">Analisis Tahun Lainnya...</a>
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Parameter</th>
              <th>Value</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>DER</td>
              <td>0.75</td>
            </tr>
            <tr>
              <td>Loan to Deposit Ratio</td>
              <td>0.85</td>
            </tr>
            <tr>
              <td>Dividend</td>
              <td>$2.00</td>
            </tr>
            <tr>
              <td>Dividend Yield</td>
              <td>3.5%</td>
            </tr>
            <tr>
              <td>Dividend Payout Ratio</td>
              <td>50%</td>
            </tr>
            <tr>
              <td>PBV</td>
              <td>1.25</td>
            </tr>
            <tr>
              <td>Annualized PER</td>
              <td>15.2</td>
            </tr>
            <tr>
              <td>Annualized ROA</td>
              <td>4.5%</td>
            </tr>
            <tr>
              <td>GPM</td>
              <td>25%</td>
            </tr>
            <tr>
              <td>NPM</td>
              <td>10%</td>
            </tr>
            <tr>
              <td>EER</td>
              <td>8.5%</td>
            </tr>
            <tr>
              <td>EAR</td>
              <td>9%</td>
            </tr>
            <tr>
              <td>Market Cap</td>
              <td>$500 million</td>
            </tr>
            <tr>
              <td>Market Cap to Assets Ratio</td>
              <td>1.5</td>
            </tr>
            <tr>
              <td>CFO to Sales Ratio</td>
              <td>20%</td>
            </tr>
            <tr>
              <td>Capex to CFO Ratio</td>
              <td>0.75</td>
            </tr>
            <tr>
              <td>Market Cap to CFO Ratio</td>
              <td>4.5</td>
            </tr>
            <tr>
              <td>PEG</td>
              <td>1.2</td>
            </tr>
            <tr>
              <td>Harga Saham+Dividen</td>
              <td>$25.50</td>
            </tr>
            <tr>
              <td>Tahun</td>
              <td>2022</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
        <h3>Finansial (2022)</h3>
        <a href="/fundamental/input/{{$ticker}}">Finansial Tahun Lainnya...</a>
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Metric</th>
              <th>Value</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Aset</td>
              <td>123</td>
            </tr>
            <tr>
              <td>Hutang Obligasi</td>
              <td>$600 million</td>
            </tr>
            <tr>
              <td>Saldo Laba</td>
              <td>$100 million</td>
            </tr>
            <tr>
              <td>Ekuitas</td>
              <td>$300 million</td>
            </tr>
            <tr>
              <td>Jumlah Saham Beredar</td>
              <td>50 million</td>
            </tr>
            <tr>
              <td>Pendapatan</td>
              <td>$200 million</td>
            </tr>
            <tr>
              <td>Laba Kotor</td>
              <td>$50 million</td>
            </tr>
            <tr>
              <td>Laba Bersih</td>
              <td>$30 million</td>
            </tr>
            <tr>
              <td>Harga Saham</td>
              <td>$20.50</td>
            </tr>
            <tr>
              <td>Operating Cashflow</td>
              <td>$60 million</td>
            </tr>
            <tr>
              <td>Investing Cashflow</td>
              <td>-$40 million</td>
            </tr>
            <tr>
              <td>Total Dividen</td>
              <td>$10 million</td>
            </tr>
            <tr>
              <td>Stock Split</td>
              <td>2-for-1</td>
            </tr>
            <tr>
              <td>Earnings Per Share</td>
              <td>$0.60</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>


</body>
@section('page-js-files')
@vite(['resources/js/chart.js'])
<script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
@stop

</html>




@endsection