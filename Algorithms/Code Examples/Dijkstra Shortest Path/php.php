<?php
// Dijkstra's Shortest Path

// https://levelup.gitconnected.com/finding-the-shortest-path-in-javascript-dijkstras-algorithm-8d16451eea34
// https://github.com/noamsauerutley/shortest-path

// PHP 7+

// Code adapted from Sauer-Utley, 2021
$graph = [
    'A' => ['B' => 5, 'C' => 2],
    'B' => ['A' => 1, 'D' => 4, 'E' => 2],
    'C' => ['B' => 8, 'E' => 7],
    'D' => ['E' => 6, 'F' => 3],
    'E' => ['F' => 1],
    'F' => [],
];

function shortestDistanceNode(array $distances, array $visited): mixed
{
    $shortest = null;
    foreach ($distances as $key => $node) {
        $currentIsShortest =
            $shortest == null
            || $distances[$key] < $distances[$shortest];
        if ($currentIsShortest && !in_array($key, $visited)) {
            $shortest = $key;
        }
    }
    return $shortest;
}

function findShortestPath(
    array $graph = [],
    string $startNode = '',
    string $endNode = ''
): array {

    $results = ['distance' => null, 'path' => null];

    if (
        !array_key_exists($startNode, $graph)
        || !array_key_exists($endNode, $graph)
    ) {
        return $results;
    }

    $distances = [];

    $distances[$endNode] = "Infinity";
    $distances = array_merge($distances, $graph[$startNode]);

    $parents['endNode'] = null;
    foreach ($graph[$startNode] as $key => $child) {
        $parents[$key] = $startNode;
    }

    $visited = [];

    $node = shortestDistanceNode($distances, $visited);

    while ($node) {
        $distance = $distances[$node];
        $children = $graph[$node];

        foreach ($children as $child => $value) {
            if ($child === $startNode) {
                continue;
            }
            $new_distance = $distance + $value;
            if (!isset($distances[$child]) || $distances[$child] > $new_distance) {
                $distances[$child] = $new_distance;
                $parents[$child] = $node;
            }
        }

        $visited[] = $node;
        $node = shortestDistanceNode($distances, $visited);
    }

    $shortestPath = [$endNode];
	$parent = $parents[$endNode];

	while ($parent) {
		$shortestPath[] = $parent;
		$parent = ($parents[$parent] ?? null);
	}

    $shortestPath = array_reverse($shortestPath);

    $results['distance'] = $distances[$endNode];
    $results['path'] = $shortestPath;
    return $results;
};

$shortest = findShortestPath($graph, "A", "F");
print(json_encode($shortest));
// Result: {"distance":8,"path":["A","B","E","F"]}

// end of adapted code
