ready(function() {
  if (document.referrer.length === 0) {
  f('#wheelie').removeClass('wheelie--init');
    setTimeout(function() {
      f('#wheelie').addClass('wheelie--loaded');
    }, 10)
  } else {
    f('#wheelie').addClass('wheelie--loaded').removeClass('wheelie--init');
  }

  f('.header__nav-icon').on('click', function() {
    this.toggleClass('header__nav-icon--active')
  })
  f('a:not( [ data-lightbox ] )').forEach(function(el) {
    if (el.hostname === window.location.hostname) {
      el.on('click', function(e) {
        e.preventDefault();
        f('#wheelie').addClass('wheelie--active');
        setTimeout(function() {
          window.location.href = el.href;
        }, 500);
      })
    } else {
      console.log(el.hostname);
    }
  })
});