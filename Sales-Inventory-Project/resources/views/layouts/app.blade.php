<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventory Management</title>
    <link rel="stylesheet" type="image/x-icon" href="{{ asset('/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastify.min.css') }}">
    <script src="{{ asset('js/toastify-js.js') }}"></script>
    {{-- <script src="{{ asset('js/axios.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.3/axios.min.js"></script>
    <script src="{{ asset('js/config.js') }}"></script>

</head>

<body>
    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div>
        @yield('content')
    </div>

    <script></script>

    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>

</body>

</html>
