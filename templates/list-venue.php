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
        $i = 0;
        foreach ($venues as $venue) {
            $owner = get_field( 'owner', $venue );
            if ($owner['ID'] == get_current_user_id()) {
                echo '<li><span style="font-weight: bold; padding-right: 30px;">'.$venue->name.'</span> <a href="'.get_term_link($venue->term_id, 'venue').'" class="button">View/edit full detail</a></li>';
                $i++;
            }
        }
        if ($i == 0) {
            echo '<li>None</li>';
        }
    }

?>
    </ul>
</div>

<div class="step" id="new">
    <h1>Add a venue</h1>
    <p>Click on the button below to open the Gift CMS. In the new page, fill out the appropiate details under "Add new Venue" and be sure to choose <strong>your username</strong> as the <strong>owner</strong>. Take a look at the list of existing venues on the page for inspiration.</p>
    <a href="https://platform.gifting.digital/wp/wp-admin/edit-tags.php?taxonomy=venue&post_type=location" target="_blank" class="button">Open the dashboard</a>
</div>

<div style="position: fixed; right: 20px; bottom: 20px;">
    <button onclick="window.history.back();">Back</button>
</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#venues').fadeIn( function () {
        $('#new').fadeIn();
    });
});
</script>