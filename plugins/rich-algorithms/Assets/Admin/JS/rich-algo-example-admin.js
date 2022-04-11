(function($) {
    var offset = 32;
    var sort_height = $('#rich-algo-example-sortable').height() + offset;
    const nonce = rich_algo_example_params.rich_algo_example_add_new_nonce;

    $('#rich-algo-example-sortable').sortable({
        cursor: 'move',
        axis: 'y',
        revert: 50,
        handle: '.rich-algo-sort-button',
        scrollSensitivity: 10,
        opacity: 1.0,
        start: function(event, ui) {
        },
        stop: function(event, ui) {
            recalculateExampleNumbers();
            $( '#rich-algo-example-sortable' ).height('');
        },
        placeholder: {
            element: function(currentItem) {
                var sortable_height = $(currentItem).height();
                return $('<div class="rich-algo-example-wrap placeholder" style="height: ' + sortable_height + 'px; position: relative;"></div>')[0];
            },
            update: function(container, p) {
                return;
            }
        }
    });

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
            sort_height = $('#rich-algo-example-sortable').height() + offset;
        });

        $(document).on('click', '.rich-algo-example-remove', function(e) {
            e.preventDefault();
            if (window.confirm('Remove this code example?')) {
                $(this).parent().parent().remove();
                resetWrapper();
            }
        });

        $(document).on('click', '#rich-algo-example-add', function(e) {
            e.preventDefault();
            addNewCodeExample(e)
        });
    });

    function resetWrapper() {
        sort_height = $('#rich-algo-example-sortable').height();
        recalculateExampleNumbers();
    }

    function addNewCodeExample(e) {
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data : {
                action: 'richweb_algorithm_code_example_add',
                key : getNextId(),
                security: nonce
            },
            success:function(response) {
                var decode = JSON.parse(response);
                if (decode == '') {
                    alert('Could not add a new code example');
                } else {
                    $('#rich-algo-example-sortable').append(decode);
                    sort_height = $('#rich-algo-example-sortable').height();
                    recalculateExampleNumbers();
                }
            }
        });
    }

    /**
     * Returns the next available ID number based on the IDs already present in the examples.
     */
    function getNextId() {

        if ($('.rich-algo-example-wrap').length == 0) {
            return 0;
        }

        var ids = new Array();

        $('.rich-algo-example-wrap').each(function() {
            var id = $(this).attr('data-example-id');
            ids.push(id);
        });

        return(Math.max.apply(Math, ids) + 1);
    }

    function recalculateExampleNumbers() {
        var count = 1;
        $('.rich-algo-example-number').each(function() {
            $(this).text(count);
            count++;
        });
    }
})(jQuery);
