

function handleDeleteRequest(modalId, modalButton, submitButton, tableName, successMessage = 'حذف با موفقیت انجام شد', errorMessage = 'حذف با موفقیت انچام نشد') {

    let routeUrl = '';

    // Show the modal when the corresponding button is clicked
    $(document).on('click', modalButton, function () {
        routeUrl = $(this).data('delete-route');
        $(modalId).modal('show');
    });

    // When the submit button in the modal is clicked
    $(document).on('click', submitButton, function () {

        axios.delete(routeUrl)
            .then(function (response) {
                if (response.data.status === 200) {

                    // Hide the modal after successful deletion
                    $(modalId).modal('hide');

                    showAlert('success', response.data.message || successMessage, 'حذف موفق');

                    // Reload the DataTable
                    $(tableName).DataTable().ajax.reload(null, false);

                } else {

                    // Hide the modal and show error message if deletion failed
                    $(modalId).modal('hide');

                    showAlert('failed', errorMessage, 'حذف ناموفق');

                }
            })
            .catch(function () {

                // Hide the modal and show error message if there is a server error
                $(modalId).modal('hide');
                showAlert('failed', errorMessage, 'حذف ناموفق');

            });
    });

}



