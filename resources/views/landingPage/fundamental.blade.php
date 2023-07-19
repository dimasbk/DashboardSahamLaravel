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
    <h4 hidden id="ticker">{{$ticker}}</h4>
    <div class="container">
        @auth
        @if ($laporan)
        @foreach ($dataFundamental as $data)
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3>Analisis ({{$data[1]['tahun']}})</h3>
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Parameter</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($check == 1)
                                <tr>
                                    <td>Loan to Deposit Ratio</td>
                                    <td>{{$data[0]['loan_to_depo_ratio']}}%</td>
                                </tr>
                                @else
                                <tr>
                                    <td>DER</td>
                                    <td>{{$data[0]['der']}}%</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Annualized ROE</td>
                                    <td>{{$data[0]['annualized_roe']}}%</td>
                                </tr>
                                <tr>
                                    <td>Dividend</td>
                                    <td>{{$data[0]['dividen']}}</td>
                                </tr>
                                <tr>
                                    <td>Dividend Yield</td>
                                    <td>{{$data[0]['dividen_yield']}}%</td>
                                </tr>
                                <tr>
                                    <td>Dividend Payout Ratio</td>
                                    <td>{{$data[0]['dividen_payout_ratio']}}%</td>
                                </tr>
                                <tr>
                                    <td>PBV</td>
                                    <td>{{$data[0]['pbv']}}</td>
                                </tr>
                                <tr>
                                    <td>Annualized PER</td>
                                    <td>{{$data[0]['annualized_per']}}</td>
                                </tr>
                                <tr>
                                    <td>Annualized ROA</td>
                                    <td>{{$data[0]['annualized_roa']}}%</td>
                                </tr>
                                <tr>
                                    <td>GPM</td>
                                    <td>{{$data[0]['gpm']}}%</td>
                                </tr>
                                <tr>
                                    <td>NPM</td>
                                    <td>{{$data[0]['npm']}}%</td>
                                </tr>
                                <tr>
                                    <td>EER</td>
                                    <td>{{$data[0]['eer']}}%</td>
                                </tr>
                                <tr>
                                    <td>EAR</td>
                                    <td>{{$data[0]['ear']}}%</td>
                                </tr>
                                <tr>
                                    <td>Market Cap</td>
                                    <td>Rp. {{$data[0]['market_cap']}}</td>
                                </tr>
                                <tr>
                                    <td>Market Cap to Assets Ratio</td>
                                    <td>{{$data[0]['market_cap_asset_ratio']}}</td>
                                </tr>
                                <tr>
                                    <td>CFO to Sales Ratio</td>
                                    <td>{{$data[0]['cfo_sales_ratio']}}%</td>
                                </tr>
                                <tr>
                                    <td>Capex to CFO Ratio</td>
                                    <td>{{$data[0]['capex_cfo_ratio']}}</td>
                                </tr>
                                <tr>
                                    <td>Market Cap to CFO Ratio</td>
                                    <td>{{$data[0]['market_cap_cfo_ratio']}}</td>
                                </tr>
                                <tr>
                                    <td>PEG</td>
                                    <td>{{$data[0]['peg']}}</td>
                                </tr>
                                <tr>
                                    <td>Harga Saham+Dividen</td>
                                    <td>{{$data[0]['harga_saham_sum_dividen']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3>Finansial ({{$data[1]['tahun']}})</h3>
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
                                    <td>Rp. {{number_format($data[1]['aset'])}}</td>
                                </tr>
                                @if ($check == 1)
                                <tr>
                                    <td>Simpanan</td>
                                    <td>Rp. {{number_format($data[1]['simpanan'])}}</td>
                                </tr>
                                <tr>
                                    <td>Pinjaman</td>
                                    <td>Rp. {{number_format($data[1]['pinjaman'])}}</td>
                                </tr>
                                @else
                                <tr>
                                    <td>Hutang Obligasi</td>
                                    <td>Rp. {{number_format($data[1]['hutang_obligasi'])}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Saldo Laba</td>
                                    <td>Rp. {{number_format($data[1]['saldo_laba'])}}</td>
                                </tr>
                                <tr>
                                    <td>Ekuitas</td>
                                    <td>Rp. {{number_format($data[1]['ekuitas'])}}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Saham Beredar</td>
                                    <td>{{number_format($data[1]['jml_saham_edar'])}}</td>
                                </tr>
                                <tr>
                                    <td>Pendapatan</td>
                                    <td>Rp. {{number_format($data[1]['pendapatan'])}}</td>
                                </tr>
                                <tr>
                                    <td>Laba Kotor</td>
                                    <td>Rp. {{number_format($data[1]['laba_kotor'])}}</td>
                                </tr>
                                <tr>
                                    <td>Laba Bersih</td>
                                    <td>Rp. {{number_format($data[1]['laba_bersih'])}}</td>
                                </tr>
                                <tr>
                                    <td>Harga Saham</td>
                                    <td>Rp. {{number_format($data[1]['harga_saham'])}}</td>
                                </tr>
                                <tr>
                                    <td>Operating Cashflow</td>
                                    <td>Rp. {{number_format($data[1]['operating_cash_flow'])}}</td>
                                </tr>
                                <tr>
                                    <td>Investing Cashflow</td>
                                    <td>Rp. {{number_format($data[1]['investing_cash_flow'])}}</td>
                                </tr>
                                <tr>
                                    <td>Total Dividen</td>
                                    <td>{{number_format($data[1]['total_dividen'])}}</td>
                                </tr>
                                <tr>
                                    <td>Stock Split</td>
                                    <td>{{number_format($data[1]['stock_split'])}}</td>
                                </tr>
                                <tr>
                                    <td>Earnings Per Share</td>
                                    <td>{{$data[1]['eps']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <h4>Belum subscribe</h4>
        <form action="/plan" method="POST">
            @csrf
            <input type="hidden" name="id" value="7">
            <button type="submit" class="follow-button follow-btn btn">Subscribe</button>
        </form>
        @endif
        @endauth
    </div>
</div>


@vite(['resources/js/chart.js', 'resources/sass/chart.scss'])
@section('page-js-files')
<script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
@stop



@endsection