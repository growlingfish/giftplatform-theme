<?php
/**
 * Index page template for project users.
 *
 * @package giftplatform-theme
 * @author  Ben Bedwell
 * @license GPL-3.0+
 */

?>

<div class="head-logo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cropped-GIFT-white.png" />
</div>

<div class="step" id="step1">
    <h1>Welcome back</h1>
    <p>What would you like to do?</p>
    <a href="https://toolkit.gifting.digital/" class="button">Take me to the GIFT Toolkit</a>
    <a href="https://gifting.digital/vis/" class="button">Take me to the Visualisation tool</a>
</div>

<div class="preloader"></div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#step1').fadeIn();
});
</script>