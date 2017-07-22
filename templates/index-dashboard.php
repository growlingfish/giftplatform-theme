<?php
/**
 * Index page template for users not yet logged in.
 *
 * @package giftplatform-theme
 * @author  Ben Bedwell
 * @license GPL-3.0+
 */

$user = wp_get_current_user();

?>

<div class="head-logo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/white-icon-circle-text.png" />
</div>

<div class="step" id="step1">
    <h1>The Recipient</h1>
    <p>Hello <?php echo $user->user_firstname; ?>. Who are you making your gift for?</p>
    <button id="step2_button">Someone I know</button>
    <button id="step2_strange_button">Someone unknown</button>
</div>

<div class="step" id="step2a">
    <h1>The Recipient</h1>
    <p>Who are you making the gift for?</p>
    <p><label for="recipientName">Name:</label><input type="text" name="recipientName" id="recipientName"></p>
    <p><label for="recipientEmail">Email:</label><input type="email" name="recipientEmail" id="recipientEmail"></p>
    <button id="step3_button">Submit</button>
</div>

<div class="step" id="step2b">
    <h1>Choose a Recipient</h1>
    <p>Who will you make a gift for today?</p>
    <button id="step3_local_button">A local</button>
    <button id="step3_outoftown_button">Someone from out of town</button>
</div>

<script>
var stranger = false;

jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-welcome.jpg');

    $('#step1').fadeIn();

    $('#step2_button').on('click', function () {
        jQuery('#step1').slideToggle(function () {
            jQuery('#step2a').slideToggle();
        });
    });

    $('#step2_strange_button').on('click', function () {
        stranger = true;
        jQuery('#step1').slideToggle(function () {
            jQuery('#step2b').slideToggle();
        });
    });

    $('#step3_button').on('click', function () {
        if (jQuery('#recipientName').val().length > 0 && jQuery('#recipientEmail').val().length) {
            console.log(jQuery('#recipientEmail').val());
        }
    });

    $('#step3_local_button').on('click', function () {
        console.log('localbrighton@gifting.digital');
            // 31B*CBbd9YS69ElJ3slxSARx

    });

    $('#step3_outoftown_button').on('click', function () {
        console.log('outoftownbrighton@gifting.digital');
            // 9u@2W*hvZpZh!lilxkVDWPZ1
    });
});
</script>