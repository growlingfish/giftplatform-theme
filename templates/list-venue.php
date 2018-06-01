<div class="step" id="venues">
    <h1>Your venues</h1>
    <p>You have registered the following venues:</p>
    <ul>
<?php

    $venues = get_terms( array(
        'taxonomy' => 'venue',
        'hide_empty' => false,
    ) );
    if (count($venues) == 0) {
        echo '<li>None</li>';
    } else {
        foreach ($venues as $venue) {
            $owner = get_field( 'owner', $venue->term_id );
            if ($owner->data->ID == get_current_user_id()) {
                echo '<li>'.$venue->name.' <a href="'.get_term_link($venue->term_id, 'venue').'" class="button">View</a> <a href="'.get_edit_term_link( $venue->term_id, 'venue', 'location' ).'" class="button">Edit</a></li>';
            }
        }
    }

?>
    </ul>
</div>

<div style="position: fixed; right: 20px; bottom: 20px;">
    <button onclick="window.history.back();">Back</button>
</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#venues').fadeIn();
});
</script>