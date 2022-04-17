# Dijkstra's Shortest Path

# Sauer-Utley, N. (2021, December 14). Finding the Shortest Path in Javascript: Dijkstra's Algorithm. Level Up Coding. Retrieved 12 April 2022, from https://levelup.gitconnected.com/finding-the-shortest-path-in-javascript-dijkstras-algorithm-8d16451eea34

# Python 3.5+

# Code adapted from Sauer-Utley, 2021
graph = {
	"A": { "B": 5, "C": 2},
	"B": { "A": 1, "D": 4, "E": 2},
	"C": { "B": 8, "E": 7 },
	"D": { "E": 6, "F": 3 },
	"E": { "F": 1 },
	"F": {},
}

def shortestDistanceNode(distances, visited):
	shortest = None
	for node in distances:
		currentIsShortest = \
			shortest == None or distances[node] < distances[shortest]
		if currentIsShortest != False and node not in visited:
			shortest = node
	return shortest

def findShortestPath(graph, startNode, endNode):
	results = {'distance': None, 'path': None}

	if startNode not in graph or endNode not in graph:
		return results

	distances = {}
	distances[endNode] = float('inf')
	distances = {**distances, **graph[startNode]}

	parents = {endNode: None }
	for child in graph[startNode]:
		parents[child] = startNode

	visited = []

	node = shortestDistanceNode(distances, visited)

	while node:
		distance = distances[node]
		children = graph[node]

		for child in children:
			if (str(child) == str(startNode)):
				continue
			else:
				newdistance = distance + children[child]
				if child not in distances or distances[child] > newdistance:
					distances[child] = newdistance
					parents[child] = node

		visited.append(node)
		node = shortestDistanceNode(distances, visited)

	shortestPath = [endNode]
	parent = parents[endNode]
	while parent:
		shortestPath.append(parent)
		parent = parents[parent] if parent in parents else None
	
	shortestPath.reverse()

	results['distance'] = distances[endNode]
	results['path'] = shortestPath

	return results

shortest = findShortestPath(graph, "A", "F")
print(shortest)
# Result: {'distance': 8, 'path': ['A', 'B', 'E', 'F']}

# end of adapted code
