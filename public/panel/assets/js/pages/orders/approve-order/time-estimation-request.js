

$(document).ready(function () {

    $('.timeEstimationButton').on('click', function () {

        let loadType = $('#flexSwitchCheckDefault').is(':checked') ? 'normal' : 'special';
        let bulkyLoad = $('input[name="bulky_load"]:checked').val();
        let packaging = $('input[name="packing"]:checked').val();
        let elevator = $('#elevatorCheckBox').is(':checked') ? '1' : '0';
        let floorsCount = 0;
        let has_floor = false;
        if (elevator === '0') {
            floorsCount = $('#floorsCount').val();
            has_floor = true;
        } else {
            has_floor = false;
        }

        axios.get(timeEstimationRoute, {
            params: {
                estimate_id: estimateId,
                load_type: loadType,
                bulky_load: bulkyLoad,
                packaging: packaging,
                has_floor: has_floor,
                floors_count: floorsCount,
                elevator: elevator
            }
        })
            .then(function (response) {
                if (response.data.status === 200) {

                    $('#timeEstimationText').text(response.data.data.hour);
                    $('#timeEstimationInput').val(response.data.data.hour);

                } else {

                    if (response.data.data.error) {

                        $('#estimate-next-789').addClass('disabled');
                        $('#estimateAlert').show();
                        $('#estimateAlertMessage').text(response.data.data.error);

                    } else
                        showAlert('failed', 'خطایی هنگام ثبت اطلاعات رخ داد، لطفاً دوباره تلاش کنید', 'ثبت ناموفق');
                }
            })
            .catch(function () {

                showAlert('failed', 'خطایی هنگام ثبت اطلاعات رخ داد، لطفاً دوباره تلاش کنید', 'ثبت ناموفق');
            });

    });

})
