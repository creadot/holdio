$(document).ready(function() {
    
    var controller = new ScrollMagic.Controller({
        loglevel: 0,
        globalSceneOptions: {
            triggerHook: 'onLeave',
        }
    });

    // Kompletní vypnutí všech logů (včetně chyb)
    if (ScrollMagic && ScrollMagic._util && ScrollMagic._util.log) {
        ScrollMagic._util.log = function() { return; };
    }
    gsap.config({
        nullTargetWarn: false
    });

    var services_list = new TimelineMax();
    var items = document.querySelectorAll(".footer-animation .title-right-container .title-right");
    var totalItems = items.length;
    //var spacing = 60;
    var spacing = Math.min(Math.max(4.5 * parseFloat(getComputedStyle(document.documentElement).fontSize), 4 * window.innerWidth / 100), 6 * parseFloat(getComputedStyle(document.documentElement).fontSize));

    items.forEach((item, index) => {
        let startY = index * spacing;
        let endY = -((totalItems - 1) * spacing) + (index * spacing);
        services_list.fromTo(item, 2, 
            { y: startY, opacity: 0.3 }, 
            { y: endY, ease: Power1.easeOut, onUpdate: function () {
                let currentY = gsap.getProperty(item, "y");

                if (currentY > -30 && currentY < 30) {
                    let opacity = 0.3 + (1 - 0.3) * (1 - Math.abs(currentY) / 30);
                    item.style.opacity = opacity;
                } else {
                    item.style.opacity = 0.3;
                }
            }}, 
            0
        );
    });

    var heroImageScene = new ScrollMagic.Scene({
        triggerElement: "#footer-text-animation",
        duration: "50%"
    })
    .setTween(services_list)
    //.addIndicators({ name: "footer-animation-1" })
    .addTo(controller);



    if ($(".homepage").length) {
        $(".header").addClass("header--fixed");
        $("main").addClass("main--padding");

        // hero video
        function updateHeroImageHeight() {
            return $(".homepage .homepage__hero .video-wrapper").outerHeight();
        }
        var hero_image = TweenMax.fromTo(".homepage .homepage__hero .video-wrapper", 1, {height: updateHeroImageHeight()}, {height: "0", ease: Linear.easeNone });
        // var first_block = TweenMax.fromTo(
        //     ".homepage .homepage__hero .video-wrapper", 
        //     1, 
        //     {margin: "6rem 0 15rem"}, 
        //     {margin: "6rem 0", ease: Linear.easeNone}
        // );

        var first_block = TweenMax.to(".homepage .homepage__hero .video-wrapper", 1, {
            marginTop: 0,
            ease: Linear.easeNone
        });

        var second_block = TweenMax.to(".homepage .services-list", 1, {
            marginTop: 0,
            ease: Linear.easeNone
        });

        function updateAnimation() {
            let mq = window.matchMedia("(max-width: 600px)");
            let marginEndFirst = mq.matches ? "-6rem" : "-12rem";
            let marginEndSecond = mq.matches ? "6rem" : "12rem";

            first_block.kill(); // Zruší předchozí animaci
            second_block.kill();
            first_block = TweenMax.to(".homepage .homepage__hero .video-wrapper", 1, {
                marginTop: marginEndFirst,
                ease: Linear.easeNone
            });
            second_block = TweenMax.to(".homepage .services-list", 1, {
                marginTop: marginEndSecond,
                ease: Linear.easeNone
            });
        }

        updateAnimation();

        window.addEventListener("resize", updateAnimation);

        var heroImageScene = new ScrollMagic.Scene({duration: "50%"})
            .setTween(hero_image)
            .setPin(".homepage")
            .addTo(controller);
        new ScrollMagic.Scene({duration: "50%"})
            .setTween(first_block)
            .addTo(controller);
        new ScrollMagic.Scene({duration: "50%"})
            .setTween(second_block)
            .addTo(controller);
        $(window).resize(function() {
            var newHeight = updateHeroImageHeight();
            hero_image.fromTo(".homepage .homepage__hero .video-wrapper", 1, {height: newHeight}, {height: "0", ease: Linear.easeNone });
            heroImageScene.refresh();
        });




        function getHeaderInitialTop() {
            const temp = document.createElement("div");
            temp.style.position = "absolute";
            temp.style.top = "min(max(1rem, 7vw), 14rem)";
            document.body.appendChild(temp);
            const top = window.getComputedStyle(temp).top;
            document.body.removeChild(temp);
            return parseFloat(top);
        }
        let headerInitialTop = getHeaderInitialTop();
        heroImageScene.on("end", function (event) {
            if (event.scrollDirection === "FORWARD") {
                TweenMax.to(".header", 0.6, {
                    top: 0,
                    ease: Power2.easeOut
                });
            } else if (event.scrollDirection === "REVERSE") {
                TweenMax.to(".header", 0.6, {
                    top: headerInitialTop,
                    ease: Power2.easeOut
                });
            }
        });




        // services list
        var services_list = TweenMax.fromTo(".homepage .services-list--bg .grid", .3, {opacity: 1, top: "500px"}, {opacity: 1, top: "0", ease: Linear.easeNone });
        var heroImageScene = new ScrollMagic.Scene({triggerElement: "#homepage-services-list", duration: "40%"})
            .setTween(services_list)
            .setPin(".categories")
            //.addIndicators({name: "services list HP"})
            .addTo(controller);
    };




    if ($(".flexible-page").length) {

        $(".header").addClass("header--fixed");
        $("main").addClass("main--padding");

        // hero video
        function updateHeroImageHeight() {
            return $(".flexible-page .block--video-or-image .video-wrapper").outerHeight();
        }

        var hero_image = TweenMax.fromTo(".flexible-page .block--video-or-image .video-wrapper", 1, {height: updateHeroImageHeight()}, {height: "0", ease: Linear.easeNone });

        var first_block = TweenMax.to(".flexible-page .block--video-or-image", 1, {
            marginTop: 0,
            ease: Linear.easeNone
        });

        var second_block = TweenMax.to(".flexible-page .block--video-or-image + div", 1, {
            marginTop: 0,
            ease: Linear.easeNone
        });

        function updateAnimation() {
            let mq = window.matchMedia("(max-width: 600px)");
            let marginEndFirst = mq.matches ? "-6rem" : "-12rem";
            let marginEndSecond = mq.matches ? "6rem" : "12rem";

            first_block.kill(); // Zruší předchozí animaci
            second_block.kill();
            first_block = TweenMax.to(".flexible-page .block--video-or-image", 1, {
                marginTop: marginEndFirst,
                ease: Linear.easeNone
            });
            second_block = TweenMax.to(".flexible-page .block--video-or-image + div", 1, {
                marginTop: marginEndSecond,
                ease: Linear.easeNone
            });
        }

        updateAnimation();

        window.addEventListener("resize", updateAnimation);

        var heroImageScene = new ScrollMagic.Scene({duration: "50%"})
            .setTween(hero_image)
            .setPin(".flexible-page")
            .addTo(controller);
        new ScrollMagic.Scene({duration: "50%"})
            .setTween(first_block)
            .addTo(controller);
        new ScrollMagic.Scene({duration: "50%"})
            .setTween(second_block)
            .addTo(controller);
        $(window).resize(function() {
            var newHeight = updateHeroImageHeight();
            hero_image.fromTo(".flexible-page .block--video-or-image .video-wrapper", 1, {height: newHeight}, {height: "0", ease: Linear.easeNone });
            heroImageScene.refresh();
        });

        function getHeaderInitialTop() {
            const temp = document.createElement("div");
            temp.style.position = "absolute";
            temp.style.top = "min(max(1rem, 7vw), 14rem)";
            document.body.appendChild(temp);
            const top = window.getComputedStyle(temp).top;
            document.body.removeChild(temp);
            return parseFloat(top);
        }
        let headerInitialTop = getHeaderInitialTop();
        heroImageScene.on("end", function (event) {
            if (event.scrollDirection === "FORWARD") {
                TweenMax.to(".header", 0.6, {
                    top: 0,
                    ease: Power2.easeOut
                });
            } else if (event.scrollDirection === "REVERSE") {
                TweenMax.to(".header", 0.6, {
                    top: headerInitialTop,
                    ease: Power2.easeOut
                });
            }
        });

    };




    // Split
    const animatedTextSelectorScroll = [
        ".block--text h2",
        ".block--fullscreen .container h2",
        ".block--cta .container .inner h2",
        ".references-list .references-list__item h2",
        ".block--testimonial .container .inner .inner__right h2",
        ".block--team .container h2",
        ".block--team .container h3",
        ".block--bubbles .h1",
        ".services-list .h1",
        ".services-list .h2",
        ".block--companies h2",
        // ".footer .footer-content .h2",
        // ".footer .footer-content .inner .grid .h3",
        ".block--references-list h2",
        ".block--anchors .h2",

    ];

    const animatedTextSelectorImmediate = [
    ".block--hero .container .inner .inner__left h1",
    //".block--hero .companies .companies__items",
    ".homepage .homepage__hero .text-wrapper .container .inner h1",
    ".contact .contact__content .h2",
    ".references .h2"
];

// Funkce pro dočasné nahrazení sup/sub elementů placeholdery
function replaceSuperSubWithPlaceholders(element) {
    const $el = $(element);
    let html = $el.html();
    const placeholders = [];
    let counter = 0;
    
    // Nahradíme všechny <sup> a <sub> elementy placeholdery
    html = html.replace(/<(su[bp])[^>]*>(.*?)<\/\1>/gi, function(match, tag, content) {
        const placeholder = `__PLACEHOLDER_${counter}__`;
        placeholders[counter] = {
            placeholder: placeholder,
            original: match,
            tag: tag,
            content: content
        };
        counter++;
        return placeholder;
    });
    
    $el.html(html);
    return placeholders;
}

// Funkce pro vrácení placeholderů zpět na sup/sub elementy
function restoreSuperSubFromPlaceholders(element, placeholders) {
    const $el = $(element);
    
    placeholders.forEach(function(item) {
        // Najdeme všechny elementy obsahující placeholder
        $el.find('*').contents().each(function() {
            if (this.nodeType === 3) { // textový node
                const text = $(this).text();
                if (text.includes(item.placeholder)) {
                    const newText = text.replace(item.placeholder, item.original);
                    $(this).replaceWith(newText);
                }
            }
        });
    });
}

$(animatedTextSelectorScroll.join(", ")).each(function (index, el) {
    // Nahradíme sup/sub placeholdery před SplitType
    const placeholders = replaceSuperSubWithPlaceholders(el);
    
    const animatedText = new SplitType(el, { types: 'words', tagName: 'span' });
    $(animatedText.words).wrap("<span class='word-wrap'></span>");
    
    // Vrátíme sup/sub elementy zpět
    restoreSuperSubFromPlaceholders(el, placeholders);
    
    const trigger = $('<div class="trigger trigger--1-05-relative"></div>');
    trigger.prependTo(el);
    const tweenAnimatedText = gsap.from(animatedText.words, {
        rotation: 45,
        y: '800%',
        duration: 1,
        stagger: { amount: 1.1 },
        ease: "power4.out",
    });
    let duration = animatedText.words.length * 2 + 10;
    if (duration < 10) {
        duration = 10;
    }
    else if (duration > 50) {
        duration = 50;
    }
    new ScrollMagic.Scene({ triggerElement: trigger.get(0), duration: duration + '%' })
        .setTween(tweenAnimatedText)
        .addTo(controller);
});

$(animatedTextSelectorImmediate.join(", ")).each(function (index, el) {
    // Nahradíme sup/sub placeholdery před SplitType
    const placeholders = replaceSuperSubWithPlaceholders(el);
    
    const animatedText = new SplitType(el, { types: 'words', tagName: 'span' });
    $(animatedText.words).wrap("<span class='word-wrap'></span>");
    
    // Vrátíme sup/sub elementy zpět
    restoreSuperSubFromPlaceholders(el, placeholders);
    
    $(el).find("img").each(function () {$(this).wrap("<span class='word-wrap'></span>");});
    $(el).css('visibility', 'visible');
    gsap.fromTo($(el).find(".word-wrap"), 
        {
            rotation: 20,
            y: "800%",
            opacity: 0
        },
        {
            rotation: 0,
            y: "0%",
            opacity: 1,
            duration: 1.3,
            stagger: { amount: .1 },
            ease: "power4.out",
            onComplete: function () {
                $(".homepage__hero").addClass("loaded");
            }
        }
    );
});

    const animatedHeadingSelector = [
        ".block--sections .inner .inner__left h3",
    ];

    $(animatedHeadingSelector.join(", ")).each(function(index, el) {
        const animatedHeading = new SplitType(el, { types: 'words, chars', tagName: 'span' });

        $(animatedHeading.chars).wrap("<span class='char-wrap'></span>");

        const trigger = $('<div class="trigger trigger--1-05-relative"></div>');
        trigger.prependTo(el);

        const tweenAnimatedHeading = gsap.from(animatedHeading.chars, {
            rotation: 0,
            x: '-250%',
            scaleX: 1,
            duration: 1,
            // duration: 0.6,
            stagger: { amount: 0.1 },
            ease: "power4.out",
        });

        // new ScrollMagic.Scene({ triggerElement: el, offset: (-appConfig.height) })
        // new ScrollMagic.Scene({ triggerElement: el, duration: '50%', offset: (-appConfig.height * 1.05) })
        new ScrollMagic.Scene({ triggerElement: trigger.get(0), duration: '45%' })
            .setTween(tweenAnimatedHeading)
            // .addIndicators({name: "animated heading"})
            .addTo(controller);
    });

    $(".block--numbers .container .grid").each(function(index, el) {
        const trigger = $(el).find(".trigger.trigger--1-05");

        const tweenImageTiles = gsap.from($(el).find(".grid__item").get(), {
            rotation: 30,
            y: '300%',
            // y: 250,
            duration: 1.5,
            // duration: 0.8,
            stagger: { amount: 1.1 },
            ease: "power4.out",
        });

        // new ScrollMagic.Scene({ triggerElement: el, offset: (-appConfig.height) })
        // new ScrollMagic.Scene({ triggerElement: el, duration: '60%', offset: (-appConfig.height * 1.05) })
        new ScrollMagic.Scene({ triggerElement: trigger.get(0), duration: '50%' })
            .setTween(tweenImageTiles)
            // .addIndicators({name: "animated image-tiles-items"})
            .addTo(controller);
    });

    // services list

    var bubbles_sticky = TweenMax.fromTo(".block--bubbles .bubbles", 1, { opacity: 1 }, { opacity: 1, ease: Power1.easeOut });

    var heroImageScene = new ScrollMagic.Scene({
        triggerElement: "#bubbles-trigger",
        duration: "100%", // 120%
        triggerHook: 1
    })
    .setTween(bubbles_sticky)
    .setPin(".block--bubbles .wrapper")
    //.addIndicators({ name: "Bubbles" })
    .addTo(controller);

    // Animace pro h1
    var bubbles_title = TweenMax.fromTo(".block--bubbles .h1", 1, { opacity: 1, scale: 1 }, { opacity: 0, scale: .8, ease: Power1.easeOut });
    new ScrollMagic.Scene({
        triggerElement: "#bubbles-trigger",
        duration: "15%",
        triggerHook: 1
    })
    .setTween(bubbles_title)
    //.addIndicators({ name: "bubbles_titley" })
    .addTo(controller);

    var bubbles_star = TweenMax.fromTo(".block--bubbles .bubbles__center .star", 1, { y: 0, opacity: 1, scale: 1 }, { y: "-40vh", opacity: 0, scale: .1, ease: Power1.easeOut });
    new ScrollMagic.Scene({
        triggerElement: "#bubbles-trigger",
        duration: "10%",
        triggerHook: 1
    })
    .setTween(bubbles_star)
    //.addIndicators({ name: "bubbles_star" })
    .addTo(controller);

    // ******* BUBBLE LEFT START *******

    var bubble_left = TweenMax.fromTo(".bubbles__left", 1, { opacity: 0, scale: .7, x: "-300%", y: "100%" }, { opacity: 1, scale: 1, x: 0, y: 0, ease: Power1.easeOut });
    new ScrollMagic.Scene({
        triggerElement: "#bubbles-trigger",
        duration: "40%",
        triggerHook: 1
    })
    .setTween(bubble_left)
    //.addIndicators({ name: "bubble_left" })
    .addTo(controller);

    // var passedTriggerPoint = false;
    // var bubble_left = TweenMax.fromTo(".bubbles__left", 1, 
    //   { opacity: 0, scale: .7, x: "-300%", y: "100%" }, 
    //   { opacity: 1, scale: 1, x: 0, y: 0, ease: Linear.easeNone }
    // );

    // var scene = new ScrollMagic.Scene({
    //     triggerElement: "#bubbles-trigger",
    //     duration: "40%",
    //     triggerHook: 1
    // })
    // .setTween(bubble_left)
    // .addTo(controller);

    // var bounceScene = new ScrollMagic.Scene({
    //     triggerElement: "#bubbles-trigger",
    //     offset: window.innerHeight * 0.4,
    //     triggerHook: 1
    // })
    // .on("enter", function(event) {
    //     if (event.scrollDirection === "FORWARD") {
    //         TweenMax.to(".bubbles__left", 0.2, {
    //             x: "-15px",
    //             y: "15px", 
    //             ease: Power1.easeOut,
    //             onComplete: function() {
    //                 TweenMax.to(".bubbles__left", 0.4, {
    //                     x: 0,
    //                     y: 0,
    //                     ease: Elastic.easeOut.config(1, 0.4)
    //                 });
    //             }
    //         });
    //     }
    // })
    // .on("leave", function(event) {
    //     if (event.scrollDirection === "REVERSE") {
    //         passedTriggerPoint = false;
    //     }
    // })
    // .addTo(controller);

    // ******* BUBBLE LEFT END *******

    // *******  PERSON LEFT START *******

    var person_left = TweenMax.fromTo(".person-left", 1, { opacity: 0, scale: .7, x: "-150%", y: "-150%" }, { opacity: 1, scale: 1, x: 0, y: 0, ease: Power1.easeOut });
    new ScrollMagic.Scene({
        triggerElement: "#bubbles-trigger",
        duration: "70%",
        triggerHook: 1
    })
    .setTween(person_left)
    //.addIndicators({ name: "person_left" })
    .addTo(controller);

    // var passedTriggerPoint_person = false;
    // var person_left = TweenMax.fromTo(".person-left", 1, 
    //   { opacity: 0, scale: .7, x: "-150%", y: "-150%" }, 
    //   { opacity: 1, scale: 1, x: 0, y: 0, ease: Linear.easeNone }
    // );

    // var scene_person = new ScrollMagic.Scene({
    //     triggerElement: "#bubbles-trigger",
    //     duration: "90%",
    //     triggerHook: 1
    // })
    // .setTween(person_left)
    // //.addIndicators({ name: "person_left" })
    // .addTo(controller);

    // var bounceScene_person = new ScrollMagic.Scene({
    //     triggerElement: "#bubbles-trigger",
    //     offset: window.innerHeight * 0.9,
    //     triggerHook: 1
    // })
    // .on("enter", function(event) {
    //     if (event.scrollDirection === "FORWARD") {
    //         TweenMax.to(".person-left", 0.2, {
    //             x: "-5px",
    //             y: "-5px", 
    //             ease: Power1.easeOut,
    //             onComplete: function() {
    //                 TweenMax.to(".person-left", 0.4, {
    //                     x: 0,
    //                     y: 0,
    //                     ease: Elastic.easeOut.config(1, 0.4)
    //                 });
    //             }
    //         });
    //     }
    // })
    // .on("leave", function(event) {
    //     if (event.scrollDirection === "REVERSE") {
    //         passedTriggerPoint_person = false;
    //     }
    // })
    // .addTo(controller);

    // *******  PERSON LEFT END *******

    var bubble_right_1 = TweenMax.fromTo(".bubbles__right--top", 1, { opacity: 0, scale: .7, x: "300%", y: "-100%" }, { opacity: 1, scale: 1, x: 0, y: 0, ease: Power1.easeOut });
    new ScrollMagic.Scene({
        triggerElement: "#bubbles-trigger",
        duration: "30%",
        triggerHook: 1
    })
    .setTween(bubble_right_1)
    //.addIndicators({ name: "bubble_right_1" })
    .addTo(controller);


    var bubble_right_2 = TweenMax.fromTo(".bubbles__right--bottom", 1, { opacity: 0, scale: .7, x: "100%", y: "200%" }, { opacity: 1, scale: 1, x: 0, y: 0, ease: Power1.easeOut });
    new ScrollMagic.Scene({
        triggerElement: "#bubbles-trigger",
        duration: "60%",
        triggerHook: 1
    })
    .setTween(bubble_right_2)
    //.addIndicators({ name: "bubble_right_2" })
    .addTo(controller);

    var person_right = TweenMax.fromTo(".person-right", 1, { opacity: 0, scale: .7, x: "300%", y: "150%" }, { opacity: 1, scale: 1, x: 0, y: 0, ease: Power1.easeOut });
    new ScrollMagic.Scene({
        triggerElement: "#bubbles-trigger",
        duration: "80%",
        triggerHook: 1
    })
    .setTween(person_right)
    //.addIndicators({ name: "person_right" })
    .addTo(controller);


    var bubble_center = TweenMax.fromTo(".bubbles__center > img", 1, { opacity: 0, scale: .2}, { opacity: 1, scale: 1, ease: Power1.easeOut });
    new ScrollMagic.Scene({
        triggerElement: "#bubbles-trigger",
        duration: "5%",
        triggerHook: 1,
        offset: window.innerHeight * 0.2
    })
    .setTween(bubble_center)
    //.addIndicators({ name: "bubble_center" })
    .addTo(controller);

    var bubble_center_person = TweenMax.fromTo(".bubbles__center .person", 1, { opacity: 0, scale: .7,}, { opacity: 1, scale: 1, ease: Power1.easeOut });
    new ScrollMagic.Scene({
        triggerElement: "#bubbles-trigger",
        duration: "5%",
        triggerHook: 1,
        offset: window.innerHeight * 0.2
    })
    .setTween(bubble_center_person)
    //.addIndicators({ name: "bubble_center_person" })
    .addTo(controller);

});