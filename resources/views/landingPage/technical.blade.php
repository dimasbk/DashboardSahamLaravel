@extends('landingPage.template')

@section('content')
@vite(['resources/js/technical.js'])
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container">
    <div class="card shadow mb-4" style="margin-top: 70px">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Trends</h6>
        </div>
        <div class="card-body">
            <form method="get" action="/search/technical">
                @csrf
                <div class="mb-3">
                    <label for="dropdown1" class="form-label">Stock Trend :</label>
                    <select class="form-select" id="trend" name="trend">
                        <option value="uptrend">Uptrend</option>
                        <option value="downtrend">Downtrend </option>
                        <option value="sideways">Sideways</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fundamental" class="form-label">Fundamental :</label>
                    <select class="form-select" id="fundamental" name="param">
                        <option value="der">Debt to Equity Ratio</option>
                        <option value="loan_to_depo_ratio">Loan to Deposit Ratio</option>
                    </select>
                    <div class="input-group">
                        <select class="form-select" id="comparison" name="comparison">
                            <option selected value="<">Less than</option>
                            <option value=">">More than</option>
                        </select>
                        <input type="number" class="form-control" id="percentage" name="num" required>
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="startDate" class="form-label">Start Date:</label>
                    <input type="date" class="form-control" id="startDate" name="start">
                </div>
                <div class="mb-3">
                    <label for="endDate" class="form-label">End Date:</label>
                    <input type="date" class="form-control" id="endDate" name="end">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <table class="table table-striped table-hover mt-4" id="tableData">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Emiten</th>
                        <th scope="col">Trend</th>
                        <th scope="col">Trend Changes</th>
                        <th scope="col">DER</th>
                        <th scope="col">Loan to Deposit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filteredData as $data)
                    @php
                    $i = 1;
                    @endphp
                    <td>{{$i}}</td>
                    @php
                    $i++
                    @endphp
                    <td>{{$data['ticker']}}</td>
                    <td>{{$data['trend']}}</td>
                    <td>{{$data['change']}}</td>
                    <td>{{$data['der']}}</td>
                    <td>{{$data['ldr']}}</td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection