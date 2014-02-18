$(function() {
    $container = $('.js-trick-container');

    $container.masonry({
        gutter: 0,
        itemSelector: '.trick-card',
        columnWidth: '.trick-card'//,
        //transitionDuration: 0
    });
    $('.js-goto-trick a').click(function(e) { e.stopPropagation() });

    $('.js-goto-trick').click(function(e)
    {
        e.preventDefault();
        var url = "{{ route('tricks.show') }}";
        var slug = $(this).data('slug');
        window.location = url + '/' + slug;
    });
});
