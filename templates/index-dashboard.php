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
    <input></input>
    <input></input>
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
        $('#step1').slideDown(function () {
            $('#step2a').slideUp();
        });
    } else {
        $('#step1').slideDown(function () {
            $('#step2b').slideUp();
        });
    }
}

function step3a () {
    // Check
}

function step3b (local) {
    // choose right recipient
}
</script>