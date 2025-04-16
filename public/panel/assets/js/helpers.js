
function showAlert(type, message, title = '') {
    switch (type) {
        case 'success':
            iziToast.success({
                title: title || 'موفقیت',
                message: message,
                position: 'topRight',
                timeout: 3000,
                rtl: true
            });
            break;
        case 'failed':
            iziToast.error({
                title: title || 'ناموفق',
                message: message,
                position: 'topRight',
                timeout: 3000,
                rtl: true
            });
            break;
        case 'validation':
            iziToast.error({
                title: title || 'خطای اعتبارسنجی',
                message: message || 'لطفاً تمام فیلدهای الزامی را پر کنید.',
                position: 'topRight',
                timeout: 5000,
                backgroundColor: '#FF4D4D',
                color: 'white',
                rtl: true
            });
            break;
        default:
            iziToast.info({
                title: title || 'اعتبارسنجی',
                message: message,
                position: 'topRight',
                timeout: 3000,
                rtl: true
            });
            break;
    }
}

// Handle show elements
function showElements(selector) {

    if (Array.isArray(selector)) {

        selector.forEach(function(sel) {
            $(sel).show();
        });

    } else {
        $(selector).show();
    }

}

// Handle hide elements
function hideElements(selector) {

    if (Array.isArray(selector)) {

        selector.forEach(function(sel) {
            $(sel).hide();
        });

    } else {
        $(selector).hide();
    }

}


function handleSessionMessages() {

    const successMessage = $('#session-success').attr('content');
    if (successMessage) {
        showAlert('success', successMessage);
    }

    const errorMessage = $('#session-failed').attr('content');
    if (errorMessage) {
        showAlert('failed', errorMessage);
    }
}


function setupValidation(formSelector, rules, messages, submitButtonSelector = null, customValidation = null, hasAxios = false, enableElementsCallback = null, useNewErrorPlacement = false) {

    $(formSelector).validate({
        rules: rules,
        messages: messages,
        errorPlacement: function (error, element) {

            let formId = $(formSelector).attr('id') || $(formSelector).attr('class') || 'form';
            let $element = $(element)
            let name = $element.attr('name') || 'unknown';

            let uniqueId;
            if (useNewErrorPlacement) {
                let index = $(formSelector).find(`[name="${name}"]`).index($element);
                uniqueId = `${formId}-${name.replace(/[\[\]_\s]/g, '-')}-${index}-error`;
            } else {
                uniqueId = `${formId}-${name.replace(/[\[\]_\s]/g, '-')}-error`;
            }

            if ($("#" + uniqueId).length === 0) {
                $("<div>", {
                    id: uniqueId,
                    class: "invalid-feedback"
                }).insertAfter(element);
            }

            $("#" + uniqueId).text(error.text()).show();

        },
        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid").addClass("is-valid");

            let formId = $(formSelector).attr('id') || $(formSelector).attr('class') || 'form';
            let $element = $(element)
            let name = $element.attr('name') || 'unknown';
            let uniqueId = formId + '-' + name.replace(/[\[\]_\s]/g, '-') + "-error";
            $("#" + uniqueId).hide();
        },
        submitHandler: function (form) {

            if (customValidation && typeof customValidation === "function") {
                const isValid = customValidation();
                if (!isValid) {
                    return false;
                } else {
                    form.submit();
                }
            }

            if (enableElementsCallback && typeof enableElementsCallback === "function") {
                enableElementsCallback();
            }

            if (hasAxios)
                return false;
            else
                form.submit();


        }
    });


    $(formSelector + ' input, ' + formSelector + ' select').on('input change', function () {
        $(this).valid();
    });

    if (submitButtonSelector) {
        $(submitButtonSelector).on('click', function (event) {
            event.preventDefault();
            $(formSelector).submit();
        });
    }

}

function initializeDataTable(tableId, route, columns, additionalParams = {}, scrollX = false, autoWidth = false) {


    return $('#' + tableId).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: route,
            data: function (d) {

                return $.extend({}, d, additionalParams);

            }
        },
        columns: columns,
        scrollX,
        autoWidth
    });
}


function formatPrice(value) {
    if (!value) return "0";
    return Number(value.toString().replace(/,/g, '')).toLocaleString('en-US');
}

