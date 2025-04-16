

$('#new-user-close-btn').on('click', function () {
    $('#addNewLoad').modal('show');
});

jQuery.validator.addMethod("pattern", function (value, element, param) {
    return this.optional(element) || param.test(value);
}, "مقدار وارد شده معتبر نیست");

setupValidation("#new-user-form", {
    name: {
        required: true,
        minlength: 2,
        maxlength: 40,
        pattern: /^[a-zA-Zآ-ی ]+$/
    },
    lastname: {
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
            url: window.checkMobileExistRoute,
            type: "GET",
            data: {
                mobile: function() {
                    return $("input[name='mobile']").val();
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
    }
}, {
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
    }
}, '#add-user-btn', null, true);


$('#new-user-form input[name="is_partner"]').on('change', function () {

    if ($(this).val() === 'yes')
        $("#search-field-partner").hide();
    else
        $("#search-field-partner").show();

})

function searchPartners() {

    clearTimeout(window.debounceTimeout);

    window.debounceTimeout = setTimeout(function () {

        const word = $("#search-field-partner").val();

        if (word.length > 1) {
            $("#search-result-partner").html('<b class="text-black-50">لطفا چند لحظه صبر کنید، در حال دریافت لیست همکاران ...</b>');

            $.ajax({
                url: window.componentSearchUserRoute + "/" + word,
                type: "GET",
                datatype: "json",
                success: function (response) {

                    $("#search-result-partner").html("");

                    if (response.count > 0) {

                        let table = `
                            <table class="table table-styling">
                                <thead>
                                    <tr>
                                        <th>نام</th>
                                        <th>نام خانوادگی</th>
                                        <th>موبایل</th>
                                        <th>انتخاب</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;


                        $.each(response.partners, function (key, user) {
                            table += `
                                <tr>
                                    <td>${user.name}</td>
                                    <td>${user.lastname}</td>
                                    <td>${user.mobile}</td>
                                    <td>
                                        <input type="checkbox" class="form-check-input" name="partners[]" id="checkbox${user.id}" value="${user.id}">
                                    </td>
                                </tr>
                            `;
                        });

                        table += `
                                </tbody>
                            </table>
                        `;

                        $("#search-result-partner").html(table);

                    } else {

                        $("#search-result-partner").html('<b class="text-danger">همکاری یافت نشد ...</b>');

                    }
                }
            });

        } else {
            $("#search-result-partner").html("");
        }

    }, 300);
}

$("#search-field-partner").on("keyup", searchPartners);

$('#add-user-btn').on('click', function (event) {

    event.preventDefault();

    const form = $('#new-user-form');
    if (!form.valid()) {
        return;
    }

    const formData = form.serialize();

    axios.post(window.componentUserStoreRoute, formData)
        .then(response => {

            const data = response.data.data;

            showAlert("success", "مشتری با موفقیت ثبت شد");

            if (data.is_partner === 1) {

                // Redirect to user list
                window.location.href = window.componentUserListRoute;

            } else {

                // Set new data to add load modal
                $('#new-load-title').text(data.user_info);
                $('#new-load-user-id').val(data.user_id);

                $('#new-user-modal').modal('hide');

                // Provide add load modal
                $('#addNewLoad').modal('show');
                $("#new-load-form").show();
                $("#search-field").hide();
                $('#submitBtn').show();

                // Reset add user form and elements
                form[0].reset();
                $("#search-field-partner").hide();
                $("#search-result-partner").html("");

            }

        })
        .catch(error => {

            if (error.response && error.response.data) {
                showAlert("error", "خطا در ارسال اطلاعات: " + error.response.data.message);
                console.error(error.response.data);
            } else {
                showAlert("error", "خطای ناشناخته‌ای رخ داد.");
                console.error(error);
            }
        });
});
