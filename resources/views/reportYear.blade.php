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
                        <th>Keuntungan (dari tahun lalu)</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $year)
                    <tr>

                        <td>{{ $year['year'] }}</td>
                        <td>{{ $year['keuntungan'] }}</td>
                        <td>{{ $year['realisasi'] }}</td>
                        <td>{{ $year['keuntunganPercent'] }}%</td>
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