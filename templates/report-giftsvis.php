<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

<div class="step" id="orders">
    <h1>Gifts</h1>
    <p>How would you like to order the gifts?</p>
    <div id="sort-by">
        <button id="byObject">By object</button>
        <button id="byVenue">By venue</button>
        <button id="bySender">By sender</button>
        <button id="byRecipient">By recipient</button>
        <button id="byDate">By date sent</button>
    </div>
</div>

<div id="giftsvis" class="grid">

<?php
    $query = array(
		'numberposts'   => -1,
		'post_type'     => 'gift',
		'post_status'   => 'publish',
        /*'date_query' => array(
            array(
                'after'     => 'July 24th, 2017',
                'before'    => 'July 28th, 2017',
                'inclusive' => true,
            )
        )*/
	);
    $all_gifts = get_posts( $query );
    foreach ($all_gifts as $gift) {
        // sender
        $senderdata = get_userdata($gift->post_author);

        // recipient
        $recipients = get_field( 'field_58e4f6e88f3d7', $gift->ID );
        unset($recipientdata);
        if ($recipients) {
            foreach ($recipients as $recipient) {
                $recipientdata = get_userdata($recipient['ID']);
                break; // only one recipient for now
            }
        }

        //object + venue
        $wraps = get_field( 'field_58e4f5da816ac', $gift->ID);
        unset($object, $venue);
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
                    $location = get_field( 'field_59a85fff4be5a', $object->ID );
                    if (!$location || count($location) == 0) {
                        
                    } else {
                        $location = $location[0];
                        $venues = wp_get_post_terms( $location->ID, 'venue' );
                        if ($venues) {
                            $venue = $venue[0];
                        }
                    }
                }
            }
        }

        echo '<div class="grid-item" '
                .'data-object="'.$object->post_title.'" '
                .'data-date="'.$gift->post_modified.'" '
                .'data-sender="'.urldecode($senderdata->nickname).'" '
                .'data-recipient="'.urldecode($recipientdata->nickname).'" '
                .'data-venue="'.$venue->name.'" '
            .'>'
                .$gift->post_title
                .'<ul>'
                    .'<li>'.$object->post_title.'</li>'
                    .'<li>'.$gift->post_modified.'</li>'
                    .'<li>'.urldecode($senderdata->nickname).'</li>'
                    .'<li>'.urldecode($recipientdata->nickname).'</li>'
                    .'<li>'.$venue->name.'</li>'
                .'</ul>'
            .'</div>';
    }

?>

</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('.grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows',
        getSortData: {
            byObject: '[data-object]',
            byDate: '[data-date]',
            bySender: '[data-sender]',
            byRecipient: '[data-recipient]',
            byVenue: '[data-venue]',
        }
    });

    $('#sort-by').on('click', 'button', function () {
        var sortByValue = $(this).attr('id');
        $('.grid').isotope({ sortBy : sortByValue });
    });

    $('#orders').fadeIn();
});
</script>