<div class="head-logo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cropped-GIFT-white.png" />
</div>

<div class="step" id="step1">
    <h1>Sorry ...</h1>
    <p>The GIFT Platform is free-to-use but we require that users are authorised by the project team before they can add public content, such as a venue.</p>
    <p>For authorisation, please email benjamin.bedwell@nottingham.ac.uk, stating your GIFT account username (<?php $current_user = wp_get_current_user(); echo $current_user->user_login; ?>) and tell us about how you hope to use the GIFT tools.</p>
    <button onclick="window.history.back();">Back</button>
</div>

<div class="preloader"></div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#step1').fadeIn();
});
</script>