// Code adapted from GoJS, 2022
function init() {

    // Since 2.2 you can also author concise templates with method chaining instead of GraphObject.make
    // For details, see https://gojs.net/latest/intro/buildingObjects.html
    const $ = go.GraphObject.make;    // for conciseness in defining templates

    myDiagram =
        $(go.Diagram, "rich-algo-shortest-path-example", // must be the ID or a reference to a DIV
            {
                initialAutoScale: go.Diagram.Uniform,
                contentAlignment: go.Spot.Center,
                layout: $(go.ForceDirectedLayout, { defaultSpringLength: 2, maxIterations: 300 }),
                maxSelectionCount: 2
            });

    // define the Node template
    myDiagram.nodeTemplate =
        $(go.Node, "Horizontal",
            {
                locationSpot: go.Spot.Center,    // Node.location is the center of the Shape
                locationObjectName: "SHAPE",
                selectionAdorned: false,
                selectionChanged: nodeSelectionChanged    // defined below
            },
            $(go.Panel, "Spot",
                $(go.Shape, "Circle",
                    {
                        name: "SHAPE",
                        fill: "lightgray",    // default value, but also data-bound
                        strokeWidth: 0,
                        desiredSize: new go.Size(40, 40),
                        portId: ""    // so links will go to the shape, not the whole node
                    },
                    new go.Binding("fill", "isSelected", (s, obj) => s ? "red" : obj.part.data.color).ofObject()),
                $(go.TextBlock,
                    new go.Binding("text", "distance", d => (d === Infinity) ? "INF" : d | 0))),
            $(go.TextBlock,
                new go.Binding("text"))
        );

    // define the Link template
    myDiagram.linkTemplate =
        $(go.Link,
            {
                selectable: false,            // links cannot be selected by the user
                curve: go.Link.Bezier,
                layerName: "Background"    // don't cross in front of any nodes
            },
            $(go.Shape,    // this shape only shows when it isHighlighted
                { isPanelMain: true, stroke: null, strokeWidth: 5 },
                new go.Binding("stroke", "isHighlighted", h => h ? "red" : null).ofObject()),
            $(go.Shape,
                // mark each Shape to get the link geometry with isPanelMain: true
                { isPanelMain: true, stroke: "black", strokeWidth: 1 },
                new go.Binding("stroke", "color")),
            $(go.Shape, { toArrow: "Standard" })
        );

    // Override the clickSelectingTool's standardMouseSelect
    // If less than 2 nodes are selected, always add to the selection
    myDiagram.toolManager.clickSelectingTool.standardMouseSelect = function() {
        const diagram = this.diagram;
        if (diagram === null || !diagram.allowSelect) return;
        var e = diagram.lastInput;
        var count = diagram.selection.count;
        var curobj = diagram.findPartAt(e.documentPoint, false);
        if (curobj !== null) {
            if (count < 2) {    // add the part to the selection
                if (!curobj.isSelected) {
                    var part = curobj;
                    if (part !== null) part.isSelected = true;
                }
            } else {
                if (!curobj.isSelected) {
                    var part = curobj;
                    if (part !== null) diagram.select(part);
                }
            }
        } else if (e.left && !(e.control || e.meta) && !e.shift) {
            // left click on background with no modifier: clear selection
            diagram.clearSelection();
        }
    }

    generateGraph();

    chooseTwoNodes();
}

// Create an assign a model that has a bunch of nodes with a bunch of random links between them.
function generateGraph() {
    var names = [
        "A", "B", "C", "D", "E", "F", "G", "H", "I"
    ];

    var nodeDataArray = [];
    for (var i = 0; i < names.length; i++) {
        nodeDataArray.push({ key: i, text: names[i], color: go.Brush.randomColor(128, 240) });
    }

    var linkDataArray = [];
    var num = nodeDataArray.length;
    for (var i = 0; i < num * 2; i++) {
        var a = Math.floor(i/2);
        var b = Math.floor(Math.random() * num / 4) + 1;
        linkDataArray.push({ from: a, to: (a + b) % num, color: go.Brush.randomColor(0, 127) });
    }

    myDiagram.model = new go.GraphLinksModel(nodeDataArray, linkDataArray);
}

// Select two nodes at random for which there is a path that connects from the first one to the second one.
function chooseTwoNodes() {
    myDiagram.clearSelection();
    var num = myDiagram.model.nodeDataArray.length;
    var node1 = null;
    var node2 = null;
    for (var i = Math.floor(Math.random()*num); i < num*2; i++) {
        node1 = myDiagram.findNodeForKey(i%num);
        var distances = findDistances(node1);
        for (var j = Math.floor(Math.random()*num); j < num*2; j++) {
            node2 = myDiagram.findNodeForKey(j%num);
            var dist = distances.get(node2);
            if (dist > 1 && dist < Infinity) {
                node1.isSelected = true;
                node2.isSelected = true;
                break;
            }
        }
        if (myDiagram.selection.count > 0) break;
    }
}


// This event handler is declared in the node template and is called when a node's
//     Node.isSelected property changes value.
// When a node is selected show distances from the first selected node.
// When a second node is selected, highlight the shortest path between two selected nodes.
// If a node is deselected, clear all highlights.
function nodeSelectionChanged(node) {
    var diagram = node.diagram;
    if (diagram === null) return;
    diagram.clearHighlighteds();
    if (node.isSelected) {
        // show the distance for each node from the selected node
        var begin = diagram.selection.first();
        showDistances(begin);

        if (diagram.selection.count === 2) {
            var end = node;    // just became selected

            // highlight the shortest path
            highlightShortestPath(begin, end);
        }
    }
}


// Have each node show how far it is from the BEGIN node.
// This sets the "distance" property on each node.data.
function showDistances(begin) {
    // compute and remember the distance of each node from the BEGIN node
    distances = findDistances(begin);

    // show the distance on each node
    var it = distances.iterator;
    while (it.next()) {
        var n = it.key;
        var dist = it.value;
        myDiagram.model.setDataProperty(n.data, "distance", dist);
    }
}


// Highlight links along one of the shortest paths between the BEGIN and the END nodes.
// Assume links are directional.
function highlightShortestPath(begin, end) {
    highlightPath(findShortestPath(begin, end));
}


// A collection of all of the paths between a pair of nodes, a List of Lists of Nodes
var paths = null;

// Return a string representation of a path for humans to read.
function pathToString(path) {
    var s = path.length + ": ";
    for (var i = 0; i < path.length; i++) {
        if (i > 0) s += " -- ";
        s += path.get(i).data.text;
    }
    return s;
}

// Highlight a particular path, a List of Nodes.
function highlightPath(path) {
    myDiagram.clearHighlighteds();
    for (var i = 0; i < path.count - 1; i++) {
        var f = path.get(i);
        var t = path.get(i + 1);
        f.findLinksTo(t).each(l => l.isHighlighted = true);
    }
}


// There are three bits of functionality here:
// 1: findDistances(Node) computes the distance of each Node from the given Node.
//        This function is used by showDistances to update the model data.
// 2: findShortestPath(Node, Node) finds a shortest path from one Node to another.
//        This uses findDistances.    This is used by highlightShortestPath.
// 3: collectAllPaths(Node, Node) produces a collection of all paths from one Node to another.
//        This is used by listAllPaths.    The result is remembered in a global variable
//        which is used by highlightSelectedPath.    This does not depend on findDistances.

// Returns a Map of Nodes with distance values from the given source Node.
// Assumes all links are directional.
function findDistances(source) {
    var diagram = source.diagram;
    // keep track of distances from the source node
    var distances = new go.Map(/*go.Node, "number"*/);
    // all nodes start with distance Infinity
    var nit = diagram.nodes;
    while (nit.next()) {
        var n = nit.value;
        distances.set(n, Infinity);
    }
    // the source node starts with distance 0
    distances.set(source, 0);
    // keep track of nodes for which we have set a non-Infinity distance,
    // but which we have not yet finished examining
    var seen = new go.Set(/*go.Node*/);
    seen.add(source);

    // keep track of nodes we have finished examining;
    // this avoids unnecessary traversals and helps keep the SEEN collection small
    var finished = new go.Set(/*go.Node*/);
    while (seen.count > 0) {
        // look at the unfinished node with the shortest distance so far
        var least = leastNode(seen, distances);
        var leastdist = distances.get(least);
        // by the end of this loop we will have finished examining this LEAST node
        seen.delete(least);
        finished.add(least);
        // look at all Links connected with this node
        var it = least.findLinksOutOf();
        while (it.next()) {
            var link = it.value;
            var neighbor = link.getOtherNode(least);
            // skip nodes that we have finished
            if (finished.has(neighbor)) continue;
            var neighbordist = distances.get(neighbor);
            // assume "distance" along a link is unitary, but could be any non-negative number.
            var dist = leastdist + 1;    //Math.sqrt(least.location.distanceSquaredPoint(neighbor.location));
            if (dist < neighbordist) {
                // if haven't seen that node before, add it to the SEEN collection
                if (neighbordist === Infinity) {
                    seen.add(neighbor);
                }
                // record the new best distance so far to that node
                distances.set(neighbor, dist);
            }
        }
    }

    return distances;
}

// This helper function finds a Node in the given collection that has the smallest distance.
function leastNode(coll, distances) {
    var bestdist = Infinity;
    var bestnode = null;
    var it = coll.iterator;
    while (it.next()) {
        var n = it.value;
        var dist = distances.get(n);
        if (dist < bestdist) {
            bestdist = dist;
            bestnode = n;
        }
    }
    return bestnode;
}


// Find a path that is shortest from the BEGIN node to the END node.
// (There might be more than one, and there might be none.)
function findShortestPath(begin, end) {
    // compute and remember the distance of each node from the BEGIN node
    distances = findDistances(begin);

    // now find a path from END to BEGIN, always choosing the adjacent Node with the lowest distance
    var path = new go.List();
    path.add(end);
    while (end !== null) {
        var next = leastNode(end.findNodesInto(), distances);
        if (next !== null) {
            if (distances.get(next) < distances.get(end)) {
                path.add(next);    // making progress towards the beginning
            } else {
                next = null;    // nothing better found -- stop looking
            }
        }
        end = next;
    }
    // reverse the list to start at the node closest to BEGIN that is on the path to END
    // NOTE: if there's no path from BEGIN to END, the first node won't be BEGIN!
    path.reverse();
    console.log(pathToString(path));
    return path;
}


// Recursively walk the graph starting from the BEGIN node;
// when reaching the END node remember the list of nodes along the current path.
// Finally return the collection of paths, which may be empty.
// This assumes all links are directional.
function collectAllPaths(begin, end) {
    var stack = new go.List(/*go.Node*/);
    var coll = new go.List(/*go.List*/);

    function find(source, end) {
        source.findNodesOutOf().each(n => {
            if (n === source) return;    // ignore reflexive links
            if (n === end) {    // success
                var path = stack.copy();
                path.add(end);    // finish the path at the end node
                coll.add(path);    // remember the whole path
            } else if (!stack.has(n)) {    // inefficient way to check having visited
                stack.add(n);    // remember that we've been here for this path (but not forever)
                find(n, end);
                stack.removeAt(stack.count - 1);
            }    // else might be a cycle
        });
    }

    stack.add(begin);    // start the path at the begin node
    find(begin, end);
    return coll;
}
window.addEventListener('DOMContentLoaded', init);
// End of adapted code
