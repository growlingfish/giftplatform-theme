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
    <p id="loginChoices">
        <button id="step3a_button">I have a Gift account</button>
        <button id="step4_button">I don't have an account</button>
    </p>
    <?php wp_login_form(); ?>
</div>

<div class="step" id="step4">
    <h1>Register</h1>
    <p class="login-username">
        <label for="register_user">Email Address</label>
        <input type="text" name="log" id="register_user" class="input" value="" size="20">
    </p>
    <p class="login-username">
        <label for="register_name">Name</label>
        <input type="text" name="name" id="register_name" class="input" value="" size="20">
    </p>
    <p class="login-password">
        <label for="register_pass">Password</label>
        <input type="password" name="pwd" id="register_pass" class="input" value="" size="20">
    </p>
    <p class="login-submit">
        <button id="register-submit" class="button button-primary">Register</button>
    </p>
</div>

<div class="preloader"></div>

<script>
var apiBase = "https://platform.gifting.digital/wp-json/gift/v1/";

jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-welcome.jpg');

    $('#step1').fadeIn();
    jQuery('#loginform').hide();

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

    $('#step3a_button').on('click', function () {
        jQuery('#loginform').slideToggle();
    });

    $('#step4_button').on('click', function () {
        jQuery('#step3').slideToggle(function () {
            jQuery('#step4').slideToggle();
        });
    });

    $('#register-submit').on('click', function () {
        jQuery('.preloader').show();
        var request = jQuery.ajax({
            dataType: "json",
            cache: false,
            url: apiBase + "new/sender/" + jQuery('#register_user').val() + "/" + jQuery('#register_name').val() + "/" + jQuery('#register_pass').val(),
            method: "GET"
        });
        request.done(function( data ) {
            if (data.success && typeof(data.new) != 'undefined' && data.new) {
                jQuery('#loginChoices').hide();
                jQuery('#loginform').show();
                jQuery('#step4').slideToggle(function () {
                    jQuery('#step3').slideToggle();
                });
            } else {
                console.log(data);
                setTimeout(function () {
                    window.location.replace("https://platform.gifting.digital");
                }, 3000);
            }
            jQuery('.preloader').fadeOut();
        });
        request.fail(function( jqXHR, textStatus ) {
            console.log( "Request failed: " + textStatus );
            setTimeout(function () {
                window.location.replace("https://platform.gifting.digital");
            }, 3000);
            jQuery('.preloader').fadeOut();
        });
    });
});
</script>