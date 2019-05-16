// jQuery( document ).ready( function( $ ) {
//   // Your JavaScript goes here
//   $nav = $('a.works__link');

//   if ($nav) {
//     $nav.hover( function() {
//       $($(this).data('target')).addClass('overlay--show');
//       $('.header__logo svg').addClass('--show');
//       $('main article h1').addClass('h1--hide');
//     }, function() {
//       $($(this).data('target')).removeClass('overlay--show');
//       $('.header__logo svg').removeClass('--show');
//       $('main article h1').removeClass('h1--hide');
//     });
//   }

// });

ready(function() {
  var $nav = f('a.works-nav__link');

  if ($nav) {
    $nav.on('mouseenter', function() {
      f(this.data('target')).addClass('overlay--show');
      f('.header__svg').addClass('header__svg--show');
      f('main article h1').addClass('h1--hide');
    });

    $nav.on('mouseleave', function() {
      f(this.data('target')).removeClass('overlay--show');
      f('.header__svg').removeClass('header__svg--show');
      f('main article h1').removeClass('h1--hide');
    });
  }

});