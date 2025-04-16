
/* handle dimensions row*/
function generateDimensionsRow() {
    return `
            <div class="row mt-3">
                        <div class="mt-1 col-md-2 px-4 pt-3">
                            <label class="mb-4 custom-label" for="size">طول کالا : </label>
                            <input class="form-control custom-elements" name="size_height[]" maxlength="3" type="text" placeholder="طول">
                        </div>

                        <div class="mt-1 col-md-2 px-4 pt-3">
                            <label class="mb-4 custom-label" for="size">ارتفاع کالا : </label>
                            <input class="form-control custom-elements" name="size_length[]" maxlength="3" type="text" placeholder="ارتفاع">
                        </div>

                        <div class="mt-1 col-md-2 px-4 pt-3">
                            <label class="mb-4 custom-label" for="size">عرض کالا : </label>
                            <input class="form-control custom-elements" name="size_width[]" maxlength="3" type="text" placeholder="عرض">
                        </div>

                        <div class="mt-1 col-md-2 px-4 pt-3">

                            <label class="custom-label" for="count">تعداد بسته : </label>
                            <input class="form-control custom-elements" name="count[]" value="1" min="1" type="number" placeholder="تعداد بسته را انتخاب کنید">

                            <div class="invalid-feedback" id="count-error"></div>
                        </div>

                            <div class="mt-1 col-md-2 px-4 pt-3">
                                <i data-feather="plus-circle" class="add-row-button"></i>
                                <i data-feather="minus-circle" class="delete-row-button"></i>
                            </div>

                    </div>`;
}

function handleAddDimensionsRowQuickEstimate(){
    let row = generateDimensionsRow();
    $('#quickEstimateDimensionsContainer').append(row);
}

function destroyDimensionsRowQuickEstimate() {
    $('#quickEstimateDimensionsContainer .row:last').remove();
}

function quickEstimateDimensionsRowHandler() {

    $(document).on('click', '.add-row-button', function () {
        handleAddDimensionsRowQuickEstimate();
    })

    $(document).on('click', '.delete-row-button', function () {
        destroyDimensionsRowQuickEstimate();
    })
}

function handleAddDimensionsRowSubmitOrder(){
    let row = generateDimensionsRow();
    $('#submitOrderDimensionsContainer').append(row);
}

function destroyDimensionsRowSubmitOrder() {
    $('#submitOrderDimensionsContainer .row:last').remove();
}

function submitOrderDimensionsRowHandler() {

    $(document).on('click', '.add-row-button', function () {
        handleAddDimensionsRowSubmitOrder();
    })

    $(document).on('click', '.delete-row-button', function () {
        destroyDimensionsRowSubmitOrder();
    })
}

submitOrderDimensionsRowHandler();
quickEstimateDimensionsRowHandler();

/* end of handle dimensions row*/


function handleCollectionAgentTypeValueQuickEstimate(id) {

    if (id !== 'GCR') {

        $('#collectionAgentTypeMessageContainerQuickEstimate').show();
        $('.collectionAgentTypeButtonQuickEstimate').addClass('disabled');

    }

    if (id === 'GCR') {

        $('#collectionAgentTypeMessageContainerQuickEstimate').hide();
        $('.collectionAgentTypeButtonQuickEstimate').removeClass('disabled');

    }

}

function handleCollectionAgentTypeChangeQuickEstimate() {

    $('#collectionAgentTypeQuickEstimate').on('change', function () {

        let id = $(this).val();

        handleCollectionAgentTypeValueQuickEstimate(id);

    })

}

function handleCollectionAgentTypeValueSubmitOrder(id) {

    if (id !== 'GCR') {

        $('#collectionAgentTypeMessageContainerSubmitOrder').show();
        $('.collectionAgentTypeButtonSubmitOrder').addClass('disabled');

    }

    if (id === 'GCR') {

        $('#collectionAgentTypeMessageContainerSubmitOrder').hide();
        $('.collectionAgentTypeButtonSubmitOrder').removeClass('disabled');

    }

}

function handleCollectionAgentTypeChangeSubmitOrder() {

    $('#collectionAgentTypeSubmitOrder').on('change', function () {

        let id = $(this).val();

        handleCollectionAgentTypeValueSubmitOrder(id);

    })

}

handleCollectionAgentTypeChangeSubmitOrder();
handleCollectionAgentTypeChangeQuickEstimate();




const buttons = document.querySelectorAll('.btn.header-btn-price');
buttons.forEach(button => {
    button.addEventListener('click', () => {
        const targetId = button.getAttribute('data-target');
        const targetElement = document.getElementById(targetId);
        const container = targetElement.closest('.search-result-container');
        const icon = button.querySelector('i');
        const isVisible = targetElement.style.display === 'block';
        targetElement.style.display = isVisible ? 'none' : 'block';
        container.style.borderRadius = isVisible ? '16px' : '16px 16px 0px 0px';
        if (icon) {
            icon.style.transform = isVisible ? 'rotate(0deg)' : 'rotate(180deg)';
        }
    });
});




const fieldTranslations = {
    id: 'شناسه',
    name: 'نام',
    lastname: 'نام خانوادگی',
    store: 'مبدا',
    address: 'مقصد',
    case_number: 'شماره پرونده',
    special_load_description: 'توضیحات بار',
    postal_code: 'کد پستی',
    mobile: 'شماره تماس',
    load_type: 'نوع بار',
    estimate: 'تخمین',
    admin_estimate: 'تخمین نهایی',
    weight: 'وزن',
    phone_number: 'شماره تماس',
    status: 'وضعیت',
    created_at: 'تاریخ',
    is_bulk: 'حجیم',
    is_urgent: 'فوری'
};

$('#general-search').on('keyup', async function () {

    const query = $(this).val();

    if (query.trim() === '') {
        $('.search-container').hide();
    }

    if (query.length < 3) {

        $('.fast-estimate-heading .text-theme-default').text(0);
        $('#estimates-count').text(0);
        $('#case-count').text(0);

        $('.search-container').hide();
        $('#estimate-search-results tbody').empty();
        $('#estimate-headers').empty();
        $('#case-search-results tbody').empty();
        $('#case-headers').empty();
        return;
    }

    if (query.length >= 3) {
        $('.search-container').show();
    }

    const generalSearchRoute = window.generalSearchRoute;
    const url = generalSearchRoute.replace(':query', query);
    const baseUrl = window.location.origin;

    try {

        const response = await axios.get(url);
        const {load_details: loadDetails, estimates, load_details_count: loadDetailsCount, estimates_count: estimatesCount} = response.data;


        // Calculate and display total results
        const totalResults = (loadDetailsCount || 0) + (estimatesCount || 0);
        $('.fast-estimate-heading .text-theme-default').text(totalResults);

        // Each count
        $('#estimates-count').text(estimatesCount || 0);
        $('#case-count').text(loadDetailsCount || 0);

        // Manage LoadDetail table
        const $loadDetailsTableBody = $('#case-search-results tbody');
        const $loadDetailsHeaders = $('#case-headers');

        $loadDetailsTableBody.empty();
        $loadDetailsHeaders.empty();

    if (loadDetails.length > 0) {
        const headers = Object.keys(loadDetails[0]);
        headers.forEach(function (header) {
        const translatedHeader = fieldTranslations[header] || header;
        const th = `<th>${translatedHeader}</th>`;
        $loadDetailsHeaders.append(th);
    });

    let loadDetailCounter = 1;

    loadDetails.forEach(function (item) {
        let row = '<tr>';
        headers.forEach(function (header) {

            let cellContent = item[header] || '-';

            if (header === 'id')
                cellContent = loadDetailCounter++;

            if (header === 'is_urgent' && item[header] === '1') {
                cellContent = `<span class="badge badge-danger">فوری</span>`;
            }
            if (header === 'is_urgent' && item[header] === '0') {
                cellContent = `<span class="badge badge-primary">نرمال</span>`;
            }
            if (header === 'is_bulk' && item[header] === '1') {
                cellContent = `<span class="badge badge-danger">حجیم</span>`;
            }
            if (header === 'is_bulk' && item[header] === '0') {
                cellContent = `<span class="badge badge-primary">نرمال</span>`;
            }

            row += `<td><a href="${baseUrl}/admin/orders/${item.id}">${cellContent}</a></td>`;

        });
        row += '</tr>';
        $loadDetailsTableBody.append(row);
    });

    } else {
        $loadDetailsTableBody.append('<tr><td colspan="100%">نتیجه‌ای یافت نشد</td></tr>');
    }

    // Manage Estimate table
    const $estimateTableBody = $('#estimate-search-results tbody');
    const $estimateHeaders = $('#estimate-headers');

    $estimateTableBody.empty();
    $estimateHeaders.empty();

    if (estimates.length > 0) {
        const headers = Object.keys(estimates[0]);
        headers.forEach(function (header) {
        const translatedHeader = fieldTranslations[header] || header;
        const th = `<th>${translatedHeader}</th>`;
        $estimateHeaders.append(th);
    });

    let estimateCounter = 1;
    let estimateID = 0;

    estimates.forEach(function (item) {
        let row = '<tr>';
        headers.forEach(function (header) {

            let cellContent = item[header] || '-';

            if (header === 'id') {
                cellContent = estimateCounter++;
                estimateID = item[header];
            }

            // Check for is_urgent or is_bulk or status to display badges
            if (header === 'is_urgent' && item[header] === '1') {
                cellContent = `<span class="badge badge-danger">فوری</span>`;
            }
            if (header === 'is_urgent' && item[header] === '0') {
                cellContent = `<span class="badge badge-primary">نرمال</span>`;
            }
            if (header === 'is_bulk' && item[header] === '1') {
                cellContent = `<span class="badge badge-danger">حجیم</span>`;
            }
            if (header === 'is_bulk' && item[header] === '0') {
                cellContent = `<span class="badge badge-primary">نرمال</span>`;
            }
            if (header === 'status' && item[header] === '1') {
                cellContent = `<span class="badge badge-primary">تایید شده</span>`;
            }
            if (header === 'status' && item[header] === '0') {
                cellContent = `<span class="badge badge-warning">درحال بررسی</span>`;
            }
            if (header === 'status' && item[header] === '-1') {
                cellContent = `<span class="badge badge-danger">رد شده</span>`;
            }

            row += `<td><a href="${baseUrl}/admin/estimate/${estimateID}">${cellContent}</a></td>`;

        });
        row += '</tr>';
        $estimateTableBody.append(row);
    });

    } else {
        $estimateTableBody.append('<tr><td colspan="100%">نتیجه‌ای یافت نشد</td></tr>');
    }

    } catch (error) {
        console.error('Error fetching search results:', error);
    }
});

$('#search-close-button').click(function () {
   $('.search-container').hide();
});

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('input[required], textarea[required], select[required]').forEach(function (field) {

        field.addEventListener('invalid', function (e) {

            const fieldName = 'این فیلد';

            if (field.validity.valueMissing) {
                e.target.setCustomValidity(`${fieldName} باید تکمیل شود.`);
            } else if (field.validity.tooShort) {
                const minLength = field.getAttribute('minlength');
                e.target.setCustomValidity(`${fieldName} باید حداقل ${minLength} کاراکتر داشته باشد.`);
            } else if (field.validity.tooLong) {
                const maxLength = field.getAttribute('maxlength');
                e.target.setCustomValidity(`${fieldName} باید حداکثر ${maxLength} کاراکتر داشته باشد.`);
            } else if (field.validity.patternMismatch) {
                e.target.setCustomValidity('فرمت ورودی نامعتبر است.');
            } else {
                e.target.setCustomValidity('');
            }

        });

        field.addEventListener('input', function (e) {
            e.target.setCustomValidity('');
        });
    });
});

$('#volume-load-exist' + ' input[name="volume_load"]').on('change', function () {
    if ($(this).val() === 'yes')
        $('#volume-load').show()

    if ($(this).val() === 'no')
        $('#volume-load').hide()
})

handleSessionMessages();


document.addEventListener('DOMContentLoaded', function () {

    window.onload = function () {
        document.querySelectorAll("[data-isModal='true']").forEach(button => {
            button.disabled = false;
        });
    };

    $(document).on('click', '#costReviewBtn', function() {
        $('#costReviewModal').modal('toggle');
    });

    $(document).on('click', '#submitLoadBtn', function() {
        $('#addNewLoad').modal('toggle');
    });

    $(document).on('click', '#quickEstimateBtn', function() {
        $('#quickEstimate').modal('toggle');
    });

});
