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
    $query = array(
        'numberposts'   => -1,
        'post_type'     => 'object',
        'post_status'   => 'publish'
    );
    $all_objects = get_posts( $query );
    $result = array();
    foreach ($all_objects as $object) {
        $location = get_field( 'field_59a85fff4be5a', $object->ID );
        if (!$location || count($location) == 0) {
            
        } else {
            $result[] = (object)array(
                'id' => $object->ID,
                'label' => $object->post_title
            );
        }
    }

    $edges = array(); // {from: ?, to: ?}
?>

    // create an array with nodes
    var nodes = new vis.DataSet(<?php echo json_encode($result); ?>);

    // create an array with edges
    var edges = new vis.DataSet();

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