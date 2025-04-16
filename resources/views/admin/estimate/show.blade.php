@extends('layouts.admin.master')

@section('title')
    <title>پنل مدیریت | تخمین مشتری</title>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/js/persiandatepicker/persian-datepicker-0.4.5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/vendors/timepicker.css') }}">
    <style>
        .clockpicker-popover {
            z-index: 1051 !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <div class="row">
        <div class="col-12 col-sm-6">
            <h3><a href="{{ route('orders.index') }}"><i class="icon-arrow-right me-2"></i></a>تخمین مشتری : {{ $estimate?->user?->lastname ?: '-' }}</h3>
        </div>
    </div>
@endsection

@section('body-content')


            <div class="row">

                <div class="col-12 col-md-6 col-lg-6">

                    <div class="modal fade" id="data{{1 }}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenter" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center">فرآیند ارسال تیم جمع آوری</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div id="{{1 }}load_detail_modal" class="modal-body">
                                    <form id="{{ 1 }}form" action="{{ route('load_detail.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="from" value="estimate_show">
                                        <input type="hidden" name="user_id" value="{{ $estimate?->user_id ?: 0}}">
                                        <input type="hidden" name="estimate_id" value="{{ $estimate->id }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="nav nav-tabs nav-primary" id="pills-warningtab" role="tablist" style="list-style: none;">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="{{1 }}step1" data-bs-toggle="pill"
                                                           href="#{{1 }}step1_content" role="tab" aria-controls="{{1 }}step1_content" aria-selected="true">مرحله 1</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link disabled" id="{{1 }}step2" data-bs-toggle="pill"
                                                           href="#{{1 }}step2_content" role="tab" aria-controls="{{1 }}step2_content"
                                                           aria-selected="false">مرحله 2</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link disabled" id="{{1 }}step3" data-bs-toggle="pill"
                                                           href="#{{1 }}step3_content" role="tab" aria-controls="{{1 }}step3_content"
                                                           aria-selected="false">مرحله 3</a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content" id="tabs">

                                                    <div class="tab-pane fade show active" id="{{1 }}step1_content" role="tabpanel"
                                                         aria-labelledby="pills-warninghome-tab">


                                                        <div class="col-12 mb-4 mt-4">
                                                            <h6><b>نوع کالا چیه؟</b></h6>

                                                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                                <div class="form-check form-check-inline radio radio-primary">
                                                                    <input class="form-check-input" id="{{ 1 }}normal_radio" type="radio" name="load_type" value="normal" checked>
                                                                    <label class="form-check-label mb-0" for="{{ 1 }}normal_radio"><span class="digits">نرمال</span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline radio radio-primary">
                                                                    <input class="form-check-input" id="{{ 1 }}special_radio" type="radio" name="load_type" value="special">
                                                                    <label class="form-check-label mb-0" for="{{ 1 }}special_radio"><span class="digits">خاص</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <textarea class="form-control mb-3" name="special_load_description" id="{{ 1 }}special_load_description" placeholder="توضیحات کالا خاص" rows="7" style="display: none;"></textarea>
                                                        </div>

                                                        <div class="col-12 mb-4">
                                                            <h6><b>آیا کالا حجیم؟</b></h6>

                                                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                                <div class="form-check form-check-inline radio radio-primary">
                                                                    <input class="form-check-input" id="{{ 1 }}bulky_yes" type="radio" name="bulky_load" value="1" checked>
                                                                    <label class="form-check-label mb-0" for="{{ 1 }}bulky_yes"><span class="digits">بله</span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline radio radio-primary">
                                                                    <input class="form-check-input" id="{{ 1 }}bulky_no" type="radio" name="bulky_load" value="0">
                                                                    <label class="form-check-label mb-0" for="{{ 1 }}bulky_no"><span class="digits">خیر</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mb-4">
                                                            <h6><b>آیا کالا فوری؟</b></h6>

                                                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                                <div class="form-check form-check-inline radio radio-primary">
                                                                    <input class="form-check-input" id="{{ 1 }}urgent_yes" type="radio" name="urgent" value="1" checked>
                                                                    <label class="form-check-label mb-0" for="{{ 1 }}urgent_yes"><span class="digits">بله</span>
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline radio radio-primary">
                                                                    <input class="form-check-input" id="{{ 1 }}urgent_no" type="radio" name="urgent" value="0">
                                                                    <label class="form-check-label mb-0" for="{{ 1 }}urgent_no"><span class="digits">خیر</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <button id="{{1 }}next_step1" class="btn btn-primary fw-bold text-white rounded-pill" type="button">مرحله بعد</button>
                                                        </div>

                                                    </div>


                                                    <div class="tab-pane fade" id="{{1 }}step2_content" role="tabpanel"
                                                         aria-labelledby="pills-warningprofile-tab">

                                                        <div class="row">


                                                            <div class="col-12 mb-3">
                                                                <h6 class="mb-4"><b>تاریخ دریافت کالا توسط مامور :</b></h6>
                                                                <input id="{{ 1 }}collection_date" class="form-control digits" type="text"  readonly>
                                                                <input id="{{ 1 }}collection_date_value" name="collection_date" class="form-control digits" type="hidden">
                                                            </div>

                                                            <div class="col-12 mb-3">
                                                                <h6><b>بازه زمانی دریافت :</b></h6>
                                                                <form class="theme-form">
                                                                    <div>
                                                                        <label class="form-label">آغاز</label>
                                                                        <div id="{{ 1 }}clockpicker1" class="input-group clockpicker pull-center" data-placement="right" data-align="top"
                                                                             data-autoclose="true">
                                                                            <input name="start_collection_time" class="form-control" type="text" value="9:00" readonly><span class="input-group-addon"><span
                                                                                    class="glyphicon glyphicon-time"></span></span>
                                                                        </div>

                                                                        <label class="form-label">اتمام</label>
                                                                        <div id="{{ 1 }}clockpicker2" class="input-group clockpicker pull-center" data-placement="left" data-align="top"
                                                                             data-autoclose="true">
                                                                            <input name="end_collection_time" class="form-control" type="text" value="19:00" readonly><span class="input-group-addon"><span
                                                                                    class="glyphicon glyphicon-time"></span></span>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <div class="col-12 mb-3">
                                                                <h6 class="mb-4"><b>تاریخ ارسال :</b></h6>
                                                                <input id="{{ 1 }}delivery_date" class="form-control digits" type="text"  readonly>
                                                                <input id="{{ 1 }}delivery_date_value" name="delivery_date" class="form-control digits" type="hidden">
                                                            </div>


                                                        </div>

                                                        <div class="col-12">
                                                            <button id="{{1 }}prev_step2" class="btn btn-warning fw-bold text-white rounded-pill" type="button">مرحله قبل</button>
                                                            <button id="{{1 }}next_step2" class="btn btn-primary fw-bold text-white rounded-pill" type="button">مرحله بعد</button>
                                                        </div>

                                                    </div>

                                                    <div class="tab-pane fade" id="{{1 }}step3_content" role="tabpanel"
                                                         aria-labelledby="pills-warningcontact-tab">


                                                        <div class="col-12 mb-3">
                                                            <label class="form-label" for="">شماره تماس منزل</label>
                                                            <input class="form-control" maxlength="11" name="phone_number" type="text" placeholder="..."/>
                                                        </div>

                                                        <div class="col-12 mb-3">
                                                            <label class="form-label" for="">کد پستی</label>
                                                            <input class="form-control"  maxlength="10" name="postal_code" type="text" placeholder="..."/>
                                                        </div>

                                                        <div class="col-12 mb-3">
                                                            <label class="form-label" for="">آدرس منزل</label>
                                                            <textarea class="form-control" name="address" placeholder="..." rows="7"></textarea>
                                                        </div>

                                                        <div class="col-12">
                                                            <button id="{{1 }}prev_step3" class="btn btn-warning fw-bold text-white rounded-pill" type="button">مرحله قبل</button>
                                                            <button id="{{1 }}store_load_details" class="btn btn-primary fw-bold text-white rounded-pill" type="submit">ثبت اطلاعات</button>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm rounded">
                        <div class="card-body">

                            <!-- Card Header -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title"><b>اطلاعات تخمین</b></h5>
                                <i data-feather="box" class="text-info" width="48" height="48"></i>
                            </div>

                            <!-- Information List -->
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>نام :</strong> {{ $estimate?->user?->name ?? '-' }}</li>
                                <li class="list-group-item"><strong>نام خانوادگی :</strong> {{ $estimate?->user?->lastname ?? '-' }}</li>
                                <li class="list-group-item"><strong>شماره موبایل :</strong> {{ $estimate?->user?->mobile ?? '-' }}</li>
                                <li class="list-group-item"><strong>ایرلاین :</strong> {{ $estimate->airline->name }} </li>
                                <li class="list-group-item"><strong>مبدا :</strong> {{ $estimate?->loads?->store }} </li>
                                <li class="list-group-item"><strong>مقصد :</strong> {{ $estimate?->loads?->address }} </li>
                                <li class="list-group-item"><strong>وزن :</strong> {{ $estimate?->loads?->weight }} </li>
                                <li class="list-group-item"><strong>طول :</strong> {{ $estimate?->loads?->size_height }} </li>
                                <li class="list-group-item"><strong>عرض :</strong> {{ $estimate?->loads?->size_width }} </li>
                                <li class="list-group-item"><strong>ارتفا :</strong> {{ $estimate?->loads?->size_length }} </li>
                                <li class="list-group-item"><strong>وزن حجمی :</strong> {{ $estimate?->loads?->volume_weight }} </li>
                                <li class="list-group-item"><strong>تخمین :</strong>{{ convertNumbersToPersian(number_format($estimate->estimate)) }}</li>
                                <li class="list-group-item"><strong>تاریخ :</strong> {{ $estimate->created_at ? gregorian_date_to_shamsi_date($estimate->created_at, true) : '-' }}</li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>



@if($estimate->status == 0)

    <a href="#" data-bs-toggle="modal" data-bs-target="#data{{1 }}">
        <button class="btn btn-warning mt-3 rounded-pill shadow-sm hover-shadow" type="button">
            <i class="bi bi-check-circle"></i> تایید سفارش
        </button>
    </a>


@endif




@endsection

@section('script')

    <script src="{{ asset('panel/assets/js/persiandatepicker/persian-date-0.1.8.min.js') }}"></script>
    <script src="{{ asset('panel/assets/js/persiandatepicker/persian-datepicker-0.4.5.min.js') }}"></script>
    <script src="{{ asset('panel/assets/js/time-picker/highlight.min.js') }}"></script>
    <script src="{{ asset('panel/assets/js/time-picker/jquery-clockpicker.min.js') }}"></script>
    <script src="{{ asset('panel/assets/js/axios.min.js') }}"></script>

    <script>
        $(document).ready(function () {


            function setupFormSubmission(ID, submitButtonId, route) {
                const submitButton = '#' + submitButtonId;
                $(submitButton).on('click', function (e) {
                    e.preventDefault();
                    let count = ID;
                    ID = ID + 'load_detail_modal';
                    let formData = {
                        user_id: $(`#${ID} input[name="user_id"]`).val(),
                        estimate_id: $(`#${ID} input[name="estimate_id"]`).val(),
                        load_type: $(`#${ID} input[name="load_type"]:checked`).val(),
                        special_load_description: $(`#${ID} #${count}special_load_description`).val(),
                        bulky_load: $(`#${ID} input[name="bulky_load"]:checked`).val(),
                        urgent: $(`#${ID} input[name="urgent"]:checked`).val(),
                        collection_date: $(`#${ID} #${count}collection_date_value`).val(),
                        delivery_date: $(`#${ID} #${count}delivery_date_value`).val(),
                        start_collection_time: $(`#${ID} input[name="start_collection_time"]`).val(),
                        end_collection_time: $(`#${ID} input[name="end_collection_time"]`).val(),
                        phone_number: $(`#${ID} input[name="phone_number"]`).val(),
                        postal_code: $(`#${ID} input[name="postal_code"]`).val(),
                        address: $(`#${ID} textarea[name="address"]`).val(),
                    };


                    // Submit data with Axios
                    axios.post(route, formData)
                        .then(function (response) {
                            if (response.data.status === 200) {
                                $('.btn-close').click();
                                showAlert('success', response.data.message, 'ثبت موفق');
                            } else {
                                $('.btn-close').click();
                                showAlert('failed', 'خطایی هنگام ثبت اطلاعات رخ داد، لطفاً دوباره تلاش کنید', 'ثبت ناموفق');
                            }
                        })
                        .catch(function () {
                            $('.btn-close').click();
                            showAlert('failed', 'خطایی هنگام ثبت اطلاعات رخ داد، لطفاً دوباره تلاش کنید', 'ثبت ناموفق');
                        });
                });
            }

            function initClockPicker(ID) {

                const name = '#' + ID;
                const container = '#' + ID + 'load_detail_modal';

                $(name).clockpicker({
                    container: container
                })
                $(name).clockpicker()
                    .find('input').change(function(){
                    console.log(this.value);

                });
                $('#single-input').clockpicker({
                    placement: 'bottom',
                    align: 'right',
                    autoclose: true,
                    'default': '20:48'
                });

            }

            function initDatePicker(ID, altFieldId) {

                $("#" + ID).persianDatepicker({
                    altField: "#" + altFieldId,
                    altFormat: "X",
                    format: "D MMMM YYYY",
                    timePicker: {
                        enabled: true
                    },
                    observer: true
                });

            }

            function initDetectLoadType (ID) {
                // Show/Hide Special Load Description
                const parent = '#' + ID + 'load_detail_modal';
                $(parent + ' input[name="load_type"]').on('change', function () {
                    if ($(this).val() === 'special') {
                        $('#' + ID + 'special_load_description').show();
                    } else {
                        $('#' + ID + 'special_load_description').hide();
                    }
                });
            }

            // Step navigation function
            function navigateStep(currentStep, nextStep) {
                $(`#${currentStep}`).removeClass('active').addClass('disabled');
                $(`#${nextStep}`).removeClass('disabled').addClass('active');
                $(`#${currentStep}_content`).removeClass('show active');
                $(`#${nextStep}_content`).addClass('show active');
            }

            function setupStep1(ID) {
                const next_step1 = '#' + ID + 'next_step1';
                $(next_step1).on('click', function () {
                    if (validateStep1(ID)) {
                        navigateStep(ID + 'step1', ID + 'step2');
                    }
                });
            }

            function setupStep2(ID) {
                const next_step2 = '#' + ID + 'next_step2';
                $(next_step2).on('click', function () {
                    if (validateStep2(ID)) {
                        navigateStep(ID + 'step2', ID + 'step3');
                    }
                });
            }

            function setupPrevStep2(ID) {
                const prev_step2 = '#' + ID + 'prev_step2';
                $(prev_step2).on('click', function () {
                    navigateStep(ID + 'step2', ID + 'step1');
                });
            }

            function setupPrevStep3(ID) {
                const prev_step3 = '#' + ID + 'prev_step3';
                $(prev_step3).on('click', function () {
                    navigateStep(ID + 'step3', ID + 'step2');
                });
            }

            // Step 1 Validation function
            function validateStep1(ID) {

                const loadType = $('#' + ID + 'load_detail_modal' + ' input[name="load_type"]:checked').val();
                const specialLoadDescription = $('#' + ID + 'special_load_description').val();

                if (loadType === 'special' && !specialLoadDescription) {
                    alert('توضیحات کالا خاص را وارد کنید');
                    return false; // Validation failed
                }

                return true; // Validation passed
            }

            // Step 2 Validation function
            function validateStep2(ID) {
                const collectionDate = $('#' + ID + 'collection_date_value').val();
                const startCollectionTime = $('#' + ID + 'load_detail_modal' + ' input[name="start_collection_time"]').val();
                const endCollectionTime = $('#' + ID + 'load_detail_modal' + ' input[name="end_collection_time"]').val();

                if (!collectionDate) {
                    alert('تاریخ دریافت کالا را وارد کنید');
                    return false;
                }

                if (!startCollectionTime) {
                    alert('آغاز بازه زمانی دریافت را وارد کنید');
                    return false;
                }

                if (!endCollectionTime) {
                    alert('اتمام بازه زمانی دریافت را وارد کنید');
                    return false;
                }

                return true;
            }

            let ID = 1;
            const collectionDate = ID + 'collection_date';
            const collectionDateValue = ID + 'collection_date_value';

            const deliveryDate = ID + 'delivery_date';
            const deliveryDateValue = ID + 'delivery_date_value';

            const startCollectionTime = ID + 'clockpicker1';
            const endCollectionTime = ID + 'clockpicker2';

            initDatePicker(collectionDate, collectionDateValue)
            initDatePicker(deliveryDate, deliveryDateValue)

            initClockPicker(startCollectionTime);
            initClockPicker(endCollectionTime);

            setupStep1(ID);
            setupStep2(ID);
            setupPrevStep2(ID);
            setupPrevStep3(ID);

            initDetectLoadType(ID);

            setupFormSubmission(ID, submitButtonId, route);

        })
    </script>

@endsection

