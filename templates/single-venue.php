<?php
    $venue = get_queried_object();
?>

<script src="https://unpkg.com/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>

<div class="step" id="detail">
    <h1><?php echo $venue->name; ?></h1>
    <p>Introduced with:</p>
    <blockquote><?php echo $venue->description; ?></blockquote>
</div>

<div class="step" id="locations">

<?php
    $locations = get_posts(
        array( 
            'post_type' => 'location',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'venue',
                    'field' => 'id',
                    'terms' => $venue->term_id
                )
            )
        )
    );
    $objects = get_posts(
        array( 
            'post_type' => 'object',
            'posts_per_page' => -1
        )
    );
    foreach ($locations as $location) {
        echo '<h2>'.$location->post_title.'</h2>';
        echo '<p>'.$location->post_content.'</p>';
        echo '<div class="grid">';
        foreach ($objects as $object) {
            $l = get_field( 'field_59a85fff4be5a', $object->ID );
            if (!$l || count($l) == 0) {
                
            } else {
                $l = $l[0];
                if ($location->ID == $l->ID) {
                    echo '<div class="grid-item">'.$object->post_title.'</div>';
                }
            }
        }
        echo '</div>';
    }
?>

</div>

<div class="step" id="gifts">
    <h2>Gifts made for this venue</h2>
    <div class="grid">
<?php
    $all_gifts = get_posts( array(
        'posts_per_page'   => -1,
        'post_type'     => 'gift',
        'post_status'   => 'publish'
    ) );
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

                if ($object) {
                    $l = get_field( 'field_59a85fff4be5a', $post->ID );
                    if (!$l || count($l) == 0) {
                        return null;
                    }
                    $l = $l[0];
                    foreach ($locations as $location) {
                        if ($l->ID == $location->ID) {
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

    $('#detail').fadeIn(function () {
        $('#locations').fadeIn(function () {
            $('#gifts').fadeIn(function () {
        
            });
        });
    });
});
</script>