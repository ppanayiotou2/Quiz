$('#side-nav a').click(function () {
    $(this).siblings('.dropdown').slideToggle();
    $(this).find('.right-icon').toggleClass('rotate');
});
