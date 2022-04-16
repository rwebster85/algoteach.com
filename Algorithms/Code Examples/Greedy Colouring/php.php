<?php
// Greedy Colouing Algorithm

// Mudiyanto, F. (2022, January 15). Solve Graph Coloring Problem with Greedy Algorithm and Python. Python in Plain English. Retrieved 15 April 2022, from https://python.plainenglish.io/solve-graph-coloring-problem-with-greedy-algorithm-and-python-6661ab4154bd

// Code adapted from Mudiyanto, 2022
$graph = [
    "A" => ["B", "C", "E"],
    "B" => ["A", "C", "D", "F"],
    "C" => ["A", "B", "D", "E"],
    "D" => ["B", "C", "F"],
    "E" => ["A", "C", "F"],
    "F" => ["B", "D", "E"],
];

function greedyColour(array $graph)
{
    $results = [];
    $colours = [];

    foreach ($graph as $node => $value) {
        $colours[$node] = ["Blue", "Red", "Yellow", "Green"];
    }

    array_multisort(
        array_map('count', $graph),
        SORT_DESC,
        array_keys($graph),
        SORT_ASC,
        $graph
    );

    foreach ($graph as $node => $value) {
        $colour = $colours[$node];
        $results[$node] = $colour[0];
        $adjacent = $value;
        foreach($adjacent as $adj_node) {
            if (in_array($colour[0], $colours[$adj_node])) {
                if (
                    ($key = array_search(
                        $colour[0],
                        $colours[$adj_node]
                    )) !== false)
                {
                    unset($colours[$adj_node][$key]);
                    $colours[$adj_node] = array_values(
                        $colours[$adj_node]
                    );
                }
            }
        }
    }
    
    ksort($results);
    return $results;
}

$filled = greedyColour($graph);

foreach($filled as $node => $colour) {
    print($node . ' -> ' . $colour . "\n");
}

// Result:
// A -> Yellow
// B -> Blue
// C -> Red
// D -> Yellow
// E -> Blue
// F -> Red

// end of adapted code
