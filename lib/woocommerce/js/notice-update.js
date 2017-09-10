/**
 * This script adds notice dismissal to the Monochrome Pro theme.
 *
 * @package Monochrome\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(document).on( 'click', '.monochrome-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
		url: ajaxurl,
		data: {
			action: 'monochrome_dismiss_woocommerce_notice'
		}
	});

});