jQuery(function ($) {

    $('.mm_sow-testimonials-slider').each(function () {

        var slider_elem = $(this);

        var slideshow_speed = slider_elem.data('slideshow_speed') || 5000;

        var animation_speed = slider_elem.data('animation_speed') || 600;

        var pause_on_action = slider_elem.data('pause_on_action') ? true : false;

        var pause_on_hover = slider_elem.data('pause_on_hover') ? true : false;

        var direction_nav = slider_elem.data('direction_nav') ? true : false;

        var control_nav = slider_elem.data('control_nav') ? true : false;


        slider_elem.flexslider({
            selector: ".mm_sow-slides > .mm_sow-slide",
            animation: "slide",
            slideshowSpeed: slideshow_speed,
            animationSpeed: animation_speed,
            namespace: "mm_sow-flex-",
            pauseOnAction: pause_on_action,
            pauseOnHover: pause_on_hover,
            controlNav: control_nav,
            directionNav: direction_nav,
            prevText: "Previous<span></span>",
            nextText: "Next<span></span>",
            smoothHeight: false,
            animationLoop: true,
            slideshow: true,
            easing: "swing",
            controlsContainer: "mm_sow-testimonials-slider"});

    });

});