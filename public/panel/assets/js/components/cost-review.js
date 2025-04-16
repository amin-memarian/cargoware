

$('#review-user-exist' + ' input[name="review_user_exist"]').on('change', function () {
    if ($(this).val() === 'yes') {
        $('#review-create-user').hide();
        $('#review-users-list').show();
    } else {
        $('#review-create-user').show();
        $('#review-users-list').hide();
    }
});


$('#review-partners-exist' + ' input[name="review_partner_exist"]').on('change', function () {

    let status = $(this).val();
    if (status === 'yes') {

        $('#review-partners-list').show();

    } else {
        $('#review-partners-list').hide();

    }
});

setupValidation("#costReviewForm", {
    store: {
        required: true,
        minlength: 1
    },
    destination: {
        required: true,
        minlength: 1
    },
    weight: {
        required: true,
        number: true,
        min: 1
    },
    volume_weight: {
        number: true
    },
    name: {
        required: {
            depends: function() {
                return $('input[name="review_user_exist"]:checked').val() === 'no';
            }
        },
        minlength: 2,
        maxlength: 40,
        pattern: /^[a-zA-Zآ-ی ]+$/
    },
    lastname: {
        required: {
            depends: function() {
                return $('input[name="review_user_exist"]:checked').val() === 'no';
            }
        },
        minlength: 2,
        maxlength: 100,
        pattern: /^[a-zA-Zآ-ی ]+$/
    },
    mobile: {
        required: {
            depends: function() {
                return $('input[name="review_user_exist"]:checked').val() === 'no';
            }
        },
        minlength: 11,
        maxlength: 11,
        digits: true,
        pattern: /^09\d{9}$/,
        remote: {
            url: window.checkMobileExistRoute,
            type: "GET",
            data: {
                mobile: function() {
                    return $("#costReviewMobile").val();
                }
            },
            dataType: "json",
            dataFilter: function(data) {
                var response = JSON.parse(data);
                if(response.is_unique) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    },
    user_id: {
        required: {
            depends: function() {
                return $('input[name="review_user_exist"]:checked').val() === 'yes';
            }
        },
        minlength: 1
    },
    admin_id: {
        required: true,
        minlength: 1
    },
    broker_id: {
        required: {
            depends: function() {
                return $('input[name="review_partner_exist"]:checked').val() === 'yes';
            }
        },
        minlength: 1
    },
    text: {
        required: true,
        minlength: 10
    }

}, {
    store: {
        required: "لطفا مبدا را انتخاب کنید",
        minlength: "حداقل یک مبدا باید انتخاب شود"
    },
    destination: {
        required: "لطفا مقصد را انتخاب کنید",
        minlength: "حداقل یک مقصد باید انتخاب شود"
    },
    weight: {
        required: "لطفا وزن بار را وارد کنید",
        number: "لطفا یک عدد معتبر وارد کنید",
        min: "وزن بار باید بیشتر از صفر باشد"
    },
    volume_weight: {
        number: "لطفا یک عدد معتبر وارد کنید"
    },
    name: {
        required: "لطفا نام را وارد کنید",
        minlength: "نام باید حداقل ۲ کاراکتر باشد",
        maxlength: "نام نباید بیشتر از ۴۰ کاراکتر باشد",
        pattern: "نام فقط باید شامل حروف و فاصله باشد"
    },
    lastname: {
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
    user_id: {
        required: 'لطفا یک مشتری را انتخاب نمایید'
    },
    admin_id: {
        required: 'لطفا یک مدیر را انتخاب نمایید'
    },
    broker_id: {
        required: 'لطفا یک مدیر را انتخاب نمایید'
    },
    text: {
        required: 'لطفا دلیل رد کردن را وارد نمایید',
        minlength: 'توضیحات باید حداقل 10 حرف باشد'
    }

}, '#costReviewSubmit', null, true);



$('#costReviewSubmit').off('click').on('click', function (e) {

    e.preventDefault();
    let form = $('#costReviewForm');
    if (form.valid()) {

        const formData = form.serialize();
        axios.post(window.costReviewComponentStoreRoute, formData)
            .then(response => {
                if (response.data.status === 200) {
                    showAlert('success', response.data.message || 'درخواست بررسی قیمت با موفقیت ثبت شد');
                    document.getElementById('costReviewForm').reset();
                    const modal = document.getElementById('costReviewModal');
                    const bootstrapModal = bootstrap.Modal.getInstance(modal);
                    bootstrapModal.hide();


                } else {
                    showAlert('failed', response.data.message || 'درخواست بررسی قیمت ناموفق بود');
                }
            })
            .catch(error => console.error('Error:', error));
    }
});

