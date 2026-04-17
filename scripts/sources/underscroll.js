// function scroll() {
//     var pos = $(window).scrollTop();

//     $(".underscroll").each(function(index, el) {
//         var underscrollEl = $(el);
//         var underscrollTrigger = underscrollEl.data("trigger");
        
//         // Zjistit aktuální stav, zda je prvek "fixed"
//         var isFixed = underscrollEl.hasClass('fixed');

//         // Aktualizace triggeru na základě aktuální výšky prvku
//         var currentHeight = underscrollEl.outerHeight();
//         underscrollEl.data("trigger", underscrollEl.offset().top);

//         if (pos >= underscrollTrigger) {
//             // Pokud prvek není již "fixed", přidej třídu
//             if (!isFixed) {
//                 underscrollEl.addClass('fixed');
//             }
//             TweenMax.to(underscrollEl, 0.3, {
//                 y: -(pos - underscrollTrigger) * 0.2,
//                 ease: Power2.easeOut
//             });
//         } else {
//             // Pokud prvek je "fixed" a je nad triggerem, odeber třídu
//             if (isFixed) {
//                 underscrollEl.removeClass('fixed');
//             }
//             TweenMax.to(underscrollEl, 0.3, {
//                 y: 0,
//                 ease: Power2.easeOut
//             });
//         }
//     });
// }

// function resize() {
//     var triggerEl = $("#video-slider");

//     if ($(".underscroll").length && triggerEl.length) {
//         if (triggerEl.is(':visible')) {
//             if (!window.matchMedia('(max-width: 540px)').matches) {
//                 var triggerPos = triggerEl.offset().top;
//                 console.log("Trigger element position:", triggerPos);

//                 $(".underscroll").each(function(index, el) {
//                     var underscrollEl = $(el);
//                     underscrollEl.data("trigger", triggerPos);
//                     underscrollEl.next(".underscroll-placeholder").height(underscrollEl.outerHeight());
//                 });
//             } else {
//                 $(".underscroll").removeClass('fixed');
//                 TweenMax.to(".underscroll", 0.3, { y: 0, ease: Power2.easeOut });
//             }
//         } else {
//             $(".underscroll").each(function(index, el) {
//                 var underscrollEl = $(el);
//                 underscrollEl.data("trigger", 0); // nebo jiná logika, kterou potřebujete
//             });
//         }
//     }
// }

// // Volání scroll a resize při načtení dokumentu
// $(document).ready(function() {
//     resize(); // Volání resize pro inicializaci triggerů
//     scroll(); // Volání scroll pro nastavení počátečního stavu
    
//     $(window).on('scroll', scroll);
//     $(window).on('resize', resize);
// });