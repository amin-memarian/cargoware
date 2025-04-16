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
                <img class="bg-img-cover bg-center" src="{{ asset('panel/assets/images/login/login-bg.webp') }}" alt="looginpage">
            </div>
            <div class="col-xl-5 p-0">
                <div class="login-card">
                    <form id="otpForm" method="post" action="{{ route('auth.checkotp') }}" class="theme-form login-form">
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
                        <input type="hidden" name="mobile" value="{{ $mobile }}">
                        <h4>ورود کد</h4>
                        <h6>کد دریافت شده به موبایل خود را وارد کنید</h6>
                        <div class="form-group">
                            <label>کد پنج رقمی: </label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-mobile"></i></span>
                                <input id="otp" class="form-control" type="text" required="" name="otp" placeholder="..." maxlength="5">
                            </div>
                        </div>
                        <div class="form-group">
                            <button id="otpSubmitButton" class="btn btn-primary btn-block" type="button">بررسی کد و ورود</button>
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

        setupValidation('#otpForm', {
            otp: {
                required: true,
                digits: true,
                minlength: 5,
                maxlength: 5
            }
        },{
            otp: {
                required: "لطفا رمز یکبار مصرف را وارد کنید",
                minlength: "رمز یکبار مصرف باید 5 رقم باشد",
                maxlength: "رمز یکبار مصرف باید 5 رقم باشد",
                digits: "رمز یکبار مصرف فقط باید شامل ارقام باشد"
            }
        }, '#otpSubmitButton', null, false);


        $('#otp').on('input', function () {
            $(this).valid();

            if ($(this).val().length === 5) {
                $('#otpForm').submit();
                $('#otpSubmitButton').addClass('disabled');
            }

        });

    })
</script>

</body>
</html>
