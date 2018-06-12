<div id="d3vis"></div>
<div id="controls">
    <button id="zoomin">+</button>
    <button id="zoomout">-</button>
</div>
<script src="https://d3js.org/d3.v4.min.js"></script>
<script>

// try https://bl.ocks.org/mbostock/3680999

var svg = d3.select(document.getElementById('d3vis')).append('svg'),
    width = window.innerWidth,
    height = window.innerHeight;

svg.attr('width', width).attr('height', height);

//var g = svg.append("g");

var color = d3.scaleOrdinal(d3.schemeCategory20);

var simulation = d3.forceSimulation()
    .force("link", d3.forceLink().distance(10).strength(0.5))
    .force("charge", d3.forceManyBody())
    .force("center", d3.forceCenter(width / 2, height / 2));

/*svg.append("rect")
    .attr("fill", "none")
    .attr("pointer-events", "all")
    .attr("width", width)
    .attr("height", height)
    .call(d3.zoom()
        .scaleExtent([1, 8])
        .on("zoom", zoom));

function zoom() {
  svg.attr("transform", d3.event.transform);
}*/

<?php
    $graph = (object)array( 
        'nodes' => array(),
        'links' => array()
    );

    $query = array(
		'numberposts'   => -1,
		'post_type'     => 'gift',
		'post_status'   => 'publish'
    );
    if( !current_user_can('administrator') ) {
        $current_user = wp_get_current_user();
    }
    $all_gifts = get_posts( $query );
    foreach ($all_gifts as $gift) {
        // sender
        $senderdata = get_userdata($gift->post_author);

        $found = false;
        foreach ($graph->nodes as $node) {
            if ($node->id == 'user-'.$senderdata->ID) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $graph->nodes[] = (object)array( 
                "id" => 'user-'.$senderdata->ID,
                "group" => 1,
                'user_id' => $senderdata->ID,
                'title' => urldecode($senderdata->nickname)
            );
        }

        // recipient
        $recipients = get_field( 'field_58e4f6e88f3d7', $gift->ID );
        unset($recipientdata);
        if ($recipients) {
            foreach ($recipients as $recipient) {
                $recipientdata = get_userdata($recipient['ID']);

                $found = false;
                foreach ($graph->nodes as $node) {
                    if ($node->id == 'user-'.$recipientdata->ID) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $graph->nodes[] = (object)array( 
                        "id" => 'user-'.$recipientdata->ID,
                        "group" => 1,
                        'user_id' => $recipientdata->ID,
                        'title' => urldecode($recipientdata->nickname)
                    );
                }
                break; // only one recipient for now
            }
        }

        
        $wraps = get_field( 'field_58e4f5da816ac', $gift->ID);
        unset($object, $venue);
        if ($wraps) {
            foreach ($wraps as $wrap) {
                $object = get_field( 'field_595b4a2bc9c1c', $wrap->ID);
                if (is_array($object) && count($object) > 0) {
                    $object = $object[0];
                } else if (is_a($object, 'WP_Post')) {
                        
                } else {
                    unset($object);
                }  
                if ($object) {
                    $found = false;
                    foreach ($graph->nodes as $node) {
                        if ($node->id == 'object-'.$object->ID) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $graph->nodes[] = (object)array( 
                            "id" => 'object-'.$object->ID,
                            "group" => 2,
                            'object_id' => $object->ID,
                            'title' => $object->post_title
                        );
                    }

                    if ($senderdata) {
                        $graph->links[] = (object)array(
                            "source" => 'user-'.$senderdata->ID,
                            "target" => 'object-'.$object->ID,
                            "value" => 1
                        );
                    }

                    if ($recipientdata) {
                        $graph->links[] = (object)array(
                            "source" => 'object-'.$object->ID,
                            "target" => 'user-'.$recipientdata->ID,
                            "value" => 1
                        );
                    }
                }
            }
        }

    }

?>


var graph = <?php echo json_encode($graph); ?>;

var nodes = graph.nodes,
    nodeById = d3.map(nodes, function(d) { return d.id; }),
    links = graph.links,
    bilinks = [];

links.forEach(function(link) {
    var s = link.source = nodeById.get(link.source),
        t = link.target = nodeById.get(link.target),
        i = {}; // intermediate node
    nodes.push(i);
    links.push({source: s, target: i}, {source: i, target: t});
    bilinks.push([s, i, t]);
});

var linkElements = svg.selectAll(".link")
    .data(bilinks)
    .enter().append("path")
        .attr("class", "link");

var nodeElements = svg.selectAll(".node")
.data(nodes.filter(function(d) { return d.id; }))
.enter().append("circle")
    .attr("class", "node")
    .attr("r", 5)
    .attr("fill", function(d) { return color(d.group); })
    .call(d3.drag()
        .on("start", dragstarted)
        .on("drag", dragged)
        .on("end", dragended));

var textElements = svg.selectAll(".text")
    .data(nodes.filter(function(d) { return d.id; }))
    .enter().append("text")
    .text(function (d) { return d.title; })
    .attr('font-size', 15)
    .attr ('dx', 15 )
    .attr ('dy', 4 );

nodeElements.on('click', selectNode);

simulation
    .nodes(nodes)
    .on("tick", ticked);

simulation.force("link")
    .links(links);

jQuery(function($) {
    $('#zoomin').click(function () {
        console.log(nodeElements);
    });
});

function ticked() {
    linkElements.attr("d", positionLink);
    nodeElements.attr("transform", positionNode);
    textElements.attr("transform", positionNode);
}

function positionLink(d) {
  return "M" + d[0].x + "," + d[0].y
       + "S" + d[1].x + "," + d[1].y
       + " " + d[2].x + "," + d[2].y;
}

function positionNode(d) {
  return "translate(" + d.x + "," + d.y + ")";
}

function dragstarted(d) {
  if (!d3.event.active) simulation.alphaTarget(0.3).restart();
  d.fx = d.x, d.fy = d.y;
}

function dragged(d) {
  d.fx = d3.event.x, d.fy = d3.event.y;
}

function dragended(d) {
  if (!d3.event.active) simulation.alphaTarget(0);
  d.fx = null, d.fy = null;
}

function getNeighbours(node) {
    var neighbours = [];
    for (i in links) {
        if (isNeighbourLink(node, links[i])) {
            neighbours.push(links[i]);
        }
    }
    return neighbours;
}

function isNeighbourLink(node, link) {
  return link.source.id && link.value && link.source.id === node.id;
}

function getNodeColor(node, neighbours) {
    for (i in neighbours) {
        if (neighbours[i].target.id === node.id) {
            return 'green';
        } else if (neighbours[i].source.id === node.id) {
            return 'blue';
        }
    }
    return node.group === 1 ? '#888888' : '#CCCCCC';
}

function getTextColor(node, neighbours) {
    for (i in neighbours) {
        if (neighbours[i].target.id === node.id) {
            return 'green';
        } else if (neighbours[i].source.id === node.id) {
            return 'blue';
        }
    }
    return node.group === 1 ? '#888888' : '#CCCCCC';
}

function getTextOpacity(node, neighbours) {
    for (i in neighbours) {
        if (neighbours[i].target.id === node.id || neighbours[i].source.id === node.id) {
            return 1;
        }
    }
    return .2;
}

function getLinkColor(node, link) {
    return link[0].id === node.id ? 'green' : '#BBBBBB';
}

function getLinkOpacity(node, link) {
    return link[0].id === node.id ? 1 : .2;
}

function getNodeSize (node, selectedNode) {
    return node === selectedNode ? 10 : 5;
}

function selectNode(selectedNode) {
    const neighbours = getNeighbours(selectedNode);
    nodeElements.attr('fill', node => getNodeColor(node, neighbours));
    nodeElements.attr('r', node => getNodeSize(node, selectedNode));
    textElements.attr('fill', node => getTextColor(node, neighbours));
    textElements.attr('fill-opacity', link => getTextOpacity(node, neighbours));
    linkElements.attr('stroke', link => getLinkColor(selectedNode, link));
    linkElements.attr('opacity', link => getLinkOpacity(selectedNode, link));
}

</script>