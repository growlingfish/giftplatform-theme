<?php
/**
 * Index page template for users not yet logged in.
 *
 * @package giftplatform-theme
 * @author  Ben Bedwell
 * @license GPL-3.0+
 */

$total = 0;
$unwrapped = 0;

?>

<div>
    <?php 
    $query = array(
		'numberposts'   => -1,
		'post_type'     => 'gift',
		'post_status'   => 'publish',
        'date_query' => array(
            array(
                'after'     => 'July 24th, 2017',
                'before'    => 'July 28th, 2017',
                'inclusive' => true,
            )
        )
	);
	$all_gifts = get_posts( $query );
	foreach ($all_gifts as $gift) {
        $total++;
        if (get_field('field_595e0593bd980', $gift->ID) == '1') {
            $unwrapped++;
        }
    ?>
    <div style="border-bottom: 5px solid black; margin: 40px 0;">
        <h1><?php echo $gift->post_title; ?></h1>
        <ul>
            <li>Sent at: <?php echo $gift->post_modified; ?></li>
            <li>ID: <?php echo $gift->ID; ?></li>
            <li>Maker: <?php $maker = get_userdata($gift->post_author); echo urldecode($maker->nickname).' ('.$gift->post_author.')'; ?></li>
            <li>Receiver: <?php $receiver = get_field('field_58e4f6e88f3d7', $gift->ID); echo urldecode($receiver[0]['nickname']).' ('.$receiver[0]['ID'].')'; ?></li>
            <li>Experienced? <?php echo (get_field('field_595e0593bd980', $gift->ID) == '1' ? 'Yes' : 'No'); ?></li>
        </ul>
        <h2>Object</h2>
        <?php
            $gift->wraps = get_field('field_58e4f5da816ac', $gift->ID);
            foreach ($gift->wraps as &$wrap) {
                //$wrap->unwrap_object = get_field('object', $wrap->ID);
                $wrap->unwrap_object = get_field('field_595b4a2bc9c1c', $wrap->ID);
                if (is_array($wrap->unwrap_object) && count($wrap->unwrap_object) > 0) {
                    $wrap->unwrap_object = $wrap->unwrap_object[0];
                } else if (is_a($wrap->unwrap_object, 'WP_Post')) {
                        
                } else {
                    unset($wrap->unwrap_object);
                }  
                if ($wrap->unwrap_object) {
                    ?><p><img src="<?php echo get_the_post_thumbnail_url($wrap->unwrap_object->ID, 'large'); ?>" /></p>
                    <p>Named: <?php echo $wrap->unwrap_object->post_title; ?></p><?php
                } else {
                    ?><p>Broken gift ...</p><?php
                }
            }
        ?>
        <h2>Gift card (message "before they get their gift")</h2>
        <?php
            $gift->giftcards = get_field('field_5964a5787eb68', $gift->ID);
            foreach ($gift->giftcards as &$giftcard) { ?>
                <p><?php echo wpautop($giftcard->post_content); ?></p>
            <?php }
        ?>
        <h2>Gift (message revealed "at the exhibit")</h2>
        <?php
            $gift->payloads = get_field('field_58e4f689655ef', $gift->ID);
            foreach ($gift->payloads as &$payload) { ?>
                <p><?php echo wpautop($payload->post_content); ?></p>
            <?php }
        ?>
    </div>
    <?php
	}
    ?>
</div>

<script>
jQuery(function($) {

});
</script>