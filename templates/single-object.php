<?php
    global $post;
?>

<script src="https://unpkg.com/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>

<div class="step" id="detail">
    <h1><?php echo $post->post_title; ?></h1>

    <p><img src="<?php echo get_the_post_thumbnail_url(); ?>" /></p>

<?php
    $userdata = get_userdata($post->post_author);
?>
    <p>Created by <?php echo $userdata->nickname; ?> on <?php echo $post->post_modified; ?>.</p>

<?php
    $location = get_field( 'field_59a85fff4be5a', $post->ID );
	if (!$location || count($location) == 0) {
		
	} else {
        $location = $location[0];
        $venues = wp_get_post_terms( $location->ID, 'venue' );
        foreach ($venues as $v) {
            $venue = '<a href="'.get_term_link((int) $v->term_id, 'venue').'">'.$v->name.'</a>';
            break;
        }
    }
?>
    <p>Located at <?php echo $location->post_title; ?><?php echo (isset($venue) ? ' in '.$venue : ''); ?>.</p>

<?php if (count($post->post_content) > 0) { ?>
    <p>Comes with the following description:</p>
    <blockquote><?php echo wpautop($post->post_content); ?></blockquote>
<?php } ?>

</div>

<div class="step" id="used">
    <h1>Used in</h1>

    <div id="usedvis" class="grid">

<?php
    $query = array(
        'numberposts'   => -1,
        'post_type'     => 'gift',
        'post_status'   => 'publish'
    );
    $all_gifts = get_posts( $query );
    foreach ($all_gifts as $gift) {
        $wraps = get_field( 'field_58e4f5da816ac', $gift->ID);
        if ($wraps) {
            foreach ($wraps as $wrap) {
                unset ($object);
                $object = get_field( 'field_595b4a2bc9c1c', $wrap->ID);
                if (is_array($object) && count($object) > 0) {
                    $object = $object[0];
                } else if (is_a($object, 'WP_Post')) {
                        
                } else {
                    unset($object);
                }  
                if ($object && $object->ID == $post->ID) { // this gift includes this object
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

                    echo '<div class="grid-item '
                        .(isset ($gift->post_modified) && isset ($senderdata->nickname) && isset ($recipientdata->nickname) ? 'complete' : 'incomplete')
                        .'" gift="'.$gift->ID.'"'                    
                    .'>'
                        .'<strong>Gift #'.$gift->ID.'</strong>'
                        .'<ul>'
                            .'<li>Sent: '.(isset ($gift->post_modified) ? $gift->post_modified : '<span style="color: red">No date</span>' ).'</li>'
                            .'<li>By: '.(isset ($senderdata->nickname) ? urldecode($senderdata->nickname) : '<span style="color: red">No sender</span>' ).'</li>'
                            .'<li>To: '.(isset ($recipientdata->nickname) ? urldecode($recipientdata->nickname) : '<span style="color: red">No recipient</span>' ).'</li>'
                        .'</ul>'
                    .'</div>';
                    break;
                }
            }
        }
    }
?>

    </div>
</div>

<div style="position: fixed; right: 20px; bottom: 20px;">
    <button onclick="window.history.back();">Back</button>
</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('.grid-item').click(function () {
        window.location.href = 'https://gifting.digital/vis/?tool=gift&id=' + $(this).attr('gift');
    });

    $('#detail').fadeIn(function () {
        $('#used').fadeIn(function () {
            $('.grid').isotope({
                itemSelector: '.grid-item',
                layoutMode: 'masonry'
            });
        });
    });
});
</script>