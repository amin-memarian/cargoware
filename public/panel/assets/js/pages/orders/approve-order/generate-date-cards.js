function generateDateCardsByTimestamp(timestamp, vehicleTypeId) {
    axios.get(daysFromSpecificDateRoute, {
        params: {
            timestamp: timestamp,
            vehicle_type_id: vehicleTypeId
        }
    })
        .then(function (response) {

            const agentsData = response.data;
            let dateHtml = '';


            if (agentsData.length === 0) {


                dateHtml = `<div id="collectionAgentTypeMessageContainerQuickEstimate" class="col-12 py-3 px-3 mt-3"
                     style="border: 2px solid red;border-radius: 14px;display: none">
                            <span class="justify-content-center align-content-center text-danger">
                                <i data-feather="alert-triangle" class="fs-3"></i>
                                <b id="" class="ms-2 fs-3">مأمور جمع‌آوری</b>
                            </span>
                    <h6 id="collectionAgentTypeMessage" class="mt-3">
                        برای این نوع ماشین مأمور جمع‌آوری وجود ندارد
                    </h6>
                </div>`;

            } else {

                let indexCounter = 0;

                agentsData.forEach(function (agentData) {
                    dateHtml += `<h4>${agentData.agent_name}</h4>
                                <div class="row d-flex justify-content-between">`;



                    agentData.dates.forEach(function (date) {

                        dateHtml += `
                        <div class="col day-card" data-index="${indexCounter}" data-agent-id="${agentData.agent_id}"
                            data-shamsi="${date.shamsi}" data-gregorian="${date.gregorian}"
                            data-timestamp="${date.timestamp}" data-pickup-start-time="${date.pickupStartTime}"
                            data-pickup-end-time="${date.pickupEndTime}">
                            <span>${date.shamsi.split('/')[2]}</span>
                            <p>${convertToDayOfWeek(date.shamsi)}</p>
                        </div>
                    `;
                        indexCounter++;

                    });

                    dateHtml += `</div></div>`;
                });
            }


            $('.estimate_timeline_days').html(dateHtml);

        })
        .catch(function (error) {
            console.error('خطا در ارسال تاریخ:', error);
        });
}

