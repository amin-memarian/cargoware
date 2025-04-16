setupValidation("#estimate-form", {
    ignore: [],
    'store[]': {
        required: true,
        minlength: 1
    },
    'destination[]': {
        required: true,
        minlength: 1
    },
    weight: {
        required: true,
        number: true,
        min: 1
    },
    'size_height[]': {
        required: {
            depends: function () {
                return $('input[name="volume_load"]:checked').val() === 'yes';
            }
        },
       max: 156,
       min: 1,
       digits: true
    },
    'size_length[]': {
        required: {
            depends: function () {
                return $('input[name="volume_load"]:checked').val() === 'yes';
            }
        },
        max: 310,
        min: 1,
        digits: true
    },
    'size_width[]': {
        required: {
            depends: function () {
                return $('input[name="volume_load"]:checked').val() === 'yes';
            }
        },
        max: 235,
        min: 1,
        digits: true
    },
    'count[]': {
        required: {
            depends: function () {
                return $('input[name="volume_load"]:checked').val() === 'yes';
            }
        },
        min: 1,
        digits: true
    }
}, {
    'store[]': {
        required: "لطفا مبدا را انتخاب کنید",
        minlength: "حداقل یک مبدا باید انتخاب شود"
    },
    'destination[]': {
        required: "لطفا مقصد را انتخاب کنید",
        minlength: "حداقل یک مقصد باید انتخاب شود"
    },
    weight: {
        required: "لطفا وزن بار را وارد کنید",
        number: "لطفا یک عدد معتبر وارد کنید",
        min: "وزن بار باید بیشتر از صفر باشد"
    },
    'size_height[]': {
        required: "لطفا ارتفاع کالا را وارد کنید",
        max: 'ارتفاع حداکثر باید 156 سانتی متر باشد',
        min: 'حداقل ارتفاع کالا 1 سانتی متر می باشد',
        digits: "لطفا یک عدد معتبر وارد کنید"
    },
    'size_width[]': {
        required: "لطفا عرض کالا را وارد کنید",
        max: 'عرض حداکثر باید 235 سانتی متر باشد',
        min: 'حداقل عرض کالا 1 سانتی متر می باشد',
        digits: "لطفا یک عدد معتبر وارد کنید",
    },
    'size_length[]': {
        required: "لطفا طول کالا را وارد کنید",
        max: 'طول حداکثر باید 310 سانتی متر باشد',
        min: 'حداقل طول کالا 1 سانتی متر می باشد',
        digits: "لطفا یک عدد معتبر وارد کنید",
    },
    'count[]': {
        required: "لطفا تعداد را وارد کنید",
        min: 'حداقل تعداد 1 می باشد',
        digits: "لطفا یک عدد معتبر وارد کنید"
    }
}, '#quick-estimate-submit-btn', null, false, null, true);

$('#estimate-form').on('change', 'input[name="size_height[]"], input[name="size_length[]"], input[name="size_width[]"], input[name="count[]"]', function () {
    $(this).valid();
});

$('input[name="volume_load"]').on('change', function () {
    if ($(this).val() === 'yes') {
        $('#volume-load').show()
    } else {
        $('#volume-load').hide()
    }
});

