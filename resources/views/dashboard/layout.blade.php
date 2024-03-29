<html>

<head>
    <title>@yield('title', 'Dashboard') - Exam</title>
    <style>
        :root {
            --bs-primary: #1A73E8 !important;
            --bs-pagination-active-bg: #1A73E8 !important;
            --bs-pagination-active-bg: #1A73E8 !important;
            --bs-pagination-active-border-color: #1A73E8 !important;
        }

 .dt-button.buttons-pdf.buttons-html5  {
    border-radius: 0.5em;;
    background-color: var(--bs-btn-bg);
    transition: all 0.15s ease-in;
    margin-bottom: 1.5rem !important;
    letter-spacing: 0;
    text-transform: uppercase;
    background-size: 150%;
    background-position-x: 25%;
    background-image: linear-gradient(195deg, #49a3f1 0%, #1A73E8 100%);
    cursor: pointer;
    border: 0;
    box-shadow: 0 3px 3px 0 rgba(26, 115, 232, 0.15), 0 3px 1px -2px rgba(26, 115, 232, 0.2), 0 1px 5px 0 rgba(26, 115, 232, 0.15);
    color: #fff;
    width: 165px;
    display: block;
 }
    </style>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('/img/favicon/favicon.png') }}"
        type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon"
        href="{{ asset('/img/favicon/favicon.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"
        href="{{ asset('/img/favicon/favicon.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
        href="{{ asset('/img/favicon/favicon.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
        href="{{ asset('/img/favicon/favicon.png') }}">
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="{{ asset('dashboard/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.css" />
    <link id="pagestyle"
        href="{{ asset('dashboard/assets/css/material-dashboard.css?v=3.1.0') }}"
        rel="stylesheet" />
    <style>
        select[name=admin_table_length],
        select[name=job_table_length] {
            border: 1px solid #cccc;
        }

        div.dataTables_wrapper div.dataTables_filter input {
            border-bottom: 1px solid #ccc;
        }

        .paginate_button.page-item.active>a {
            color: #fff;
        }



        .input-group.input-group-outline.is-focused .form-label+.form-control,
        .input-group.input-group-outline.is-filled .form-label+.form-control {
            border-color: #1A73E8 !important;
            border-top-color: transparent !important;
            box-shadow: inset 1px 0 #1A73E8, inset -1px 0 #1A73E8, inset 0 -1px #1A73E8, inset -1px 0 #1A73E8;
        }

        .input-group.input-group-outline.is-focused .form-label,
        .input-group.input-group-outline.is-filled .form-label {
            color: #1A73E8;
        }
        
        .input-group.input-group-outline.is-focused .form-label:before,
        .input-group.input-group-outline.is-focused .form-label:after,
        .input-group.input-group-outline.is-filled .form-label:before,
        .input-group.input-group-outline.is-filled .form-label:after {
            border-top-color: #1A73E8;
            box-shadow: inset 0 1px #1A73E8;
        }

        .shadow-primary {
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgb(26 115 232 / 60%) !important;
        }

        .form-check:not(.form-switch) .form-check-input[type="checkbox"]:checked {
            background: #1A73E8;
        }

        .form-check:not(.form-switch) .form-check-input[type="checkbox"]:checked,
        .form-check:not(.form-switch) .form-check-input[type="radio"]:checked {
            border-color: #1A73E8;
        }

        .input-group.input-group-dynamic .form-control,
        .input-group.input-group-dynamic .form-control:focus,
        .input-group.input-group-static .form-control,
        .input-group.input-group-static .form-control:focus {
            background-image: linear-gradient(0deg, #1A73E8 2px, rgba(156, 39, 176, 0) 0), linear-gradient(0deg, #d2d2d2 1px, rgba(209, 209, 209, 0) 0);
        }

        .input-group.input-group-dynamic.is-focused label,
        .input-group.input-group-static.is-focused label {
            color: #1A73E8;
        }

        .page-link.active,
        .active>.page-link {
            background-color: #1A73E8;
            border-color: #1A73E8;
        }

    </style>

</head>

<body class="g-sidenav-show  bg-gray-200">
    @include('dashboard.components.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('dashboard.components.navbar')
        @yield('content')
        @include('dashboard.components.footer')
    </main>
    <script src="{{ asset('/js/jquery-3.6.1.min.js') }}"></script>
    <!--   Core JS Files   -->
    <script src="{{ asset('dashboard/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/plugins/perfect-scrollbar.min.js') }}">
    </script>
    <script src="{{ asset('dashboard/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

    </script>
    <script src="{{ asset('dashboard/assets/js/material-dashboard.min.js?v=3.1.0') }}">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
    </script>
    @yield('js')
</body>

</html>
