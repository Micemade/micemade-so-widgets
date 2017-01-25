jQuery(function ($) {

    if ($().isotope === undefined) {
        return;
    }

    $('.mm_sow-portfolio-wrap').each(function () {

        // layout Isotope after all images have loaded
        var html_content = $(this).find('.js-isotope');
        html_content.imagesLoaded(function () {
            html_content.isotope('layout');
        });

        var container = $(this).find('.mm_sow-portfolio');
        if (container.length === 0) {
            return; // no items to filter or load and hence don't continue
        }

        /* -------------- Taxonomy Filter --------------- */

        $(this).find('.mm_sow-taxonomy-filter .mm_sow-filter-item a').on('click', function (e) {
            e.preventDefault();

            var selector = $(this).attr('data-value');
            container.isotope({filter: selector});
            $(this).closest('.mm_sow-taxonomy-filter').children().removeClass('mm_sow-active');
            $(this).closest('.mm_sow-filter-item').addClass('mm_sow-active');
            return false;
        });
    });

});