$(function()
{
    $('.js-like-trick').click(function(e)
    {
        e.preventDefault();
        if($(this).data('liked') == '0')
        {
            var data = {};

            $.post('{{ route("tricks.like", $trick->slug) }}', data, function(res)
            {
                if(res != 'error')
                {
                    $('.js-like-trick').find('.fa').addClass('text-primary');
                    $('.js-like-trick').data('liked', '1');
                    $('.js-like-status').html('You like this');
                    $('.js-like-count').html(res + ' likes');
                }
            });
        }
    });
});
