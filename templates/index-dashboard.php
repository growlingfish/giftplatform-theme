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

<div class="step" id="step3">
    <h1>Choose an Exhibit</h1>
    <p>Which museum exhibit would you like to include in your gift?</p>
<?php 
	$query = array(
		'numberposts'   => -1,
		'post_type'     => 'object',
		'post_status'   => 'publish'
	);
	$all_objects = get_posts( $query );
	foreach ($all_objects as $object) {
		$owner = get_field( 'field_5969c3853f8f2', $object->ID );
		if ($owner == null || $owner['ID'] == $user->ID) { // object belongs to no-one or this user
            echo '<div>'
                .'<h2>'.$object->post_title.'</h2>'
			    .'<img src="'.get_the_post_thumbnail_url($object->ID, 'medium').'" />'
			    .'<div>'.wpautop($object->post_content).'</div>'
            .'</div>';
		}
	}
?>
</div>

<script>
var stranger = false;
var apiBase = "https://gifting.digital/wp-json/gift/v1/";
var receiver;

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
            var request = jQuery.ajax({
                dataType: "json",
                cache: false,
                url: apiBase + "validate/receiver/" + jQuery('#recipientEmail').val(),
                method: "GET"
                //data: { name: "John", location: "Boston" }
            });
            request.done(function( data ) {
                if (data.success && typeof(data.exists) != 'undefined' && data.exists) {
                    receiver = data.exists;
                } else if (typeof(data.exists) != 'undefined' && !data.exists) {
                    console.log(data);
                    var request = jQuery.ajax({
                        dataType: "json",
                        cache: false,
                        url: apiBase + "new/receiver/" + jQuery('#recipientEmail').val() + "/" + jQuery('#recipientName').val() + "/" + "<?php echo $user->ID; ?>",
                        method: "GET"
                        //data: { name: "John", location: "Boston" }
                    });
                    request.done(function( data ) {
                        console.log(data);
                        /*if (data.success && typeof(data.exists) != 'undefined' && data.exists) {
                            receiver = data.exists;
                        } else if (typeof(data.exists) != 'undefined' && !data.exists) {
                            console.log(data);
                            //this.http.get(this.globalVar.getSetupReceiverURL(email, name, this.auth.currentUser.id))
                            
                        } else {
                            console.log(data);
                            setTimeout(function () {
                                window.location.replace("https://gifting.digital");
                            }, 3000);
                        }*/
                    });
                    request.fail(function( jqXHR, textStatus ) {
                        console.log( "Request failed: " + textStatus );
                        setTimeout(function () {
                            window.location.replace("https://gifting.digital");
                        }, 3000);
                    });
                } else {
                    console.log(data);
                    setTimeout(function () {
                        window.location.replace("https://gifting.digital");
                    }, 3000);
                }
            });
            request.fail(function( jqXHR, textStatus ) {
                console.log( "Request failed: " + textStatus );
                setTimeout(function () {
                    window.location.replace("https://gifting.digital");
                }, 3000);
            });
        }
    });

    $('#step3_local_button').on('click', function () {
        var request = jQuery.ajax({
            dataType: "json",
            cache: false,
            url: apiBase + "validate/receiver/" + 'localbrighton@gifting.digital',
            method: "GET"
            //data: { name: "John", location: "Boston" }
        });
        request.done(function( data ) {
            if (data.success && typeof(data.exists) != 'undefined' && data.exists) {
                receiver = data.exists;
            } else {
                console.log(data);
                setTimeout(function () {
                    window.location.replace("https://gifting.digital");
                }, 3000);
            }
        });
        request.fail(function( jqXHR, textStatus ) {
            console.log( "Request failed: " + textStatus );
            setTimeout(function () {
                window.location.replace("https://gifting.digital");
            }, 3000);
        });
    });

    $('#step3_outoftown_button').on('click', function () {
        var request = jQuery.ajax({
            dataType: "json",
            cache: false,
            url: apiBase + "validate/receiver/" + 'outoftownbrighton@gifting.digital',
            method: "GET"
            //data: { name: "John", location: "Boston" }
        });
        request.done(function( data ) {
            if (data.success && typeof(data.exists) != 'undefined' && data.exists) {
                receiver = data.exists;
            } else {
                console.log(data);
                setTimeout(function () {
                    window.location.replace("https://gifting.digital");
                }, 3000);
            }
        });
        request.fail(function( jqXHR, textStatus ) {
            console.log( "Request failed: " + textStatus );
            setTimeout(function () {
                window.location.replace("https://gifting.digital");
            }, 3000);
        });
    });
});
</script>