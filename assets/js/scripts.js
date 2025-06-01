//  Preloader
jQuery(window).on("load", function () {
  $('#preloader').fadeOut(500);
  $('#main-wrapper').addClass('show');
});


(function ($) {
  //===========  ==========//
  $('.duration-option a')
  .on('click', function () {
      $(".duration-option a.active")
        .removeClass("active");
      $(this)
        .addClass('active');
  });


  //=========== Header sticky-top ==========//
  $(window).on('scroll', function(){
    if ($(window).scrollTop() > 50){
      $('.header').addClass('sticky-top');
    }
    else{
      $('.header').removeClass('sticky-top');
    }

  });


  //=========== niceSelect ==========//
  $('select').niceSelect();

  //=========== Testimonial1 OwlCarousel ==========//
  $('.testimonial .owl-carousel').owlCarousel({
    loop: true,
    items: 1,
    dots: false,
    nav: true,
    autoplay: false,
    autoplaySpeed: 2500,
    navSpeed: true,
    navSpeed: 1500,
    smartSpeed: 1500,
    navText: ["<i class='la la-arrow-left'></i>", "<i class='la la-arrow-right'></i>"],
  });

  //=========== owlCarousel client-slide ==========//
  var owl = $('.client-slide');
  owl.owlCarousel({
    loop: true,
    dots: false,
    autoplay: true,
    autoplaySpeed: 1000,
    responsive: {
      0: {
        items: 1
      },
      400: {
        items: 2
      },
      575: {
        items: 3
      },
      1000: {
        items: 5
      }
    }
  })
  
  //=========== masonry ==========//
  var $grid = $('.masonry-wrapper').masonry({
    itemSelector: '.masonry-item',
    columnWidth: '.masonry-sizer',
    percentPosition: true,
    transitionDuration: 0,
  });
  $grid.imagesLoaded().progress( function() {
      $grid.masonry();
  });



})(jQuery);;

