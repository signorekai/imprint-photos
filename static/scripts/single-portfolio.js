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

  new LuminousGallery(f('[data-lightbox]'), {}, {
    namespace: 'winterfell',
    showCloseButton: true,
    caption: function (trigger) {
      return trigger.querySelector("img").getAttribute("alt");
    }
  });
});
