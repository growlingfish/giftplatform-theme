<?php
    $venue = get_queried_object();
?>

<script src="https://unpkg.com/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>

<div class="step" id="venue">
    <h1><?php var_dump($venue); ?></h1>
</div>

<div style="position: fixed; right: 20px; bottom: 20px;">
    <button onclick="window.history.back();">Back</button>
</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#venue').fadeIn(function () {
        
    });
});
</script>