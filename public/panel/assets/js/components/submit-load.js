$('#add-new-user-btn').on('click', function () {
    $('#addNewLoad').modal('hide');
});

setupValidation("#new-load-form", {
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
        max: 156,
        min: 1,
        digits: true
    },
    'size_length[]': {
        max: 310,
        min: 1,
        digits: true
    },
    'size_width[]': {
        max: 235,
        min: 1,
        digits: true
    },
    'count[]': {
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
}, '#submitBtn', null, false, null, true);

$('#estimate-form').on('change', 'input[name="size_height[]"], input[name="size_length[]"], input[name="size_width[]"], input[name="count[]"]', function () {
    $(this).valid();
});


function getusers() {

    clearTimeout(window.debounceTimeout);

    window.debounceTimeout = setTimeout(function () {

        let data = $("#search-field").val();

        if (data.length > 1) {
            $("#search-result").html("");
            $("#search-result").append("<p class='text-black-50 ml-4'>درحال دریافت اطلاعات ...</p>");

            $.ajax({
                url: window.componentSearchUserRoute + "/" + data,
                type: "GET",
                datatype: "json",
                success: function (response) {

                    let users = response.users;

                    $("#search-result").html("");

                    if (response.count > 0) {

                        var table = `
                        <table class="table table-styling">
                            <thead>
                                <tr>
                                    <th>نام و نام خانوادگی</th>
                                    <th>موبایل مشتری</th>
                                    <th>بازاریاب 1</th>
                                    <th>بازاریاب 2</th>
                                    <th>بازاریاب 3</th>
                                    <th>بازاریاب 4</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;


                        $.each(users, function (key, user) {
                            var fullname = user.name + ' ' + user.lastname;


                            var partner1 = user.partner_1 || '-';
                            var partner2 = user.partner_2 || '-';
                            var partner3 = user.partner_3 || '-';
                            var partner4 = user.partner_4 || '-';


                            table += `

                            <tr class="text-dark form-user-table-content" data-user_id="${user.id}">
                                <td>${fullname}</td>
                                <td>${user.mobile}</td>
                                <td>${partner1}</td>
                                <td>${partner2}</td>
                                <td>${partner3}</td>
                                <td>${partner4}</td>
                            </tr>

                        `;
                        });


                        table += `
                            </tbody>
                        </table>
                    `;


                        $("#search-result").append(table);

                    } else {

                        $('#search-result').append("<b class='text-danger'>کاربری با این مشخصات یافت نشد</b>");
                        $("#new-load-form").css('display', 'none');
                    }
                }
            });

        } else {
            $("#search-result").html("");
            $("#new-load-form").hide();
        }
    }, 300);
}

$('#search-field').on('keyup', function () {
    getusers();
})

$(document).on('click', '.form-user-table-content', function() {

    let id = $(this).data('user_id');
    let name = $(this).find('td:first').text();


    $("#search-result").html("");

    $("#new-load-title").text(name);


    $("#new-load-form").show();
    $("#search-field").hide();


    $("#new-load-user-id").val(id);
    $('#submitBtn').show();

});

$('#add-load-return-btn').on('click', function () {

    if (!$('#new-load-form').is(':visible')) {

        $('#addNewLoad').modal('hide');

    } else {

        $("#new-load-title").text('');
        $('#new-load-form').hide();
        $('#submitBtn').hide();
        $("#search-field").val('');
        $('#search-field').show();
        $('#search-result').show();

    }

})
