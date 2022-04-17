// Point In Polygon

// Finley, D. R., & Lagidse, L. (2007). Determining Whether A Point Is Inside A Complex Polygon. Alien Ryder Flex. Retrieved 11 April 2022, from http://alienryderflex.com/polygon/

// Code adapted from Finley and Lagidse, 2007
function pointInPolygon(x, y, polyX, polyY) {
    var in_polygon = false;

    var poly_corners = polyX.length;
    var j = poly_corners - 1;

    for (let i = 0; i < poly_corners; i++) {
        if (
            (polyY[i] < y && polyY[j] >= y
            || polyY[j] < y && polyY[i] >= y)
            && (polyX[i] <= x || polyX[j] <= x))
        {
            in_polygon ^= (
                polyX[i] + (y - polyY[i])
                / (polyY[j] - polyY[i])
                * (polyX[j] - polyX[i]) < x
            );
        }
        j = i;
    }

    return in_polygon;
}

let polyX = [20.0, 70.0, 303.0, 245.0];
let polyY = [40.0, 320.0, 261.0, 135.0];
let point = [220.5, 156.0];

let in_polygon = pointInPolygon(point[0], point[1], polyX, polyY);

console.log(in_polygon)
// Result: 1

// end of adapted code
