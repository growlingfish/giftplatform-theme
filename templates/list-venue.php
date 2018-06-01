<div class="step" id="venues">
    <h1>Your venues</h1>
    <p>You have registered the following venues:</p>

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