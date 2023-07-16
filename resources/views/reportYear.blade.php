@extends('layouts.master')

@section('content')

<body>
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Report Saham</h6>
            </div>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Tahun</th>
                        <th>Keuntungan</th>
                        <th>Realisasi</th>
                        <th>Keuntungan %</th>
                        <th>Realisasi %</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $year)
                    <tr>

                        <td>{{ $year['year'] }}</td>
                        <td>{{ number_format($year['keuntungan'],2) }}</td>
                        <td>{{ number_format($year['realisasi'], 2) }}</td>
                        <td>{{ number_format($year['keuntunganPercent'],2) }}%</td>
                        <td>{{ number_format($year['realisasiPercent'],2) }}%</td>
                        <td><button class="btn btn-primary" onclick="location.href='/report/{{$year['year']}}'"
                                type="button">
                                Detail</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
</body>
@endsection