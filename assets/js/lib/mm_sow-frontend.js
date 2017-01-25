/**
 * Reviews JS
 */
if (typeof (jQuery) != 'undefined') {

    jQuery.noConflict(); // Reverts '$' variable back to other JS libraries

    (function ($) {
        "use strict";

        $(function () {


            var MM_SOW_Frontend = {

                init: function () {
                    this.output_custom_css();
                    this.carousel();
                    this.setup_parallax();
                    this.setup_ytp();
					this.smoothScrollTo();
					this.quickView();
                },

                output_custom_css: function () {

                    var custom_css = mm_sow_settings['custom_css'];
                    if (custom_css !== undefined && custom_css != '') {
                        custom_css = '<style type="text/css">' + custom_css + '</style>';
                        $('head').append(custom_css);
                    }
                },

                isMobile: function () {
                    "use strict";
                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                        return true;
                    }
                    return false;
                },

                vendor_prefix: function () {

                    var prefix;

                    function prefix() {
                        var styles = window.getComputedStyle(document.documentElement, '');
                        prefix = (Array.prototype.slice.call(styles).join('').match(/-(moz|webkit|ms)-/) || (styles.OLink === '' && ['', 'o']))[1];

                        return prefix;
                    }

                    prefix();

                    return prefix;
                },

                carousel: function () {

                    if ($().slick === undefined) {
                        return;
                    }
	
                    var carousel_elements = $('.mm_sow-carousel, .mm_sow-posts-carousel, .mm_sow-gallery-carousel, .mm_sow-testimonials-slider');

                    carousel_elements.each(function () {

                        var carousel_elem = $(this);

                        var arrows = carousel_elem.data('arrows') ? true : false;

                        var dots = carousel_elem.data('dots') ? true : false;

                        var autoplay = carousel_elem.data('autoplay') ? true : false;

                        var autoplay_speed = carousel_elem.data('autoplay_speed') || 3000;

                        var animation_speed = carousel_elem.data('animation_speed') || 300;

                        var fade = carousel_elem.data('fade') ? true : false;

                        var pause_on_hover = carousel_elem.data('pause_on_hover') ? true : false;

                        var display_columns = carousel_elem.data('display_columns') || 4;

                        var scroll_columns = carousel_elem.data('scroll_columns') || 4;

                        var gutter = carousel_elem.data('gutter') || 10;

                        var tablet_width = carousel_elem.data('tablet_width') || 800;

                        var tablet_display_columns = carousel_elem.data('tablet_display_columns') || 2;

                        var tablet_scroll_columns = carousel_elem.data('tablet_scroll_columns') || 2;

                        var mobile_width = carousel_elem.data('mobile_width') || 480;

                        var mobile_display_columns = carousel_elem.data('mobile_display_columns') || 1;

                        var mobile_scroll_columns = carousel_elem.data('mobile_scroll_columns') || 1;

                        carousel_elem.on('init', function(event, slick, direction){
							
							var to_equalize = $(this).find('.mm_sow-entry-text-wrap');
							
							var maxHeight = 0;
							to_equalize.each(function(){
								if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
							});

							to_equalize.height(maxHeight);
						});
						
						carousel_elem.slick({
                            arrows: arrows,
                            dots: dots,
                            infinite: true,
                            autoplay: autoplay,
                            autoplaySpeed: autoplay_speed,
                            speed: animation_speed,
                            fade: false,
                            pauseOnHover: pause_on_hover,
                            slidesToShow: display_columns,
                            slidesToScroll: scroll_columns,
                            responsive: [
                                {
                                    breakpoint: tablet_width,
                                    settings: {
                                        slidesToShow: tablet_display_columns,
                                        slidesToScroll: tablet_scroll_columns
                                    }
                                },
                                {
                                    breakpoint: mobile_width,
                                    settings: {
                                        slidesToShow: mobile_display_columns,
                                        slidesToScroll: mobile_scroll_columns
                                    }
                                }
                            ]
                        });
                    });
                },

                setup_parallax: function () {

                    var scroll = window.requestAnimationFrame ||
                        window.webkitRequestAnimationFrame ||
                        window.mozRequestAnimationFrame ||
                        window.msRequestAnimationFrame ||
                        window.oRequestAnimationFrame ||
                        function (callback) {
                            window.setTimeout(callback, 1000 / 600);
                        };

                    function init_parallax() {

                        if (MM_SOW_Frontend.isMobile() === false) {
                            var windowHeight = $(window).height();
                            $('.mm_sow-section-bg-parallax').each(function () {
                                var segment = $(this);
                                var elementHeight = segment.outerHeight(true);

                                /* Apply transform only when the element is in the viewport */
                                var boundingRect = segment[0].getBoundingClientRect();
                                if (boundingRect.bottom >= 0 && boundingRect.top <= windowHeight) {
                                    var distanceToCover = windowHeight + elementHeight;
                                    var pixelsMoved = windowHeight - boundingRect.top;
                                    var toTransform = 50; // only 50% of the image height is available for transforming
                                    var transformPercent = toTransform * Math.abs(pixelsMoved / distanceToCover);
                                    transformPercent = -transformPercent.toFixed(2); // not more than 2 decimal places for performance reasons

                                    segment.find('.mm_sow-parallax-bg').css('-' + MM_SOW_Frontend.vendor_prefix() + '-transform', 'translate3d(0px, ' + transformPercent + '%, 0px)');
                                }
                            });
                        }

                    }

                    if (this.isMobile() === false) {

                        // Call once to initialize parallax and then call on each scroll
                        scroll(init_parallax);
                        $(window).on('scroll', function () {
                            scroll(init_parallax);
                        });
                    }

                },

                setup_ytp: function () {

                    // Do not initialize YouTube backgrounds in mobile devices
                    if (this.isMobile() || $().mb_YTPlayer === undefined) {
                        return;
                    }

                    /* Video Backgrounds */
                    $('.mm_sow-section-bg-youtube').mb_YTPlayer({
                        startAt: 0,
                        showYTLogo: false,
                        showControls: false,
                        autoPlay: true,
                        mute: true,
                        containment: 'self'});


                },
				
				smoothScrollTo: function () {
					
					var $clickTrigger	= $('.mm_sow-pointer-down');
					
					$clickTrigger.on('click', function(event){
						
						event.preventDefault();
						
						var wpAdminBarH = 0;
						if( $("#wpadminbar").length ) { wpAdminBarH = $("#wpadminbar").height() }
						
						var $scrollto	= $(this).data("scrollto"),
							$target		= $('[data-anchor="'+ $scrollto +'"]');
					
						if( !$scrollto ||	!$($target).length ) return;
						
						
						var	$targetPos		= $($target).offset().top - (wpAdminBarH + 60);
						
						$('body,html').animate({
							scrollTop: $targetPos ,
							}, 500
						);
					
					});
				},
				
				quickView: function () {
					
					var ajaxurl = window.mm_sow_ajaxurl;
					
					$(document).on("click", "a.mm_sow-quick-view", function(e) {

						e.preventDefault();
						
						var aLink		= $(this),
							prod_ID		= aLink.attr("data-id"),
							WP_adminbar =  $("#wpadminbar").length ? $("#wpadminbar").height() : 0,
							aLink_offset = aLink.offset().top;
						
						// IF TO APPEND TO ITEM OR BODY (EXPANDER OR MODAL)
						var holder = "",
							toAdd = "";
						if( $(this).hasClass("expand") ){
							
							aLink.find(".mm_sow-loading").remove();
							aLink.prepend("<div class=\"mm_sow-loading\"><i class=\"fa fa-spinner fa-spin\"></i></div>");
							
							holder		= $(this).closest(".item");

							toAdd	= "<div class=\"mm_sow-qv-holder expander woocommerce\" id=\"mm_sow-qv-holder-"+prod_ID+"\"></div>";
							
							var existing_qv = holder.parent().find(".mm_sow-qv-holder");
							
							if( existing_qv.length ){
								existing_qv.fadeOut( 700, function() {
									$(this).remove();
								});
							}
							
							holder.after(toAdd);	
							
						}else{
							
							holder		= $("body");
							toAdd	= "<div class=\"mm_sow-qv-overlay\"><div class=\"mm_sow-qv-holder woocommerce\" id=\"mm_sow-qv-holder-"+prod_ID+"\"><div class=\"mm_sow-loading\"><i class=\"fa fa-spinner fa-spin\"></i><span>"+ mm_sow_settings.loading_qv + "</span></div></div></div>"
							holder.append( toAdd );
							
						}
						
						var	lang			= aLink.attr("data-lang");
						var	qv_holder		= $("#mm_sow-qv-holder-"+prod_ID+"");
						var qv_overlay		= $(".mm_sow-qv-overlay");
						var load_anim		= qv_holder.find(".mm_sow-loading");
						var load_anim_item	= aLink.find(".mm_sow-loading");
						var qv_img_format	= aLink.attr("data-qv_img_format");
						
						qv_overlay.fadeIn();
						
						// REMOVE IF CLICKED ON OVERLAY:
						qv_overlay.on("click", function(e) {

							if(e.target == this ) $(this).fadeOut("slow", function() { this.remove(); });

						});
						
						$.ajax({
						
							type: "POST",
							url: ajaxurl,
							data: { "action": "load-quick-view", productID: prod_ID, lang: lang, qv_img_format: qv_img_format  },
							success: function(response) {
								
								load_anim.fadeToggle(500);
								load_anim_item.fadeToggle(500);
								
								// fill with response from server:
								qv_holder.html(response);
								
								// -------- > REMOVING ACTIONS:
								// add QV window remover:
								qv_holder.append("<div class=\"mm_sow-remove fa fa-times \"></div>");
								// on remover click:	
								qv_holder.find(".mm_sow-remove").on("click", function(e) {
									
									// if EXPANDER:
									if( qv_holder.hasClass("expander") ) {
										
										qv_holder.fadeOut("slow", function() { 
											qv_holder.remove();
											$.waypoints("refresh");
											
											$("body,html").delay(200).animate(

												{scrollTop:aLink_offset - WP_adminbar - 30}, 1000, 'easeInOutQuint', function(){

													$(window).delay(200).trigger("resize");
													aLink_offset = "";
												}
											
											);
											
										});
									// if  MODAL:
									}else{
										qv_overlay.fadeOut("slow", function() { qv_overlay.remove(); });
									}
								
								});
								// end removing actions

								
							}, // end success
							error: function () {
								alert("Ajax fetching or transmitting data error");
							}
						});
				 
					});
					
				}
				
            }

            MM_SOW_Frontend.init();

        });

    }(jQuery));

}

(function( $ ) {
"use strict";
$(document).ready(function() {	
	
	var ajaxurl = window.mm_sow_ajaxurl;

	/**
	 *	MINI WISHLIST
	 *	- for AS themes only ( Larix )
	 */	
	$(document).on("click", "a.vc_ase_add_to_wishlist", function(e) {
		
		var	prod_ID		= $(this).attr("data-product-id");
		
		$.ajax({
		
			type: "POST",
			url: ajaxurl,
			data: { "action": "add_miniwishlist", productID: prod_ID },
			success: function(response) {
				
				var miniWishlist	= $(".mini-wishlist"),
					productExists 	= miniWishlist.find("a.mm_sow-quick-view").data("id");
				
					if( productExists == prod_ID ) return;
				
					miniWishlist.find(".wishlist-empty").remove();
					miniWishlist.append( response );
			}
		})
	
	});

}) // end (document).ready
})(window.jQuery);