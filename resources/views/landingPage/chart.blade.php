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
        <div class="d-flex align-items-center justify-content-center">
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
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <div id="loader" class="spinner-border display-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div id="chart_div" style="width: 100%; height: 500px;"></div>

        @auth
        @if ($laporan)
        <a type="button" style="margin-bottom: 10px" class="btn btn-primary"
            href="/emiten/{{$ticker}}/fundamental">Lihat semua tahun</a>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3>Analisis</h3>
                        @if (Auth::user()->rolse == 1)
                        <a href="/fundamental">Analisis Tahun Lainnya...</a>
                        @endif
                        <table class="table table-bordered table-striped table-responsive" style="overflow-x: auto;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Parameter</th>
                                    @foreach ($outputData as $dataOutput)
                                    <th>{{$dataOutput['tahun']}} {{$dataOutput['kuartal']}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @if ($check == 1)
                                <tr>
                                    <th>Loan to Deposit Ratio</th>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['loan_to_depo_ratio']}}%</td>
                                    @endforeach
                                </tr>
                                @else
                                <tr>
                                    <td>DER</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['der']}}%</td>
                                    @endforeach
                                </tr>
                                @endif
                                <tr>
                                    <td>Annualized ROE</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['annualized_roe']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Dividend</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['dividen']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Dividend Yield</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['dividen_yield']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Dividend Payout Ratio</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['dividen_payout_ratio']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>PBV</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['pbv']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Annualized PER</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['annualized_per']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Annualized ROA</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['annualized_roa']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>GPM</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['gpm']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>NPM</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['npm']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>EER</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['eer']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>EAR</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['ear']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Market Cap</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['market_cap']}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Market Cap to Assets Ratio</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['market_cap_asset_ratio']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>CFO to Sales Ratio</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['annualized_roa']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Capex to CFO Ratio</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['capex_cfo_ratio']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Market Cap to CFO Ratio</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['market_cap_cfo_ratio']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>PEG</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['peg']}}%</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Harga Saham+Dividen</td>
                                    @foreach ($outputData as $dataOutput)
                                    <td>{{$dataOutput['harga_saham_sum_dividen']}}%</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3>Finansial</h3>
                        @if (Auth::user()->roles == 1)
                        <a href="/fundamental/input/{{$ticker}}">Finansial Tahun Lainnya...</a>
                        @endif
                        <table class="table table-bordered table-striped table-responsive" style="overflow-x: auto;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Metric</th>
                                    @foreach ($inputData as $data)
                                    <th>{{$data['tahun']}} {{$data['type']}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Aset</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['aset'])}}</td>
                                    @endforeach
                                </tr>
                                @if ($check == 1)
                                <tr>
                                    <td>Simpanan</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['simpanan'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Pinjaman</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['pinjaman'])}}</td>
                                    @endforeach
                                </tr>
                                @else
                                <tr>
                                    <td>Hutang Obligasi</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['hutang_obligasi'])}}</td>
                                    @endforeach
                                </tr>
                                @endif
                                <tr>
                                    <td>Saldo Laba</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['saldo_laba'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Ekuitas</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['ekuitas'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Jumlah Saham Beredar</td>
                                    @foreach ($inputData as $data)
                                    <td>{{number_format($data['jml_saham_edar'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Pendapatan</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['pendapatan'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Laba Kotor</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['laba_kotor'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Laba Bersih</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['laba_bersih'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Harga Saham</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['harga_saham'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Operating Cashflow</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['operating_cash_flow'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Investing Cashflow</td>
                                    @foreach ($inputData as $data)
                                    <td>Rp. {{number_format($data['investing_cash_flow'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Total Dividen</td>
                                    @foreach ($inputData as $data)
                                    <td>{{number_format($data['total_dividen'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Stock Split</td>
                                    @foreach ($inputData as $data)
                                    <td>{{number_format($data['stock_split'])}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Earnings Per Share</td>
                                    @foreach ($inputData as $data)
                                    <td>{{number_format($data['eps'])}}</td>
                                    @endforeach
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