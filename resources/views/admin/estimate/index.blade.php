@extends('layouts.admin.master')

@section('title')
    <title>پنل مدیریت | لیست تخمین ها</title>
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
            <h3>لیست تخمین ها</h3>
        </div>
    </div>
@endsection

@section('body-content')



    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display" id="basic-2">
                        <thead>
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">اطلاعات مشتری</th>
                            <th class="text-center">ایرلاین</th>
                            <th class="text-center">مبدا</th>
                            <th class="text-center">مقصد</th>
                            <th class="text-center">وزن</th>
                            <th class="text-center">طول</th>
                            <th class="text-center">عرض</th>
                            <th class="text-center">ارتفاع</th>
                            <th class="text-center">وزن حجمی</th>
                            <th class="text-center">قیمت تخمینی</th>
                            <th class="text-center custom-sort">تاریخ ثبت</th>
                            <th class="text-center">وضعیت</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            {{--     reject modal       --}}
            <div class="modal fade" id="reject-order-modal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenter" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center">آیا میخواهید سفارش را رد کنید؟</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="col-12 mb-3">
                                <label class="form-label" for="">دلیل رد کردن : <small>(لطفا دلیل رد کردن تخمین رو شرح دهید)</small></label>
                                <form id="reject-order-form" action="#" method="post">
                                <div>
                                    <label for="reason_select">انتخاب دلیل</label>
                                    <select class="form-control" name="reason_select" id="reason_select">
                                        <option value="custom">دلیل جدید</option>
                                        @foreach($messages as $message)
                                            <option value="{{ $message->message }}">{{ $message->title }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div style="margin-top: 10px;">
                                    <label for="rejection_reason">دلیل شکست</label>
                                    <textarea class="form-control" name="rejection_reason" id="rejection_reason" rows="3"></textarea>
                                </div>
                                </form>

                            </div>

                            <button id="reject-order-submit" class="btn btn-primary fw-bold text-white rounded-pill" type="button">ثبت درخواست</button>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>






@endsection

@section('script')

    <script src="{{ asset('panel/assets/js/persiandatepicker/persian-date-0.1.8.min.js') }}"></script>
    <script src="{{ asset('panel/assets/js/persiandatepicker/persian-datepicker-0.4.5.min.js') }}"></script>
    <script src="{{ asset('panel/assets/js/time-picker/highlight.min.js') }}"></script>
    <script src="{{ asset('panel/assets/js/time-picker/jquery-clockpicker.min.js') }}"></script>
    <script src="{{ asset('panel/assets/js/axios.min.js') }}"></script>


    <script>

        let approveOrderRoute  = "{{ route('load_detail.store') }}";

        $( document ).ready(function() {


            let table = $('#basic-2').DataTable();

            if ($.fn.dataTable.isDataTable('#basic-2')) {
                table.destroy();
            }

            $('#basic-2').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('estimates.data') }}",
                columns: [
                    { data: 'id', name: 'id', className: 'text-center' },
                    { data: 'user_info', name: 'user_info', className: 'text-center' },
                    { data: 'airline_name', name: 'airline_name', className: 'text-center' },
                    { data: 'origin', name: 'origin', className: 'text-center' },
                    { data: 'destination', name: 'destination', className: 'text-center' },
                    { data: 'weight', name: 'size_width', className: 'text-center' },
                    { data: 'size_width', name: 'size_width', className: 'text-center' },
                    { data: 'size_height', name: 'size_height', className: 'text-center' },
                    { data: 'size_length', name: 'size_length', className: 'text-center' },
                    { data: 'volume_weight', name: 'volume_weight', className: 'text-center' },
                    { data: 'formatted_estimate', name: 'formatted_estimate', className: 'text-center' },
                    { data: 'created_at', name: 'created_at', className: 'text-center' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' },
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: '<i class="icon-reload fa-2x"></i>',
                        action: function (e, dt, node, config) {
                            dt.ajax.reload(null, false);
                        }
                    }
                ],
                language: {
                    url: '{{ url('panel/assets/js/datatable/datatables/buttons.bootstrap5.min.js') }}'
                }
            });

            setupValidation('#reject-order-form', {
                rejection_reason: {
                    required: true,
                    minlength: 10,
                },
            },{
                rejection_reason: {
                    required: 'لطفا دلیل رد کردن را وارد نمایید',
                    minlength: 'توضیحات باید حداقل 10 حرف باشد',
                }
            }, '#reject-order-submit', null, true);

            setupValidation('#form', {
                    special_load_description: {
                        required: {
                            depends: function() {
                                return $('input[name="load_type"]:checked').val() === 'special';
                            }
                        },
                        minlength: 6
                    },
                    phone_number: {
                        required: true,
                        minlength: 11,
                        maxlength: 11,
                        digits: true
                    },
                    postal_code: {
                        required: true,
                        maxlength: 10,
                        minlength: 10,
                        digits: true
                    },
                    address: {
                        required: true,
                        minlength: 10
                    },
                    region: {
                        required: true,
                    },
                    floors_count: {
                        required: {
                            depends: function() {
                                return $('input[name="elevator"]:checked').val() === 'no';
                            }
                        }
                    }
                },
                {
                    special_load_description: {
                        required: "لطفا توضیحات بار خاص را وارد کنید",
                        minlength: "توضیحات باید حداقل 6 حرف باشد",
                    },
                    phone_number: {
                        required: "لطفا شماره تماس منزل را وارد کنید",
                        minlength: "شماره تماس باید ۱۱ رقم باشد",
                        maxlength: "شماره تماس باید ۱۱ رقم باشد",
                        digits: "شماره تماس فقط باید شامل ارقام باشد"
                    },
                    region: {
                        required: "لطفا جهت منطقه جغرافیایی را انتخاب کنید",
                    },
                    postal_code: {
                        required: "لطفا کد پستی را وارد کنید",
                        maxlength: "کد پستی باید ۱۰ رقم باشد",
                        minlength: "کد پستی باید ۱۰ رقم باشد",
                        digits: "کد پستی فقط باید شامل ارقام باشد"
                    },
                    address: {
                        required: "لطفا آدرس منزل را وارد کنید",
                        minlength: "آدرس باید حداقل ۱۰ کاراکتر باشد"
                    },
                    floors_count: {
                        required: "لطفا تعداد طبقات را وارد نمایید"
                    }

            }, '#store_load_details', null, true);

            $(document).on('click', '.reject-order-btn', function (e) {
                e.preventDefault();

                let url = $(this).data('url');

                const $selectElement = $('#reason_select');
                const $textarea = $('#rejection_reason');

                $selectElement.off('change').on('change', function () {
                    if ($(this).val() === 'custom') {
                        $textarea.val('').prop('readonly', false).focus();
                    } else {
                        $textarea.val($(this).val()).prop('readonly', true);
                        $textarea.valid();
                    }
                });

                $textarea.off('input').on('input', function () {
                    if ($textarea.val() !== $selectElement.val()) {
                        $selectElement.val('custom');
                    }
                });

                $('#reject-order-submit').off('click').on('click', function (submitEvent) {
                    submitEvent.preventDefault();

                    if ($('#reject-order-form').valid()) {
                        let rejectionReason = $textarea.val();

                        axios.delete(url, {
                            params: { rejection_reason: rejectionReason }
                        })
                            .then(function (response) {
                                if (response.data.status === 200) {
                                    $('.btn-close').click();
                                    showAlert('success', response.data.message, 'ثبت موفق');

                                    $('#basic-2').DataTable().ajax.reload(null, false);
                                } else {
                                    $('.btn-close').click();
                                    showAlert('failed', 'خطایی هنگام ثبت اطلاعات رخ داد، لطفاً دوباره تلاش کنید', 'ثبت ناموفق');
                                }
                            })
                            .catch(function () {
                                $('.btn-close').click();
                                showAlert('failed', 'خطایی هنگام ثبت اطلاعات رخ داد، لطفاً دوباره تلاش کنید', 'ثبت ناموفق');
                            });
                    }
                });

                $('#reject-order-modal').off('hidden.bs.modal').on('hidden.bs.modal', function () {
                    $selectElement.val('custom');
                    $textarea.val('').prop('readonly', false);
                });
            });



            $(document).on('click', '.approve-order-btn', function (e) {

                e.preventDefault();

                let userId = $(this).data('user_id');
                let estimateId = $(this).data('id');

                $('#user_id').val(userId || 0);
                $('#estimate_id').val(estimateId);


                // Show/Hide Special Load Description
                const parent = '#load_detail_modal';
                $(parent + ' input[name="load_type"]').on('change', function () {
                    if ($(this).val() === 'special') {
                        $('#special_load_description').show();
                    } else {
                        $('#special_load_description').hide();
                    }
                });


                const next_step1 = '#next_step1';
                $(next_step1).on('click', function () {
                    if ($('#form').valid()) {
                        navigateStep('step1', 'step2');
                    }
                });


                const next_step2 = '#next_step2';
                $(next_step2).on('click', function () {
                    navigateStep('step2', 'step3');
                });


                const prev_step2 = '#prev_step2';
                $(prev_step2).on('click', function () {
                    navigateStep('step2', 'step1');
                });



                const prev_step3 = '#prev_step3';
                $(prev_step3).on('click', function () {
                    navigateStep('step3', 'step2');
                });


                // Date picker 1
                $("#collection_date").persianDatepicker({
                    altField: "#collection_date_value",
                    altFormat: "X",
                    format: "D MMMM YYYY",
                    timePicker: {
                        enabled: true
                    },
                    observer: true
                });

                // Date picker 2
                $("#delivery_date").persianDatepicker({
                    altField: "#delivery_date_value",
                    altFormat: "X",
                    format: "D MMMM YYYY",
                    timePicker: {
                        enabled: true
                    },
                    observer: true
                });

                // Time picker 1
                $('#clockpicker1').clockpicker({
                    container: '#load_detail_modal'
                })
                $('#clockpicker1').clockpicker()
                    .find('input').change(function(){
                    console.log(this.value);

                });
                $('#single-input').clockpicker({
                    placement: 'bottom',
                    align: 'right',
                    autoclose: true,
                    'default': '20:48'
                });

                // Time picker 2
                $('#clockpicker2').clockpicker({
                    container: '#load_detail_modal'
                })
                $('#clockpicker2').clockpicker()
                    .find('input').change(function(){
                    console.log(this.value);

                });
                $('#single-input').clockpicker({
                    placement: 'bottom',
                    align: 'right',
                    autoclose: true,
                    'default': '20:48'
                });




                $('#store_load_details').off('click').on('click', function () {


                    if ($('#form').valid()) {

                        let formData = {
                            user_id: $(`#load_detail_modal input[name="user_id"]`).val(),
                            estimate_id: $(`#load_detail_modal input[name="estimate_id"]`).val(),
                            load_type: $(`#load_detail_modal input[name="load_type"]:checked`).val(),
                            special_load_description: $(`#load_detail_modal #special_load_description`).val(),
                            bulky_load: $(`#load_detail_modal input[name="bulky_load"]:checked`).val(),
                            urgent: $(`#load_detail_modal input[name="urgent"]:checked`).val(),
                            collection_date: $(`#load_detail_modal #collection_date_value`).val(),
                            delivery_date: $(`#load_detail_modal #delivery_date_value`).val(),
                            start_collection_time: $(`#load_detail_modal input[name="start_collection_time"]`).val(),
                            end_collection_time: $(`#load_detail_modal input[name="end_collection_time"]`).val(),
                            phone_number: $(`#load_detail_modal input[name="phone_number"]`).val(),
                            region: $(`#load_detail_modal select[name="region"]`).val(),
                            postal_code: $(`#load_detail_modal input[name="postal_code"]`).val(),
                            address: $(`#load_detail_modal textarea[name="address"]`).val(),
                            floors_count: $(`#load_detail_modal input[name="floors_count"]`).val(),
                            fast_shipping: $(`#load_detail_modal input[name="fast_shipping"]:checked`).val(),
                            packing: $(`#load_detail_modal input[name="packing"]:checked`).val(),
                            elevator: $(`#load_detail_modal input[name="elevator"]:checked`).val()
                        };


                        // Submit data with Axios
                        axios.post(approveOrderRoute, formData)
                            .then(function (response) {
                                if (response.data.status === 200) {

                                    $('#form')[0].reset();
                                    $('.btn-close').click();
                                    $('#basic-2').DataTable().ajax.reload(null, false);
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

                    }

                });


                $('#load_detail_modal').on('hidden.bs.modal', function () {

                    $(this).find('form')[0].reset();

                    $(this).find('input[type="radio"], input[type="checkbox"]').prop('checked', false);
                    $(this).find('select').val('');
                });

            });


            // Step navigation function
            function navigateStep(currentStep, nextStep) {
                $(`#${currentStep}`).removeClass('active').addClass('disabled');
                $(`#${nextStep}`).removeClass('disabled').addClass('active');
                $(`#${currentStep}_content`).removeClass('show active');
                $(`#${nextStep}_content`).addClass('show active');
            }

            $('#form #special_load_description').on('input change', function () {
                $(this).valid();
            });



            $(document).on('change', 'input[name="fast_shipping"]', function () {

                let status = $(this).val();
                switch (status) {
                    case 'yes':
                        $('#delivery_date').addClass('disabled');
                        $('#delivery_date').prop('disabled', true);
                        break;
                    case 'no':
                        $('#delivery_date').removeClass('disabled');
                        $('#delivery_date').prop('disabled', false);
                        break;
                }

            });

            $(document).on('change', 'input[name="elevator"]', function () {

                let status = $(this).val();
                switch (status) {
                    case 'no':
                        $('#floors_count').show();
                        break;
                    case 'yes':
                        $('#floors_count').hide();
                        break;
                }

            });




        });
    </script>


@endsection

