(function($) {
    $(document).ready(function() {
        $(document).on('click', '.rich-algo-copy', function(e) {
            e.preventDefault();
            var element = $(this);
            var textarea = element.closest('.rich-algo-frontend-code-example').find('.rich-algo-frontend-code-example-textarea').val();
            navigator.clipboard.writeText(textarea);
            element.addClass('copied');
            setTimeout(
                function() {
                    if (element.hasClass('copied')) {
                        element.removeClass('copied');
                    }
                },
            1000);
        });

        function djikstraAlgorithm(startNode) {
            let distances = {};
         
            // Stores the reference to previous nodes
            let prev = {};
            let pq = new PriorityQueue(this.nodes.length * this.nodes.length);
         
            // Set distances to all nodes to be infinite except startNode
            distances[startNode] = 0;
            pq.enqueue(startNode, 0);
            this.nodes.forEach(node => {
               if (node !== startNode) distances[node] = Infinity;
               prev[node] = null;
            });
         
            while (!pq.isEmpty()) {
               let minNode = pq.dequeue();
               let currNode = minNode.data;
               let weight = minNode.priority;
               this.edges[currNode].forEach(neighbor => {
                  let alt = distances[currNode] + neighbor.weight;
                  if (alt < distances[neighbor.node]) {
                     distances[neighbor.node] = alt;
                     prev[neighbor.node] = currNode;
                     pq.enqueue(neighbor.node, distances[neighbor.node]);
                  }
               });
            }
            return distances;
         }

        let g = new Graph();
        g.addNode("A");
        g.addNode("B");
        g.addNode("C");
        g.addNode("D");
        g.addNode("E");
        g.addNode("F");
        g.addNode("G");

        g.addDirectedEdge("A", "C", 100);
        g.addDirectedEdge("A", "B", 3);
        g.addDirectedEdge("A", "D", 4);
        g.addDirectedEdge("D", "C", 3);
        g.addDirectedEdge("D", "E", 8);
        g.addDirectedEdge("E", "F", 10);
        g.addDirectedEdge("B", "G", 9);
        g.addDirectedEdge("E", "G", 50);

        //console.log(g.djikstraAlgorithm("A"));
        //g.display();

        var g2 = new WeightedGraph();
        g2.addNode("A")
        g2.addNode("B")
        g2.addNode("C")
        g2.addNode("D")
        g2.addNode("E")
        g2.addNode("F")
        
        
        g2.addEdge("A", "B", 4);
        g2.addEdge("A", "C", 2);
        g2.addEdge("B", "E", 3);
        g2.addEdge("C", "D", 2);
        g2.addEdge("C", "F", 4);
        g2.addEdge("D", "E", 3);
        g2.addEdge("D", "F", 1);
        g2.addEdge("E", "F", 1);

        var shortest = g2.Dijkstra("A", "E");
        console.log(shortest);

    });
})(jQuery);

class Graph {
    constructor() {
       this.edges = {};
       this.nodes = [];
    }
 
    addNode(node) {
       this.nodes.push(node);
       this.edges[node] = [];
    }
 
    addEdge(node1, node2, weight = 1) {
       this.edges[node1].push({ node: node2, weight: weight });
       this.edges[node2].push({ node: node1, weight: weight });
    }
 
    addDirectedEdge(node1, node2, weight = 1) {
       this.edges[node1].push({ node: node2, weight: weight });
    }

    display() {
       var graph = "";
       this.nodes.forEach(node => {
          graph += node + "->" + this.edges[node].map(n => n.node).join(", ") + "\n";
       });
       console.log(graph);
    }

    djikstraAlgorithm(startNode) {
       let distances = {};
 
       // Stores the reference to previous nodes
       let prev = {};
       let pq = new PriorityQueue(this.nodes.length * this.nodes.length);
 
       // Set distances to all nodes to be infinite except startNode
       distances[startNode] = 0;
       pq.enqueue(startNode, 0);
 
       this.nodes.forEach(node => {
          if (node !== startNode) distances[node] = Infinity;
          prev[node] = null;
       });
 
       while (!pq.isEmpty()) {
          let minNode = pq.dequeue();
          let currNode = minNode.data;
          let weight = minNode.priority;
 
          this.edges[currNode].forEach(neighbor => {
             let alt = distances[currNode] + neighbor.weight;
             if (alt < distances[neighbor.node]) {
                distances[neighbor.node] = alt;
                prev[neighbor.node] = currNode;
                pq.enqueue(neighbor.node, distances[neighbor.node]);
             }
          });
       }
       return distances;
    }

    Dijkstra2(start, finish){
		const pq = new PriorityQueue2();
		const distances = {};
		const previous = {};
		let path = [] // to return at end
		let smallest;

		// build up initial state
		for(let vertex in this.edges){
			if(vertex === start){
				pq.enqueue(vertex, 0);
				distances[vertex] =0;
			}else{
				distances[vertex] =Infinity;
				pq.enqueue(vertex, Infinity);
			}
			previous[vertex] =null;
		}

		// as long as there is something to visit
		while(pq.values.length){
			smallest = pq.dequeue().val;
			if (smallest === finish){
				// WE ARE DONE
				// BUILD UP PATH TO RETURN AT END
				while(previous[smallest]){
				path.push(smallest);
				smallest =previous[smallest];
			}
			}
			if(smallest || distances[smallest] != Infinity){
			  	for(let neighbor in this.edges[smallest]){
					// find neighboring node
					let nextNode = this.edges[smallest][neighbor];
					console.log(nextNode);
					// calculate new distance to neighboring node
					let candidate =distances[smallest] + nextNode.weight;
					let nextNeighbor = nextNode.node;
					
					if(candidate < distances[nextNeighbor]){
					// updating new smallest distance to neighbor
					distances[nextNeighbor] = candidate;
					// updating previous – How we got to neighbor
					previous[nextNeighbor] = smallest;
					// enqueue in priority queue with new priority
					pq.enqueue(nextNeighbor, candidate);
					}
				}
			}
		
		}
		return path.concat(smallest).reverse();
	}

 }

 class PriorityQueue {
    constructor(maxSize) {
       // Set default max size if not provided
       if (isNaN(maxSize)) {
          maxSize = 10;
        }
       this.maxSize = maxSize;
       // Init an array that'll contain the queue values.
       this.container = [];
    }
    // Helper function to display all values while developing
    display() {
       console.log(this.container);
    }
    // Checks if queue is empty
    isEmpty() {
       return this.container.length === 0;
    }
    // checks if queue is full
    isFull() {
       return this.container.length >= this.maxSize;
    }
    enqueue(data, priority) {
       // Check if Queue is full
       if (this.isFull()) {
          console.log("Queue Overflow!");
          return;
       }
       let currElem = new this.Element(data, priority);
       let addedFlag = false;
       // Since we want to add elements to end, we'll just push them.
       for (let i = 0; i < this.container.length; i++) {
          if (currElem.priority < this.container[i].priority) {
             this.container.splice(i, 0, currElem);
             addedFlag = true; break;
          }
       }
       if (!addedFlag) {
          this.container.push(currElem);
       }
    }
    dequeue() {
    // Check if empty
    if (this.isEmpty()) {
       console.log("Queue Underflow!");
       return;
    }
    return this.container.pop();
 }
 peek() {
    if (isEmpty()) {
       console.log("Queue Underflow!");
       return;
    }
    return this.container[this.container.length - 1];
 }
 clear() {
    this.container = [];
    }
 }
 // Create an inner class that we'll use to create new nodes in the queue
 // Each element has some data and a priority
 PriorityQueue.prototype.Element = class {
    constructor(data, priority) {
       this.data = data;
       this.priority = priority;
    }
 };


 class PriorityQueue2{

    constructor(){
    this.values =[];
    }
    
    enqueue(val, priority){
    this.values.push({val, priority});
    this.sort()
    };
    
    dequeue(){
    return this.values.shift();
    };
    
    sort(){
    this.values.sort((a,b) => a.priority -b.priority);
    
    };
    }


    class WeightedGraph{

        constructor(){
            this.adjacencyList ={}
        }
        addNode(vertex){
        if(!this.adjacencyList[vertex]) this.adjacencyList[vertex] =[];
        }
        addEdge(vertex1, vertex2, weight){
        this.adjacencyList[vertex1].push({node:vertex2, weight})
        this.adjacencyList[vertex2].push({node:vertex1,weight})
        }
        
        Dijkstra(start, finish){
            const nodes = new PriorityQueue2();
            const distances = {};
            const previous = {};
            let path = [] // to return at end
            let smallest;
    
            // build up initial state
            for(let vertex in this.adjacencyList){
                if(vertex === start){
                    nodes.enqueue(vertex, 0);
                    distances[vertex] =0;
                }else{
                    distances[vertex] =Infinity;
                    nodes.enqueue(vertex, Infinity);
                }
                previous[vertex] =null;
            }
    
            // as long as there is something to visit
            while(nodes.values.length){
                smallest = nodes.dequeue().val;
                if (smallest === finish){
                    // WE ARE DONE
                    // BUILD UP PATH TO RETURN AT END
                    while(previous[smallest]){
                    path.push(smallest);
                    smallest =previous[smallest];
                }
                }
                if(smallest || distances[smallest] != Infinity){
                      for(let neighbor in this.adjacencyList[smallest]){
                        // find neighboring node
                        let nextNode = this.adjacencyList[smallest][neighbor];
                        //console.log(nextNode);
                        // calculate new distance to neighboring node
                        let candidate =distances[smallest] + nextNode.weight;
                        let nextNeighbor = nextNode.node;
                        
                        if(candidate < distances[nextNeighbor]){
                        // updating new smallest distance to neighbor
                        distances[nextNeighbor] = candidate;
                        // updating previous – How we got to neighbor
                        previous[nextNeighbor] = smallest;
                        // enqueue in priority queue with new priority
                        nodes.enqueue(nextNeighbor, candidate);
                        }
                    }
                }
            
            }
            return path.concat(smallest).reverse();
        }
    
    }
