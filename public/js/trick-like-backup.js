(function ($) {

    $('.js-like-trick').click(function (e) {
        e.preventDefault();
        var liked = $(this).data('liked') == '0';

        var data = {"_token": "{{ csrf_token() }}"   };

        $.post('{{ route("tricks.like", $trick->slug) }}', data, function (res) {
            if (res != 'error') {

                if (!liked) {

                    $('.js-like-trick .fa').removeClass('text-primary');

                    $('.js-like-trick').data('liked', '0');

                    $('.js-like-status').html('Like this?');
                } else {

                    $('.js-like-trick .fa').addClass('text-primary');

                    $('.js-like-trick').data('liked', '1');

                    $('.js-like-status').html('You like this');
                }

                $('.js-like-count').html(res + ' likes');
            }
        });

    });
})(jQuery)
