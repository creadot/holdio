<script src="<?php bloginfo('stylesheet_directory'); ?>/scripts/jquery-3.6.1.min.js" type="text/javascript"></script>      
<script src="<?php bloginfo('stylesheet_directory'); ?>/scripts/scripts-noreload.min.js" type="text/javascript"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/scripts/scripts.min.js" type="text/javascript"></script>

<?php if (is_front_page()): ?>
    <script>
        $(document).ready(function() {
            gsap.registerPlugin(ScrollTrigger);
            
            const companiesItems = document.querySelector(".homepage .companies .companies__items");
            if (!companiesItems) return;
            
            const companySpans = companiesItems.querySelectorAll('span');
            companiesItems.innerHTML = "";
            
            companySpans.forEach((companySpan) => {
                const companyWrapper = document.createElement("span");
                companyWrapper.classList.add("company");
                
                const companyText = companySpan.textContent;
                const isStrong = companySpan.classList.contains('strong');
                
                const asteriskSpan = document.createElement("span");
                asteriskSpan.classList.add("word");
                asteriskSpan.style.display = "inline-block";
                
                const asteriskLetter = document.createElement("span");
                asteriskLetter.classList.add("letter");
                asteriskLetter.style.opacity = 0;
                asteriskLetter.textContent = "*";
                asteriskSpan.appendChild(asteriskLetter);
                
                companyWrapper.appendChild(asteriskSpan);
                companyWrapper.appendChild(document.createTextNode(" "));
                
                companyText.split(" ").forEach((word, wordIndex) => {
                    if (word.trim()) {
                        const wordSpan = document.createElement("span");
                        wordSpan.classList.add("word");
                        if (isStrong) wordSpan.classList.add("strong");
                        wordSpan.style.display = "inline-block";
                        
                        word.split("").forEach((char) => {
                            const letterSpan = document.createElement("span");
                            letterSpan.classList.add("letter");
                            letterSpan.style.opacity = 0;
                            letterSpan.textContent = char;
                            wordSpan.appendChild(letterSpan);
                        });
                        
                        companyWrapper.appendChild(wordSpan);
                        
                        if (wordIndex < companyText.split(" ").filter(w => w.trim()).length - 1) {
                            companyWrapper.appendChild(document.createTextNode(" "));
                        }
                    }
                });
                
                companiesItems.appendChild(companyWrapper);
                
                companiesItems.appendChild(document.createTextNode(" "));
            });
            
            const letterSpans = document.querySelectorAll(".homepage .companies .companies__items .letter");

            const state = {
                scrollY: 0,           
                startY: 0,            
                endY: 0,              
                progress: 0,          
                isHovering: false,    
                activeTween: null,    
                scrollDisabled: false 
            };
            
            function init() {
                state.startY = 0; 
                state.endY = window.innerHeight * 0.5; 
                state.scrollY = window.scrollY;
                updateProgress();
            }
            
            function updateProgress() {
                if (!state.isHovering && !state.scrollDisabled) {
                    if (state.scrollY <= state.startY) {
                        state.progress = 0;
                    } else if (state.scrollY >= state.endY) {
                        state.progress = 1;
                    } else {
                        state.progress = (state.scrollY - state.startY) / (state.endY - state.startY);
                    }
                    
                    applyProgressToLetters();
                }
            }
            
            function applyProgressToLetters() {
                letterSpans.forEach((letter, index) => {
                    const letterProgress = Math.min(1, Math.max(0, 
                        (state.progress * letterSpans.length * 0.1 - index * 0.1) * 10
                    ));
                    letter.style.opacity = letterProgress;
                });
            }
            
            function clearActiveTween() {
                if (state.activeTween && state.activeTween.isActive()) {
                    state.activeTween.kill();
                    state.activeTween = null;
                }
            }
            
            window.addEventListener("scroll", function() {
                if (!state.scrollDisabled) {
                    state.scrollY = window.scrollY;
                    updateProgress();
                }
            });
            
            window.addEventListener("resize", init);
            
            const siteName = document.querySelector("h1 .site-name");
            if (siteName) {
                siteName.addEventListener("mouseenter", function() {
                    state.isHovering = true;
                    state.scrollDisabled = true;
                    
                    clearActiveTween();
                    
                    state.activeTween = gsap.to(state, {
                        progress: 1,
                        duration: (1 - state.progress) * 2,
                        ease: "power1.out",
                        onUpdate: function() {
                            applyProgressToLetters();
                        }
                    });
                });
                
                siteName.addEventListener("mouseleave", function() {
                    state.isHovering = false;
                    
                    clearActiveTween();
                    
                    let targetProgress;
                    if (state.scrollY <= state.startY) {
                        targetProgress = 0;
                    } else if (state.scrollY >= state.endY) {
                        targetProgress = 1;
                    } else {
                        targetProgress = (state.scrollY - state.startY) / (state.endY - state.startY);
                    }
                    
                    state.activeTween = gsap.to(state, {
                        progress: targetProgress,
                        duration: 0.1,
                        ease: "power2.out",
                        onUpdate: function() {
                            applyProgressToLetters();
                        },
                        onComplete: function() {
                            state.scrollDisabled = false;
                        }
                    });
                });
            }
            
            init();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.services-list--bg .categories__item').click(function() {
                lenis.scrollTo($('.services-list--bg .anchor').offset().top - 200, { duration: 2 });
            });
        });
    </script>
<?php endif ?>

<?php if ( is_single() && 'post' == get_post_type() ) { ?>
    <script>
        const templateShareLink = document.getElementById('share-link-template').innerHTML;
        Mustache.parse(templateShareLink);

        function shareLink(link, title = "") {
            const data = {
                "link": link,
                "linkEncoded": encodeURIComponent(link),
                "title": title,
                "titleEncoded": encodeURIComponent(title),
            };

            $("body").append(Mustache.render(templateShareLink, data));

            const clipboard = new Clipboard('.share-link-copy button');
            clipboard.on('success', function(e) {
                $(e.trigger).find("i").removeClass('fa-copy').addClass('fa-check');
            });

            $.fancybox.open({
                src: '#share-link',
                touch: false,
                afterClose: function () {
                    $('#share-link').remove();
                }
            });
        }

        $("body").on('click', '[data-share-link]', function(event) {
            event.preventDefault();

            const button = $(this);
            const link = button.data("share-link");
            const title = button.data("share-title");

            if (isMobileReally()) {
                navigator.share({
                    url: link,
                    title: title
                });
            }
            else {
                shareLink(link, title);
            }
        });
    </script>
<?php } ?>

<?php wp_footer(); ?>