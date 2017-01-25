jQuery(function ($) {


    $('.mm_sow-stats-bars').waypoint(function (direction) {

        $(this).find('.mm_sow-stats-bar-content').each(function () {

            var dataperc = $(this).attr('data-perc');
            $(this).animate({ "width": dataperc + "%"}, dataperc * 20);

        });

    }, { offset: $.waypoints('viewportHeight') - 150,
        triggerOnce: true});


});