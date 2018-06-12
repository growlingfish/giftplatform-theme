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
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cropped-GIFT-white.png" />
</div>

<div class="step" id="step1">
    <h1>Welcome!</h1>
    <p>This website is part of a set of tools that helps museums and other cultural heritage venues to create new visitor experiences based on sending and receiving 'gifts'.</p>
    <p>It is a service provided by the EU-funded <a href="https://gift.itu.dk/" target="_blank">GIFT project</a>, which is investigating ways to combine digital content with real cultural artifacts to provide new ways for visitors to engage with heritage.</p>
    <button id="step2_button">Continue</button>
</div>

<div class="step" id="step2">
    <h1>What would you like to do?</h1>
    <p>We offer a <strong>broad kit of tools</strong> for cultural heritage venues and a <strong>platform</strong>for developers who make apps for those venues. We are currently developing a framework that documents these resources.</p>
    <a href="https://toolkit.gifting.digital/" class="button">Take me to the GIFT framework</a>
    <a href="https://gift.itu.dk/" class="button">Take me to the GIFT project website</a>
    <p style="padding-top: 20px; font-size: 1.5rem;"><a href="#" id="step3_button">I'm a member of the GIFT Project</a></p>
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
var apiBase = "https://gifting.digital/wp-json/gift/v3/";

jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#step1').fadeIn();
    jQuery('#loginform').hide();

    $('#step2_button').on('click', function () {
        jQuery('#step1').slideToggle(function () {
            jQuery('#step2').slideToggle();
        });
    });

    $('#step3_button').on('click', function (e) {
        e.preventDefault();
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
                    window.location.replace("https://gifting.digital");
                }, 3000);
            }
            jQuery('.preloader').fadeOut();
        });
        request.fail(function( jqXHR, textStatus ) {
            console.log( "Request failed: " + textStatus );
            setTimeout(function () {
                window.location.replace("https://gifting.digital");
            }, 3000);
            jQuery('.preloader').fadeOut();
        });
    });
});
</script>