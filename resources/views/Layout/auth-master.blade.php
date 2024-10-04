<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | HRM - Human Resources Managment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="HRM - Human Resources Managment" name="description" />
    <meta content="Build By Hassan Ahmed" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .toast-success {
            background-color: rgb(10, 192, 116) !important;
        }
    </style>
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            @yield('main_section')
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    @session('success')
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endsession
    @session('error')
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endsession
    <script>
        $('form').each(function() {
            $(this).on('submit', function() {
                var button = $(this).find('button[type="submit"]');
                button.prop('disabled', true).html(`
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        &nbsp;&nbsp;...
                    `);
                return true;
            });
        });
    </script>
</body>

</html>
