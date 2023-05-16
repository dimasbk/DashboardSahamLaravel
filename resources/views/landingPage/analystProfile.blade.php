@extends('landingPage.template')

@section('content')
@vite(['resources/sass/newsArticle.scss', 'resources/css/analyst.css', 'resources/js/analyst.js'])

<head>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
        integrity="sha384-1dM6U4ne6U2xZUMgX9hgeS0S1vTTpG6luUP/oA4dSl6m4l6FQJnhC/3XeyQTrxrW" crossorigin="anonymous">

    <!-- JavaScript and dependencies -->
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
</body>

@endsection