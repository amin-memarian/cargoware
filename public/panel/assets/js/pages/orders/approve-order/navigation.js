
$(document).ready(function() {

    $('#estimate-next-444').on('click', function () {

        let floorsCountIsValid = $('#floorsCount').valid();

        let collectionPostalCodeIsValid = $('#collectionPostalCode').valid();
        let collectionAddressIsValid = $('#collectionAddress').valid();

        if (floorsCountIsValid && collectionPostalCodeIsValid && collectionAddressIsValid) {
            let targetTab = $(this).data('bs-target');
            $(targetTab + '-tab').tab('show');
        }
    });

    $('#estimate-next-456').on('click', function() {

        let mobileIsValid = $('#mobile').valid();
        let postalCodeIsValid = $('#postalCode').valid();
        let addressIsValid = $('#address').valid();


        let name = $('#name').valid();
        let nationalId = $('#nationalId').valid();
        let receiverName = $('#receiverName').valid();
        let receiverAddress = $('#receiverAddress').valid();
        let receiverPhone = $('#receiverPhone').valid();
        let receiverPostalCode = $('#receiverPostalCode').valid();

        if (mobileIsValid && postalCodeIsValid && addressIsValid
            && name && nationalId && receiverName && receiverAddress && receiverPhone && receiverPostalCode
        ) {
            let targetTab = $(this).data('bs-target');
            $(targetTab + '-tab').tab('show');
        }

    });

    $('#estimate-next-789, #estimate-next-101').on('click', function () {

        let targetTab = $(this).data('bs-target');
        $(targetTab + '-tab').tab('show');

    });

    $('#estimate-next-123').on('click', function() {

        let specialLoadDescription = $('#special_load_description').valid();
        let packageCount = $('#package_count').valid();
        let declaredValueIsValid = $('#declaredValue').valid();


        if (specialLoadDescription && packageCount && declaredValueIsValid) {
            let targetTab = $(this).data('bs-target');
            $(targetTab + '-tab').tab('show');
        }
    });

    $('.btn.btn_borderless_1').on('click', function() {
        let currentTab = $('.tab-pane.active');
        let prevTab = currentTab.prev('.tab-pane');
        if (prevTab.length) {
            let prevTabId = prevTab.attr('id');
            $('#' + prevTabId + '-tab').tab('show');
        }
    });

});
