"use strict";
setTimeout(function(){
        (function($) {
            "use strict";
            // Single Search Select

            $(".js-example-basic-single").select2({
                placeholder: "انتخاب مقصد",
            });
            $(".js-example-disabled-results").select2();

            // Multi Select
            $(".js-example-basic-multiple").select2();

            // With Placeholder
            $(".js-example-placeholder-multiple").select2({
                placeholder: "انتخاب کنید"
            });

            //Limited Numbers
            $(".js-example-basic-multiple-limit").select2({
                maximumSelectionLength: 2
            });

            $(".multiple-limit").select2({
                maximumSelectionLength: 1,
                placeholder: "انتخاب مبدا",
                allowClear: true
            });

            //RTL Suppoort
            $(".js-example-ltr").select2({
                dir: "ltr"
            });
            // Responsive width Search Select
            $(".js-example-basic-hide-search").select2({
                minimumResultsForSearch: Infinity
            });
            $(".js-example-disabled").select2({
                disabled: true
            });
            $(".js-programmatic-enable").on("click", function() {
                $(".js-example-disabled").prop("disabled", false);
            });
            $(".js-programmatic-disable").on("click", function() {
                $(".js-example-disabled").prop("disabled", true);
            });
        })(jQuery);
    }
    ,350);
