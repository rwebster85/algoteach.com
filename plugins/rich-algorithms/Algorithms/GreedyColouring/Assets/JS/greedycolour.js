// Code adapted from Mudiyanto, 2022
function greedyColour(graph, colour_selection) {
    let results = {};
    let colours = {};

    for (let node in graph) {
        colours[node] = colour_selection.slice();
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
        let colour = colours[node];
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
// end of adapted code
