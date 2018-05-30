<div class="step" id="detail">
    <h1><?php echo get_the_title(); ?></h1>

    <p><img src="<?php echo get_the_post_thumbnail_url(); ?>" /></p>

<?php
    global $post;
    $userdata = get_userdata($post->post_author);
?>
    <p>Created by <?php echo $userdata->nickname; ?> on <?php the_date(); ?>.</p>

<?php
    $location = get_field( 'field_59a85fff4be5a', get_the_ID() );
	if (!$location || count($location) == 0) {
		
	} else {
        $location = $location[0];
        $venues = wp_get_post_terms( $location->ID, 'venue' );
        foreach ($venues as $v) {
            $venue = $v->name;
            break;
        }
    }
?>
    <p>Located at <?php echo $location->post_title; ?><?php echo (isset($venue) ? ' in ' : ''); ?>.</p>

<?php if (count(get_the_content()) > 0) { ?>
    <p>Comes with the following description:</p>
    <blockquote><?php echo wpautop(get_the_content()); ?></blockquote>
<?php } ?>

</div>

<div style="position: fixed; right: 20px; bottom: 20px;">
    <button onclick="window.history.back();">Back</button>
</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#detail').fadeIn(function () {
        
    });
});
</script>