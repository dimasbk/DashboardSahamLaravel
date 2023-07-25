@extends('landingPage.template')

@section('content')
@vite(['resources/js/search.js', 'resources/css/search.css'])

<div class="container">
    <div style="margin-top: 100px">
        <div style="display:flex; justify-content:center;">
            <h3>Cari Emiten</h3>
        </div>
        <div class="searchbar">
            <div class="searchbar-wrapper">
                <div class="searchbar-left">
                    <div class="search-icon-wrapper">
                        <span class="search-icon searchbar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path
                                    d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                                </path>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="searchbar-center">
                    <div class="searchbar-input-spacer"></div>

                    <input type="text" id="searchBar" class="searchbar-input" maxlength="2048" name="q"
                        autocapitalize="off" autocomplete="off" title="Search" role="combobox"
                        placeholder="Search Emiten">
                </div>

                <div class="searchbar-right">

                </div>
            </div>
        </div>
        <div>
            <table id="emiten" class="table custom-table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Ticker Emiten</th>
                        <th scope="col">Nama Emiten</th>
                        <th scope="col">Detail Chart</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$i}}</td>
                        <?php $i++; ?>
                        <td>{{$item->nama_saham}}</td>
                        <td>{{$item->nama_perusahaan}}</td>
                        <td>
                            <a href="/emiten/{{$item->nama_saham}}" type="button" class="btn btn-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $data->links() }}
        </div>
    </div>
</div>

@endsection