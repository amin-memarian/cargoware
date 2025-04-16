
$(document).ready(function() {

    toggleTextarea();
    toggleFloors();

    $('#flexSwitchCheckDefault').on('change', function() {
        toggleTextarea();
    })

    $('#elevatorCheckBox').on('change', function() {
        toggleFloors();
    })

    function toggleTextarea() {

        if ($('#flexSwitchCheckDefault').is(':checked')) {
            $('#special_load_description').hide();
        } else {
            $('#special_load_description').show();
        }

    }

    function toggleFloors() {

        if ($('#elevatorCheckBox').is(':checked')) {
            $('#floorsCountId').hide();
        } else {
            $('#floorsCountId').show();
        }

    }


});
