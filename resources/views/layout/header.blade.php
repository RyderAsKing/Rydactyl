@section('header')

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href={{ asset('vendors/mdi/css/materialdesignicons.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/css/vendor.bundle.base.css') }}>
    <!-- endinject -->
    <link rel="stylesheet" href={{ asset('vendors/flag-icon-css/css/flag-icon.min.css') }}>
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- Layout styles -->
    <link rel="stylesheet" href={{ asset('css/style.css') }}>
    <!-- End layout styles -->
    <link rel="shortcut icon" href={{ asset('images/favicon.png') }} />
</head>
@endsection