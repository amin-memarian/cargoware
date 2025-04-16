$(document).ready(function () {
    setupValidation('#box_price_calculate_valueStoreForm',
        {
            price_of_three_meter_board: {
                required: true,
                number: true,
                min: 1000
            },
            Price_of_two_meter_sheet: {
                required: true,
                number: true,
                min: 1000
            },
            benefit: {
                required: true,
                number: true,
                min: 1,
                max: 100,
            },

        },
        {
            price_of_three_meter_board: {
                required: "لطفا نرخ قیمت را وارد کنید",
                number: "لطفا مقدار معتبر عددی وارد کنید",
                min: "نرخ قیمت باید حداقل 1000 باشد"
            },
            Price_of_two_meter_sheet: {
                required: "لطفا نرخ قیمت را وارد کنید",
                number: "لطفا مقدار معتبر عددی وارد کنید",
                min: "نرخ قیمت باید حداقل 1000 باشد"
            },
            benefit: {
                required: "لطفا نرخ قیمت را وارد کنید",
                number: "لطفا مقدار معتبر عددی وارد کنید",
                min: "نباید کمتر از 1 باشد",
                max: "نباید بیشتر از 100 باشد",
            },

        }
        ,'#box_price_calculate_valueStoreButton', null, false);
})
