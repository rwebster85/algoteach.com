(function($) {
    let demo = document.querySelector('#demo');
    var context = demo.getContext('2d');

    var working = false;

    let point_offset = 5;

    let pi2 = Math.PI * 2;
    let radius = 5;

    let polyX_l = [20.0, 70.0, 303.0, 446.0, 429.0, 511.0, 245.0];
    let polyY_l = [40.0, 320.0, 261.0, 299.0, 160.0, 59.0, 135.0];

    let polyX_s = [20.0, 70.0, 303.0, 245.0];
    let polyY_s = [40.0, 320.0, 261.0, 135.0];

    let polyX = [];
    let polyY = [];

    let min_width;

    let height;

    let window_width;

    function init() {
        window_width = $(window).width();
        if (window_width > 600) {
            polyX = polyX_l;
            polyY = polyY_l;
            min_width = 530;
        } else {
            polyX = polyX_s;
            polyY = polyY_s;
            min_width = 330;
        }
        if ($('#new-point').length) {
            $('#new-point').remove();
        }
        $('.demo-wrapper .demo-point').each(function() {
            $(this).remove();
        });
        $('#demo-result p').html('Result:');
        drawPolygon(polyX, polyY, 'rgb(255, 102, 0, 0.5)', 'rgb(156, 85, 33, 1.0)');
        drawPoints(polyX, polyY);
        $('#demo-result').css('max-width', min_width);
    }

    $(document).ready(function() {

        window_width = $(window).width();

        $(window).resize(function() {
            if ($(window).width() == window_width) {
                return;
            }
            init();
        });

        $('.entry-content .wp-post-image').css('display', 'none');
        height = $('.demo-outer').height();
        init();

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

            var in_poly = pointInPolygon(point_pos.x, point_pos.y, polyX, polyY);

            if (in_poly == true) {
                var result = 'Point is inside polygon';
                $('#demo-result p').html(result);
            } else {
                var result = 'Point is not inside polygon';
                $('#demo-result p').html(result);
            }

            working = false;

            return false;
        });
    });

    // Code adapted from Hajibaba, 2019
    function drawPolygon(polyX, polyY, fill, stroke) {
        demo.width = min_width;
        demo.height = height;
        if (polyX.length > 0) {
            context.fillStyle = fill;
            context.strokeStyle = stroke;
            context.lineWidth = 2;
            context.beginPath();
            context.moveTo(polyX[0], polyY[0]);

            for (var i = 0; i < polyX.length; i++) {
                context.lineTo(polyX[i], polyY[i]);
            }

            context.closePath();
            context.fill();
            context.stroke();
        }
    }
    //end of adapted code

    function drawPoints(polyX, polyY) {
        if (polyX.length > 0) {
            context.fillStyle = '#35495c';
            context.beginPath();
            for (var i = 0; i < polyX.length; i++) {
                x = polyX[i],
                y = polyY[i];
                drawSinglePoint(x, y, radius, 0, pi2);
            }
            context.fill();
        }
    }

    function drawSinglePoint(x, y, radius, start, end) {
        context.moveTo(x + radius, y);
        context.arc(x, y, radius, start, end);
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

    // Code adapted from Finley and Lagidse, 2007
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
