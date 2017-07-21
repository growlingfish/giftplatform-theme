<?php
/**
 * Index page template for users not yet logged in.
 *
 * @package giftplatform-theme
 * @author  Ben Bedwell
 * @license GPL-3.0+
 */

?>

<div class="center-logo">
    <a href="<php echo wp_login_url(); ?>">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/white-icon-circle-text.png" />
    </a>
</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-welcome.jpg');	
});
</script>