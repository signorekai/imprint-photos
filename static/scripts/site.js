ready(function() {

  const masonryObserver = new IntersectionObserver(function(e) {
    e.forEach(function(el) {
      if (el.isIntersecting) {
        el.target.f('img').attr('srcset', el.target.f('img').data('srcset'));
        el.target.f('img').addClass('portfolio__masonry-img--show')
      }
    })
  }, { threshold: 0.5 });

  barba.hooks.after(() => {
    gtag('config', 'G-HE1NVQC063', {'page_path': window.location.pathname})
  });

  barba.init({
    prevent: ({el}) => el.href.indexOf('wp-admin') !== -1 || el.data('lightbox'),
    views: [{
      namespace: 'home',
      beforeEnter() {
        f('body').addClass('home')
      },
      afterEnter({next}) {
        window.scrollTo(0, 0);
        var $nav = next.container.f('a.works-nav__link');
        if ($nav) {
          $nav.on('mouseenter', function() {
            next.container.f(this.data('target')).addClass('overlay--show');
            // f('.header__svg').addClass('header__svg--show');
            // f('main article h1').addClass('h1--hide');
          });

          $nav.on('mouseleave', function() {
            next.container.f(this.data('target')).removeClass('overlay--show');
            // f('.header__svg').removeClass('header__svg--show');
            // f('main article h1').removeClass('h1--hide');
          });
        }
      },
      afterLeave(data) {
        f('body').removeClass('home')
      }
    }, {
      namespace: 'portfolio-page',
      beforeEnter() {
        console.log('portfolio-page beforeEnter hook')
        f('body').addClass('single')
        f('body').addClass('single-portfolio')
      },
      afterEnter({next}) {
        window.scrollTo(0, 0);
        console.log('portfolio-page afterEnter hook')

        // masonry
        const msnry = new Masonry(next.container.f('.portfolio__masonry'), {
          itemSelector: '.portfolio__masonry-item',
          columnWidth: '.portfolio__masonry-item-sizer',
          // columnWidth: 260,
          gutter: 10,
          percentPosition: true,
        })

        imagesLoaded( next.container.f('.portfolio__masonry')).on('progress', function() {
          msnry.layout();
        });

        next.container.f('.portfolio__masonry-item:not(.portfolio__masonry-description):not(.portfolio__masonry-view-more)').forEach(function(el) {

          el.on('click', function (e) {
            next.container.f('.gallery__photo').attr('src', (e.target.data('full-size')))
            next.container.f('.gallery__description').innerText = e.target.data('description')
            // console.log(e.target.attr('href'))
          })

          if (Modernizr.webp) {
            el.f('img').attr('data-srcset', el.f('img').data('webp-srcset'));
            // } else {
            // el.f('img').attr('data-srcset', el.f('img').data('webp-srcset'));
          }

          masonryObserver.observe(el);
        });

        next.container.f('.portfolio__masonry-view-more').forEach(function(el) {
          const projectName = el.data('project')
          el.on('mousedown', function (e) {

            next.container.f(`.portfolio__masonry-item[data-project='${projectName}']`).forEach(function(el) {
              el.toggleClass('portfolio__masonry-item--active')
            })

            setTimeout(() => {
              msnry.layout()
            }, 200)
          })
        }) 

        const headerParallax = rallax(f('.portfolio__header'), {
          speed: 0.4
        });

        let scrollY = window.scrollY;
        headerParallax.when(function() {
          const $height = document.documentElement.clientHeight;
          if (Math.abs(window.scrollY - scrollY) > ($height/10)) {
            scrollY = window.scrollY;
            return true;
          }
          return false;
        }, function(el) {
          const $percentage = 1 - ((window.scrollY / document.documentElement.clientHeight) * 1.1);
          next.container.f('.portfolio__title').style.transform = `translateY(${window.scrollY / document.documentElement.clientHeight * 100}%)`
          next.container.f('.portfolio__header').style.opacity = $percentage;
        });
      },
      afterLeave({current}) {
        current.container.f('.portfolio__masonry-item:not(.portfolio__masonry-description):not(.portfolio__masonry-view-more)').forEach(function(el) {
          masonryObserver.unobserve(el)
        });

        f('body').removeClass('single')
        f('body').removeClass('single-portfolio')
      }
    }]
    // schema: {
    // 	prefix: 'data-custom',
    // 	wrapper: 'wrap'
    // }
  });

  barba.hooks.afterEnter((data) => {
    console.log('global afterEnter hook', data)
    window.scrollTo(0, 0);
    f('[data-replace-img]').forEach(function(el) {
      if (Modernizr.webp) {
        el.css('background-image', `url(${el.data('webp-bg')}`);
      } else {
        el.css('background-image', `url(${el.data('bg')}`);
      }
    });
  })

  f('header.header').daybreak({
    onEnter: function(el) {
      el.addClass('footer--active');
    },
    // onLeave: function(el) {
    //   el.removeClass('footer--active');
    // }
  });
  
  f('.header__nav-icon').on('click', function() {
    this.toggleClass('header__nav-icon--active')
  })

  f('[href^="#contact"]').on('click', function(e) {
    // e.preventDefault();
    // console.log('hi');
  })
});