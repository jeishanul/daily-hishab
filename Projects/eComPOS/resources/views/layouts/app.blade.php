<!DOCTYPE html>
<html lang="en" dir="{{ getSettings('direction') ?? 'lrt' }}">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png"
        href="{{ getSettings('favicon_path') ? asset(getSettings('favicon_path')) : asset('public/logo/small-logo.png') }}" />
    <!-- Page Title -->
    <title>
        {{ getSettings('site_title') ?? 'eCom POS' }} - @yield('title')
    </title>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('public/assets/webfonts/poppins-medium.ttf') }}">
    <!-- Stylesheets -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/font-awesome.min.css') }}">
    <!-- jPreview CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/jpreview.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/sweetalert2.min.css') }}">
    <!-- Summernote CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/summerynote/summernote-bs4.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/datatables.min.css') }}">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
    <!-- Dark Mode Styles -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/dark-mode.css') }}">
    <!-- Responsive Styles -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/responsive.css') }}">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/daterangepicker.css') }}">
    <!-- Additional Styles -->
    @stack('styles')
    <style>
        :root {
            --theme-color: {{ getSettings('primary_color') ?? '#29aae1' }};
            --theme-secondary-color: {{ getSettings('secondary_color') ?? '#eaf7fc' }};
            --bs-btn-bg: {{ getSettings('primary_color') ?? '#29aae1' }};
        }
    </style>
</head>

<body mode="{{ getSettings('dark_mode') == 1 ? 'dark' : 'light' }}">
    <!-- Alert Container Start -->
    <div class="alerts-container w-100 d-flex flex-column gap-1" style="z-index: 99; position: fixed; top: 0;">
        <!-- Seeder Alert -->
        @if ($seederRun)
            <div class="alert alert-danger alert-dismissible fade show mb-0 w-100 text-center rounded-0 text-black seeder-alert"
                role="alert" style="padding: 10px;">
                <strong>
                    <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-placement="bottom"
                        title="If you do not run this seeder, you will not be able to use the system."></i>
                    Seeder does not run.
                </strong>
                Please run
                <code class="text-danger">php artisan migrate:fresh --seed</code>
                or
                <a href="{{ route('seeder.run.index') }}" class="btn btn-sm common-btn">Click here</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    id="closeSeederAlert"></button>
            </div>
        @endif

        <!-- Storage Link Alert -->
        @if ($storageLink)
            <div class="alert alert-danger alert-dismissible fade show mb-0 w-100 text-center rounded-0 text-black storage-link-alert"
                role="alert" style="padding: 10px;">
                <strong>
                    <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-placement="bottom"
                        title="If you cannot install the storage link, images will not be found."></i>
                    Storage link does not exist or images are missing.
                </strong>
                Please run
                <code class="text-danger">php artisan storage:link</code>
                or
                <a href="{{ route('storage.install.index') }}" class="btn btn-sm common-btn">Click here</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    id="closeStorageLinkAlert"></button>
            </div>
        @endif
    </div>
    <!-- Alert Container End -->

    <div class="app-container {{ getSettings('dark_mode') == 1 ? 'app-theme-dark' : 'app-theme-light' }} body-tabs-shadow fixed-sidebar fixed-header"
        id="appContent">
        <!-- Header -->
        @include('layouts.partials.header')

        <div class="app-main">
            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <div class="app-main-outer">
                <div class="app-main-inner">
                    <!-- Main Content -->
                    @yield('content')
                </div>

                <!-- Footer -->
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('public/assets/scripts/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('public/assets/scripts/jquery-ui.min.js') }}"></script>

    <!-- Bootstrap Bundle -->
    <script src="{{ asset('public/assets/scripts/bootstrap.bundle.min.js') }}"></script>

    <!-- Main Scripts -->
    <script src="{{ asset('public/assets/scripts/main.js') }}"></script>
    <script src="{{ asset('public/assets/scripts/full-screen.js') }}"></script>

    <!-- Summernote -->
    <script src="{{ asset('public/assets/summerynote/summernote-bs4.min.js') }}"></script>

    <!-- Image Preview -->
    <script src="{{ asset('public/assets/image_preview_js/bootstrap-prettyfile.js') }}"></script>
    <script src="{{ asset('public/assets/image_preview_js/jpreview.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('public/assets/scripts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/assets/scripts/sweetalert_modify.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('public/assets/scripts/datatables.min.js') }}"></script>
    <script src="{{ asset('public/assets/scripts/datatable4.min.js') }}"></script>

    <!-- Date Range Picker -->
    <script src="{{ asset('public/assets/scripts/moment.min.js') }}"></script>
    <script src="{{ asset('public/assets/scripts/daterangepicker.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('public/assets/js/main.js') }}" type="text/javascript"></script>

    <!-- Additional Scripts -->
    @stack('scripts')

    <!-- Toast Notifications -->
    @if (session('success') || session('error') || session('errors'))
        @php
            $messages = [];
            if (session('success')) {
                $messages[] = [
                    'type' => 'success',
                    'message' => session('success'),
                ];
            }
            if (session('error')) {
                $messages[] = [
                    'type' => 'error',
                    'message' => session('error'),
                ];
            }
            if (session('errors')) {
                foreach (session('errors')->all() as $error) {
                    $messages[] = [
                        'type' => 'error',
                        'message' => $error,
                    ];
                }
            }
        @endphp
        <script>
            $(document).ready(function() {
                @foreach ($messages as $message)
                    Toast.fire({
                        icon: '{{ $message['type'] }}',
                        title: "{{ $message['message'] }}"
                    });
                @endforeach
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            // Database Backup Confirmation
            $('#databaseDownloadConfirm').on('click', function(e) {
                e.preventDefault();
                const url = "{{ route('database.backup') }}";
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to backup your database!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#00B894',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateSVGImages(menu) {
                var svgImages = menu.querySelectorAll('.menu-icon');
                svgImages.forEach(function(svgImage) {
                    var svgPath = svgImage.getAttribute('src');
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var svgContent = xhr.responseText;
                            svgContent = svgContent.replace(/stroke="#9395A2"/g,
                                'stroke="{{ getSettings('primary_color') ?? '#29aae1' }}"'
                            );
                            svgImage.src = 'data:image/svg+xml;charset=utf-8,' +
                                encodeURIComponent(svgContent);
                        }
                    };
                    xhr.open('GET', svgPath, true);
                    xhr.send();
                });
            }

            function resetSVGImages(menu) {
                var svgImages = menu.querySelectorAll('.menu-icon');
                svgImages.forEach(function(svgImage) {
                    var svgPath = svgImage.getAttribute('src');
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var svgContent = xhr.responseText;
                            svgContent = svgContent.replace(
                                /stroke="{{ getSettings('primary_color') ?? '#29aae1' }}"/g,
                                'stroke="#9395A2"'
                            );
                            svgImage.src = 'data:image/svg+xml;charset=utf-8,' +
                                encodeURIComponent(svgContent);
                        }
                    };
                    xhr.open('GET', svgPath, true);
                    xhr.send();
                });
            }

            // Initial SVG updates for active menus
            var activeMenus = document.querySelectorAll('.menu.active');
            activeMenus.forEach(updateSVGImages);

            // Event listeners for menu hover
            var menus = document.querySelectorAll('.menu');
            menus.forEach(function(menu) {
                menu.addEventListener('mouseover', function() {
                    updateSVGImages(menu);
                });

                menu.addEventListener('mouseout', function() {
                    resetSVGImages(menu);

                    // Also handle active and expanded menus on mouse out
                    var activeMenus = document.querySelectorAll('.menu.active');
                    activeMenus.forEach(updateSVGImages);

                    var expandedMenus = document.querySelectorAll('.menu[aria-expanded="true"]');
                    expandedMenus.forEach(updateSVGImages);
                });
            });
        });
    </script>

</body>

</html>
