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

        console.log('Script!');
    });
})(jQuery);
