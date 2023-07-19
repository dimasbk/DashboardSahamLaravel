@extends('layouts.master')

@section('content')

<body>
    <div class="container">
        @if (session('status'))
        <div style="margin-top: 10px" class="alert alert-success alert-dismissible" role="alert">
            {{session('status')}}
        </div>
        @endif
        <form action="/profile/update" method="post" enctype="multipart/form-data" class="container mt-4">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{Auth::user()->name}}" required>
            </div>

            <div class="form-group">
                <label for="profile-picture">Profile Picture:</label>
                <input type="file" class="form-control-file" id="profile-picture" name="profile-picture"
                    accept="image/*">
            </div>

            <div class="form-group">
                <label>Current Profile Picture:</label>
                <div class="mb-2">
                    @if (Auth::user()->profile_picture == null)
                    <img src="{{ asset ('default.jpg') }}" alt="Profile Picture" class="img-thumbnail"
                        style="max-width: 200px;">
                    @else
                    <img src="{{asset('images')}}/profile_picture/{{Auth::user()->profile_picture}}"
                        alt="Profile Picture" class="img-thumbnail" style="max-width: 200px;">
                    <a type="button" class="btn btn-alert" href="/delete-photo">Hapus Profile Picture</a>
                    @endif
                </div>
                <small class="text-muted">Upload a new profile picture to replace the current one.</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>

            @if ($request->status != 'approved')
            <div class="form-group" style="margin-top: 10px">
                <Strong>Analyst Request Status : {{$request->status}}</Strong>
            </div>
            @endif

            @if (Auth::user()->id_roles == 2)
            <a type="button" class="btn btn-primary" href="/profile/{{Auth::id()}}">Lihat Profile</a>
            @else

            @if ($request->status == 'rejected'||$request->status == 'no request')
            <a type="button" class="btn btn-primary" href="/profile/request/analyst">Request to be Analyst</a>
            @else
            @endif
            @endif

        </form>
    </div>

</body>

@endsection