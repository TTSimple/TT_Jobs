$('.js-trigger').on('click', function() {
    $('html').toggleClass('show-me') 
});

$('.conversation__header').on('click', function() {
    $('.conversation').slideToggle(300);
});

$('.chat__name').on('click', function() {
    $('.conversation').slideToggle(300);
});