ready(function() {
  const msnry = new Masonry('.portfolio__masonry', {
    itemSelector: '.portfolio__masonry-item',
    // columnWidth: 260,
    gutter: 10,
    percentPosition: true,
  })
  imagesLoaded( f('.portfolio__masonry')).on('progress', function() {
    msnry.layout();
  });

  new LuminousGallery(f('[data-lightbox]'), {
    arrowNavigation: true
  }, {
    namespace: 'winterfell',
    showCloseButton: true,
    caption: function (trigger) {
      return trigger.querySelector("img").getAttribute("alt");
    },
    closeTrigger: 'none',
    onOpen: function () {
      setTimeout(function() {
        f('.winterfell-open .winterfell-lightbox-caption').addClass('winterfell-lightbox-caption--show');
      }, 200);
      f('.winterfell-gallery-button').forEach(function(el) {
        el.innerText = "";
      });
    },
    onClose: function () {
      f('.winterfell-lightbox-caption').forEach(
        function(el) {
          el.removeClass('winterfell-lightbox-caption--show');
        }
      );
    },
  });

  const masonryObserver = new IntersectionObserver(function(e) {
    e.forEach(function(el) {
      if (el.isIntersecting) {
        el.target.f('img').attr('srcset', el.target.f('img').data('srcset'));
        el.target.f('img').addClass('portfolio__masonry-img--show')
      }
    })
  }, { threshold: 0.5 });

  f('.portfolio__masonry-item').forEach(function(el) {
    masonryObserver.observe(el);
  });

  // const logoObserver = new IntersectionObserver(function(entries, root) {
  // }, { threshold: [0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1], rootMargin: '20px', root: null });

  // logoObserver.observe(f('.portfolio__header'));
});
