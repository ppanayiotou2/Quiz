feather.replace();

$(document).on('click', '.user-profile', function (e) {
    e.stopPropagation();
    $(this).children('.dropdown').fadeToggle();
    $('#arrow').toggleClass('rotate');
});

$(document).click(function () {
    $('#user-profile-dropdown').fadeOut();
    $('#arrow').removeClass('rotate');
});

$('.mobile-menu-container').on('click', function () {
    $(this).children('.mobile-menu-icon').toggleClass('open');
    $('.mobile-nav ul ').slideToggle();
});
