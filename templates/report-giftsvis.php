<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<div class="grid">

<?php
    $query = array(
        'numberposts'   => -1,
        'post_type'     => 'object',
        'post_status'   => 'publish'
    );
    $all_objects = get_posts( $query );
    $result = array();
    foreach ($all_objects as $object) {
        $location = get_field( 'field_59a85fff4be5a', $object->ID );
        if (!$location || count($location) == 0) {
            
        } else {
            echo '<div class="grid-item">'.$object->post_title.'</div>';
        }
    }
?>

</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('.grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });
});
</script>