<?php
// Point In Polygon

// Finley, D. R., & Lagidse, L. (2007). Determining Whether A Point Is Inside A Complex Polygon. Alien Ryder Flex. Retrieved 11 April 2022, from http://alienryderflex.com/polygon/

// Code adapted from Finley and Lagidse, 2007
function pointInPolygon(float $x, float $y, array $polyX, array $polyY): bool
{
    $in_polygon = false;

    $poly_corners = count($polyX);
    $j = $poly_corners - 1;

    for ($i = 0; $i < $poly_corners; $i++) {
        if (
            ($polyY[$i] < $y && $polyY[$j] >= $y
            || $polyY[$j] < $y && $polyY[$i] >= $y)
            && ($polyX[$i] <= $x || $polyX[$j] <= $x))
        {
            $in_polygon ^= (
                $polyX[$i] + ($y - $polyY[$i])
                / ($polyY[$j] - $polyY[$i])
                * ($polyX[$j] - $polyX[$i]) < $x
            );
        }
        $j = $i;
    }
    
    return (bool) $in_polygon;
}

$polyX = [20.0, 70.0, 303.0, 245.0];
$polyY = [40.0, 320.0, 261.0, 135.0];
$point = [220.5, 156.0];

print(pointInPolygon($point[0], $point[1], $polyX, $polyY));
// Result: 1
// end of adapted code
