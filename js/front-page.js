/**
 * This script adds the jquery effects to the front page of the Monochrome Pro Theme.
 *
 * @package Monochrome\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

// Fadeup effect for front page sections.
(function( $ ) {

	$(document).ready(function() {

		$( 'div[class^="front-page-"] a[href*="#"]:not([href="#"])' ).click(function() {

			if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {

				var target = $(this.hash);
				target = target.length ? target : $( '[name=' + this.hash.slice(1) + ']' );

				if (target.length) {

					$( 'html,body' ).animate({
						scrollTop: target.offset().top
					}, 1000);

					return false;

				}
			}

		});

		// Run 0.25 seconds after document ready for any instances viewable on load.
		setTimeout(function() {
			animateObject();
		}, 250);

	});

	$(window).scroll(function() {

		// Run on scroll.
		animateObject();

	});

	function animateObject() {

		// Define object via class.
		var object = $( '.fadeup-effect' );

		// Loop through each object in the array.
		$.each(object, function() {

			var windowHeight = $(window).height(),
				offset = $(this).offset().top,
				top = offset - $(document).scrollTop(),
				percent = Math.floor(top / windowHeight * 100);


			if (percent < 80) {

				$(this).addClass( 'fadeInUp' );

			}

		});

	}

})( jQuery );
