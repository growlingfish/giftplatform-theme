<div class="head-logo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cropped-GIFT-white.png" />
</div>

<?php 

    if (isset ($_GET['venue'])) {
        $venue = get_term( $_GET['venue'], 'venue' );
    }

?>

<div class="step" id="step1">
    <h1>CMS: Add a Location</h1>
    <p>"Locations" are a way of dividing up your venue into different spaces: this then allows you to assign objects to particular spaces, making it easier for visitors to organise the content of their gifts.</p>
    <p>Click on the button below to open the Gift CMS. In the new page ...</p>
    <ol>
        <li style="list-style-type: numeric;">Give the location a name (in the box labelled "Enter title here")</li>
        <li style="list-style-type: numeric;">Give the location a brief description in the larger box below</li>
        <li style="list-style-type: numeric;">Start typing the name of your venue <?php echo (isset ($venue) ? '('.$venue->name.')' : '' ); ?> into the box labelled "Venues"; when your venue appears, "add" it</li>
    </ol>
    <p style="padding-top: 30px;">When this is complete, press the button labelled "Publish".</p>
    <p><a href="https://gifting.digital/wp/wp-admin/post-new.php?post_type=location" class="button">Open the CMS</a></p>
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