(function($) {
	window.onmessage = function(e) {
		$('#demo-result p').html('Shortest Path: ' + e.data);
	};
})(jQuery);
