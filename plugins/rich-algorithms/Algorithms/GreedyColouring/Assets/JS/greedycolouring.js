(function($) {
    let demo = document.querySelector('#demo');
    var context = demo.getContext('2d');
    let pi2 = Math.PI * 2;
    let min_width = 700;
    let height;

    let colours_selection = ["White", "Pink", "Yellow", "Purple", "Red", "Green", "Blue", "Orange"];

    let first_run = false;

    const graph = {
        'A': {x: 92.0, y: 101.0, adj: ["B", "C", "E"]},
        'B': {x: 92.0, y: 326.0, adj: ["A", "C", "D", "F"]},
        'C': {x: 190.0, y: 225.0, adj: ["A", "B", "D", "E"]},
        'D': {x: 362.0, y: 225.0, adj: ["B", "C", "F"]},
        'E': {x: 460.0, y: 101.0, adj: ["A", "C", "F"]},
        'F': {x: 460.0, y: 326.0, adj: ["B", "D", "E"]}
    };

    const graph_custom = {
        'A': {x: 71.5, y: 85.0, adj: ["B", "C", "D"]},
        'B': {x: 71.5, y: 445.0, adj: ["A", "D", "E", "F"]},
        'C': {x: 233.5, y: 85.0, adj: ["A", "D", "J"]},
        'D': {x: 185.5, y: 270.0, adj: ["A", "B", "C", "E", "I", "J"]},
        'E': {x: 273.5, y: 367.0, adj: ["B", "D", "F", "H", "I"]},
        'F': {x: 402.5, y: 445.0, adj: ["B", "E", "G"]},
        'G': {x: 542.5, y: 369.0, adj: ["F", "H", "K", "L"]},
        'H': {x: 463.5, y: 317.0, adj: ["E", "G", "I", "J"]},
        'I': {x: 384.5, y: 201.0, adj: ["D", "E", "H"]},
        'J': {x: 463.5, y: 85.0, adj: ["C", "D", "H", "K"]},
        'K': {x: 595.5, y: 174.0, adj: ["G", "J", "L"]},
        'L': {x: 635.0, y: 289.0, adj: ["G", "K"]}
    };

    const graph_adj = {};
    for (let node in graph_custom) {
        graph_adj[node] = graph_custom[node].adj;
    }

    let working = null;
    let random_colours = null;
    let filled = null;

    function init() {
        demo.width = min_width;
        demo.height = demo.width * 0.75;

        let colours;

        if (first_run == false) {
            colours = colours_selection.slice();
            first_run = true;
        } else {
            colours = shuffle(colours_selection.slice()).slice();
        }

        filled = greedyColour(graph_adj, colours);

        drawLines(graph_custom);
        drawCircles(graph_custom);
    }

    $(document).ready(function() {
        height = $('.demo-outer').height();
        init();

        $('body').on('click', '.demo-controls #reset-colours', function (e) {
            e.stopImmediatePropagation();
            if (working == true) {
                return false;
            }

            $(this).attr('disabled', true);

            working = true;

            init();

            working = false;

            $(this).attr('disabled', false);

            return false;
        });
    });

    // Code adapted from Hajibaba, 2019
    function drawCircles(graph) {
        context.font = '22pt Consolas';
        context.textAlign = 'center';
        context.strokeStyle = '#000000';
        context.lineWidth = 2;
        for (let node in graph) {
            context.beginPath();
            let colour = hexFromColour(filled[node]);
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
        let colours_only = [];
        for (let node in filled) {
            colours_only.push(filled[node]);
        }
        let colours_used = [...new Set(colours_only)];
        let colours_used_text = colours_used.join(', ');
        result_text += '<br>' + colours_used.length + ' colours used: ';
        result_text += colours_used_text + '.';
        result_text += '<br><br>';
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

    function hexFromColour(colour) {
        let hex = '';
        switch (colour) {
            case 'Blue':
                hex = '#6495ED';
                break;
            case 'Purple':
                hex = '#CF9FFF';
                break;
            case 'Green':
                hex = '#90EE90';
                break;
            case 'Red':
                hex = '#E97451';
                break;
            default:
                hex = colour;
                break;
        }
    
        return hex;
    }

    // Bostock, M. (2012, January 14). Fisher–Yates Shuffle. Mike Bostock. Retrieved 17 April 2022, from https://bost.ocks.org/mike/shuffle/
    // Code adapted from Bostock, 2012
    function shuffle(array) {
        let currentIndex = array.length,  randomIndex;
      
        // While there remain elements to shuffle.
        while (currentIndex != 0) {
      
          // Pick a remaining element.
          randomIndex = Math.floor(Math.random() * currentIndex);
          currentIndex--;
      
          // And swap it with the current element.
          [array[currentIndex], array[randomIndex]] = [
            array[randomIndex], array[currentIndex]];
        }
      
        return array;
    }
    // end of adapted code
})(jQuery);
