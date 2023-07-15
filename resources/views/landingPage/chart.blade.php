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
        <div class="btn-group m-3" role="group" aria-label="First group">
            <button type="button" class="btn btn-dark btn-round mr-md-3 mb-md-0 mb-2" id="oneWeek">Satu
                Minggu</button>
            <button type="button" class="btn btn-dark btn-round mr-md-3 mb-md-0 mb-2" id="oneMonth">Satu
                Bulan</button>
            <button type="button" class="btn btn-dark btn-round mr-md-3 mb-md-0 mb-2" id="oneYear">Satu
                Tahun</button>
            <button type="button" class="btn btn-dark btn-round mr-md-3 mb-md-0 mb-2" id="threeYear">Tiga
                Tahun</button>
        </div>
        <div id="chart_div" style="width: 100%; height: 500px;"></div>
        <div class="d-flex justify-content-center align-items-center">
            <div id="loader" class="spinner-border display-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>


        @auth
        @if ($laporan)
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3>Analisis ({{$inputData['tahun']}})</h3>
                        @if (Auth::user()->rolse == 1)
                        <a href="/fundamental">Analisis Tahun Lainnya...</a>
                        @endif
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
                                    <td>{{$outputData['loan_to_depo_ratio']}}%</td>
                                </tr>
                                @else
                                <tr>
                                    <td>DER</td>
                                    <td>{{$outputData['der']}}%</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Annualized ROE</td>
                                    <td>{{$outputData['annualized_roe']}}%</td>
                                </tr>
                                <tr>
                                    <td>Dividend</td>
                                    <td>{{$outputData['dividen']}}</td>
                                </tr>
                                <tr>
                                    <td>Dividend Yield</td>
                                    <td>{{$outputData['dividen_yield']}}%</td>
                                </tr>
                                <tr>
                                    <td>Dividend Payout Ratio</td>
                                    <td>{{$outputData['dividen_payout_ratio']}}%</td>
                                </tr>
                                <tr>
                                    <td>PBV</td>
                                    <td>{{$outputData['pbv']}}</td>
                                </tr>
                                <tr>
                                    <td>Annualized PER</td>
                                    <td>{{$outputData['annualized_per']}}</td>
                                </tr>
                                <tr>
                                    <td>Annualized ROA</td>
                                    <td>{{$outputData['annualized_roa']}}%</td>
                                </tr>
                                <tr>
                                    <td>GPM</td>
                                    <td>{{$outputData['gpm']}}%</td>
                                </tr>
                                <tr>
                                    <td>NPM</td>
                                    <td>{{$outputData['npm']}}%</td>
                                </tr>
                                <tr>
                                    <td>EER</td>
                                    <td>{{$outputData['eer']}}%</td>
                                </tr>
                                <tr>
                                    <td>EAR</td>
                                    <td>{{$outputData['ear']}}%</td>
                                </tr>
                                <tr>
                                    <td>Market Cap</td>
                                    <td>Rp. {{$outputData['market_cap']}}</td>
                                </tr>
                                <tr>
                                    <td>Market Cap to Assets Ratio</td>
                                    <td>{{$outputData['market_cap_asset_ratio']}}</td>
                                </tr>
                                <tr>
                                    <td>CFO to Sales Ratio</td>
                                    <td>{{$outputData['cfo_sales_ratio']}}%</td>
                                </tr>
                                <tr>
                                    <td>Capex to CFO Ratio</td>
                                    <td>{{$outputData['capex_cfo_ratio']}}</td>
                                </tr>
                                <tr>
                                    <td>Market Cap to CFO Ratio</td>
                                    <td>{{$outputData['market_cap_cfo_ratio']}}</td>
                                </tr>
                                <tr>
                                    <td>PEG</td>
                                    <td>{{$outputData['peg']}}</td>
                                </tr>
                                <tr>
                                    <td>Harga Saham+Dividen</td>
                                    <td>{{$outputData['harga_saham_sum_dividen']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3>Finansial ({{$inputData['tahun']}})</h3>
                        @if (Auth::user()->roles == 1)
                        <a href="/fundamental/input/{{$ticker}}">Finansial Tahun Lainnya...</a>
                        @endif
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
                                    <td>Rp. {{number_format($inputData['aset'])}}</td>
                                </tr>
                                @if ($check == 1)
                                <tr>
                                    <td>Simpanan</td>
                                    <td>Rp. {{number_format($inputData['simpanan'])}}</td>
                                </tr>
                                <tr>
                                    <td>Pinjaman</td>
                                    <td>Rp. {{number_format($inputData['pinjaman'])}}</td>
                                </tr>
                                @else
                                <tr>
                                    <td>Hutang Obligasi</td>
                                    <td>Rp. {{number_format($inputData['hutang_obligasi'])}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Saldo Laba</td>
                                    <td>Rp. {{number_format($inputData['saldo_laba'])}}</td>
                                </tr>
                                <tr>
                                    <td>Ekuitas</td>
                                    <td>Rp. {{number_format($inputData['ekuitas'])}}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Saham Beredar</td>
                                    <td>{{number_format($inputData['jml_saham_edar'])}}</td>
                                </tr>
                                <tr>
                                    <td>Pendapatan</td>
                                    <td>Rp. {{number_format($inputData['pendapatan'])}}</td>
                                </tr>
                                <tr>
                                    <td>Laba Kotor</td>
                                    <td>Rp. {{number_format($inputData['laba_kotor'])}}</td>
                                </tr>
                                <tr>
                                    <td>Laba Bersih</td>
                                    <td>Rp. {{number_format($inputData['laba_bersih'])}}</td>
                                </tr>
                                <tr>
                                    <td>Harga Saham</td>
                                    <td>Rp. {{number_format($inputData['harga_saham'])}}</td>
                                </tr>
                                <tr>
                                    <td>Operating Cashflow</td>
                                    <td>Rp. {{number_format($inputData['operating_cash_flow'])}}</td>
                                </tr>
                                <tr>
                                    <td>Investing Cashflow</td>
                                    <td>Rp. {{number_format($inputData['investing_cash_flow'])}}</td>
                                </tr>
                                <tr>
                                    <td>Total Dividen</td>
                                    <td>{{number_format($inputData['total_dividen'])}}</td>
                                </tr>
                                <tr>
                                    <td>Stock Split</td>
                                    <td>{{number_format($inputData['stock_split'])}}</td>
                                </tr>
                                <tr>
                                    <td>Earnings Per Share</td>
                                    <td>{{$inputData['eps']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
        <h4>Belum subscribe</h4>
        <form action="/plan" method="POST">
            @csrf
            <input type="hidden" name="id" value="7">
            <button type="submit" class="follow-button follow-btn btn">Subscribe</button>
        </form>
        @endif
        @endauth
        <div>
            <div class="row mt-5">
                @if ($post)
                @foreach ($post as $posts)
                <div class="preview-card">
                    <div class="preview-card__wrp">
                        <div class="preview-card__item">
                            <div class="preview-card__img">
                                <img src="{{asset('images')}}/public_images/{{$posts['picture']}}" alt="">
                            </div>
                            <div class="preview-card__content">
                                <span
                                    class="preview-card__code">{{\Carbon\Carbon::parse($posts['updated_at'])->diffForHumans()}}</span>
                                <div class="preview-card__title">{{$posts['title']}}</div>
                                <div><strong>{{Str::camel($posts['tag'])}}</strong></div>
                                <div><strong>Written by : </strong>{{$posts['name']}}</div>
                                <div class="preview-card__text">{{Str::limit($posts['content'], 100)}}</div>
                                <a href="/post/view/{{$posts['id_post']}}" class="preview-card__button">READ
                                    MORE</a>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>


@vite(['resources/js/chart.js', 'resources/sass/chart.scss'])
@section('page-js-files')
<script src="{{asset('style')}}/table/js/bootstrap.min.js"></script>
@stop



@endsection