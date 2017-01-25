jQuery(function ($) {

    $('.mm_sow-odometers').waypoint(function (direction) {

        $(this).find('.mm_sow-odometer .mm_sow-number').each(function () {

            var odometer = $(this);

            setTimeout(function () {
                var data_stop = odometer.attr('data-stop');
                $(odometer).text(data_stop);

            }, 100);


        });

    }, { offset: $.waypoints('viewportHeight') - 100,
        triggerOnce: true});


});