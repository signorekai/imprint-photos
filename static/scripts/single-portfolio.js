ready(function() {
  var msnry = new Masonry('.article__masonry', {
    itemSelector: '.article__masonry-item',
    // columnWidth: 260,
    gutter: 10,
    percentPosition: true,
  })
  imagesLoaded( f('.article__masonry')).on('progress', function() {
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
});
