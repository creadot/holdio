$( document ).ready(function() {
    $("body").on('click', '.accordion__title', function(event) {
        $(this).parent().toggleClass('active').find(".accordion__content").slideToggle(300);
    });
});