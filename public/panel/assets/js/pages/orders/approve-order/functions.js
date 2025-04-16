


function handleDisabledElements() {

    $('#flexSwitchCheckDefault').prop('disabled', false);
    $('#special_load_description').prop('disabled', false);
    $('#estimate-next-123').removeClass('disabled');
}

function convertToDayOfWeek(date) {

    const daysOfWeek = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه'];
    const [year, month, day] = date.split('/');
    const dateObj = new Date(`${year}-${month}-${day}`);
    const dayOfWeek = dateObj.getDay();
    return daysOfWeek[dayOfWeek];

}

function getPickupAgentInformation(index) {

    let timelineStart = $('.day-card[data-index="' + index + '"]').attr('data-pickup-start-time');
    let timelineEnd = $('.day-card[data-index="' + index + '"]').attr('data-pickup-end-time');
    let agentId = $('.day-card[data-index="' + index + '"]').attr('data-agent-id');

    return { timelineStart, timelineEnd, agentId };

}


function handleReservedSlot(index, element) {

    if ($(element).hasClass('reserved')) {

        $(`.estimate_timeline_hours[data-index="${index}"] .time-slot`).removeClass('selected');
        showAlert('validation', 'تایم شروع شما با تایم فعالیت مامور جمع آوری تداخل دارد');

        $('#start_collection_time').val('');
        return true;
    }

    return false;

}

function handleTimeOverlap(index) {

    $(`.estimate_timeline_hours[data-index="${index}"] .time-slot`).removeClass('selected');
    showAlert('validation', 'تایم شروع شما با تایم فعالیت مامور جمع آوری تداخل دارد');

    $('#start_collection_time').val('');
    $('#hasOverlap').val(1);

}


function handleValidTimeSelection(index, selectedHour, selectedTime, endTime) {

    $('#hasOverlap').val(0);

    $(".time-slot").removeClass("selected");

    $(`.estimate_timeline_hours[data-index="${index}"] .time-slot`).each(function () {
        let slotHour = $(this).data("time");
        let selectedHourNum = selectedTime;
        let endTimeNum = parseFloat(endTime);

        if (slotHour >= selectedHourNum && slotHour <= endTimeNum) {
            $(this).addClass("selected from-server");
        }
    });

    $('#start_collection_time').val(selectedHour);
}

function checkTimeOverlap(index, selectedHour, selectedTime, timelineStart, timelineEnd) {

    let timeEstimation = $('#timeEstimationInput').val();
    let startTime = selectedHour;
    let timestamp = $('#start_collection_timestamp').val();
    $('#new_delivery_date_value').val(timestamp);

    axios.get(checkTimeOverlapRoute, {
        params: {
            timeEstimation: timeEstimation,
            startTime: startTime,
            timelineStart: timelineStart,
            timelineEnd: timelineEnd,
            timestamp: timestamp
        }
    })
        .then(function (response) {
            $('#end_collection_time').val(response.data.sum_time);
            let endTime = response.data.sum_time;

            if (response.data.has_overlap) {
                handleTimeOverlap(index);
            } else {
                handleValidTimeSelection(index, selectedHour, selectedTime, endTime);
            }

            $('#collectionDateParagraph').html(response.data.formatted_date);
        })
        .catch(function (error) {
            console.error('خطا در پردازش:', error);
        });

}

