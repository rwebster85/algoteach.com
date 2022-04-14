(function($) {
	$(document).ready(function() {
		$('.entry-content .wp-post-image').css('display', 'none');
	});
})(jQuery);

function pathFormatted(path) {
    let formatted_path = '';

    let path_size = path.length - 1;
    for (let i = 0; i < path.length; i++) {
        formatted_path += path[i];
        if (path_size > i) {
            formatted_path += " --> ";
        }
    }

    return formatted_path;
}
