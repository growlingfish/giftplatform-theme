<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js" integrity="sha256-L3S3EDEk31HcLA5C6T2ovHvOcD80+fgqaCDt2BAi92o=" crossorigin="anonymous"></script>

<div class="step" id="detail">
    <h1>Gift</h1>
<?php
    $gift = get_post($_GET['id']);

    echo '<p>This gift was sent on <span id="sent-date"></span> at <span id="sent-time"></span></p>';

    // sender
    $senderdata = get_userdata($gift->post_author);
    echo '<p>It was sent by '.urldecode($senderdata->nickname).'</p>';

    $recipients = get_field( 'field_58e4f6e88f3d7', $gift->ID );
    if ($recipients) {
        foreach ($recipients as $recipient) {
            $recipientdata = get_userdata($recipient['ID']);
            break; // only one recipient for now
        }
    }
    if ($recipientdata) {
        echo '<p>It was sent to '.urldecode($recipientdata->nickname).'</p>';
    } else {
        echo '<p style="color: red;">No recipient was chosen.</p>';
    }
?>
</div>

<div class="step" id="giftcard">
    <h1>Gift card</h1>
<?php
    $giftcards = get_field( 'field_5964a5787eb68', $gift->ID);
	if ($giftcards) {
        foreach ($giftcards as $giftcard) {
            $giftcarddata = (object)array(
                'ID' => $giftcard->ID,
                'post_content' => wpautop($giftcard->post_content)
            );
        }
    }
    if ($giftcarddata) {
        echo '<p>The gift card said:</p><blockquote>'.$giftcarddata->post_content.'</blockquote>';
    } else {
        echo '<p style="color: red;">No gift card was written.</p>';
    }
?>
</div>

<div class="step" id="wraps">
    <h1>Wraps</h1>
    <p>The recipient was asked to find the following objects:</p>
    <div id="giftobjectsvis" class="grid">
<?php
    $wraps = get_field( 'field_58e4f5da816ac', $gift->ID);
	if ($wraps) {
        foreach ($wraps as $wrap) {
            $object = get_field( 'field_595b4a2bc9c1c', $wrap->ID);
            if (is_array($object) && count($object) > 0) {
                $object = $object[0];
            } else if (is_a($object, 'WP_Post')) {
                    
            } else {
                unset($object);
            }  
            if ($object) {

                echo '<div class="grid-item"><strong>'.$object->post_title.'</strong>';
                echo '<p>'.get_the_post_thumbnail_url($object->ID, 'medium').'</p>';

                $location = get_field( 'field_59a85fff4be5a', $object->ID );
                if (!$location || count($location) == 0) {
                    
                } else {
                    $location = $location[0];

                    echo '<div>'.$location->post_title;

                    $venues = wp_get_post_terms( $location->ID, 'venue' );
                    if ($venues) {
                        $venue = $venues[0];

                        echo ' in '.$venue->name;
                    }

                    echo '</div>';
                }

                echo '</div>';
            }
        }
    }
    echo '</div>';
    if (!$wraps) {
        echo '<p style="color: red;">Gift was not wrapped.</p>';
    }
?>
</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#sent-date').text(moment('<?php echo $gift->post_modified; ?>').format("dddd, MMMM Do YYYY"));
    $('#sent-time').text(moment('<?php echo $gift->post_modified; ?>').format("h:mm:ss a"));

    $('#detail').fadeIn(function () {
        $('#giftcard').fadeIn(function () {
            $('#wraps').fadeIn(function () {
                $('.grid').isotope({
                    itemSelector: '.grid-item',
                    layoutMode: 'fitRows'
                });
            });
        });
    });
});
</script>