$(document).ready(function () {
    $("#nav a").on("click", function () {
        var target = $(this).data("target");

        if (target === "All") {
            $(".prev_con").show();
        } else {
            $(".prev_con").hide();
            $("." + target).show();
        }
        $("ul li").removeClass("active");
        $(this).parent().addClass("active");
        $('.nav_link_con').removeClass('toggle_nav_con');
        $('body').removeClass('fixed_body');

    });
});


// Forms on content area
var libIframe = $('.main_con').find('#myframe');
if (libIframe.length > 0) {
    document.getElementById('myframe').onload = function () {
        calcHeight();
    };
}



// var baseUrl = window.location.origin;
// document.querySelectorAll('.dynamic-link').forEach(function (iframe) {

//     var relativePath1 = iframe.getAttribute('data-path');
//     var fullUrlI = baseUrl + relativePath1;
//     iframe.setAttribute('src', fullUrlI);
// });


// document.querySelectorAll('.dynamic-link').forEach(function (link) {
//     var relativePath = link.getAttribute('data-path');
//     var fullUrl = baseUrl + relativePath;
//     link.setAttribute('href', fullUrl);
// });


let homeUrl = window.location.origin;
let getHomeBtn = document.getElementById('getOrigin');
getHomeBtn.addEventListener('click', function () {
    window.location.href = homeUrl;
});
console.log("Origin Link " + homeUrl);




window_width = $(window).width();

$(window).resize(function () {
    window_width = $(this).width();
    if (window_width >= 1000) {
        $('.nav_link_con').removeClass('toggle_nav_con');
        $('body').removeClass('fixed_body');
    }
});

$('.menu_bar').click(function () {
    $('.nav_link_con').toggleClass('toggle_nav_con');
    $('body').toggleClass('fixed_body');

});

// icon jquery tooltips
$(function () {
    $(".open-outline").tooltip();
    $(".code-download-outline").tooltip();
});


$(document).ready(function () {
    // Create an array of the main containers
    var mainContainers = [
        '.prev_con.navbar',
        '.prev_con.banner',
        '.prev_con.boxes',
        '.prev_con.buttons',
        '.prev_con.text',
        '.prev_con.images',
        '.prev_con.footer',
        '.prev_con.gsap'
    ];

    // Loop through each main container
    mainContainers.forEach(function (selector) {
        // Find the main container and its .output_viewer elements
        var $mainContainer = $(selector);
        var $outputViewers = $mainContainer.find('.output_viewer');

        // Loop through each .output_viewer and update the corresponding .temp_counter
        $outputViewers.each(function (index) {
            var $tempCounter = $(this).find('.temp_counter');
            if ($tempCounter.length) {
                // Update the template number (starting from 1)
                $tempCounter.text(`#${String(index + 1).padStart(4, '0')}`); // Format like #0001
            }
        });
    });
});
