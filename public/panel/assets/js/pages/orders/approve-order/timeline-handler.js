


$(document).on('click', '.day-card', function () {

    let index = $(this).data('index');
    let pickupStartTime = $(this).data('pickup-start-time');
    let pickupEndTime = $(this).data('pickup-end-time');


    // fill reserved times
    $(`.estimate_timeline_hours[data-index="${index}"] .time-slot`).each(function () {

        let slotHour = $(this).data("time");
        let selectedHourNum = parseFloat(pickupStartTime);
        let endTimeNum = parseFloat(pickupEndTime);

        if (slotHour >= selectedHourNum && slotHour <= endTimeNum) {
            $(this).addClass("reserved");
        }

    });


    // show timeline
    $(".time-slot").removeClass("selected from-server");
    $('#start_collection_time').val('');
    $(".estimate_timeline_days .day-card").removeClass("estimate_timeline_days_active");
    $(this).addClass('estimate_timeline_days_active');
    $('.estimate_timeline_hours').hide();
    $('.estimate_timeline_hours[data-index="' + index + '"]').fadeIn();

    // update collection elements
    let timestamp = $(this).data('timestamp');
    $('#start_collection_timestamp').val(timestamp);
    $('#new_collection_date').val(timestamp);

});
