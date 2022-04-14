(function($) {
	$(document).ready(function() {
		$('.entry-content .wp-post-image').css('display', 'none');
	});
	window.onmessage = function(e) {
		$('#demo-result p').html('Shortest Path: ' + e.data);
	};
})(jQuery);
