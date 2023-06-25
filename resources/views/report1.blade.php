@extends('layouts.master')

@section('content')

<body>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Report Saham</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Nama Saham</th>
                        <th>Total Volume Beli</th>
                        <th>Average Buy</th>
                        <th>Total Volume Jual</th>
                        <th>Average Sell</th>
                        <th>Lot Remaining</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $report)
                    <tr>

                        <td>{{ $report['nama_saham'] }}</td>
                        <td>{{ $report['total_volume_beli'] }}</td>
                        <td>{{ $report['avg_harga_beli'] }}</td>
                        <td>{{ $report['total_volume_jual'] }}</td>
                        <td>{{ $report['avg_harga_jual'] }}</td>
                        <td>{{ $report['total_volume_beli'] - $report['total_volume_jual']}}</td>
                        <td><button class="btn btn-primary"
                                onclick="location.href='/report/{{$tahun}}/{{$report['nama_saham']}}'" type="button">
                                Detail</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

@endsection