// Dijkstra's Shortest Path

// https://levelup.gitconnected.com/finding-the-shortest-path-in-javascript-dijkstras-algorithm-8d16451eea34
// https://github.com/noamsauerutley/shortest-path

// Code adapted from Sauer-Utley, 2021
const graph = {
	A: { B: 5, C: 2 },
	B: { A: 1, D: 4, E: 2 },
	C: { B: 8, E: 7 },
	D: { E: 6, F: 3 },
	E: { F: 1 },
	F: {},
};

const shortestDistanceNode = (distances, visited) => {
	let shortest = null;
	for (let node in distances) {
		let currentIsShortest =
			shortest === null || distances[node] < distances[shortest];
		if (currentIsShortest && !visited.includes(node)) {
			shortest = node;
		}
	}
	return shortest;
};

const findShortestPath = (graph, startNode, endNode) => {
	let results = {'distance': null, 'path': null}

	if (!graph[startNode] || !graph[endNode]) {
		return results;
	}

	let distances = {};
	distances[endNode] = "Infinity";
	distances = Object.assign(distances, graph[startNode]);

	let parents = { endNode: null };
	for (let child in graph[startNode]) {
		parents[child] = startNode;
	}

	let visited = [];

	let node = shortestDistanceNode(distances, visited);

	while (node) {
		let distance = distances[node];
		let children = graph[node];

		for (let child in children) {
			if (String(child) === String(startNode)) {
				continue;
			} else {
				let newdistance = distance + children[child];
				if (!distances[child] || distances[child] > newdistance) {
					distances[child] = newdistance;
					parents[child] = node;
				}
			}
		}
		visited.push(node);
		node = shortestDistanceNode(distances, visited);
	}

	let shortestPath = [endNode];
	let parent = parents[endNode];
	while (parent) {
		shortestPath.push(parent);
		parent = parents[parent];
	}
	shortestPath.reverse();

	results = {
		distance: distances[endNode],
		path: shortestPath,
	};

	return results;
};

shortest = findShortestPath(graph, "A", "F");
console.log(JSON.stringify(shortest));
// Result: {"distance":8,"path":["A","B","E","F"]}

// Tests

// Result: {"distance":8,"path":["A","B","E","F"]}
/*
var start_end = findShortestPath(graph, "A", "F");
console.log(start_end);
console.log("start_end.path: " + start_end.path);
console.log("Formatted: " + pathFormatted(start_end.path));
> {
  	distance: 8
	path: (4) ["A", "B", "E", "F"]
}
*/

/*
var start_end = findShortestPath(graph, "B", "C");
console.log(start_end);
console.log("start_end.path: " + start_end.path);
console.log("Formatted: " + pathFormatted(start_end.path));
/*
> {
  distance: 3
  path: (3) ["B", "A", "C"]
}

var start_end = findShortestPath(graph, "B", "A");
console.log(start_end);
console.log("start_end.path: " + start_end.path);
console.log("Formatted: " + pathFormatted(start_end.path));

> {
distance: 1
path: (2) ["B", "A"]
}
*/

// end of adapted code
