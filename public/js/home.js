$('.search-button').on('click', function() {
    $('.button-wrapper').css('opacity', 0);
    $('.button-wrapper').css('transform', 'translateY(30px)');
    $('.search-wrapper').css('opacity', 1);
    $('.search-wrapper').css('transform', 'translateY(30px)');

})

$('.close-button').on('click', function() {
    $('.button-wrapper').css('opacity', 1);
    $('.button-wrapper').css('transform', 'translateY(-30px)');
    $('.search-wrapper').css('opacity', 0);
    $('.search-wrapper').css('transform', 'translateY(-30px)');

})