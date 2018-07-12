<?php
    $venue = get_queried_object();

    if( !current_user_can('administrator') ) {
        $current_user = wp_get_current_user();
    }
?>

<script src="https://unpkg.com/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>

<div class="step" id="detail">
    <h1><?php echo $venue->name; ?></h1>
    <p>Introduced with:</p>
    <blockquote><?php echo $venue->description; ?></blockquote>
    <p><a href="<?php echo get_edit_term_link( $venue->term_id, 'venue', 'location' ); ?>" class="button" target="_blank">Edit this title/introduction</a></p>
</div>

<div class="step" id="locations">
    <h1>Locations and objects</h1>
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
    if (count ($locations) > 0) {
        echo '<p>This venue contains the following locations and objects:</p>';
        $objects = get_posts(
            array( 
                'post_type' => 'object',
                'posts_per_page' => -1
            )
        );
        $i = 0;
        foreach ($locations as $location) {
            echo '<h2 style="padding-top: 30px;">Location '.++$i.': '.$location->post_title.'</h2>';
            echo '<blockquote>'.$location->post_content.'</blockquote>';
            echo '<p><a href="'.get_the_guid($location->ID).'" class="button">Edit this location</a></p>';
            echo '<div class="grid giftobjectsvis">';
            echo '<div class="grid-item grid-item--width2"><p style="text-align: center; margin-bottom: 0px;"><a href="/new-object/?loc='.$location->ID.'" class="button">Add a new object to this location</a></p></div>';
            foreach ($objects as $object) {
                $l = get_field( 'field_59a85fff4be5a', $object->ID );
                if (!$l || count($l) == 0) {
                    
                } else {
                    $l = $l[0];
                    if ($location->ID == $l->ID) {
                        $userdata = get_userdata($object->post_author);
                        if (!$userdata || !isset ($current_user) || $current_user->ID == $userdata->ID) {
                            echo '<div class="grid-item grid-item--width2"><strong>'.$object->post_title.'</strong>'
                                .'<p><a href="'.get_the_guid($object->ID).'"><img style="width: 100%;" src="'.get_the_post_thumbnail_url($object->ID, 'thumbnail').'" /></a></p>'
                            .'</div>';
                        } else {
                            echo '<div class="grid-item grid-item--width2"><strong>Private object</strong>'
                                .'<p><a href="'.get_the_guid($object->ID).'"><img style="width: 100%;" src="'.get_the_post_thumbnail_url($object->ID, 'thumbnail').'" /></a></p>'
                            .'</div>';
                        }
                    }
                }
            }
            echo '</div>';
        }
    } else {
        echo '<p>There are no locations configured in your venue yet.</p>';
    }
?>
    <h2 style="padding-top: 30px;">More locations?</h2>
    <p><a href="/new-location/?venue=<?php echo $venue->term_id; ?>" class="button" target="_blank">Add a new location</a></p>
</div>

<div class="step" id="freegift">
    <h2>Free gifts</h2>
    <div class="grid" id="freegiftsvis">
<?php
    $all_gifts = get_posts( array(
        'posts_per_page'   => -1,
        'post_type'     => 'gift',
        'post_status'   => 'publish'
    ) );
    $found = false;
    foreach ($all_gifts as $gift) {
        $freeGift = get_field( 'field_5a54cf62fc74f', $gift->ID );
        if ($freeGift) {
            $wraps = get_field( 'field_58e4f5da816ac', $gift->ID);
            $located = false;
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
                        $l = get_field( 'field_59a85fff4be5a', $object->ID );
                        if (!$l || count($l) == 0) {
                            return null;
                        }
                        $l = $l[0];
                        foreach ($locations as $location) {
                            if ($l->ID == $location->ID) {
                                $located = true;

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

                                $found = true;

                                if (!isset ($current_user) || $current_user->ID == $senderdata->ID || $current_user->ID == $recipientdata->ID) {
                                    echo '<div class="public grid-item '
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
                                } else { // Anonymised
                                    echo '<div class="grid-item '
                                        .(isset ($gift->post_modified) && isset ($senderdata->nickname) && isset ($recipientdata->nickname) ? 'complete' : 'incomplete')
                                    .'">'
                                        .'<strong>Private gift</strong>'
                                        .'<ul>'
                                            .'<li>Sent: '.(isset ($gift->post_modified) ? $gift->post_modified : '<span style="color: red">No date</span>' ).'</li>'
                                        .'</ul>'
                                    .'</div>';
                                }
                                break;
                            }
                        }
                    }

                    if ($located) {
                        break;
                    }
                }
            }
        }
    }
    echo '</div>';

    if (!$found) {
        echo '<p>You have not made any free gifts for visitors yet.</p>';
    }
?>
    <p><a href="/new-free-gift/?venue=<?php echo $venue->term_id; ?>" class="button">Add a free gift</a></p>
</div>

<div class="step" id="gifts">
    <h2>Gifts made for this venue</h2>
<?php
    if( !current_user_can('administrator') ) {
        echo '<p><strong>Please note:</strong> some of the gifts have been anonymised as you are not the sender or recipient.</p>';
    }
?>
    <div class="grid" id="giftsvis">
<?php
    $all_gifts = get_posts( array(
        'posts_per_page'   => -1,
        'post_type'     => 'gift',
        'post_status'   => 'publish'
    ) );
    $found = false;
    foreach ($all_gifts as $gift) {
        $freeGift = get_field( ACF_freegift, $giftobject->ID );
		if (!$freeGift) {
            $wraps = get_field( 'field_58e4f5da816ac', $gift->ID);
            $located = false;
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
                        $l = get_field( 'field_59a85fff4be5a', $object->ID );
                        if (!$l || count($l) == 0) {
                            return null;
                        }
                        $l = $l[0];
                        foreach ($locations as $location) {
                            if ($l->ID == $location->ID) {
                                $located = true;

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

                                $found = true;

                                if (!isset ($current_user) || $current_user->ID == $senderdata->ID || $current_user->ID == $recipientdata->ID) {
                                    echo '<div class="public grid-item '
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
                                } else { // Anonymised
                                    echo '<div class="grid-item '
                                        .(isset ($gift->post_modified) && isset ($senderdata->nickname) && isset ($recipientdata->nickname) ? 'complete' : 'incomplete')
                                    .'">'
                                        .'<strong>Private gift</strong>'
                                        .'<ul>'
                                            .'<li>Sent: '.(isset ($gift->post_modified) ? $gift->post_modified : '<span style="color: red">No date</span>' ).'</li>'
                                        .'</ul>'
                                    .'</div>';
                                }
                                break;
                            }
                        }
                    }

                    if ($located) {
                        break;
                    }
                }
            }
        }
    }
    echo '</div>';

    if (!$found) {
        echo '<p>No gifts have been made by visitors yet.</p>';
    }
?>
</div>

<div style="position: fixed; right: 20px; bottom: 20px;">
    <button onclick="window.history.back();">Back</button>
</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('.public').click(function () {
        window.location.href = 'https://gifting.digital/vis/?tool=gift&id=' + $(this).attr('gift');
    });

    $('#detail').fadeIn(function () {
        $('#locations').fadeIn(function () {
            $('#freegift').fadeIn(function () {
                $('#gifts').fadeIn(function () {
                    $('.grid').isotope({
                        itemSelector: '.grid-item',
                        layoutMode: 'masonry'
                    });
                });
            });
        });
    });
});
</script>