if (typeof (jQuery) != 'undefined') {

    jQuery.noConflict(); // Reverts '$' variable back to other JS libraries

    (function ($) {
        
		"use strict";

		$(document).ready(function() {
			
			var $cont			= $('.cont');
			//var $slide			= $('.slide');
			//var $closeBtn		= $('.slide__close')
			//var $slide_title	= $('.slide__title');
			// var $detailsDiv		= $('.slide__postcontent-wrap');
			//var numSlides 		= $cont.data('numslides');
			var initialAnimDur	= 1500;
			var animDelay		= 500;
			var initialAnim		= true;
			//var clickAnim		= false;
			
			
			// MOUSE OVER THE SINGLE SLIDE
			function hoverSlide( $this, numSlides, container ) {
				
				if( initialAnim || container.data("clickAnim") ) return;
				
				var _this	= $( $this ), 				// hovered element 'slide'
					target	= +_this.attr('data-target'),
					$siblings	= _this.siblings(),
					$allSlides	= _this.parent().children();
				
				
				
				// THIS SLIDE and it's TITLE, OVERLAY, IMAGE
				_this.css({
					'transform'	: 'translate3d(-' + (((100 / numSlides) * (numSlides - (target - 1))) + 5) + '%, 0, 0)',
					'-webkit-transform'	: 'translate3d(-' + (((100 / numSlides) * (numSlides - (target - 1))) + 5) + '%, 0, 0)',
					'transition': '750ms',
					'-webkit-transition': '750ms'
				})
				
				_this.find('.slide__title').css({
					'transform': 'translate3d(0, -40%, 0) rotate(0.01deg)',
					'-webkit-transform': 'translate3d(0, -40%, 0) rotate(0.01deg)',
					'opacity': '1',
					'transition': '750ms',
					'-webkit-transition': '750ms'
				})
				_this.find('.slide__bg-dark').css({
					'opacity'	: '1',
					'transition': '750ms',
					'-webkit-transition': '750ms'
				})
				
				_this.find('.slide__img-wrapper').css({
					'transform': 'translate3d(-'+ 100/numSlides +'%, 0, 0) scale(1.2, 1.2)',
					'-webkit-transform': 'translate3d(-'+ 100/numSlides +'%, 0, 0) scale(1.2, 1.2)',
					'transition': '750ms',
					'-webkit-transition': '750ms'
				})
				
				// ALL SLIDES
				for(var i = target, length = $allSlides.length; i < length; i++) {
					_this.parent().find('.slide--' + (i + 1)).css({
						'transform': 'translate3d(-' + (((100 / numSlides) * (numSlides - ((i + 1) - 1))) - 5) + '%, 0, 0)',
						'-webkit-transform': 'translate3d(-' + (((100 / numSlides) * (numSlides - ((i + 1) - 1))) - 5) + '%, 0, 0)',
						'transition': '750ms'
					})
					
				}
				 
				for(var i = target; i > 1; i--) {
					_this.parent().find('.slide--' + (i - 1)).css({
						'transform': 'translate3d(-' + (((100 / numSlides) * (numSlides - ((i - 1) - 1))) + 5) + '%, 0, 0)',
						'-webkit-transform': 'translate3d(-' + (((100 / numSlides) * (numSlides - ((i - 1) - 1))) + 5) + '%, 0, 0)',
						'transition': '750ms',
						'-webkit-transition': '750ms'
					})
					
				}
				
				
				// OTHER SLIDES (siblings) IMAGE AND OVERLAY
				$siblings.not(_this).find('.slide__img-wrapper').css({
					'transform': 'translate3d(-'+ 100/numSlides +'%, 0, 0) scale(1.05, .1.05)',
					'-webkit-transform': 'translate3d(-'+ 100/numSlides +'%, 0, 0) scale(1.05, .1.05)',
					'transition': '1000ms',
					'-webkit-transition': '1000ms'
				})
				
				$siblings.not(_this).find('.slide__bg-dark').css({
					'opacity': '0.3'
				})
				
			}
			// end on mouseover
			
			// MOUSE LEAVE THE SLIDE - RESET ALL			
			function mouseLeaveSlide( $this, numSlides, container ) {
				
				if(initialAnim || container.data("clickAnim")) return;
				
				var _this = $( $this ),
					target = +_this.attr('data-target'),
					$slide	= _this.parent().children();
				
				for(var i = 1, length = $slide.length; i <= length; i++) {
					_this.parent().find('.slide--' + i).css({
						'transform': 'translate3d(-' + (100 / numSlides) * (numSlides - (i - 1)) + '%, 0, 0)',
						'-webkit-transform': 'translate3d(-' + (100 / numSlides) * (numSlides - (i - 1)) + '%, 0, 0)',
						'transition': '1000ms',
						'-webkit-transition': '1000ms'
					})
				}
				
				$slide.find('.slide__img-wrapper').css({
					//'transform': 'translate3d(-'+ (50 - ((100/numSlides)/2)) +'% , 0, 0) scale(1, 1)',
					'transform': 'translate3d(-'+ (50 - (100/(numSlides*2))) +'% , 0, 0) scale(1, 1)',
					'-webkit-transform': 'translate3d(-'+ (50 - (100/(numSlides*2))) +'% , 0, 0) scale(1, 1)',
					'transition': '750ms',
					'-webkit-transition': '750ms'
				})
				
				$slide.find('.slide__bg-dark').css({
					'opacity': '0'
				})
				
				$slide.find('.slide__title').css({
					'transform': 'translate3d(0, -50%, 0) rotate(0.01deg)',
					'-webkit-transform': 'translate3d(0, -50%, 0) rotate(0.01deg)',
					'opacity': '0',
					'transition': '200ms',
					'-webkit-transition': '200ms'
				})

			}
			
			
			
			
			// MOUSE CLICK ON SLIDE TO REVEAL
			function revealSlide ( $this, container ) {
				
				if (initialAnim || container.data("clickAnim")) return;
				
				var _this = $( $this ).parent(),
					target = +_this.attr('data-target'),
					$siblings	= _this.siblings(),
					$allSlides	= _this.parent().children(),
					$detailsDiv	= _this.find('.slide__postcontent-wrap'),
					$closeBtn	= _this.find('.slide__close');
				
				//clickAnim = true;
				container.data("clickAnim",true);
				
				_this.addClass("active-slide");
				
				_this.css({
					'transform': 'translate3d(-100%, 0, 0)',
					'-webkit-transform': 'translate3d(-100%, 0, 0)',
					'transition': '750ms',
					'-webkit-transition': '750ms',
					'cursor': 'default'
				})
				
				_this.find('.slide__img-wrapper').css({
					'transform': 'translate3d(0, 0, 0) scale(1.02, 1.02)',
					'-webkit-transform': 'translate3d(0, 0, 0) scale(1.02, 1.02)',
					'transition': '1000ms',
					'-webkit-transition': '1000ms',
					'-webkit-transition': '1000ms'
				})
				
				_this.find('.slide__bg-dark').css({
					'opacity'	: '0.75',
					'transition': '750ms',
					'-webkit-transition': '750ms'
				})
				
				_this.find('.slide__title').css({
					'transform': 'translate3d(30%, -40%, 0)',
					'-webkit-transform': 'translate3d(150px, -40%, 0)',
					'opacity': '1',
					'transition': '2000ms',
					'-webkit-transition': '2000ms'
				})
				
				for(var i = target, length = $allSlides.length; i < length; i++) {
					_this.parent().find('.slide--' + (i + 1)).css({
						'transform': 'translate3d(0, 0, 0)',
						'-webkit-transform': 'translate3d(0, 0, 0)',
						'transition': '750ms',
						'-webkit-transition': '750ms'
					})
				}
				
				for(var i = target, length = $allSlides.length; i > 1; i--) {
					_this.parent().find('.slide--' + (i - 1)).css({
						'transform': 'translate3d(-125%, 0, 0)',
						'-webkit-transform': 'translate3d(-125%, 0, 0)',
						'transition': '750ms',
						'-webkit-transition': '750ms'
					})
				}
				
				setTimeout(function() {
					$siblings.find('.slide__bg-dark').css({
						'opacity': '0'
					})
					$siblings.find('.slide__img-wrapper').css({
						'transform': 'translate3d(-100%, 0, 0)',
						'-webkit-transform': 'translate3d(-100%, 0, 0)',
						'transition': '750ms',
						'-webkit-transition': '750ms'
					})
					
				}, 500)
				
				$closeBtn.addClass('show-close');
				$detailsDiv.addClass('details-show');

				
			}
			// end on click reveal slide
			

			
			// MOUSE CLICK TO RESET SLIDES
			function clickCloseSlide( $this, numSlides, container ) {
				
				setTimeout(function() {
					container.data("clickAnim",false);
				}, 1000);
				
				var $closedSlide	= $( $this ).parent().parent(),
					$slidesCont		= $closedSlide.parent(),
					$allSlides		= $slidesCont.children(),
					$detailsDiv		= $closedSlide.find('.slide__postcontent-wrap'),
					$closeBtn		= $closedSlide.find('.slide__close');
				
				$closedSlide.find('.slide__img-wrapper').css({
					'transform': 'translate3d(-'+ (50 - (100/(numSlides*2))) +'% , 0, 0) scale(1, 1)',
					'-webkit-transform': 'translate3d(-'+ (50 - (100/(numSlides*2))) +'% , 0, 0) scale(1, 1)',
					'transition': '750ms',
					'-webkit-transition': '750ms'
				})
				
				$closedSlide.removeClass("active-slide");
				
				$closeBtn.removeClass('show-close');
				$detailsDiv.removeClass('details-show');
				
				for(var i = 1, length = $allSlides.length; i <= length; i++) {
					$slidesCont.find('.slide--' + i).css({
						'transform': 'translate3d(-' + (100 / numSlides) * (numSlides - (i - 1)) + '%, 0, 0)',
						'-webkit-transform': 'translate3d(-' + (100 / numSlides) * (numSlides - (i - 1)) + '%, 0, 0)',
						'transition': '1000ms',
						'-webkit-transition': '1000ms',
						'cursor': 'pointer'
					})
				}
				
				$slidesCont.find('.slide__img-wrapper').css({
					'transform': 'translate3d( -' + (50 - ((100 / numSlides) /2)) +'%, 0, 0 )',
					'-webkit-transform': 'translate3d( -' + (50 - ((100 / numSlides) /2)) +'%, 0, 0 )',
					'transition': '750ms',
					'-webkit-transition': '750ms'
				})
				
				$slidesCont.find('.slide__title').css({
					'transform': 'translate3d(150px, -40%, 0)',
					'-webkit-transform': 'translate3d(150px, -40%, 0)',
					'opacity': '0',
					'transition': '200ms',
					'-webkit-transition': '200ms'
				})
				
				$slidesCont.find('.slide__bg-dark').css({
					'opacity': '0'
				})
				/*  
				setTimeout(function() {
					$slidesCont.find('.slide__title').css({
						'transform': 'translate3d(0, -50%, 0)'
					})
				}, 200)
				*/
			}
			
			
			setTimeout(function() {
				$cont.addClass('active');
			}, animDelay);
			
			setTimeout(function() {
				initialAnim = false;
			}, initialAnimDur + animDelay);
			
			 $cont.each( function(){
				 var $_cont		= $(this),
					numSlides	= $_cont.data('numslides'),
					$slide		= $_cont.find('.slide'),
					$slideOver	= $slide.find('.slide__bg-dark'),
					$slideClose	= $slide.find('.slide__close');
					
					$_cont.attr("data-clickAnim", false);
					
					$slide.on('mousemove', function() { hoverSlide( $(this), numSlides, $_cont ); });
					$slide.on('mouseleave', function() { mouseLeaveSlide( $(this), numSlides, $_cont ); });
					$slideOver.on('click', function() { revealSlide( $(this), $_cont ); } );
					$slideClose.on('click', function() { clickCloseSlide( $(this), numSlides, $_cont ); });
					
			 } );
			
			
		});

	}(jQuery));

}