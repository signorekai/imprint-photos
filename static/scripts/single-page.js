ready(function() {
  f('header.header').daybreak({
    onEnter: function(el) {
      el.addClass('footer--active');
    },
    onLeave: function(el) {
      el.removeClass('footer--active');
    }
  });

  const headerParallax = rallax(f('.portfolio__header'), {
    speed: 0.4
  });

});