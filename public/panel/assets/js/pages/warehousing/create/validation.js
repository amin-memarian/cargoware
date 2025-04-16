$(document).ready(function () {
    setupValidation('#warehousingStoreForm',
        {
            name: {
                required: true,
                minlength: 2,
                maxlength: 40,
                pattern: /^[a-zA-Zآ-ی ]+$/
            },
            address: {
                required: true,
                minlength: 10
            },
            price_rate: {
                required: true,
                number: true
            },
            manager_id: {
                required: true,
            }
        },
        {
            name: {
                required: "لطفا نام را وارد کنید",
                minlength: "نام باید حداقل ۲ کاراکتر باشد",
                maxlength: "نام نباید بیشتر از ۴۰ کاراکتر باشد",
                pattern: "نام فقط باید شامل حروف و فاصله باشد"
            },
            address: {
                required: "لطفا آدرس انبار را وارد کنید",
                minlength: "آدرس باید حداقل ۱۰ کاراکتر باشد"
            },
            price_rate: {
                required: "لطفا نرخ قیمت را وارد کنید",
                number: "لطفا مقدار معتبر عددی وارد کنید",
            },
            manager_id: {
                required: "لطفا یک مدیر انبار را انتخاب کنید"
            }
        }
        ,'#warehousingStoreButton', null, false);
})
