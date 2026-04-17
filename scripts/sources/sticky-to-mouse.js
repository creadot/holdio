$( document ).ready(function() {

    const param = {
        duration: 0.3,
        ease: 'Power2.easeOut'
    }

    const menus = document.querySelectorAll('.pagination .prev, .pagination .next, .button--sticky')

    menus.forEach(menu => {
        const circle = menu.querySelector('.circle')
        const icon = menu.querySelectorAll('i')
        const text = menu.querySelectorAll('.text')

        menu.addEventListener('mousemove', (e) => {
            if (!circle || !text) return

            const rect = menu.getBoundingClientRect()
            const s = e.clientX - rect.left
            const o = e.clientY - rect.top

            gsap.to(circle, {
                x: (s - menu.clientWidth / 2) / menu.clientWidth * 20,
                y: (o - menu.clientHeight / 2) / menu.clientHeight * 20,
                scale: 1.1,
                ease: param.ease,
                duration: param.duration
            });

            gsap.to(icon, {
                x: (s - menu.clientWidth / 2) / menu.clientWidth * 30,
                y: (o - menu.clientHeight / 2) / menu.clientHeight * 30,
                ease: param.ease,
                duration: param.duration
            });
            gsap.to(text, {
                x: (s - menu.clientWidth / 2) / menu.clientWidth * 20,
                y: (o - menu.clientHeight / 2) / menu.clientHeight * 20,
                ease: param.ease,
                duration: param.duration
            });
        });

        menu.addEventListener('mouseleave', () => {
            if (!circle || !icon || !text) return

            gsap.to(circle, {
                x: 0,
                y: 0,
                scale: 1,
                ease: param.ease,
                duration: param.duration
            });

            gsap.to(icon, {
                x: 0,
                y: 0,
                xPercent: -50,
                yPercent: -50,
                ease: param.ease,
                duration: param.duration
            });

            gsap.to(text, {
                x: 0,
                y: 0,
                xPercent: 0,
                yPercent: -50,
                ease: param.ease,
                duration: param.duration
            });
        });
    });

});