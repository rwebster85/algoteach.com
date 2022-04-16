# Code adapted from Finley and Lagidse, 2007
def pointInPolygon(x, y, polyX, polyY):
	in_polygon = False
	i = 0
	poly_corners = len(polyX)
	j = poly_corners - 1

	while i < poly_corners:
		if (
			(polyY[i] < y and polyY[j] >= y
			or polyY[j] < y and polyY[i] >= y)
			and (polyX[i] <= x or polyX[j] <= x)):

			in_polygon ^= (
				polyX[i] + (y - polyY[i])
				/ (polyY[j] - polyY[i])
				* (polyX[j] - polyX[i]) < x
			)
		j = i
		i += 1

	return in_polygon

polyX = [20.0, 70.0, 303.0, 245.0]
polyY = [40.0, 320.0, 261.0, 135.0]
point = [220.5, 156.0]

print(pointInPolygon(point[0], point[1], polyX, polyY))
# Result: True
# end of adapted code
