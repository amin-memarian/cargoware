@extends('layouts.admin.master')

@section('title')
    <title>پنل مدیریت | لیست سفارش ها</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/js/persiandatepicker/persian-datepicker-0.4.5.min.css') }}">
    <style>.CodeMirror-lines {padding-left: 10px;}</style>
@endsection

@section('body-content')

    <h1>تکمیل اطلاعات بار</h1>
    <form id="approveOrderForm" class="container p-3 p-md-5 estimate_container nbg" action="{{ route('load_detail.store') }}" method="post">
        @csrf

        <input type="hidden" name="user_id" id="user_id" value="">
        <input type="hidden" name="estimate_id" id="estimate_id" value="">
        <input type="hidden" name="hasOverlap" id="hasOverlap" value="0">
        <input type="hidden" name="start_collection_timestamp" id="start_collection_timestamp" value="">
        <input type="hidden" name="end_collection_time" id="end_collection_time" value="">
        <input type="hidden" name="start_collection_time" id="start_collection_time" value="">
        <input type="hidden" name="collection_agent_id" id="collection_agent_id" value="">
        <input id="new_collection_date" name="new_collection_date" class="form-control" type="hidden" value="">

        <!-- process section -->
        @include('components.orders.approve-order.collection-tabs')
        <!-- end process section -->

        <div class="tab-content" id="estimateTabsContent">
            @include('components.orders.approve-order.step1')
            @include('components.orders.approve-order.step2')
            @include('components.orders.approve-order.step3')
            @include('components.orders.approve-order.step4')
            @include('components.orders.approve-order.step5')
        </div>
    </form>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
{{--<script src="{{ asset('panel/assets/js/editor/simple-mde/simplemde.min.js') }}"></script>--}}
<script src="{{ asset('panel/assets/js/editor/simple-mde/simplemde.custom.js') }}"></script>

    <script src="{{ asset('panel/assets/js/persiandatepicker/persian-date-0.1.8.min.js') }}"></script>
    <script src="{{ asset('panel/assets/js/persiandatepicker/persian-datepicker-0.4.5.min.js') }}"></script>
    <script src="{{ asset('panel/assets/js/time-picker/highlight.min.js') }}"></script>
    <script src="{{ asset('panel/assets/js/time-picker/jquery-clockpicker.min.js') }}"></script>

    <!-- Custom function -->
    <script src="{{ asset('panel/assets/js/helpers/enable-elements-by-config.js') }}"></script>

    <!-- General routes -->
    <script>
        let timeEstimationRoute = @json(route('time-estimation'));
        let approveOrderRoute = @json(route('load_detail.store'));
        let daysFromSpecificDateRoute = @json(route('next-days'));
        let checkTimeOverlapRoute = @json(route('check-time-overlap'));
        let dashboardRoute = @json(route('admin.dashboard'));
        let estimatesListRoute = @json(route('estimate.index'));
        let estimateId = @json($estimate->id);
    </script>

    <!-- Custom scripts -->
    <!-- process bar color change -->
    <script src="{{ asset('panel/assets/js/pages/orders/approve-order/process-bar.js') }}"></script>

    <!-- next/prev btn -->
    <script src="{{ asset('panel/assets/js/pages/orders/approve-order/navigation.js') }}"></script>

    <!-- show/hide textarea -->
    <script src="{{ asset('panel/assets/js/pages/orders/approve-order/toggle-elements.js') }}"></script>

    <!-- generate date cards function -->
    <script src="{{ asset('panel/assets/js/pages/orders/approve-order/generate-date-cards.js') }}"></script>

    <!-- init delivery and collection date pickers -->
    <script src="{{ asset('panel/assets/js/pages/orders/approve-order/custom-date-pickers.js') }}"></script>

    <!-- init custom validation -->
    <script src="{{ asset('panel/assets/js/pages/orders/approve-order/custom-validation.js') }}"></script>

    <!-- cancel button -->
    <script src="{{ asset('panel/assets/js/pages/orders/approve-order/cancel-button.js') }}"></script>

    <!-- functions -->
    <script src="{{ asset('panel/assets/js/pages/orders/approve-order/functions.js') }}"></script>

    <!-- toggle time slot -->
    <script src="{{ asset('panel/assets/js/pages/orders/approve-order/toggle-time-slot.js') }}"></script>

    <!-- timeline handler -->
    <script src="{{ asset('panel/assets/js/pages/orders/approve-order/timeline-handler.js') }}"></script>

    <!-- Handle show timeline by card -->
    <script src="{{ asset('panel/assets/js/pages/orders/approve-order/time-estimation-request.js') }}"></script>

    <script>
        $(document).ready(function () {

            $('#mobile').val(@json($mobile));
            $('#package_count').val(@json($packageCount));

            // active disabled elements after load
            enableElementsByConfig([
                { id: 'flexSwitchCheckDefault', isNormal: false, hasProperty: true },
                { id: 'special_load_description', isNormal: false, hasProperty: true },
                { id: 'estimate-next-123', isNormal: true, hasProperty: false }
            ]);

            // set defaults
            $('#user_id').val(@json($estimate->user_id));
            $('#estimate_id').val(@json($estimate->id));


            // while we are switching from step 3 to step 4
            $('#estimate-next-789').on('click', function () {

                // generate date cars with default value
                let timestamp = $('#collection_date_value').val();
                let vehicleTypeId = $('#vehicle_type').val();

                generateDateCardsByTimestamp(timestamp, vehicleTypeId);

            })


            // select time to delivery request
            $(".time-slot").on("click", function () {

                let index = $(this).data("index");

                if (handleReservedSlot(index, this)) return;

                let selectedHour = $(this).data("hour");
                let selectedTime = $(this).data("time");

                // get pickup agent times
                let { timelineStart, timelineEnd, agentId } = getPickupAgentInformation(index);

                checkTimeOverlap(index, selectedHour, selectedTime, timelineStart, timelineEnd);

                $('#collection_agent_id').val(agentId);

            });

            $('#estimate-perv').on('click', function () {
                $(".time-slot").removeClass("selected from-server reserved");
                $('.estimate_timeline_hours').hide();
            });

        });

        function declaredValue() {
            if(parseInt($("#declaredValue").val()) > parseInt($("#declaredValue2").val())) {
                $("#declaredValueMsg").fadeIn();
            }
            else {
                $("#declaredValueMsg").hide();
            }
        }

        $("#declaredValue").on('change', declaredValue);
        $("#declaredValue2").on('change', declaredValue);



        // Prevent type persian
        function preventTypePersian(e) {
            this.value = this.value.replace(/[\u0600-\u06FF\uFB50-\uFDFF]/g, '');
        }
        $("#address").on("input", preventTypePersian);
        $("#name").on("input", preventTypePersian);
        $("#nationalId").on("input", preventTypePersian);
        $("#mobile").on("input", preventTypePersian);
        $("#postalCode").on("input", preventTypePersian);
        $("#receiverAddress").on("input", preventTypePersian);
        $("#receiverName").on("input", preventTypePersian);
        $("#receiverPhone").on("input", preventTypePersian);
        $("#receiverPostalCode").on("input", preventTypePersian);
        $("#receiverEmail").on("input", preventTypePersian);
    </script>
@endsection
