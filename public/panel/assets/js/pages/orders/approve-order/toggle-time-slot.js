$(document).ready(function () {

    $(".time-slot").on("click", function () {

        let isSelected = $(this).hasClass("selected");

        if (isSelected) {
            $(".time-slot").removeClass("selected");
        } else {
            $(".time-slot").not('.from-server').removeClass("selected");
            $(this).addClass("selected");
        }

    });

});
