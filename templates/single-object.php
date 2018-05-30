<div class="step" id="detail">
    <h1><?php echo get_the_title(); ?></h1>

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