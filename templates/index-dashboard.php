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
    <div>
        <div class="profile">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/familiar.jpg" />
            <h2>Someone I know</h2>
            <button id="step2_button">Choose</button>
        </div>
        <div class="profile">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/stranger.jpg" />
            <h2>Someone unknown</h2>
            <button id="step2_strange_button">Choose</button>
        </div>
    </div>
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
    <div>
        <div class="profile">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/local.jpg" />
            <h2>A Local</h2>
            <button id="step3_local_button">Choose</button>
        </div>
        <div class="profile">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/outoftown.jpg" />
            <h2>From out of town</h2>
            <button id="step3_outoftown_button">Choose</button>
        </div>
    </div>
</div>

<div class="step" id="step3">
    <h1>Choose an Exhibit</h1>
    <p>Which museum exhibit would you like to include in your gift for <span class="receiverName">the receiver</span>?</p>
    <div>
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
            echo '<div class="exhibit">'
                .'<h2>'.$object->post_title.'</h2>'
			    .'<img src="'.get_the_post_thumbnail_url($object->ID, 'medium').'" />'
			    .'<div>'.wpautop($object->post_content).'</div>'
                .'<button class="step4_button" object="'.$object->ID.'" objectImage="'.get_the_post_thumbnail_url($object->ID, 'large').'">Choose</button>'
            .'</div>';
		}
	}
?>
    </div>
</div>

<div class="step" id="step4">
    <img class="exhibitImage" src="" />
    <h2>A New Name</h2>
    <p>If <em>you</em> could name this object what would you call it?</p>
    <p><label for="exhibitName">Name:</label><input type="text" name="exhibitName" id="exhibitName"></p>
    <button id="step5_button">Submit</button>
</div>

<div class="step" id="step5">
    <h2>Write Them a Card</h2>
    <p>The gift card will be the first thing <span class="receiverName">the receiver</span> sees, before they start unwrapping the gift.</p>
    <p><textarea name="giftcard" id="giftcard">Hey stranger - I wanted to give you ...</textarea></p>
    <button id="step6_button">Submit</button>
</div>

<div class="step" id="step6">
    <img class="exhibitImage" src="" />
    <h2>What is in your gift?</h2>
    <p>Write a message for <span class="receiverName">the receiver</span> about this part of their gift when they have found it in the museum.</p>
    <p><textarea name="payload" id="payload"></textarea></p>
    <button id="step7_button">Submit</button>
</div>

<div class="step" id="step7">
    <h2>Another?</h2>
    <p>This part of the gift has been sent to <span class="receiverName">the receiver</span>. Would you like to add another part to the gift?</p>
    <p>
        <button id="step8a_button">No, thanks</button>
        <button id="step8b_button">Yes!</button>
    </p>
</div>

<div class="step" id="step8a">
    <h2>Outro</h2>
    <p>Outro text</p>
    <button id="step9_button">Log out</button>
</div>

<div class="preloader"></div>

<script>
var stranger = false;
var apiBase = "https://gifting.digital/wp-json/gift/v1/";
var receiver;
var exhibit;
var exhibitName;
var giftcard;
var payload;

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
            jQuery('.preloader').show();
            var request = jQuery.ajax({
                dataType: "json",
                cache: false,
                url: apiBase + "validate/receiver/" + jQuery('#recipientEmail').val(),
                method: "GET"
            });
            request.done(function( data ) {
                if (data.success && typeof(data.exists) != 'undefined' && data.exists) {
                    receiver = data.exists;
                    jQuery('.receiverName').text(receiver.data.display_name);
                    jQuery('#step2a').slideToggle(function () {
                        jQuery('#step3').slideToggle();
                    });
                } else if (typeof(data.exists) != 'undefined' && !data.exists) {
                    console.log(data);
                    var setupRequest = jQuery.ajax({
                        dataType: "json",
                        cache: false,
                        url: apiBase + "new/receiver/" + jQuery('#recipientEmail').val() + "/" + jQuery('#recipientName').val() + "/" + "<?php echo $user->ID; ?>",
                        method: "GET"
                    });
                    setupRequest.done(function( data ) {
                        if (data.success && typeof(data.new) != 'undefined' && data.new) {
                            receiver = {
                                "data": {
                                    "ID": data.new.id,
                                    "user_email": jQuery('#recipientEmail').val(),
                                    "display_name": jQuery('#recipientName').val()
                                },
                                "ID": data.new.id
                            };
                            jQuery('.receiverName').text(receiver.data.display_name);
                            jQuery('#step2a').slideToggle(function () {
                                jQuery('#step3').slideToggle();
                            });
                        } else {
                            console.log(data);
                            setTimeout(function () {
                                window.location.replace("https://gifting.digital");
                            }, 3000);
                        }
                    });
                    setupRequest.fail(function( jqXHR, textStatus ) {
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
                jQuery('.preloader').fadeOut();
            });
            request.fail(function( jqXHR, textStatus ) {
                console.log( "Request failed: " + textStatus );
                setTimeout(function () {
                    window.location.replace("https://gifting.digital");
                }, 3000);
                jQuery('.preloader').fadeOut();
            });
        }
    });

    $('#step3_local_button').on('click', function () {
        jQuery('.preloader').show();
        var request = jQuery.ajax({
            dataType: "json",
            cache: false,
            url: apiBase + "validate/receiver/" + 'localbrighton@gifting.digital',
            method: "GET"
        });
        request.done(function( data ) {
            if (data.success && typeof(data.exists) != 'undefined' && data.exists) {
                receiver = data.exists;
                jQuery('.receiverName').text(receiver.data.display_name);
                jQuery('#step2b').slideToggle(function () {
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

    $('#step3_outoftown_button').on('click', function () {
        jQuery('.preloader').show();
        var request = jQuery.ajax({
            dataType: "json",
            cache: false,
            url: apiBase + "validate/receiver/" + 'outoftownbrighton@gifting.digital',
            method: "GET"
        });
        request.done(function( data ) {
            if (data.success && typeof(data.exists) != 'undefined' && data.exists) {
                receiver = data.exists;
                jQuery('.receiverName').text(receiver.data.display_name);
                jQuery('#step2b').slideToggle(function () {
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

    $('.step4_button').on('click', function () {
        exhibit = jQuery(this).attr('object');
        if (!stranger) {
            jQuery('#giftcard').text('Hey ' + receiver.data.display_name + ' - I wanted to give you ...');
        }
        jQuery('.exhibitImage').attr('src', jQuery(this).attr('objectImage'));
        jQuery('.head-logo').hide();
        jQuery('#step3').slideToggle(function () {
            jQuery('#step4').slideToggle();
        });
    });

    $('#step5_button').on('click', function () {
        if (jQuery('#exhibitName').val().length > 0 && jQuery('#exhibitName').val().length) {
            exhibitName = jQuery('#exhibitName').val();
            jQuery('.head-logo').show();
            jQuery('#step4').slideToggle(function () {
                jQuery('#step5').slideToggle();
            });
        }
    });

    $('#step6_button').on('click', function () {
        if (jQuery('#giftcard').val().length > 0 && jQuery('#giftcard').val().length) {
            giftcard = jQuery('#giftcard').val();
            jQuery('.head-logo').hide();
            jQuery('#step5').slideToggle(function () {
                jQuery('#step6').slideToggle();
            });
        }
    });

    $('#step7_button').on('click', function () {
        if (jQuery('#payload').val().length > 0 && jQuery('#payload').val().length) {
            payload = jQuery('#payload').val();
            jQuery('.head-logo').show();
            sendGift();
            jQuery('#step6').slideToggle(function () {
                jQuery('#step7').slideToggle();
            });
        }
    });

    $('#step8a_button').on('click', function () {
        jQuery('#step7').slideToggle(function () {
            jQuery('#step8a').slideToggle();
        });
    });

    $('#step8b_button').on('click', function () {
        exhibit = null;
        exhibitName = null;
        jQuery('#exhibitName').val('');
        giftcard = null;
        if (!stranger) {
            jQuery('#giftcard').text('Hey ' + receiver.data.display_name + ' - I wanted to give you ...');
        } else {
            jQuery('#giftcard').text('Hey stranger - I wanted to give you ...');
        }
        payload = null;
        jQuery('#payload').text('');

        jQuery('#step7').slideToggle(function () {
            jQuery('#step3').slideToggle();
        });
    });

    $('#step9_button').on('click', function () {
        window.location.replace("<?php echo wp_logout_url( home_url() ); ?>");
    });
    
    function sendGift () {
        jQuery('.preloader').show();
        var request = jQuery.ajax({
            dataType: "json",
            cache: false,
            url: apiBase + "new/gift/",
            method: "POST",
            data: {
                sender: "<?php echo $user->ID; ?>", 
                gift: JSON.stringify({ 
                    title: exhibitName,
                    receiver: receiver.data.user_email,
                    receiverName: receiver.data.display_name,
                    wraps: [
                        {
                            id: 0,
                            title: "<?php echo $user->display_name; ?>'s wrap for " + exhibitName,
                            challenges: [
                                {
                                    type: 'object',
                                    task: [exhibit]
                                }
                            ]
                        }
                    ],
                    payloads: [
                        {
                            id: 0,
                            title: "<?php echo $user->display_name; ?>'s payload for " + exhibitName,
                            content: payload
                        }
                    ],
                    giftcard: {
                        title: "<?php echo $user->display_name; ?>'s giftcard for " + exhibitName,
                        content: giftcard
                    }
                })
            }
        });
        request.done(function( data ) {
            jQuery('.preloader').fadeOut();
        });
        request.fail(function( jqXHR, textStatus ) {
            console.log( "Request failed: " + textStatus );
            jQuery('.preloader').fadeOut();
        });
    }
});
</script>