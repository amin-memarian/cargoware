<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Handle session messages -->
    @if(session('success'))
        <meta id="session-success" name="success" content="{{ session('success') }}">
    @endif
    @if(session('failed'))
        <meta id="session-failed" name="failed" content="{{ session('failed') }}">
    @endif

    <link rel="icon" href="{{ asset('panel/assets/images/fav.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('panel/assets/images/fav.png') }}" type="image/x-icon">

    @yield('title')
    <title></title>

    <!-- 1. Icon Fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/themify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/feather-icon.css') }}">

    <!-- 2. Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/datatables.css') }}">

    <!-- 3. Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/bootstrap.css') }}">

    <!-- 4. App Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/general-search.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('panel/assets/css/color-1.css') }}" media="screen">

    <!-- 5. Responsive Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/responsive.css') }}">

    <!-- 6. Custom Plugins / Libraries -->
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/iziToast/iziToast.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/general-styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/show-orders.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/approve-order.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/uploader/custom-uploader.css') }}">

    @yield('styles')

</head>

<body>

<!-- tap on top starts-->
<div class="tap-top">
    <i data-feather="chevrons-up"></i>
</div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    @include('partials.admin.header')

    <!-- Page Body Start-->
    <div class="page-body-wrapper horizontal-menu">
        @include('partials.admin.sidebar')
        <div class="page-body">
            <div class="container-fluid">
                <div class="page-title">
                    @yield('breadcrumb')

                    @include('partials.admin.general-search')
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row starter-main">
                    @yield('body-content')
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        @include('partials.admin.footer')
    </div>
    @include('partials.admin.general-components-config')
</div>

<!-- latest jquery-->
<script src="{{ asset('panel/assets/js/jquery-3.5.1.min.js') }}"></script>

<!-- Include Modals -->
@include('components.modals.quick-estimate')
@include('components.modals.register-user')
@include('components.modals.submit-order')

<!-- Bootstrap js-->
<script src="{{ asset('panel/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('panel/assets/js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/select2/select2-custom.js') }}"></script>

<!-- feather icon js-->
<script src="{{ asset('panel/assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/icons/feather-icon/feather-icon.js') }}"></script>

<!-- scrollbar js-->
<script src="{{ asset('panel/assets/js/scrollbar/simplebar.js') }}"></script>
<script src="{{ asset('panel/assets/js/scrollbar/custom.js') }}"></script>

<!-- Sidebar jquery-->
<script src="{{ asset('panel/assets/js/config.js') }}"></script>

<!-- Plugins JS start-->
<script src="{{ asset('panel/assets/js/prism/prism.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/custom-card/custom-card.js') }}"></script>

<script src="{{ asset('panel/assets/js/tooltip-init.js') }}"></script>
<script src="{{ asset('panel/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('panel/assets/js/height-equal.js') }}"></script>
<script src="{{ asset('panel/assets/js/tooltip-init.js') }}"></script>
<script src="{{ asset('panel/assets/js/datatable/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/datatable/datatables/buttons.bootstrap5.min.js') }}"></script>

<!-- Theme js-->
<script src="{{ asset('panel/assets/js/script.js') }}"></script>

<!-- Optional Scripts -->
<script src="{{ asset('panel/assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('panel/assets/js/iziToast/iziToast.min.js') }}"></script>

<!-- Add any custom scripts -->
@yield('script')

<script src="{{ asset('panel/assets/js/helpers.js') }}"></script>

<!-- General Scripts -->
<script src="{{ asset('panel/assets/js/general-scripts.js') }}"></script>
<script src="{{ asset('panel/assets/js/jquery.validate.min.js') }}"></script>


@include('partials.admin.general-script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const files = [
            { src: "{{ asset('panel/assets/js/components/quick-estimate.js') }}", type: "text/javascript" },
            { src: "{{ asset('panel/assets/js/components/submit-load.js') }}", type: "text/javascript" },
            { src: "{{ asset('panel/assets/js/components/register-user.js') }}", type: "text/javascript" }
        ];

        files.forEach(function(file) {
            const script = document.createElement('script');
            script.src = file.src;
            script.type = file.type;
            document.body.appendChild(script);
        });
    });
</script>


</body>

</html>
