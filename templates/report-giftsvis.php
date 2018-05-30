<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

<div class="step" id="orders">
    <h1>Gifts</h1>
    <p>How would you like to order the gifts?</p>
    <div id="sort-by">
        <button id="byObject">By object</button>
        <button id="byVenue">By venue</button>
        <button id="bySender">By sender</button>
        <button id="byReceiver">By receiver</button>
        <button id="byDate">By date sent</button>
    </div>
</div>

<div id="giftsvis" class="grid">

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
            echo '<div class="grid-item" '
                    .'data-object="'.$object->ID.'" '
                .'>'
                    .$object->post_title
                .'</div>';
        }
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
            byObject: '[data-object]'
        }
    });

    $('#sort-by').on('click', 'button', function () {
        var sortByValue = $(this).attr('id');
        $('.grid').isotope({ sortBy : sortByValue });
    });

    $('#orders').fadeIn();
});
</script>