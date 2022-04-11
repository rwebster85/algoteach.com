(function($) {
    let demo = document.querySelector('#demo');
    var context = demo.getContext('2d');

    var working = false;

    let point_offset = 3;

    let polyX = [
        20.0,
        70.0,
        303.0,
        446.0,
        429.0,
        511.0,
        245.0
    ];

    let polyY = [
        40.0,
        320.0,
        261.0,
        299.0,
        160.0,
        59.0,
        135.0
    ];

    let min_width = 530.0;

    $(document).ready(function() {

        $('.entry-content .wp-post-image').css('display', 'none');

        drawPolygon(polyX, polyY, 'rgb(255, 102, 0, 0.6)', 'rgb(156, 85, 33, 1.0)');

        $('#demo-result').css('max-width', min_width);

        $('body').on('click', '#demo', function (e) {
            e.stopImmediatePropagation();
            if (working == true) {
                return false;
            }

            working = true;

            if ($('#new-point').length) {
                $('#new-point').remove();
            }

            let target = e.target;
            point_pos = getClickedPointFromEvent(e, target);

            var point = drawPoint(point_pos.x - point_offset, point_pos.y - point_offset, target.parentElement);
            $(point).attr('id', 'new-point');

            //console.log('New point = x: ' + point_pos.x + ', y: ' + point_pos.y);

            var in_poly = pointInPolygon(point_pos.x, point_pos.y, polyX, polyY);

            if (in_poly == true) {
                var result = 'Result: Point is inside polygon';
                $('#demo-result p').html(result);
            } else {
                var result = 'Result: Point is not inside polygon';
                $('#demo-result p').html(result);
            }

            working = false;

            return false;
        });
    });

    function drawPolygon(polyX, polyY, fill, stroke) {
        demo.width = min_width;
        demo.height = $('.demo-outer').height();
        if (polyX.length > 0) {
            context.fillStyle = fill;
            context.strokeStyle = stroke;
            context.lineWidth = 2;
            context.beginPath();
            context.moveTo(polyX[0], polyY[0]);

            for (var i = 0; i < polyX.length; i++) {
                context.lineTo(polyX[i], polyY[i]);
                drawPoint((polyX[i] - point_offset), (polyY[i] - point_offset), $('.demo-wrapper'));
            }

            context.closePath();
            context.fill();
            context.stroke();
        }
    }

    function drawPoint(x, y, atElement) {
        var point = $('<div class="demo-point" style="left:'+x+'px; top: '+y+'px;"></div>');
        $(atElement).append(point);
        return point;
    }

    function getClickedPointFromEvent(e, target) {
        let bound = target.getBoundingClientRect();
        return {
           x: (e.clientX - bound.left),
           y: (e.clientY - bound.top)
        };
    }

    // Code adapted from Darel Rex Finley and Lascha Lagidse, 2007
    function pointInPolygon(x, y, polyX, polyY) {
        var in_polygon = false;

        var poly_corners = polyX.length;
        var j = poly_corners - 1;

        for (let i = 0; i < poly_corners; i++) {
            if ((polyY[i]< y && polyY[j]>=y || polyY[j]< y && polyY[i]>=y) && (polyX[i]<=x || polyX[j]<=x)) {
                in_polygon ^= (polyX[i]+(y-polyY[i])/(polyY[j]-polyY[i])*(polyX[j]-polyX[i])<x);
            }
            j=i;
        }
        
        return in_polygon;
    }
    //end of adapted code
})(jQuery);
