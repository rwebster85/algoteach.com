(function($) {
    $(document).ready(function() {
        /**
         * Ensure the code examples wrapper height remains stable when sorting them.
         */
        $(document).on('mousedown', '.rich-algo-sort-button', function() {
            $('#rich-algo-example-sortable').height(sort_height);
        }).on('mouseup', '.rich-algo-sort-button', function() {
            $('#rich-algo-example-sortable').height('');
        });
        $(document).on('mouseup', '#rich-algo-example-sortable textarea', function() {
            sort_height = $('#rich-algo-example-sortable').height();
        });

        $(document).on('click', '.rich-algo-example-remove', function(e) {
            e.preventDefault();
            if (window.confirm('Remove this code example?')) {
                $(this).parent().parent().remove();
                resetWrapper();
            }
        });

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