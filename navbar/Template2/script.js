$(document).ready(function () {
    $(".nav_links li").on("click", function () {
        $(".nav_links li").removeClass("active"); // Remove 'active' from all li
        $(this).addClass("active"); // Add 'active' to the clicked li
    });
});

window_width = $(window).width();

$(window).resize(function () {
    window_width = $(this).width();
    if (window_width >= 1000) {
        $('.nav_con').removeClass('toggle_nav_con');
        $('body').removeClass('fixed_body');
    }
});

$('.menu_bar').click(function () {
    $('.nav_con').toggleClass('toggle_nav_con');
    $('body').toggleClass('fixed_body');

});