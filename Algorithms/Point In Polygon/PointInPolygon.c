// Point In Polygon

// Finley, D. R., & Lagidse, L. (2007). Determining Whether A Point Is Inside A Complex Polygon. Alien Ryder Flex. Retrieved 11 April 2022, from http://alienryderflex.com/polygon/

// Code adapted from Finley and Lagidse, 2007
#include <stdio.h>
#include <stdbool.h>

float polyX[] = {20.0, 70.0, 303.0, 245.0};
float polyY[] = {40.0, 320.0, 261.0, 135.0};

bool pointInPolygon(float x, float y) {
    bool in_polygon = false;
    int polyCorners = sizeof(polyX) / sizeof(polyX[0]);
    int j = polyCorners - 1;

    for (int i = 0; i < polyCorners; i++) {
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
  
    return (bool) in_polygon;
}

int main()
{
    float point[] = {220.5, 156.0};
    
    bool in_polygon = pointInPolygon(point[0], point[1]);

    printf("%d\n", in_polygon);
    return 0;
}
// Result: 1
// end of adapted code
