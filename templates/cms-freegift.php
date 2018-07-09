<div class="head-logo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cropped-GIFT-white.png" />
</div>

<script src="https://unpkg.com/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>

<div class="step" id="step1">
    <h1>CMS: Add a free Gift</h1>
    <p>"Free Gifts" are gift experiences from the venue to each visitor (unlike gifts from visitor to visitor). In the <a href="https://toolkit.gifting.digital/framework-pages/gift-exchange-app/" target="_blank">Gift Exchange</a> app, your free gift is offered to each user when they select your particular venue: in this way, the free gift is a useful introduction to the venue and tends to frame the way the users will make their own gifts subsequently.</p>
    <p>If you would like to set up a free gift for your venue, fill out the form below.</p>
</div>

<?php
    $all_objects = get_posts( array(
        'posts_per_page'   => -1,
        'post_type'     => 'object',
        'post_status'   => 'publish'
    ) );
    $our_objects = array();
    global $current_user;
	foreach ($all_objects as $object) {
		$location = get_field( 'field_59a85fff4be5a', $object->ID);
		if ($location && count($location) == 1) { // does object have a location?
            $venues = wp_get_post_terms( $location[0]->ID, 'venue' );
			foreach ($venues as $venue) {
				if ($venue->term_id == $_GET['venue']) { // is the location in the appropriate venue?
					$owner = get_field( 'field_5969c3853f8f2', $object->ID );
					if ($owner == null || $owner['ID'] == $current_user->ID) { // object belongs to no-one or this user
						$our_objects[] = $object;
					}
					break;
				}
			}
		}
	}
?>

<div class="step" id="step2">
<?php
    if (count($our_objects) == 0) {
        echo '<h2>No objects</h2>';
        echo '<p>You haven\'t registered any objects in your venue yet. You need to do this first so that you can use the objects to make a free gift.</p>';
    } else {
?>
    <h2>Gift card</h2>
    <p>How will you introduce the experience that you are gifting to your visitors? Keep the introduction brief (e.g. 1-3 sentences). The introduction might describe the objects that the experience includes, an overarching theme for the experience, or a perspective that you want the visitor to take while they are exploring.</p>
    <p><textarea id="giftcard"></textarea></p>
    <h2>Objects</h2>
    <p>An experience consists of three objects and three special messages that you have left for them at those objects. It may help to think about one object as the start of the experience, one object as the middle, and one as the end.</p>
    <h2>Object 1: the Start</h2>
    <p>Choose an object from those shown below: these are the objects you have registered for your venue. You may need to return to the previous screen to add more locations and objects before you complete the free gift.</p>
    <div class="grid" id="objects1">
<?php
    foreach ($our_objects as $object) {
        echo '<div class="grid-item" style="cursor: pointer;" onclick="selectObject(1, '.$object->ID.')" chosen="false" object="'.$object->ID.'"><strong>'.$object->post_title.'</strong>'
            .'<p><img style="width: 100%;" src="'.get_the_post_thumbnail_url($object->ID, 'thumbnail').'" /></p>'
        .'</div>';
    }
?>
    </div>
    <p>Now write a message to be "wrapped up" with the object. The visitor will need to find the object in your venue first: by finding the object they will "unwrap" and be able to read the associated message.</p>
    <p><textarea id="message1"></textarea></p>
    <h2>Object 2: the Middle</h2>
    <p>Object:</p>
    <div class="grid" id="objects2">
<?php
    foreach ($our_objects as $object) {
        echo '<div class="grid-item" style="cursor: pointer;" onclick="selectObject(2, '.$object->ID.')" chosen="false" object="'.$object->ID.'"><strong>'.$object->post_title.'</strong>'
            .'<p><img style="width: 100%;" src="'.get_the_post_thumbnail_url($object->ID, 'thumbnail').'" /></p>'
        .'</div>';
    }
?>
    </div>
    <p>Message:</p>
    <p><textarea id="message2"></textarea></p>
    <h2>Object 3: the End</h2>
    <p>Object:</p>
    <div class="grid" id="objects3">
<?php
    foreach ($our_objects as $object) {
        echo '<div class="grid-item" style="cursor: pointer;" onclick="selectObject(3, '.$object->ID.')" chosen="false" object="'.$object->ID.'"><strong>'.$object->post_title.'</strong>'
            .'<p><img style="width: 100%;" src="'.get_the_post_thumbnail_url($object->ID, 'thumbnail').'" /></p>'
        .'</div>';
    }
?>
    </div>
    <p>Message:</p>
    <p><textarea id="message3"></textarea></p>
<?php
    }
?>
</div>

<div class="step" id="step3">
    <h2>Done?</h2>
    <p><button id="addGift">Add the free gift</button></p>
</div>

<div style="position: fixed; right: 20px; bottom: 20px;">
    <button onclick="window.history.back();">Back</button>
</div>

<div class="preloader"></div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#step1').fadeIn(function () {
        $('#step2').fadeIn(function () {
            jQuery('.grid').isotope({
                itemSelector: '.grid-item',
                layoutMode: 'masonry'
            });
        });
    });

    $("#giftcard, #message1, #message2, #message3").on("change input paste keyup", function() {
        checkComplete();
    });

    $('#addGift').click(function () {
        jQuery('.preloader').show();
        var request = jQuery.ajax({
            dataType: "json",
            cache: false,
            url: "<?php echo get_stylesheet_directory_uri(); ?>/addgift.php",
            method: "POST",
            data: {
                sender: "<?php echo $user->ID; ?>", 
                gift: JSON.stringify({ 
                    title: exhibitName,
                    receiver: receiver.data.user_email,
                    receiverName: decodeURIComponent(receiver.data.nickname),
                    wraps: [
                        {
                            id: 0,
                            title: "<?php echo $user->nickname; ?>'s wrap for " + exhibitName,
                            challenges: [
                                {
                                    type: 'object',
                                    task: exhibit
                                }
                            ]
                        }
                    ],
                    payloads: [
                        {
                            id: 0,
                            title: "<?php echo $user->nickname; ?>'s payload for " + exhibitName,
                            content: payload
                        }
                    ],
                    giftcard: {
                        title: "<?php echo $user->nickname; ?>'s giftcard for " + exhibitName,
                        content: giftcard
                    }
                })
            }
        });
        request.done(function( data ) {
            console.log(data);
            jQuery('.preloader').fadeOut();
        });
        request.fail(function( jqXHR, textStatus ) {
            console.log( "Request failed: " + textStatus );
            jQuery('.preloader').fadeOut();
        });
    });
});

function selectObject (step, objectID) {
    if (jQuery('#objects' + step + ' div[object="' + objectID + '"]').attr('chosen') == 'true') {
        jQuery('#objects' + step + ' div[object="' + objectID + '"]').css('border', 'none');
        jQuery('#objects' + step + ' div[object="' + objectID + '"]').attr('chosen', 'false');
    } else {
        jQuery('#objects' + step + ' div[object="' + objectID + '"]').css('border', '3px solid green');
        jQuery('#objects' + step + ' div[object="' + objectID + '"]').attr('chosen', 'true');
        jQuery('#objects' + step + ' div[object!="' + objectID + '"]').css('border', 'none');
        jQuery('#objects' + step + ' div[object!="' + objectID + '"]').css('chosen', 'false');
    }
    checkComplete();
}

function checkComplete () {
    var disabled = false;
    jQuery("#giftcard, #message1, #message2, #message3").each(function() {
        if (!jQuery.trim(jQuery(this).val())) {
            disabled = true; 
        }
    });
    for (var i = 1; i <= 3; i++) {
        if(jQuery('#objects' + i + ' div[chosen="true"]').length == 0) {
            disabled = true;
        }
    }
    if (!disabled) {
        jQuery('#step3').fadeIn();
    } else {
        jQuery('#step3').fadeOut();
    }
}
</script>