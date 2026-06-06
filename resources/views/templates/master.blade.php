<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            @include('templates.sidebar')

            <div class="col-md-9 col-lg-10 main-content d-flex flex-column vh-100">
                
                @include('templates.navbar')

                <div class="content-body flex-grow-1">
                    @yield('content')
                </div>

                @include('templates.footer')

            </div>
        </div>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>