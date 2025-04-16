

window.uploadPath = 'uploads/certificate';
import {getConfig} from '/panel/assets/js/uploader/custom-uploader.js';
window.relatedType = 'App\\Models\\Employee';

$(document).ready(async function () {


    try {
        const config = await getConfig();

        const csrfToken = config.csrfToken;
        const uploadRoute = config.uploadRoute;
        const deleteRoute = config.deleteRoute;

        const $fileInput = $('#file-input');
        const $preview = $('.uploader-preview');
        const $hiddenInput = $('#media-file-id');

        handleFileUpload($fileInput, $preview, $hiddenInput, csrfToken, uploadRoute, '#storeEmployeeButton');
        handleImageDelete($preview, $hiddenInput, $fileInput, csrfToken, deleteRoute);

    } catch (error) {
        console.error('Error loading config:', error);
    }


    let initialMobile = $('#oldMobile').val();

    const rules = {
        name: {
            required: true,
            minlength: 2,
            maxlength: 40,
            pattern: /^[a-zA-Zآ-ی ]+$/
        },
        last_name: {
            required: true,
            minlength: 2,
            maxlength: 100,
            pattern: /^[a-zA-Zآ-ی ]+$/
        },
        mobile: {
            required: true,
            minlength: 11,
            maxlength: 11,
            digits: true,
            pattern: /^09\d{9}$/,
            remote: {
                url: window.employeesCheckMobileExistRoute,
                type: "GET",
                data: {
                    mobile: function () {
                        return $("#employeeMobile").val();
                    }
                },
                dataType: "json",
                dataFilter: function (data) {

                    var response = JSON.parse(data);

                    if ($("#employeeMobile").val() === initialMobile)
                        return true;
                    else
                        return response.is_unique ? true : false;

                }
            }
        },
        role_id: {
            required: true
        },
        unit_id: {
            required: true
        },
        'media-file-id': {
            required: true
        }
    };

    const messages = {
        name: {
            required: "لطفا نام را وارد کنید",
            minlength: "نام باید حداقل ۲ کاراکتر باشد",
            maxlength: "نام نباید بیشتر از ۴۰ کاراکتر باشد",
            pattern: "نام فقط باید شامل حروف و فاصله باشد"
        },
        last_name: {
            required: "لطفا نام خانوادگی را وارد کنید",
            minlength: "نام خانوادگی باید حداقل ۲ کاراکتر باشد",
            maxlength: "نام خانوادگی نباید بیشتر از ۱۰۰ کاراکتر باشد",
            pattern: "نام خانوادگی فقط باید شامل حروف و فاصله باشد"
        },
        mobile: {
            required: "لطفا شماره موبایل را وارد کنید",
            minlength: "شماره موبایل باید ۱۱ رقم باشد",
            maxlength: "شماره موبایل باید ۱۱ رقم باشد",
            digits: "شماره موبایل فقط باید شامل ارقام باشد",
            pattern: "شماره موبایل باید با 09 شروع شود و فقط شامل ارقام باشد",
            remote: "این موبایل قبلاً ثبت شده است"
        },
        role_id: {
            required: 'لطفا یک نقش را انتخاب نمایید'
        },
        unit_id: {
            required: 'لطفا یک واحد را انتخاب نمایید'
        },
        'media-file-id': {
            required: 'لطفا عکس مدرک را آپلود نمایید'
        }
    };



   setupValidation('#storeEmployeeForm', rules, messages, '#storeEmployeeButton', null, false)


});
