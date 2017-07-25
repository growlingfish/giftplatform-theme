<?php
/**
 * Index page template for users not yet logged in.
 *
 * @package giftplatform-theme
 * @author  Ben Bedwell
 * @license GPL-3.0+
 */

?>

<div>
    <?php 
    $query = array(
		'numberposts'   => -1,
		'post_type'     => 'gift',
		'post_status'   => 'publish'
	);
	$all_gifts = get_posts( $query );
	foreach ($all_gifts as $gift) {
    ?>
    <div style="border-bottom: 5px solid black; margin-bottom: 20px;">
        <h1><?php echo $gift->post_title; ?></h1>
        <p>Sent at: <?php echo $gift->post_modified; ?></p>
        <p>ID: <?php echo $gift->ID; ?></p>
        <p>Maker: <?php $maker = get_userdata($gift->post_author); echo $maker->user_login.' ('.$gift->post_author.')'; ?></p>
        <p>Receiver: <?php $receiver = get_field('receiver', $gift->ID); echo $receiver->user_login.' ('.$receiver->ID.')'; ?></p>
        
    </div>
    <?php
	}
    ?>
</div>

<script>
jQuery(function($) {
	
});
</script>