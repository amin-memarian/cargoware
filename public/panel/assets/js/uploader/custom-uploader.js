
export async function getConfig() {
    try {
        const response = await axios.get(window.configRoute);
        return response.data;
    } catch (error) {
        console.error('Error while loading configuration:', error);
        throw error;
    }
}

window.handleFileUpload = function ($fileInput, $preview, $hiddenInput, csrfToken, uploadRoute, isSubmitButtonDisabled = null) {
    $('.uploader-label').on('click', function () {
        if ($hiddenInput.val()) {
            showAlert('info', 'لطفا ابتدا فایل موجود را حذف کنید و بعد اقدام به بازگذاری کنید', 'آپلود فایل جدید');
            return;
        }
        $fileInput.click();
    });

    $fileInput.on('change', function (event) {

        const file = event.target.files[0];

        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            $preview.html(`
                <div style="position: relative;">
                    <img src="${e.target.result}" alt="Preview" class="uploader-preview-image">
                    <button class="delete-btn">&times;</button>
                </div>
            `);
        };
        reader.readAsDataURL(file);

        const uploadPath = window.uploadPath;
        const relatedType = window.relatedType;

        const formData = new FormData();
        formData.append('file', file);
        formData.append('uploadPath', uploadPath);
        formData.append('relatedType', relatedType);

        axios.post(uploadRoute, formData, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'multipart/form-data',
            },
        })
            .then((response) => {
                const imageId = response.data.data;
                $hiddenInput.val(imageId);
                console.log('Upload successful! Image ID:', imageId);

                $fileInput.val('');
                if (isSubmitButtonDisabled ) {
                    $(isSubmitButtonDisabled).removeClass('disabled');
                }
            })
            .catch((error) => {
                console.error('Upload error:', error);
            });
    });
};


window.handleImageDelete = function ($preview, $hiddenInput, $fileInput, csrfToken, deleteRoute) {
    $preview.on('click', '.delete-btn', function () {
        const imageId = $hiddenInput.val();
        if (!imageId) {
            alert('No image to delete.');
            return;
        }

        axios.delete(`${deleteRoute}/${imageId}`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        })
            .then((response) => {

                $preview.html('');
                $hiddenInput.val('');
                $fileInput.val('');
            })
            .catch((error) => {
                console.error('Delete error:', error);
            });
    });
};
