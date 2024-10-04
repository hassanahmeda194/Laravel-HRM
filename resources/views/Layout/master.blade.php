<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dashboard | HRM - Human Resources Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .toast-success {
            background-color: rgb(10, 192, 116) !important;
        }

        .dt-button {
            border: none;
            background-color: #485EC4;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .dt-paging-button {
            border: none;
            background-color: #485EC4;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 0 5px;
        }
    </style>
</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">
        @include('partials.app_header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('main_section')
                </div>
            </div>
        </div>
    </div>
    <div class="right-bar">
        <div data-simplebar class="h-100" style="background: white !important;">
            <div class="">
                <div class="py-2 d-flex justify-content-between align-items-center px-3" style="border-bottom: 2px solid lightgray ">
                    <div>
                        <h5 class="mt-3 ">Notifications</h5>
                    </div>
                    <button class="btn btn-light" id="close-btn">X</button>
                </div>
                <div id="notification-box"></div>
            </div>
        </div>
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <div class="bg-light shadow-lg"></div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>

        <script>
            $('#datatable').DataTable({
                "pageLength": 25,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'dt-button',
                        text: 'Copy'
                    },
                    {
                        extend: 'csv',
                        className: 'dt-button',
                        text: 'Export CSV'
                    },
                    {
                        extend: 'excel',
                        className: 'dt-button',
                        text: 'Export Excel'
                    },
                    {
                        extend: 'pdf',
                        className: 'dt-button',
                        text: 'Export PDF'
                    },
                    {
                        extend: 'print',
                        className: 'dt-button',
                        text: 'Print'
                    }
                ]
            });
        </script>

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
        <script>
            $(document).ready(function() {
                function fetchNotifications() {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get.notification') }}",
                        success: function(response) {
                            $('#notification-box').html(response);
                        }
                    });
                }
                $('#close-btn').click(function(e) {
                    e.preventDefault();
                    $('.right-bar').hide();
                });
                $('#right-bar-toggle').click(function(e) {
                    e.preventDefault();
                    $('.right-bar').show();
                });
                $(document).on('click', '.read-notification', function(e) {
                    e.preventDefault();
                    var notificationID = $(this).data('id');
                    $.ajax({
                        type: "GET",
                        url: "{{ route('read.notification') }}",
                        data: {
                            id: notificationID
                        },
                        success: function(response) {
                            if (response) {
                                toastr.success('Notification read successfully');
                                fetchNotifications();
                            } else {
                                toastr.error('Failed to read notification');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
                fetchNotifications();
            });
        </script>
    </div>
</body>

</html>