;(function($) {
    $(document).ready(function() {
        $('.comment-delete').on('click', this, function() {
            var id = $(this).data('value'),
                $dialogWindow = $('#dialog-window'),
                width = $(window).width(),
                height = $(window).height(),
                top,
                left;

            top = height / 2 - 76;
            left = width / 2 - 126;
            // console.log(top);

            $dialogWindow.css({'top': top, 'left': left});
            $('#overlay-frame').show();
            $dialogWindow.show();
        });

        $('body').on('click', '#dialog-window-btn-cancel', function() {
            $('#dialog-window').hide();
            $('#overlay-frame').hide();
        });
    });
})(jQuery);
