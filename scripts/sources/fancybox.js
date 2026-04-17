$(document).ready(function() {
    $("[data-fancybox]:not([data-src])").fancybox({});
    $("[data-fancybox][data-src]").fancybox({
        dragToClose: false
    });
});