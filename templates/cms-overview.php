<div class="head-logo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cropped-GIFT-white.png" />
</div>

<div class="step" id="step1">
    <h1>Overview</h1>
    <p>Welcome back, <?php $current_user = wp_get_current_user(); echo $current_user->display_name; ?>.</p>
    <a href="https://gifting.digital/venues/" class="button">Show me my venues</a>
    <button onclick="window.history.back();">Back</button>
</div>

<div class="preloader"></div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#step1').fadeIn();
});
</script>