

function enableElementsByConfig(elements) {

    elements.forEach(element => {

        let selector = `#${element.id}`;

        if (element.isNormal) {
            $(selector).removeClass('disabled');
        }

        if (element.hasProperty) {
            $(selector).prop('disabled', false);
        }

    });

}
