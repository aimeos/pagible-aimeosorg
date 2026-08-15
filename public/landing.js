/**
 * @license MIT, https://opensource.org/license/MIT
 */


document.addEventListener('DOMContentLoaded', () => {
    const initCarousel = (container, itemSelector) => {
        const items = Array.from(container.querySelectorAll(`.content > ${itemSelector}`));
        const indicators = Array.from(container.querySelectorAll('.indicators > .indicator'));

        if (items.length < 2 || indicators.length === 0) {
            return;
        }

        let activeIndex = Math.max(0, items.findIndex(item => item.classList.contains('active')));
        let interval = null;

        const activate = index => {
            activeIndex = index % items.length;

            items.forEach((item, itemIndex) => {
                item.classList.toggle('active', itemIndex === activeIndex);
                item.setAttribute('aria-hidden', itemIndex === activeIndex ? 'false' : 'true');
            });

            indicators.forEach((indicator, indicatorIndex) => {
                const active = indicatorIndex === activeIndex;
                indicator.classList.toggle('active', active);
                indicator.querySelector('a')?.setAttribute('aria-current', active ? 'true' : 'false');
            });
        };

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', event => {
                event.preventDefault();
                window.clearInterval(interval);
                activate(index);
            });
        });

        activate(activeIndex);
        interval = window.setInterval(() => activate(activeIndex + 1), 5000);
    };

    document.querySelectorAll('.landing.showcases').forEach(container => {
        initCarousel(container, '.showcase');
    });

    document.querySelectorAll('.landing.casestudies').forEach(container => {
        initCarousel(container, '.casestudy');
    });

    document.querySelectorAll('.landing.code .navbottom').forEach(navigation => {
        const section = navigation.closest('.landing.code');
        const links = Array.from(navigation.querySelectorAll('a'));
        const panels = Array.from(section?.querySelectorAll('.content > .code') ?? []);

        links.forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();

                const target = link.dataset.target
                    || Array.from(link.classList).find(name => panels.some(panel => panel.classList.contains(name)));

                if (!target) {
                    return;
                }

                links.forEach(item => item.classList.toggle('active', item === link));
                panels.forEach(panel => panel.classList.toggle('active', panel.classList.contains(target)));
            });
        });
    });
});
