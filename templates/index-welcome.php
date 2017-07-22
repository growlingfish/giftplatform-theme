<?php
/**
 * Index page template for users not yet logged in.
 *
 * @package giftplatform-theme
 * @author  Ben Bedwell
 * @license GPL-3.0+
 */

?>

<div class="head-logo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/white-icon-circle-text.png" />
</div>

<div class="step" id="step1">
    <h1>Welcome!</h1>
    <p>The GIFT Platform is a set of tools, including this website, that lets you send and receive 'gifts'.</p>
    <p>It is a service provided by the EU-funded GIFT project, which is investigating ways to combine digital content with real cultural artifacts - museum exhibits, historical sites, and so on - to provide new ways for visitors to engage with heritage.</p>
    <button id="step2_button">Continue</button>
</div>

<div class="step" id="step2">
    <h1>What is this website?</h1>
    <p>This website lets you make a gift for another user. The gifts are personal messages that you create for another user to experience when they have found particular exhibits in the museum.</p>
    <p>Using this website you choose the exhibit, create the gift, and send it to the lucky recipient.</p>
    <button id="step3_button">OK</button>
</div>

<div class="step" id="step3">
    <h1>Login</h1>
    <?php wp_login_form(); ?>
</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-welcome.jpg');

    $('#step1').fadeIn();

    $('#step2_button').on('click', function () {
        jQuery('#step1').slideToggle(function () {
            jQuery('#step2').slideToggle();
        });
    });

    $('#step3_button').on('click', function () {
        jQuery('#step2').slideToggle(function () {
            jQuery('#step3').slideToggle();
        });
    });
});
</script>