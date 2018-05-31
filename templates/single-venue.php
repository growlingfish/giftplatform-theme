<?php
    $venue = get_queried_object();
?>

<script src="https://unpkg.com/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>

<div class="step" id="detail">
    <p><?php echo $venue->description; ?></p>
</div>

<div class="step" id="locations">

<?php
    $args = array(
        'post_type' => 'location',
        'tax_query' => array(
            array(
                'taxonomy' => 'venue',
                'field'    => 'term_id',
                'terms'    => array($venue->term_id),
            ),
        ),
    );
    $locations = new WP_Query( $args );
    foreach ($locations as $location) {
        echo '<h1>'.$location->post_title.'</h1>';
        echo '<p>'.$location->post_content.'</p>';
        
    }
?>

</div>

<div class="step" id="gifts">
    <h1>Gifts made for this venue</h1>
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