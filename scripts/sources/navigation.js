$(document).ready(function() {
    $(".menu-button").click( function() {
        $("body").toggleClass('menu-open').find(".main-menu").slideToggle(200);
    });
});



// $(document).ready(function($) {
//     var menu = $('header.header');

//     // najetí myší pár px k hornímu okraji menu zobrazí
//     $("body").mousemove(function(event) {
//         if(event.clientY < 50) {
//             menu.removeClass('nav-up').addClass('nav-down');
//             $("body").removeClass('has-nav-up').addClass('has-nav-down');
//         }
//     });

//     var didScroll;

//     var lastScrollTop = 0;
//     var delta = 0;
//     var navbarHeight = 220;

//     // run hasScrolled() and reset didScroll status
//     setInterval(function() {
//         if (didScroll) {
//             hasScrolled();
//             didScroll = false;
//         }
//     }, 250);

//     function hasScrolled() {
//         var st = $(this).scrollTop();

//         // make sure they scroll more than delta
//         if(Math.abs(lastScrollTop - st) <= delta) {
//             return;
//         }

//         // if they scrolled down and are past the navbar, add class .header-up
//         if (st > lastScrollTop && st > navbarHeight){
//             // scroll down
//             menu.removeClass('nav-down').addClass('nav-up');
//             $("body").removeClass('has-nav-down').addClass('has-nav-up');
//         } else {
//             // scroll up
//             if(st + $(window).height() < $(document).height()) {
//                 menu.removeClass('nav-up').addClass('nav-down');
//                 $("body").removeClass('has-nav-up').addClass('has-nav-down');
//             }
//         }

//         lastScrollTop = st;
//     }
    
//     lenis.on('scroll', (e) => {

//         // window.requestAnimationFrame(scroll);
//         // console.log(e);
//         scroll();
//         didScroll = true;

//     });

// });



