<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}" type="text/css">
    <title>{{ __('category_print') }}</title>
    <style>
        /* Table header background color */
        .table-bg-color {
            background: #29aae1;
            color: #fff;
        }

        /* Main content styling */
        .main-content {
            max-width: 860px;
        }

        /* Centered text */
        .centered {
            text-align: center;
            align-content: center;
        }

        /* Print-specific styles */
        @media print {
            /* Hide elements with the class 'hidden-print' during print */
            .hidden-print {
                display: none !important;
            }

            /* Page margins for print */
            @page {
                margin: 1.5cm 0.5cm 0.5cm;
            }

            /* Margin for the first page in print */
            @page:first {
                margin-top: 0.5cm;
            }

            /* Page break handling */
            tbody::after {
                content: '';
                display: block;
                page-break-after: avoid;
                page-break-inside: avoid;
                page-break-before: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="main-content m-auto">
        <!-- Header Section -->
        <div class="centered mt-5">
            <img src="{{ getSettings('logo_path') ? asset(getSettings('logo_path')) : asset('public/logo/small-logo.png') }}" 
                height="42" style="margin-top: -10px; margin-bottom: 0px; filter: brightness(100%);">
            <p style="margin-top: 0; font-size: 10px; line-height: 20px;">
                {{ getSettings('address') ?? '' }}<br>
                <i class="fas fa-phone-alt" style="font-size:10px"></i> {{ getSettings('phone') ?? '' }}<br>
                <i class="fas fa-globe" style="font-size:10px"></i> {{ getSettings('email') }}
            </p>
            <h4>{{ __('category_report') }}</h4>
        </div>

        <!-- Print and Back Buttons -->
        <div class="hidden-print mt-3 mb-2 text-center">
            <a href="{{ route('category.index') }}" class="btn btn-danger">{{ __('back') }}</a>
            <button type="button" class="btn common-btn" onclick="window.print();">{{ __('print') }}</button>
        </div>

        <!-- Table for displaying categories -->
        <table class="table table-bordered text-center">
            <thead class="table-bg-color">
                <tr>
                    <th>{{ __('sl') }}</th>
                    <th>{{ __('image') }}</th>
                    <th>{{ __('name') }}</th>
                    <th>{{ __('parent') }}</th>
                    <th>{{ __('number_of_product') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ $category->media->file ?? asset('public/default/default.jpg') }}" height="30" width="30"></td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->category->name ?? 'N/A' }}</td>
                        <td>{{ $category->product->count() ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Auto-print script -->
    <script type="text/javascript">
        function auto_print() {
            window.print();
        }
        setTimeout(auto_print, 1000);
    </script>
</body>

</html>
