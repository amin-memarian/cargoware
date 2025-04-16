$(document).ready(function () {
    setupValidation('#CollectionAgentCustomerStoreForm',
        {
            count: {
                required: true,
                number: true,

            },

            weight: {
                required: true,
                number: true,
            },
            load_type: {
                required: true,
            },

            manager_id: {
                required: true,
            }
        },
        {
            count: {
                required: "لطفا تعداد را وارد کنید",
                minlength: "تعداد باید حداقل 1 باشد",
            },
            weight: {
                required: "وزن را وارد کنید",
            },
            load_type: {
                required: "نوع بار را انتخاب کنید",
            },


        }
        ,'#CollectionAgentCustomerStoreButton', null, false);
})
