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
    <h1>The Recipient</h1>
    <p>Hello <?php echo wp_get_current_user()->user_firstname; ?>. Who are you making your gift for?</p>
    <button onclick="step2(false);">Someone I know</button>
    <button onclick="step2(true);">Someone unknown</button>
</div>

<div class="step" id="step2a">
    <h1>The Recipient</h1>
    <p>Who are you making the gift for?</p>
    <p><label for="recipientName">Name:</label><input type="text" name="recipientName" id="recipientName"></p>
    <p><label for="recipientEmail">Email:</label><input type="email" name="recipientEmail" id="recipientEmail"></p>
    <button onclick="step3a();">Submit</button>
</div>

<div class="step" id="step2b">
    <h1>Choose a Recipient</h1>
    <p>Who will you make a gift for today?</p>
    <button onclick="step3b(true);">A local</button>
    <button onclick="step3b(false);">Someone from out of town</button>
</div>

<script>
var stranger = false;

jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-welcome.jpg');

    $('#step2').fadeIn();
});

function step2 (isStranger) {
    stranger = isStranger;
    if (stranger) {
        jQuery('#step1').slideDown(function () {
            jQuery('#step2a').slideUp();
        });
    } else {
        jQuery('#step1').slideDown(function () {
            jQuery('#step2b').slideUp();
        });
    }
}

function step3a () {
    if (jQuery('#recipientName').val().length > 0 && jQuery('#recipientEmail').val().length) {
        console.log(jQuery('#recipientEmail').val());
    }
}

function step3b (local) {
    if (local) {
        console.log('localbrighton@gifting.digital');
        // 31B*CBbd9YS69ElJ3slxSARx
    } else {
        console.log('outoftownbrighton@gifting.digital');
        // 9u@2W*hvZpZh!lilxkVDWPZ1
    }
}
</script>