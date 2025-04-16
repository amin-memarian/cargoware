<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('panel/assets/images/logo/favicon-icon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('panel/assets/images/logo/favicon-icon.png') }}" type="image/x-icon">
    <title>ورود به پنل مدیریت</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/themify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('panel/assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/responsive.css') }}">
</head>
<body>

<div class="loader-wrapper">
    <div class="loader">
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-ball"></div>
    </div>
</div>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7" style="background-color:#EFEFFD; background-size:contain !important; background-repeat: no-repeat;">
                <img class="bg-img-cover bg-center" src="{{ asset('panel/assets/images/login/login-bg-2.webp') }}" alt="looginpage">
            </div>
            <div class="col-xl-5 p-0">
                <div class="login-card">

                    <form id="loginForm" method="post" action="{{ route('auth.otp') }}" class="theme-form login-form">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @csrf
                        <h4>ورود</h4>
                        <h6>جهت ورود لطفا شماره موبایل خود را وارد کنید</h6>
                        <div class="form-group">
                            <label>شماره موبایل</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-mobile"></i></span>
                                <input id="mobile" class="form-control" type="text" name="mobile" maxlength="11" placeholder="..." value="{{ old('mobile') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <button id="loginSubmitButton" class="btn btn-primary btn-block" type="button">ارسال کد تایید</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('panel/assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/helpers.js') }}"></script>
<script src="{{ asset('panel/assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('panel/assets/js//additional-methods.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
<script src="{{ asset('panel/assets/js/config.js') }}"></script>
<script src="{{ asset('panel/assets/js/script.js') }}"></script>


<script>
    $(document).ready(function () {

        setupValidation('#loginForm', {
            mobile: {
                required: true,
                digits: true,
                minlength: 11,
                maxlength: 11,
                pattern: /^09\d{9}$/
            }
        },{
            mobile: {
                required: "لطفا شماره موبایل را وارد کنید",
                minlength: "شماره موبایل باید ۱۱ رقم باشد",
                maxlength: "شماره موبایل باید ۱۱ رقم باشد",
                digits: "شماره موبایل فقط باید شامل ارقام باشد",
                pattern: "شماره موبایل باید با 09 شروع شود و فقط شامل ارقام باشد"
            }
        }, '#loginSubmitButton', null, false);


        $('#mobile').on('change', function () {
            $(this).valid();
        });

    })
</script>

</body>
</html>
