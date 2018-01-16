<?php
/**
 * Index page template for Exchange Visualisation.
 *
 * @package giftplatform-theme
 * @author  Ben Bedwell
 * @license GPL-3.0+
 */

$user = wp_get_current_user();

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.css" rel="stylesheet" type="text/css" />
<div id="mynetwork" style="width: 600px; height: 400px; border: 1px solid lightgray;"></div>

<div class="preloader"></div>

<script>
jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-project.jpg');

<?php
    define ( 'ACF_recipient', 	'field_58e4f6e88f3d7' );
    define ( 'ACF_wrap', 		'field_58e4f5da816ac' );
    define ( 'ACF_date', 		'field_58e4fb5c55127' );
    define ( 'ACF_key',			'field_58e4fb8055128' );
    define ( 'ACF_place', 		'field_58e4fae755126' );
    define ( 'ACF_artcode',		'field_58ff4bdf23d95' );
    define ( 'ACF_personal', 	'field_594d2552e8835' );
    define ( 'ACF_object', 		'field_595b4a2bc9c1c' );
    define ( 'ACF_payload',		'field_58e4f689655ef' );
    define ( 'ACF_giftcard', 	'field_5964a5787eb68' );
    define ( 'ACF_received', 	'field_595e186f21668' );
    define ( 'ACF_unwrapped', 	'field_595e0593bd980' );
    define ( 'ACF_responded', 	'field_595e05c8bd981' );
    define ( 'ACF_location', 	'field_59a85fff4be5a' );
    define ( 'ACF_gift', 		'field_59c4cdc1f07f6' );
    define ( 'ACF_owner', 		'field_5969c3853f8f2' );
    define ( 'ACF_freegift', 	'field_5a54cf62fc74f' );

    function prepare_gift_object ($post) {
        $location = get_field( ACF_location, $post->ID );
        if (!$location || count($location) == 0) {
            return null;
        }
        return (object)array(
            'id' => $post->ID,
            'label' => $post->post_title
        );
    }

    $query = array(
        'numberposts'   => -1,
        'post_type'     => 'object',
        'post_status'   => 'publish'
    );
    $all_objects = get_posts( $query );
    $result = array();
    foreach ($all_objects as $object) {
        $o = prepare_gift_object($object);
        if ($o) {
            $result[] = $o;
        }
    }
?>

    // create an array with nodes
    var nodes = new vis.DataSet(<?php echo json_encode($result); ?>);

    // create an array with edges
    var edges = new vis.DataSet([
        {from: 1, to: 3},
        {from: 1, to: 2},
        {from: 2, to: 4},
        {from: 2, to: 5}
    ]);

    // create a network
    var container = document.getElementById('mynetwork');

    // provide the data in the vis format
    var data = {
        nodes: nodes,
        edges: edges
    };
    var options = {};

    // initialize your network!
    var network = new vis.Network(container, data, options);
});
</script>