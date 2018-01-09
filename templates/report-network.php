<?php
/**
 * Index page template for analytics.
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
var apiBase = "https://gifting.digital/wp-json/gift/v3/";

jQuery(function($) {
	$.backstretch('<?php echo get_stylesheet_directory_uri(); ?>/images/backstretch/index-welcome.jpg');

    // create an array with nodes
    var nodes = new vis.DataSet([
        {id: 1, label: 'Node 1'},
        {id: 2, label: 'Node 2'},
        {id: 3, label: 'Node 3'},
        {id: 4, label: 'Node 4'},
        {id: 5, label: 'Node 5'}
    ]);

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

/*  $('#step3_local_button').on('click', function () {
        jQuery('.preloader').show();
        var request = jQuery.ajax({
            dataType: "json",
            cache: false,
            url: apiBase + "validate/receiver/" + 'localbrighton@gifting.digital',
            method: "GET"
        });
        request.done(function( data ) {
            if (data.success && typeof(data.exists) != 'undefined' && data.exists) {
                receiver = data.exists;
                jQuery('.receiverName').text(decodeURIComponent(receiver.data.nickname));
                jQuery('#step2b').slideToggle(function () {
                    jQuery('#step3').slideToggle();
                });
            } else {
                console.log(data);
                setTimeout(function () {
                    window.location.replace("https://gifting.digital");
                }, 3000);
            }
            jQuery('.preloader').fadeOut();
        });
        request.fail(function( jqXHR, textStatus ) {
            console.log( "Request failed: " + textStatus );
            setTimeout(function () {
                window.location.replace("https://gifting.digital");
            }, 3000);
            jQuery('.preloader').fadeOut();
        });
    });*/

});
</script>