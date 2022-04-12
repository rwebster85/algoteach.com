// https://levelup.gitconnected.com/finding-the-shortest-path-in-javascript-dijkstras-algorithm-8d16451eea34
// https://github.com/noamsauerutley/shortest-path

const findShortestPathWithLogs = (graph, startNode, endNode) => {
	// establish object for recording distances from the start node
	let distances = {};
	distances[endNode] = "Infinity";
	distances = Object.assign(distances, graph[startNode]);

	// track paths
	let parents = { endNode: null };
	for (let child in graph[startNode]) {
		parents[child] = startNode;
	}

	// track nodes that have already been visited
	let visited = [];

	// find the nearest node
	let node = shortestDistanceNode(distances, visited);

	// for that node
	while (node) {
		// find its distance from the start node & its child nodes
		let distance = distances[node];
		let children = graph[node];
		// for each of those child nodes
		for (let child in children) {
			// make sure each child node is not the start node
			if (String(child) === String(startNode)) {
				console.log("don't return to the start node! 🙅");
				continue;
			} else {
				console.log("startNode: " + startNode);
				console.log("distance from node " + parents[node] + " to node " + node + ")");
				console.log("previous distance: " + distances[node]);
				// save the distance from the start node to the child node
				let newdistance = distance + children[child];
				console.log("new distance: " + newdistance);
				// if there's no recorded distance from the start node to the child node in the distances object
				// or if the recorded distance is shorter than the previously stored distance from the start node to the child node
				// save the distance to the object
				// record the path
				if (!distances[child] || distances[child] > newdistance) {
					distances[child] = newdistance;
					parents[child] = node;
					console.log("distance + parents updated");
				} else {
					console.log("not updating, because a shorter path already exists!");
				}
			}
		}
		// move the node to the visited set
		visited.push(node);
		// move to the nearest neighbor node
		node = shortestDistanceNode(distances, visited);
	}

	// using the stored paths from start node to end node
	// record the shortest path
	let shortestPath = [endNode];
	let parent = parents[endNode];
	while (parent) {
		shortestPath.push(parent);
		parent = parents[parent];
	}
	shortestPath.reverse();

	// return the shortest path from start node to end node & its distance
	let results = {
		distance: distances[endNode],
		path: shortestPath,
	};

	return results;
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
	// establish object for recording distances from the start node
	let distances = {};
	distances[endNode] = "Infinity";
	distances = Object.assign(distances, graph[startNode]);

	// track paths
	let parents = { endNode: null };
	for (let child in graph[startNode]) {
		parents[child] = startNode;
	}

	// track nodes that have already been visited
	let visited = [];

	// find the nearest node
	let node = shortestDistanceNode(distances, visited);

	// for that node
	while (node) {
		// find its distance from the start node & its child nodes
		let distance = distances[node];
		let children = graph[node];
		// for each of those child nodes
		for (let child in children) {
			// make sure each child node is not the start node
			if (String(child) === String(startNode)) {
				continue;
			} else {
				// save the distance from the start node to the child node
				let newdistance = distance + children[child];
				// if there's no recorded distance from the start node to the child node in the distances object
				// or if the recorded distance is shorter than the previously stored distance from the start node to the child node
				// save the distance to the object
				// record the path
				if (!distances[child] || distances[child] > newdistance) {
					distances[child] = newdistance;
					parents[child] = node;
				}
			}
		}
		// move the node to the visited set
		visited.push(node);
		// move to the nearest neighbor node
		node = shortestDistanceNode(distances, visited);
	}

	// using the stored paths from start node to end node
	// record the shortest path
	let shortestPath = [endNode];
	let parent = parents[endNode];
	while (parent) {
		shortestPath.push(parent);
		parent = parents[parent];
	}
	shortestPath.reverse();

	// return the shortest path from start node to end node & its distance
	let results = {
		distance: distances[endNode],
		path: shortestPath,
	};

	return results;
};

function pathFormatted(path) {
    let formatted_path = '';

    let path_size = path.length - 1;
    for (let i = 0; i < path.length; i++) {
        formatted_path += path[i];
        if (path_size > i) {
            formatted_path += " --> ";
        }
    }

    return formatted_path;
}

const graph = {
	A: { B: 5, C: 2 },
	B: { A: 1, D: 4, E: 2 },
	C: { B: 8, E: 7 },
	D: { E: 6, F: 3 },
	E: { F: 1 },
	F: {},
};

/*
test(`shortest path from 'start' to 'end' should be 8 with start-A-D-end`, () => {
  const shortestPath = findShortestPathWithLogs(graph, 'start', 'end');
  expect(shortestPath).toEqual({
    distance: 8,
    path: ['start', 'A', 'D', 'end'],
  });
});
*/

var start_end = findShortestPath(graph, "A", "F");
console.log(start_end);
console.log("start_end.path: " + start_end.path);
console.log("Formatted: " + pathFormatted(start_end.path));
/*
> {
  	distance: 8
	path: (4) ["A", "B", "E", "F"]
}
*/

var start_end = findShortestPath(graph, "B", "C");
console.log(start_end);
console.log("start_end.path: " + start_end.path);
console.log("Formatted: " + pathFormatted(start_end.path));
/*
> {
  distance: 3
  path: (3) ["B", "A", "C"]
}
*/
var start_end = findShortestPath(graph, "B", "A");
console.log(start_end);
console.log("start_end.path: " + start_end.path);
console.log("Formatted: " + pathFormatted(start_end.path));
/*
> {
distance: 1
path: (2) ["B", "A"]
}
*/
