<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js" integrity="sha256-L3S3EDEk31HcLA5C6T2ovHvOcD80+fgqaCDt2BAi92o=" crossorigin="anonymous"></script>

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
    <p>Would you like to filter the gifts?</p>
    <button id="sept-sprint">Sep 2017 Brighton sprint</button>
    <button id="byVenue">By venue</button>
    <button id="bySender">By sender</button>
    <button id="byRecipient">By recipient</button>
    <button id="byDate">By date sent</button>
</div>

<div id="giftsvis" class="grid">

<?php
    $query = array(
		'numberposts'   => -1,
		'post_type'     => 'gift',
		'post_status'   => 'publish'
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
                            $venue = $venues[0];
                        }
                    }
                }
            }
        }

        echo '<div class="grid-item '
                .(isset ($object->post_title) && isset ($gift->post_modified) && isset ($senderdata->nickname) && isset ($recipientdata->nickname) ? 'complete' : 'incomplete')
            .'" '
                .'gift="'.$gift->ID.'"'
                .'data-object="'.$object->post_title.'" '
                .'data-date="'.$gift->post_modified.'" '
                .'data-sender="'.urldecode($senderdata->nickname).'" '
                .'data-recipient="'.urldecode($recipientdata->nickname).'" '
                .'data-venue="'.$venue->name.'" '
            .'>'
                .'<strong>Gift #'.$gift->ID.'</strong>'
                .'<ul>'
                    .'<li>Sent: '.(isset ($gift->post_modified) ? $gift->post_modified : '<span style="color: red">No date</span>' ).'</li>'
                    .'<li>By: '.(isset ($senderdata->nickname) ? urldecode($senderdata->nickname) : '<span style="color: red">No sender</span>' ).'</li>'
                    .'<li>To: '.(isset ($recipientdata->nickname) ? urldecode($recipientdata->nickname) : '<span style="color: red">No recipient</span>' ).'</li>'
                    .'<li>Object: '.(isset ($object->post_title) ? $object->post_title : '<span style="color: red">No object</span>' ).'</li>'
                    .'<li>At: '.(isset ($venue->name) ? $venue->name : 'No venue' ).'</li>'
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

    $('#sept-sprint').click( function () {
        $('.grid').isotope({
            filter: function() {
                var date = $(this).attr('data-date');
                return moment(date).isBetween('2017-09-24', '2017-09-28');
            }
        });
    });

    $('.grid-item').click(function () {
        window.location.href = 'https://gifting.digital/vis/?tool=gift&id=' + $(this).attr('gift');
    });

    $('#orders').fadeIn();
});
</script>