<div class="head-logo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cropped-GIFT-white.png" />
</div>

<div class="step" id="step1">
    <h1>Visualisations</h1>
    <p>What would you like to see?</p>
    <a href="https://platform.gifting.digital/vis/?tool=exchange" class="button">Network of exchanges</a>
    <a href="https://platform.gifting.digital/vis/?tool=gifts" class="button">Gifts</a>
</div>

<div style="position: fixed; right: 20px; bottom: 20px;">
    <button onclick="window.history.back();">Back</button>
</div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

    $('#step1').fadeIn();
});
</script>