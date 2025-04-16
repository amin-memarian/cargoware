
$(document).ready(function() {
    function updateActiveTabs() {
        $('.estimate_process .nav-item a div').css('background', '#D9D9D9');
        let activeTab = $('.nav-item a.active');
        let activeIndex = $('.nav-item').index(activeTab.closest('.nav-item'));

        $('.nav-item').each(function(index) {
            if (index <= activeIndex) {
                $(this).find('a div').css('background', '#FFAC5E');
            }
        });
    }
    $('#estimateTabs a').on('shown.bs.tab', function() {
        updateActiveTabs();
    });
    updateActiveTabs();
});
