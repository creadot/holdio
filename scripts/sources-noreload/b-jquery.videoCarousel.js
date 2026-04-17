/*
 _    ___     __              ______                                 __
| |  / (_)___/ /__  ____     / ____/___ __________  __  __________  / /
| | / / / __  / _ \/ __ \   / /   / __ `/ ___/ __ \/ / / / ___/ _ \/ /
| |/ / / /_/ /  __/ /_/ /  / /___/ /_/ / /  / /_/ / /_/ (__  )  __/ /
|___/_/\__,_/\___/\____/   \____/\__,_/_/   \____/\__,_/____/\___/_/

 Version: 0.1.0
  Author: Creadot
 Website: https://creadot.cz

 */

(function ( $ ) {

	function VideoCarousel(element, config) {
		this.element = $(element);
		this.slick = null;
		this.playing = false;

        this.config = $.extend({
			autoStart: false,
			autoAdvance: true,
			infinite: true,
			fadeSpeed: 300,
			buttons: true,
			arrows: false,
			//prevArrow: '<button type="button" class="slick-prev"><i class="fa-regular fa-arrow-left"></i></button>',
			//nextArrow: '<button type="button" class="slick-next"><i class="fa-regular fa-arrow-right"></i></button>',
        }, config);

		this.init();
	}

	// init VideoCarousel
	VideoCarousel.prototype.init = function() {
		let _ = this;

		let slickConfig = {
			pauseOnHover: false,
			pauseOnFocus: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: _.config.infinite,
			autoplay: false,
			speed: _.config.fadeSpeed,
			fade: true,
			arrows: _.config.arrows,
			prevArrow: _.config.prevArrow,
			nextArrow: _.config.nextArrow,
			dots: _.config.buttons,
			customPaging: function(slick, i) {
			    const slide = $('.video-carousel-slide').eq(i);
			    const label = slide.attr('data-label');
			    const title = slide.attr('data-title');
			    //console.log('Title:', title, 'Label:', label);

			    const button = $('<button type="button" />').addClass('video-carousel-button');
			    const buttonLabel = $('<span />').addClass('video-carousel-button-label').text(label);
			    const buttonTitle = $('<span />').addClass('video-carousel-button-title').text(title);
			    const buttonProgress = $('<span />').addClass('video-carousel-button-progress');

			    button.append(buttonLabel);
			    button.append(buttonTitle);
			    button.append(buttonProgress);

			    return button;
			},
			responsive: [
		        {
		            breakpoint: 540,
		            settings: {
		                fade: false, // Zruší fade efekt při menší šířce
		                swipe: true, // Umožní swipování
		            }
		        }
		    ]
    	};

		_.element.slick(slickConfig);

		_.element.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
			_.play(nextSlide, currentSlide, slick);
		});

		if (_.config.autoStart) {
			_.start();
		}
	}

	// start
	VideoCarousel.prototype.start = function(nextSlide = 0, currentSlide = null, slick = null) {
		let _ = this;

		if (_.playing == false) {
			_.play(nextSlide, currentSlide, slick);
		}
	}

	

	function MobileFunction(x) {
  		if (x.matches) {
			// play
			VideoCarousel.prototype.play = function(nextSlide = 0, currentSlide = null, slick = null) {
			    let _ = this;

			    if (slick == null) {
			        slick = _.element.slick("getSlick");
			    }

			    if (slick.currentSlide != nextSlide || _.playing == false) {
			        if (currentSlide != null) {
			            const currentVideo = slick.$slides.eq(currentSlide).find("video").get(0);
			            const currentButtonProgress = slick.$dots.find("li:eq("+currentSlide+") .video-carousel-button-progress");
			            const currentProgress = slick.$slides.eq(currentSlide).find(".progress");

			            setTimeout(function() {
			                currentVideo.pause();
			                currentVideo.currentTime = 0;

			                // Reset progress u tlačítka i title-area
			                currentButtonProgress.css("animation", "none");
			                currentProgress.css("animation", "none");
			            }, _.config.fadeSpeed);
			        }

			        const nextVideo = slick.$slides.eq(nextSlide).find("video").get(0);
			        const nextButtonProgress = slick.$dots.find("li:eq("+nextSlide+") .video-carousel-button-progress");
			        const nextProgress = slick.$slides.eq(nextSlide).find(".progress");

			        let progressAnimation;

			        if (_.config.autoAdvance) {
			            progressAnimation = "video-carousel-progress "+nextVideo.duration+"s linear 0s 1 normal forwards";

			            nextVideo.addEventListener("ended", () => {
			                slick.slick("slickNext");
			            });
			        } else {
			            progressAnimation = "video-carousel-progress "+nextVideo.duration+"s linear 0s infinite normal forwards";
			            nextVideo.loop = true;
			        }

			        nextVideo.play();

			        // Spustíme animaci u tlačítka i title-area
			        nextButtonProgress.css("animation", progressAnimation);
			        nextProgress.css("animation", progressAnimation);
			    }

			    _.playing = true;
			}
	  	} else {
	   		// play
			VideoCarousel.prototype.play = function(nextSlide = 0, currentSlide = null, slick = null) {
				let _ = this;

				if (slick == null) {
					slick = _.element.slick("getSlick");
				}

				if (slick.currentSlide != nextSlide || _.playing == false) {
					if (currentSlide != null) {
						const currentVideo = slick.$slides.eq(currentSlide).find("video").get(0);
						const currentButton = slick.$dots.find("li:eq("+currentSlide+") button");
						const currentButtonProgress = currentButton.find(".video-carousel-button-progress");
						let currentButtonProgressAnimation;

						setTimeout(function() {
							currentVideo.pause();
							currentVideo.currentTime = 0;

							currentButtonProgress.css("animation", "none");
						}, _.config.fadeSpeed);
					}

					const nextVideo = slick.$slides.eq(nextSlide).find("video").get(0);
					const nextButton = slick.$dots.find("li:eq("+nextSlide+") button");
					const nextButtonProgress = nextButton.find(".video-carousel-button-progress");
					let nextButtonProgressAnimation;

					if (_.config.autoAdvance) {
						nextButtonProgressAnimation = "video-carousel-progress "+nextVideo.duration+"s linear 0s 1 normal forwards";

						nextVideo.addEventListener("ended", (event) => {
							slick = _.element.slick("slickNext");
						});
					}
					else {
						nextButtonProgressAnimation = "video-carousel-progress "+nextVideo.duration+"s linear 0s infinite normal forwards";

						nextVideo.loop = true;
					}

					nextVideo.play();

					nextButtonProgress.css("animation", nextButtonProgressAnimation);
				}

				_.playing = true;
			}
	  	}
	}

	var x = window.matchMedia("(max-width: 540px)")

	MobileFunction(x);

	x.addEventListener("change", function() {
	  MobileFunction(x);
	});

    $.fn.videoCarousel = function() {
        let _ = this;
        let opt = arguments[0];
        let args = Array.prototype.slice.call(arguments, 1);
        let length = _.length;
        let ret;

        for (let i = 0; i < length; i++) {
            if (typeof opt == 'object' || typeof opt == 'undefined') {
                _[i].videoCarousel = new VideoCarousel(_[i], opt);
            }
            else {
                ret = _[i].videoCarousel[opt].apply(_[i].videoCarousel, args);
            }

            if (typeof ret != 'undefined') return ret;
        }

        return _;
    };

}( jQuery ));
