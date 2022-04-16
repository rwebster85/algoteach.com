(function($) {
    let demo = document.querySelector('#demo');
    var context = demo.getContext('2d');
    let pi2 = Math.PI * 2;
    let min_width = 530;
    let height;

    const graph = {
        'A': {x: 92.0, y: 101.0, adj: ["B", "C", "E"]},
        'B': {x: 92.0, y: 326.0, adj: ["A", "C", "D", "F"]},
        'C': {x: 190.0, y: 225.0, adj: ["A", "B", "D", "E"]},
        'D': {x: 362.0, y: 225.0, adj: ["B", "C", "F"]},
        'E': {x: 460.0, y: 101.0, adj: ["A", "C", "F"]},
        'F': {x: 460.0, y: 326.0, adj: ["B", "D", "E"]}
    };

    const graph_adj = {};
    for (let node in graph) {
        graph_adj[node] = graph[node].adj;
    }

    const filled = greedyColour(graph_adj);

    function init() {
        demo.width = min_width;
        demo.height = height;

        drawLines(graph);
        drawCircles(graph);
        
        $('#demo-result').css('max-width', min_width);
    }

    $(document).ready(function() {
        $('.entry-content .wp-post-image').css('display', 'none');
        height = $('.demo-outer').height();
        init();
    });

    // Code adapted from Hajibaba, 2019
    function drawCircles(graph) {
        context.font = '22pt Consolas';
        context.textAlign = 'center';
        context.strokeStyle = '#000000';
        context.lineWidth = 2;
        for (let node in graph) {
            context.beginPath();
            let colour = filled[node];
            if (colour == 'Blue') {
                colour = '#ccccff';
            }
            context.fillStyle = colour;
            x = graph[node].x,
            y = graph[node].y;
            drawSinglePoint(x, y, 30, 0, pi2);
            context.fill();
            context.fillStyle = '#000000';
            context.fillText(node, x, y + 8);
            context.stroke();
            context.closePath();
        }
        let result_text = '';
        for (let node in filled) {
            result_text += node + ' -> ' + filled[node] + '<br>';
        }
        $('#demo-result p').html('Result:<br>' + result_text);
    }
    //end of adapted code

    function drawSinglePoint(x, y, radius, start, end) {
        context.moveTo(x + radius, y);
        context.arc(x, y, radius, start, end);
    }

    function drawLines(graph) {
        context.strokeStyle = '#000000';
        context.lineWidth = 2;
        context.beginPath();
        for (let node in graph) {
            x = graph[node].x,
            y = graph[node].y;
            adj = graph[node].adj;
            context.moveTo(x, y);
            for (let adj_node in adj) {
                context.moveTo(x, y);
                let circle = adj[adj_node];
                let circle_in_graph = graph[circle];
                drawSingleLine(circle_in_graph.x, circle_in_graph.y);
            }
        }
        context.stroke();
    }

    function drawSingleLine(x, y) {
        context.lineTo(x, y);
    }
})(jQuery);

// Code adapted from Mudiyanto, 2022
function greedyColour(graph) {
    let results = {};
    let colours = {};
    
    for (let node in graph) {
        colours[node] = ["Blue", "Red", "Yellow", "Green"];
    }

    var items = Object.keys(graph).map(function(key) {
        return [key, graph[key]];
    });

    items.sort(function(first, second) {
        return second[1].length - first[1].length;
    });

    let sorted = {};
    for (let item in items) {
        let id = items[item][0];
        let adj = items[item][1];
        sorted[id] = adj;
    }

    for (let node in sorted) {
        colour = colours[node];
        results[node] = colour[0];
        adjacent = sorted[node];
        for (let adj_node in adjacent) {
            let node_letter = adjacent[adj_node];
            if (colours[node_letter].includes(colour[0])) {
                let index = colours[node_letter].indexOf(colour[0]);
                if (index !== -1) {
                    colours[node_letter].splice(index, 1);
                }
            }
        }
    }

    return Object.keys(results).sort().reduce(
        (value, key) => ({...value, [key]: results[key]}), {}
    );
}   

// Result:
// A -> Yellow
// B -> Blue
// C -> Red
// D -> Yellow
// E -> Blue
// F -> Red
// end of adapted code
