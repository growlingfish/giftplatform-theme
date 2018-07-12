<?php

require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp/wp-load.php' );

if (isset ($_POST['sender']) && isset ($_POST['gift'])) {
	$gift = json_decode(stripslashes($_POST['gift']));

	$sender = get_user_by('id', $_POST['sender']);

	$giftcard_post = array(
		'post_title'    => 'Giftcard for free gift from '.$sender->nickname,
		'post_content'  => wp_strip_all_tags( $gift->giftcard->content ),
		'post_status'   => 'publish',
		'post_author'   => $_POST['sender'],
		'post_type'		=> 'giftcard'
	);
	$giftcard_id = wp_insert_post( $giftcard_post );
	if (is_wp_error($giftcard_id)) {
		// delete everything in gift and stop?
	}

	$payloads = array();
	foreach ($gift->payloads as $payload) {
		$payload_post = array(
			'post_title'    => 'Payload '.$payload->id.' for free gift from '.$sender->nickname,
			'post_content'  => wp_strip_all_tags( $payload->content ),
			'post_status'   => 'publish',
			'post_author'   => $_POST['sender'],
			'menu_order'	=> $payload->id,
			'post_type'		=> 'payload'
		);
		$payload_id = wp_insert_post( $payload_post );
		if (is_wp_error($payload_id)) {
			// delete everything in gift and stop?
		} else {
			$payloads[] = $payload_id;
		}
	}

	$wraps = array();
	foreach ($gift->wraps as $wrap) {
		$wrap_post = array(
			'post_title'    => 'Wrap '.$wrap->id.' for free gift from '.$sender->nickname,
			'post_status'   => 'publish',
			'post_author'   => $_POST['sender'],
			'menu_order'	=> $wrap->id,
			'post_type'		=> 'wrap'
		);
		$wrap_id = wp_insert_post( $wrap_post );
		if (!is_wp_error($wrap_id)) {
			update_field( 'field_595b4a2bc9c1c', array($wrap->unwrap_object), $wrap_id );
			$wraps[] = $wrap_id;
		} else {
			// delete everything in gift and stop?
		}
	}

	$gift_post = array(
		'post_title'    => 'Free gift from '.$sender->nickname,
		'post_status'   => 'publish',
		'post_author'   => $_POST['sender'],
		'post_type'		=> 'gift'
	);
	$gift_id = wp_insert_post( $gift_post );
	if (!is_wp_error($gift_id)) {
		update_field( 'field_5964a5787eb68', array($giftcard_id), $gift_id );

		update_field( 'field_58e4f689655ef', $payloads, $gift_id );
		
		update_field( 'field_58e4f5da816ac', $wraps, $gift_id );

		update_field('field_5a54cf62fc74f', 1, $gift_id );

		echo $gift_id;
	} else {
		// delete everything in gift and stop?
	}
}

?>