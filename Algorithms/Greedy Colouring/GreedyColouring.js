// Greedy Colouring Algorithm

// Mudiyanto, F. (2022, January 15). Solve Graph Coloring Problem with Greedy Algorithm and Python. Python in Plain English. Retrieved 15 April 2022, from https://python.plainenglish.io/solve-graph-coloring-problem-with-greedy-algorithm-and-python-6661ab4154bd

// Code adapted from Mudiyanto, 2022
const graph = {
    "A": ["B", "C", "E"],
    "B": ["A", "C", "D", "F"],
    "C": ["A", "B", "D", "E"],
    "D": ["B", "C", "F"],
    "E": ["A", "C", "F"],
    "F": ["B", "D", "E"],
}

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

let filled = greedyColour(graph)

for (let node in filled) {
    console.log(node + ' -> ' + filled[node]);
}

// Result:
// A -> Yellow
// B -> Blue
// C -> Red
// D -> Yellow
// E -> Blue
// F -> Red

// end of adapted code
