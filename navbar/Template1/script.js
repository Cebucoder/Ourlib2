$(document).ready(function() {

    webHeight = $(document).height(),
    // window_width = $(window).width();


    // Menu bar Function
    $('.menu_nav').click(function(){
        $('.nav_overlay').toggleClass('toggle_nav_overlay');
        $('.nav_links').toggleClass('toggle_nav_links');
        $('body').css('overflow','hidden');

        $('.page_nav li').each(function(index) {
            $(this).addClass('slide-in').show().delay(200 * (index + 1)).queue(function(next) {
                $(this).addClass('slide-in-active');
                next();
            });
        });
    });   

    $('.mobile_close_menu').click(function(){
        $('.nav_overlay').removeClass('toggle_nav_overlay');
        $('.nav_links').removeClass('toggle_nav_links');
        $('body').css('overflow','visible');

        $('.page_nav li').each(function() {
            $(this).removeClass('slide-in');
            $(this).removeClass('slide-in-active');
        });
    });

    $('.nav_overlay').click(function(){
        $('.nav_overlay').removeClass('toggle_nav_overlay');
        $('.nav_links').removeClass('toggle_nav_links');
        $('body').css('overflow','visible');
 
        $('.page_nav li').each(function() {
            $(this).removeClass('slide-in');
            $(this).removeClass('slide-in-active');
        });
    });


    $(window).resize(function () {
        window_width = $(this).width();
    
        if (window_width > 1000) {
            $('.nav_overlay').removeClass('toggle_nav_overlay');
            $('.nav_links').removeClass('toggle_nav_links');
        }

        if(window_width > 600){
            $('.nav_con').removeClass('fixed_nav_con')
        }
      });
      // Menu bar Function

    // Resize navbar when it scroll 90px
    $(window).scroll(function() {
        const scrollTop = $(this).scrollTop(); // Use $(this) instead of $this
    
        if (scrollTop > 90) {
            $('.main_logo').addClass('fixed_main_logo'); // Add class when scrolled more than 90px
            $('nav').addClass('fixed_nav_con'); // Add class when scrolled more than 90px
        } else {
            $('.main_logo').removeClass('fixed_main_logo'); // Remove class when less than 90px
        }
    });
    

});
  