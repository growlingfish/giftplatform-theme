<div class="head-logo">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cropped-GIFT-white.png" />
</div>

<?php 

    if (isset ($_GET['loc'])) {
        $location = get_post( $_GET['loc']);
    }

?>

<div class="step" id="step1">
    <h1>CMS: Add an Object</h1>
    <p>"Objects" are digital records of physical things in your venue that visitors might want to add to their gifts. These might be exhibits, but they could also be objects in the gift shop, or even architectural features.</p>
    <p>Click on the button below to open the Gift CMS. In the new page ...</p>
    <ol>
        <li>Give the object a name (in the box labelled "Enter title here")</li>
        <li>Give the object a brief description in the larger box below</li>
        <li>Be sure to choose <strong>your username</strong> as the owner</li>
        <li>Search the list of locations and choose yours <?php echo (isset ($location) ? '('.$location->post_title.')' : '' ); ?></li>
        <li>Click "Add featured image" and choose an image of the object from your computer (or any image that would help a visitor to find the object)</li>
    </ol>
    <p>When this is complete, press the button labelled "Publish".</p>
    <p><a href="https://gifting.digital/wp/wp-admin/post-new.php?post_type=object" class="button">Open the CMS</a></p>
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