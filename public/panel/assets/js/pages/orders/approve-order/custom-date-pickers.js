
$(document).ready(function () {

    $("#collection_date").persianDatepicker({
        altField: "#collection_date_value",
        altFormat: "X",
        format: "D MMMM YYYY",
        timePicker: {
            enabled: true
        },
        observer: true,
        onSelect: function (unixDate) {

            let timestamp = $('#collection_date_value').val();
            let vehicleTypeId = $('#vehicle_type').val();

            generateDateCardsByTimestamp(timestamp, vehicleTypeId);

        }
    });

    $("#delivery_date").persianDatepicker({
        altField: "#delivery_date_value",
        altFormat: "X",
        format: "D MMMM YYYY",
        timePicker: {
            enabled: true
        },
        observer: true
    });

    $('#startCollectionTimePicker').clockpicker({
        container: '#approveOrderForm'
    })
    $('#startCollectionTimePicker').clockpicker()
        .find('input').change(function(){
    });
    $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'right',
        autoclose: true,
        'default': '20:48'
    });

})
