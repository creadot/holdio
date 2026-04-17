$( document ).ready(function() {
    let videoCarousel = $(".video-carousel");
    if (videoCarousel.length) {
        videoCarousel.videoCarousel({
            autoPlay: false,
            arrows: false,
            autoAdvance: true,
            //infinite: true,
            //fadeSpeed: 300,
        });

        videoCarousel.waypoint(function(direction) {
            if (direction == "down") {
                videoCarousel.videoCarousel("start");
            }
        }, {
            offset: "100%"
            //offset: 'right-in-view'
        });
    }
});