# Greedy Colouring Algorithm

# Mudiyanto, F. (2022, January 15). Solve Graph Coloring Problem with Greedy Algorithm and Python. Python in Plain English. Retrieved 15 April 2022, from https://python.plainenglish.io/solve-graph-coloring-problem-with-greedy-algorithm-and-python-6661ab4154bd

# Code adapted from Mudiyanto, 2022
from collections import OrderedDict

graph = {
	"A": ["B", "C", "E"],
	"B": ["A", "C", "D", "F"],
	"C": ["A", "B", "D", "E"],
	"D": ["B", "C", "F"],
	"E": ["A", "C", "F"],
	"F": ["B", "D", "E"],
}

def greedyColour(graph):
	results = {}
	colours = {}
	
	for node in graph:
		colours[node] = ["Blue", "Red", "Yellow", "Green"]

	nodes = OrderedDict(
		sorted(graph.items(),
		key=lambda x: len(x[1]),
		reverse=True)
	)

	for node in nodes:
		colour = colours[node]
		results[node] = colour[0]
		adjacent = nodes[node]
		for adj_node in adjacent:
			if (colour[0] in colours[adj_node]):
				colours[adj_node].remove(colour[0])

	return results

filled = greedyColour(graph)

for node, colour in sorted(filled.items()):
	print(node, "->", colour)

# Result:
# A -> Yellow
# B -> Blue
# C -> Red
# D -> Yellow
# E -> Blue
# F -> Red

# end of adapted code
