jQuery( document ).ready( function( $ ) {
  // Your JavaScript goes here
  $nav = $('a.works__link');

  if ($nav) {
    $nav.hover( function() {
      $($(this).data('target')).addClass('--show');
      $('header.header .logo-link svg').addClass('--show');
      $('main article h1').addClass('--hide');
    }, function() {
      $($(this).data('target')).removeClass('--show');
      $('main article h1').removeClass('--hide');
      $('header.header .logo-link svg').removeClass('--show');
    });
  }

});