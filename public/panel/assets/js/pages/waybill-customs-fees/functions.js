
function initElements() {

        datePickerElement = $("#selectedDate").persianDatepicker({
            altField: "#selectedDateValue",
            altFormat: "X",
            format: "D MMMM YYYY",
            timePicker: {
                enabled: true
            },
            observer: true,
        });

        $('#costSelect').select2();

}

function defineConstantsOfAllElements() {

    userSelectableClass = '.user-selectable-row';
    caseSelectableClass = '.user-cases-selectable-row';

    datePickerElementName = '#selectedDate';
    userElementName = '#searchUsersInput';
    caseElementName = "#searchCasesInput";
    waybillNoElementName = "#waybillNo";
    natureOfGoodsElementName = "#natureOfGoods";
    weightElementName = "#weight";
    airlineNameElementName = "#airlineName";
    destinationElementName = "#destination";
    originElementName = "#origin";
    costSelectElementName = '#costSelect';

    datePickerElement = $(datePickerElementName);
    userElement = $(userElementName);
    caseElement = $(caseElementName);
    waybillNoElement = $(waybillNoElementName);
    natureOfGoodsElement = $(natureOfGoodsElementName);
    weightElement = $(weightElementName);
    airlineNameElement = $(airlineNameElementName);
    destinationElement = $(destinationElementName);
    originElement = $(originElementName);
    costSelectElement = $(costSelectElementName);
    loadDetailIdElement = $('#loadDetailIdInput');

}

/* Begin of requests */

function addAirWaybillFeePriceDetailCard(id, price) {

    if ($('#card-cost-' + id).length === 0) {
        let selectedValues = costSelectElement.val() || [];

        if (selectedValues && !selectedValues.includes(id))
            selectedValues.push(id);
        else
            selectedValues = [id];

        costSelectElement.val(selectedValues).trigger('change');

        id = 'cost-' + id;
        makeCard(id, 'کرایه حمل هواپیمایی (مبلغ بارنامه)', price, false, '', true);
        makeHiddenInputs(id, 'کرایه حمل هواپیمایی (مبلغ بارنامه)', price, '', false);

    }

    feather.replace();

}

/* Begin of price format */

function formatNumberWithCommas(value) {
    value = value.replace(/,/g, "");
    return value ? Number(value).toLocaleString("en-US") : "";
}

function removeCommas(value) {
    return value ? value.replace(/,/g, "") : "";
}

function handlePriceInput(event) {
    let $input = $(event.target);
    let rawValue = $input.val().replace(/\D/g, "");
    $input.val(formatNumberWithCommas(rawValue));
}

(function ($) {
    let originalVal = $.fn.val;

    $.fn.val = function (value) {
        if (arguments.length > 0) {
            let $this = $(this);
            let oldValue = originalVal.apply(this);

            let result = originalVal.apply(this, arguments);

            if (oldValue !== value) {
                $this.trigger("change");
            }

            return result;
        }
        return originalVal.apply(this);
    };
})(jQuery);

function registerPriceInputHandler() {
    $(document).on("input change", "[data-format='price']", handlePriceInput);
}

/* End of price format*/

function updateCasesSearchResults(content, noResultsMessage = 'پرونده ای یافت نشد !') {

    if (typeof content === "string" && content.trim() !== "") {

        $('#userCasesSearchResults').html(content);

    } else {

        $('#userCasesSearchResults').html(`<div class="py-3 px-3 text-center"><b class="text-danger">${noResultsMessage}</b></div>`);
    }

}

function emptyCasesSearchResults() {
    $('#userCasesSearchResults').empty();
}

function updateUsersSearchResults(content, noResultsMessage = 'کاربری یافت نشد !') {

    if (typeof content === "string" && content.trim() !== "") {

        $('#userSearchResults').html(content);

    } else {

        $('#userSearchResults').html(`<div class="py-3 px-3 text-center"><b class="text-danger">${noResultsMessage}</b></div>`);
    }

}

function emptyUsersSearchResults() {
    $('#userSearchResults').empty();
}

function handleShowCasesTableContent(response) {

    let tableContent = "";

    if (response.data.count > 0) {

        tableContent = `
                 <table class="table table-hover table-bordered" style="width: 100%;cursor: pointer">

                    <thead>
                        <tr>
                            <th>شماره پرونده</th>
                            <th>مبدا</th>
                            <th>مقصد</th>
                            <th>قیمت کل (بارنامه)</th>
                            <th>تاریخ</th>
                        </tr>
                    </thead>

                    <tbody>
            `;

        let cases = response.data.cases;

        cases.forEach(function (caseItem) {

            tableContent += `
                  <tr class='user-cases-selectable-row'
                        data-id="${caseItem.action_data.id}"
                        data-case-number="${caseItem.action_data.case_number}"
                        data-origin="${caseItem.action_data.origin}"
                        data-destination="${caseItem.action_data.destination}"
                        data-weight="${caseItem.action_data.weight}"
                        data-airline-id="${caseItem.action_data.airline_id}"
                        data-air-waybill-amount="${caseItem.action_data.air_waybill_amount}"
                        data-total-price="${caseItem.action_data.total_price}"
                        data-date-in-timestamp="${caseItem.action_data.date_in_timestamp}"
                        >

                  <td>${caseItem.case_number}</td>
                  <td>${caseItem.origin}</td>
                  <td>${caseItem.destination}</td>
                  <td>${formatPrice(caseItem.total_price)}</td>
                  <td>${caseItem.date}</td>
            `;

        });

        tableContent += `
                </tbody>
                </table>
            `;

        return tableContent;

    } else {

        updateCasesSearchResults(null);

        return null;

    }


}

function searchCaseByUserId(searchUserCasesRoute, userId) {

    axios.get(searchUserCasesRoute,{
        params: {
            'userId': userId
        }
    })
        .then(response => {

            updateCasesSearchResults('<div class="py-3 px-3 text-center rounded"><b class="text-black-50">در حال جستجو ...</b></div>');

            let tableContent = handleShowCasesTableContent(response);

            updateCasesSearchResults(tableContent);

        })
        .catch(error => {

            updateCasesSearchResults(null);

        });

}

function searchCaseByWaybillNo(searchUserCasesRoute, waybillNo) {

    axios.get(searchUserCasesRoute,{
        params: {
            'waybillNo': waybillNo
        }
    })
        .then(response => {

            updateCasesSearchResults('<div class="py-3 px-3 text-center rounded"><b class="text-black-50">در حال جستجو ...</b></div>');

            let tableContent = handleShowCasesTableContent(response);

            updateCasesSearchResults(tableContent);

        })
        .catch(error => {

            updateCasesSearchResults(null);

        });

}

function searchUsers() {

    clearTimeout(window.debounceTimeout);

    window.debounceTimeout = setTimeout(function () {

        const word = $("#searchUsersInput").val();

        if (word.length > 1) {
            $("#userSearchResults").html('<div class="py-3 px-3 text-center rounded"><b class="text-black-50">در حال جستجو ...</b></div>');

            $.ajax({
                url: window.window.searchAllUsersRoute + "/" + word,
                type: "GET",
                datatype: "json",
                success: function (response) {

                    updateUsersSearchResults('');

                    if (response.count > 0) {

                        let table = `
                                        <table class="table table-hover table-bordered" role="grid" style="cursor: pointer;width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>نام</th>
                                                    <th>نام خانوادگی</th>
                                                    <th>موبایل</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    `;

                        $.each(response.users, function (key, user) {
                            table += `
                                            <tr class='user-selectable-row' data-user-id='${user.id}' data-user-name='${user.name}' data-user-lastname='${user.lastname}' data-user-mobile='${user.mobile}'>
                                                <td>${user.name}</td>
                                                <td>${user.lastname}</td>
                                                <td>${user.mobile}</td>
                                            </tr>
                                        `;
                        });

                        table += `
                                </tbody>
                            </table>
                        `;

                        updateUsersSearchResults(table);

                    } else {

                        updateUsersSearchResults('<div class="py-3 px-3 text-center"><b class="text-danger">کاربری یافت نشد !</b></div>');


                    }
                }
            });

        } else {
            $("#userSearchResults").html("");
        }

    }, 300);
}

/* End of requests */


function setRelatedCaseElementsValue(caseNumber, origin, destination, weight, airlineId, totalPrice, dateInTimestamp) {

    if (caseNumber) {
        waybillNoElement.val(caseNumber)
            .prop('disabled', true)
            .addClass('disabled');
    }

    if (destination) {
        destinationElement.val(destination)
            .prop('disabled', true)
            .trigger('change');
    }

    if (weight) {

        weightElement.val(weight)
            .prop('disabled', true)
            .addClass('disabled');

        handleAddCustomsFormalitiesFeeCard(weight);

    }

    if (airlineId) {
        airlineNameElement.val(airlineId)
            .prop('disabled', true)
            .trigger('change')
            .addClass('disabled');
    }

    if (totalPrice) {

        addAirWaybillFeePriceDetailCard(
            airWaybillFeeId,
            formatPrice(totalPrice)
        );

    }

    // if (dateInTimestamp) {
    //
    //     setNewDate(dateInTimestamp);
    //
    // }

}

function enableRelatedCaseElements() {

    if (waybillNoElement.prop('disabled')) {

        waybillNoElement.prop('disabled', false)
            .removeClass('disabled');

    }


    if (destinationElement.prop('disabled')) {

        destinationElement.prop('disabled', false)
            .trigger('change');

    }

    if (weightElement.prop('disabled')) {

        weightElement.prop('disabled', false)
            .removeClass('disabled');

    }

    if (airlineNameElement.prop('disabled')) {

        airlineNameElement.prop('disabled', false)
            .removeClass('disabled')
            .trigger('change');

    }

}

function resetRelatedCaseElementsValue() {

    if (waybillNoElement.prop('disabled')) {

        waybillNoElement.val('')
            .prop('disabled', false)
            .removeClass('disabled');

    } else {
        waybillNoElement.val('');
    }

    if (destinationElement.prop('disabled')) {

        destinationElement.val('')
            .prop('disabled', false)
            .trigger('change');

    } else {

        destinationElement.val('')
            .trigger('change');

    }

    if (weightElement.prop('disabled')) {

        weightElement.val('')
            .prop('disabled', false)
            .removeClass('disabled');

    } else {

        weightElement.val('');

    }

    if (airlineNameElement.prop('disabled')) {

        airlineNameElement.val('')
            .trigger('change')
            .prop('disabled', false)
            .removeClass('disabled');

    } else {

        airlineNameElement.val('')
            .trigger('change');

    }

    // if (datePickerElement.prop('disabled')) {
    //
    //     datePickerElement
    //         .prop('disabled', false)
    //         .trigger('change');
    // }



}

function handleUsersInputClick() {

    $("#searchUsersInput").on("focus", function () {

        $(this).val('');
        $('#userIdInput').val('');

        updateCasesSearchResults('<div class="py-3 px-3 text-center rounded"><b class="text-black-50">ابتدا باید مشتری مورد نظر را انتخاب نمایید</b></div>');

        handleResetCaseComponents();

        handleDestroyAirWaybillFeeRelatedElements();

        handleDestroyCustomsFormalitiesFeeRelatedElements();

    });

}

function handleDestroyAirWaybillFeeRelatedElements() {

    let targetTitle = 'کرایه حمل هواپیمایی (مبلغ بارنامه)';
    let targetButton = $('button[data-title="' + targetTitle + '"]');
    if (targetButton) {

        let targetId = targetButton.attr('data-id');
        destroyHiddenInput(targetId);
        destroyCard(targetId);

        const id = targetId.replace('cost-', '');
        let selectedValues = costSelectElement.val() || [];
        selectedValues = selectedValues.filter(value => value !== id);
        costSelectElement.val(selectedValues).trigger("change");


    }

}


function handleUsersInputKeyUp() {

    $("#searchUsersInput").on("keyup", function () {
        searchUsers();
    });

}

function handleSearchedUserClick() {

    $(document).on('click', userSelectableClass, function () {

        let userId = $(this).data('user-id');
        let name = $(this).data('user-name');
        let lastName = $(this).data('user-lastname');
        let mobile = $(this).data('user-mobile');

        let searchUserCasesRoute = window.searchUserCasesRoute.replace(':term', userId);
        searchCaseByUserId(searchUserCasesRoute, userId);

        $('#userIdInput').val(userId);

        emptyUsersSearchResults();

        fillUserElement(name + ' ' + lastName + ' ' + mobile);

    });

}

function handleSearchedCaseClick() {

    $(document).ready(function () {

        $(document).on('click', caseSelectableClass, function () {

            let id, caseNumber, origin, destination, weight, airlineId, totalPrice, dateInTimestamp;

            id = $(this).attr('data-id');
            caseNumber = $(this).attr('data-case-number');
            origin = $(this).attr('data-origin');
            destination = $(this).attr('data-destination');
            weight = $(this).attr('data-weight');
            airlineId = $(this).attr('data-airline-id');
            totalPrice = $(this).attr('data-total-price');
            dateInTimestamp = $(this).attr('data-date-in-timestamp');

            fillLoadDetailId(id);

            fillCaseElement(caseNumber);

            setRelatedCaseElementsValue(caseNumber, origin, destination,  weight, airlineId, totalPrice, dateInTimestamp);

            updateCasesSearchResults('<div class="py-3 px-3 text-center rounded"><b class="text-black-50">پرونده انتخاب شده است</b></div>');

        })

    });

}

function fillLoadDetailId(id) {
    loadDetailIdElement.val(id);
}

function emptyLoadDetailId() {
    loadDetailIdElement.val('');
}

function fillUserElement(information = '') {

    userElement.attr('data-has-user-information', 1);
    userElement.val(information);

}

function emptyUserElement() {
    if (userElement.attr('data-has-user-information') === '1' || userElement.attr('data-has-user-information') === 1) {
        userElement.attr('data-has-user-information', 0);
        userElement.val('');
    }
}

function fillCaseElement(caseNumber) {

    caseElement.attr('data-has-waybill-no', 1);
    caseElement.val(caseNumber);

}

function emptyCaseElement() {
    caseElement.attr('data-has-waybill-no', 0);
    caseElement.val('');
}


function handleResetCaseComponents() {

    if (caseElement.attr('data-has-waybill-no') === '1' || caseElement.attr('data-has-waybill-no') === 1) {

        updateCasesSearchResults('<div class="py-3 px-3 text-center rounded"><b class="text-black-50">ابتدا باید مشتری مورد نظر را انتخاب نمایید</b></div>');
        emptyLoadDetailId();
        emptyCaseElement();
        resetRelatedCaseElementsValue();

    }

}

function handleCaseInputClick() {

    $(caseElementName).on('click', function () {

        handleResetCaseComponents();

        handleDestroyAirWaybillFeeRelatedElements();

        handleDestroyCustomsFormalitiesFeeRelatedElements();

    });

}

function handleCasesInputKeyUp() {

    let timeout = null;

    caseElement.on("keyup", function () {

        clearTimeout(timeout);

        let waybillNo = $(this).val();

        if (waybillNo.length > 6) {

            let searchUserCasesRoute = window.searchUserCasesRoute.replace(':term', waybillNo);

            timeout = setTimeout(() => {

                searchCaseByWaybillNo(searchUserCasesRoute, waybillNo);
            }, 300);

        }

    });

}


function setNewDate(timestamp) {
    datePickerElement.setDate(timestamp * 1000);
    $('#selectedDateValue').val(timestamp);
}


/* Begin of monitoring price detail section */

function generateHiddenInputsTemplate(newId, costTitle, costPrice, costDescription = '', costAirportFee = false) {

    return `
        <div id="hidden-input-${newId}">
            <input type="hidden" id="title-${newId}" name="costs[${newId}][title]" value="${costTitle ?? ''}" />

            <input data-format='price' type="hidden" id="price-${newId}" name="costs[${newId}][price]" value="${removeCommas(costPrice)}" />

            <textarea id="description-${newId}" name="costs[${newId}][description]" rows="4" style="display: none">${costDescription ?? ''}</textarea>

        </div>
`;

}

function makeHiddenInputs(id, title, price, description = '', addAirportFee = false) {

    let hideInput = generateHiddenInputsTemplate(id, title, price, description, addAirportFee);
    $('#hideInputs').append(hideInput);

}

function destroyCard(id) {
    $('#card-' + id).remove();
}

function destroyHiddenInput(id) {
    $('#hidden-input-' + id).remove();
}

function generateInputsTemplate(newId, costTitle, costPrice, costDescription = '', addAirportFee) {

    return `
            <div class="cost-field" id="${newId}">
                <div class="row">
                    <input type="hidden" id="title-${newId}" name="costs[${newId}][title]" class="form-control custom-elements" value="${costTitle ?? ''}" />

                    <div class="col-12 col-md-6 col-lg-6 mt-4">
                        <label class="custom-label" for="price-${newId}">
                            شرح هزینه :
                            <span>${costTitle}</span>
                        </label>
                        <input data-format='price' type="text" id="price-${newId}" name="costs[${newId}][price]" class="form-control custom-elements" value="${formatPrice(costPrice)}" placeholder="قیمت جدید" />
                    </div>


                    <div class="col-12 col-md-6 col-lg-6 mt-4" id="description-container-${newId}">
                        <label class="custom-label" id="description-label-${newId}" for="description-${newId}">توضیحات :</label>
                        <textarea type="text" id="description-${newId}" name="costs[${newId}][description]" class="form-control custom-elements" placeholder="..." rows="1">${costDescription ?? ''}</textarea>
                    </div>

                    <div class="col-12 col-md-6 col-lg-6 mt-4">
                    </div>

                    <div class="col-12 col-md-12 col-lg-12 mt-4">
                        <button class="btn btn-danger reject-price-detail" data-id="${newId}" id="reject-price-detail-${newId}">انصراف</button>
                        <button class="btn btn-warning approve-price-detail" data-id="${newId}" id="approve-price-detail-${newId}">تایید</button>
                    </div>


                </div>
            </div>`;

}

function makeInputs(id, title, price, description = '', addAirportFee = false) {

    let costFieldHTML = generateInputsTemplate(id, title, price, description, addAirportFee);

    $('#addedCostsContainer').append(costFieldHTML);

}

function generateCardsTemplate(id, title, price, addAirportFee, description, hasNoEdit = false) {
    return `
            <div class="col-12 col-md-4 col-lg-4 mt-2" id="card-${id}">

                <div class="border py-3 px-2" style="border-radius: 15px" id="choose-card-${id}" data-id="${id}">

                    <span class="justify-content-center align-content-center">

                        <button type="button" class="delete-cost ms-2 border-0" id="delete-${id}" data-id="${id}">
                                    <i data-feather="x-square"></i>
                        </button>

                        <button type="button" class="edit-cost ms-2 border-0 ${hasNoEdit ? 'disabled' : ''}" id="edit-${id}"
                                data-title="${title}" data-price="${price}"
                                data-has-airport-fee="${addAirportFee}"
                                data-description="${description}" data-id="${id}" ${hasNoEdit ? 'disabled' : ''}>
                                    <i data-feather="edit"></i>
                        </button>

                        <span class="ms-2">${title}</span>

                    </span>

                </div>

            </div>
            `;
}

function defineApprovePriceDetailBasics(id) {

    return {
        title: $('#title-' + id).val(),
        price: $('#price-' + id).val(),
        description: $('#description-' + id).val(),
        addAirportFee: $('#addAirportFee-' + id).is(':checked')
    };

}

function makeCard(id, title, price, addAirportFee, description, hasNoEdit = false) {

    let card = generateCardsTemplate(id, title, price, addAirportFee, description, hasNoEdit);
    $('#addedCostsList').append(card);

}

function defineEditCostBasics(editCostElement) {

    return {
        id: editCostElement.attr('data-id'),
        title: editCostElement.attr('data-title'),
        price: editCostElement.attr('data-price'),
        description: editCostElement.attr('data-description'),
        addAirportFee: editCostElement.attr('data-has-airport-fee'),
    };

}

function toggleIntroDots() {
    if ($('.cost-field').length === 0) {
        $('#introDots').show();
    } else {
        $('#introDots').hide();
    }
}

function updateActionButtonsData(id, title, price, description, addAirportFee) {

    let deleteButton = $('#delete-' + id);
    let editButton = $('#edit-' + id);

    deleteButton.attr('data-id', id);
    deleteButton.attr('data-title', title);
    deleteButton.attr('data-price', price);
    deleteButton.attr('data-description', description);
    deleteButton.attr('data-add-airport-fee', addAirportFee);

    editButton.attr('data-id', id);
    editButton.attr('data-title', title);
    editButton.attr('data-price', price);
    editButton.attr('data-description', description);
    editButton.attr('data-add-airport-fee', addAirportFee);

}

function handleCostUnselect() {

    $('#costSelect').on('select2:unselect', function (e) {

        let removedItem = e.params.data.id;

        $('#addedCostsContainer').empty();
        $('#card-cost-' + removedItem).remove();

        toggleIntroDots();

        destroyHiddenInput('cost-' + removedItem);

    });

}

function preventCostSelectionIfNotApproved(message = 'ابتدا باید شرح هزینه مورد نظر را تایید کنید و بعد اقدام به انتخاب کنید') {

    $('#costSelect').on('select2:selecting', function (e) {

        if ($('.cost-field').length >= 1) {
            e.preventDefault();
            showAlert('success', message, 'شرح هزینه');
        }

    });

}

function handleCostSelect() {

    $('#costSelect').on('select2:select', function (e) {

        let selectedItem = e.params.data.id;
        let costTitle = e.params.data.text;
        let costPrice =  e.params.data.element.getAttribute('data-price');
        let newId = "cost-" + selectedItem;

        makeInputs(newId, costTitle, costPrice, '', false);

        toggleIntroDots();

    });

}

function handleApprovePriceDetail() {

    $(document).on('click', '.approve-price-detail', function () {

        let id = $(this).data('id');
        let { title, price, description, addAirportFee } = defineApprovePriceDetailBasics(id);


        if ($('#card-' + id).length > 0) {

            updateActionButtonsData(id, title, price, description, addAirportFee);

            destroyHiddenInput(id);
            makeHiddenInputs(id, title, price, description, addAirportFee);

            $('#choose-card-' + id).removeClass('shadow');

        } else {

            makeCard(id, title, price, addAirportFee, description);

            makeHiddenInputs(id, title, price, description, addAirportFee);


        }

        feather.replace();
        $('#'+ id).remove();

        toggleIntroDots();

    });

}

function handleRejectPriceDetail() {

    $(document).on('click', '.reject-price-detail', function () {

        let id = $(this).data('id');

        $('#'+ id).remove();

        toggleIntroDots();

        $('#choose-card-' + id).removeClass('shadow');

        if (!$('#card-' + id).length > 0) {

            let selectedValues = $("#costSelect").val();

            id = id.replace('cost-', '');

            selectedValues = selectedValues.filter(value => value !== id);

            $("#costSelect").val(selectedValues).trigger("change");

        }

    });

}

function handleCostEdit() {

    $(document).on('click', '.edit-cost', function () {

        if ($('#addedCostsContainer .cost-field').length != 1) {

            let { id, title, price, description, addAirportFee } = defineEditCostBasics($(this));

            $('#choose-card-' + id).addClass('shadow');

            makeInputs(id, title, price, description, addAirportFee);

            toggleIntroDots();

        } else {

            showAlert('success', 'لطفا ابتدا وضعیت شرح هزینه جاری را مشخص نمایید', 'شرح هزینه');

        }

    });

}

function handleCostDelete() {

    $(document).on('click', '.delete-cost', function () {

        let selectedItems = $('#costSelect').val() || [];
        let id = $(this).data('id');

        $('#card-' + id).remove();

        destroyHiddenInput(id);

        id = id.replace('cost-', '');

        selectedItems = selectedItems.filter(item => item !== id);
        $('#costSelect').val(selectedItems).trigger('change');

    });

}

/* End of monitoring price detail section */

/* Financial section */
function handleAccountClick() {

    $(document).ready(function () {

        $(document).on('click', '.invoice-account-selectable-row', function () {

            let id = $(this).data('id');
            let bankName = $(this).data('bank-name');
            let branch = $(this).data('branch');
            let code = $(this).data('code');
            let accountHolder = $(this).data('account-holder');
            let cardNumber = $(this).data('card-number');
            let accountNumber = $(this).data('account-number');
            let shebaNumber = $(this).data('sheba-number');

            $('#invoiceAccountIdInput').val(id);
            $("#invoiceAccountsSearchResults").hide();

            $('#bankName').text(bankName);
            $('#branch').text(branch);
            $('#code').text(code);
            $('#accountHolder').text(accountHolder);
            $('#cardNumber').text(cardNumber);
            $('#accountNumber').text(accountNumber);
            $('#shebaNumber').text(shebaNumber);

            $('#reselectButton').show();

            $('#selectedAccountLabel').text('حساب انتخاب شده :')

        });

        $('#reselectButton').on('click', function () {

            $('#bankName').text('');
            $('#branch').text('');
            $('#code').text('');
            $('#accountHolder').text('');
            $('#cardNumber').text('');
            $('#accountNumber').text('');
            $('#shebaNumber').text('');

            $("#invoiceAccountsSearchResults").show();
            $(this).hide();

            $('#selectedAccountLabel').text('در حال حاضر حسابی انتخاب نشده :')

        });

    });
}

/* End of financial section */

/* Begin of customs formalities fee section */

function addCustomsFormalitiesFeeCard(id, price) {

    if ($('#card-cost-' + id).length === 0) {
        let selectedValues = costSelectElement.val() || [];

        if (selectedValues && !selectedValues.includes(id))
            selectedValues.push(id);
        else
            selectedValues = [id];

        costSelectElement.val(selectedValues).trigger('change');

        id = 'cost-' + id;
        makeCard(id, 'هزینه تشریفات گمرکی', price, false, '');
        makeHiddenInputs(id, 'هزینه تشریفات گمرکی', price, '', false);

    }

    feather.replace();

}

function handleAddCustomsFormalitiesFeeCard(weight) {

    let priceApplied = false;

    if (customsFormalitiesFees.length > 0) {
        customsFormalitiesFees.forEach(fee => {

            if (weight >= fee.from_weight && weight <= fee.to_weight && !priceApplied) {

                addCustomsFormalitiesFeeCard(
                    customsFormalitiesFeeId,
                    formatPrice(fee.price)
                );
                priceApplied = true;

            }

        });
    }

}

function handleWeightElementBlur() {

    $('#weight').on('blur', function() {

        let weight = $(this).val();

        handleAddCustomsFormalitiesFeeCard(weight);

    });

}

function handleDestroyCustomsFormalitiesFeeRelatedElements() {

    let targetTitle = 'هزینه تشریفات گمرکی';
    let targetButton = $('button[data-title="' + targetTitle + '"]');
    if (targetButton) {

        let targetId = targetButton.attr('data-id');
        destroyHiddenInput(targetId);
        destroyCard(targetId);

        const id = targetId.replace('cost-', '');
        let selectedValues = costSelectElement.val() || [];
        selectedValues = selectedValues.filter(value => value !== id);
        costSelectElement.val(selectedValues).trigger("change");


    }

}

/* End of customs formalities fee section */

function autoFillUserAndCase(user, loadDetail) {


    $('#userIdInput').val(user.id);

    emptyUsersSearchResults();

    fillUserElement(user.name + ' ' + user.last_name + ' ' + user.mobile);

    fillLoadDetailId(loadDetail.id);

    fillCaseElement(loadDetail.case_number);

    setRelatedCaseElementsValue(
        loadDetail.case_number,
        loadDetail.origin,
        loadDetail.destination,
        loadDetail.weight,
        loadDetail.airline_id,
        loadDetail.total_price,
        loadDetail.date_in_timestamp
    );

    updateCasesSearchResults('<div class="py-3 px-3 text-center rounded"><b class="text-black-50">پرونده انتخاب شده است</b></div>');

}

/* A powerful event handler */
function initEventHandlers() {

    initElements();

    defineConstantsOfAllElements();

    registerPriceInputHandler();

    handleCostSelect();
    handleCostUnselect();
    preventCostSelectionIfNotApproved();

    handleApprovePriceDetail();
    handleRejectPriceDetail();

    handleCostEdit();
    handleCostDelete();

}

