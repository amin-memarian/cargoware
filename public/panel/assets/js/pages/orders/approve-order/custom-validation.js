$(document).ready(function () {
    setupValidation('#approveOrderForm', {
            name: {
                required: true,
                pattern: /^[a-zA-Zآ-ی ]+$/
            },
            national_id: {
                required: true,
                minlength: 10,
                maxlength: 10,
            },
            special_load_description: {
                required: {
                    depends: function() {
                        return $('input[name="load_type"]:checked').length === 0;
                    }
                },
                minlength: 6
            },
            package_count: {
                required: true,
                min: 1,
                digits: true
            },
            phone_number: {
                required: true,
                minlength: 11,
                maxlength: 11,
                digits: true
            },
            postal_code: {
                maxlength: 10,
                minlength: 10,
                digits: true
            },
            address: {
                required: true,
                minlength: 10
            },
            floors_count: {
                required: {
                    depends: function() {
                        return $('input[name="elevator"]:checked').val() === 'no';
                    }
                }
            },
            receiver_name: {
                required: true,
                pattern: /^[a-zA-Zآ-ی ]+$/

            },
            receiver_postal_code: {
                maxlength: 10,
                minlength: 10,
                digits: true
            },
            receiver_address: {
                required: true,
                minlength: 10
            },
            nature_id: {
                required: true
            },
            receiver_phone: {
                required: true,
                minlength: 11,
                maxlength: 11,
                digits: true
            },
            collection_postal_code: {
                maxlength: 10,
                minlength: 10,
                digits: true
            },
            collection_address: {
                required: true,
                minlength: 10
            },
            declared_value: {
                required: true,
                digits: true
            },
            declared_value_for_destination: {
                required: true,
                digits: true
            }
        },
        {
            name: {
                required: "Please enter the name.",
                pattern: "The name does not have a valid pattern."
            },
            national_id: {
                required: "Please enter your national code.",
                minlength: "The ID must be 10 digits.",
                maxlength: "The ID must be 10 digits.",
            },
            special_load_description: {
                required: "لطفا توضیحات بار خاص را وارد کنید",
                minlength: "توضیحات باید حداقل 6 حرف باشد",
            },
            package_count: {
                required: "لطفا تعداد بسته را وارد کنید",
                min: "تعداد بسته حداقل باید ۱ باشد",
                digits: "تعدا بسته فقط باید شامل ارقام باشد"
            },
            nature_id: {
                required: "لطفا ماهیت کالا را انتخاب کنید",
            },
            phone_number: {
                required: "Please enter tel.",
                minlength: "The tel must be 11 digits.",
                maxlength: "The tel must be 11 digits.",
                digits: "The tel must only contain digits."
            },
            postal_code: {
                maxlength: "The postal code must be 10 digits.",
                minlength: "The postal code must be 10 digits.",
                digits: "The postal code must only contain digits."
            },
            address: {
                required: "Please enter your address.",
                minlength: "The address must be at least 10 characters long."
            },
            floors_count: {
                required: "لطفا تعداد طبقات را وارد نمایید"
            },
            receiver_name: {
                required: "Please enter the name.",
                pattern: "The name does not have a valid pattern."
            },
            receiver_postal_code: {
                maxlength: "The postal code must be 10 digits.",
                minlength: "The postal code must be 10 digits.",
                digits: "The postal code must only contain digits."
            },
            receiver_address: {
                required: "Please enter your address.",
                minlength: "The address must be at least 10 characters long."
            },
            receiver_phone: {
                required: "Please enter tel.",
                minlength: "The tel must be 11 digits.",
                maxlength: "The tel must be 11 digits.",
                digits: "The tel must only contain digits."
            },
            collection_postal_code: {
                maxlength: "کد پستی باید ۱۰ رقم باشد",
                minlength: "کد پستی باید ۱۰ رقم باشد",
                digits: "کد پستی فقط باید شامل ارقام باشد"
            },
            collection_address: {
                required: "لطفا آدرس را وارد کنید",
                minlength: "آدرس باید حداقل ۱۰ کاراکتر باشد"
            },
            declared_value: {
                required: 'لطفا قیمت اظهاری را وارد کنید',
                digits: 'قیمت باید مقدار عددی باشد'
            },
            declared_value_for_destination: {
                required: 'لطفا قیمت اظهاری را وارد کنید',
                digits: 'قیمت باید مقدار عددی باشد'
            },
        }, '.approveOrderButton',
        function () {

            if ($(".estimate_timeline_days .day-card.estimate_timeline_days_active").length === 0 || $('.time-slot.selected, .day-card.from-server').length === 0) {
                showAlert('validation', 'لطفاً ابتدا یک روز و تایم مشخصی را انتخاب نمایید');
                return false;
            }

            if ($('#hasOverlap').val() == 1 || $('#hasOverlap').val() == '1')
            {
                showAlert('validation', 'در این تایم امکان رزرو جمع آوری کالا وجود ندارد لطفا تایم دیگری را انتخاب نمایید');
                return false;
            }
            return true;
        }
        , false, true);


})
