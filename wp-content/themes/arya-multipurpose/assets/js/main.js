(function ($) {
  
  "use strict";


  var window_width = $(window).width(),
    window_height = window.innerHeight,
    header_height = $(".default-header").height(),
    header_height_static = $(".site-header.static").outerHeight(),
    fitscreen = window_height - header_height;

  $(".fullscreen").css("height", window_height)
  $(".fitscreen").css("height", fitscreen);


  $(window).on('scroll', function () {
    if ($(this).scrollTop() > 600) {
      $('.scroll-top').fadeIn(600);
    } else {
      $('.scroll-top').fadeOut(600);
    }
  });
  $('.scroll-top').on("click", function () {
    $("html,body").animate({
      scrollTop: 0
    }, 500);
    return false;
  });


  // ------------------------------------------------------------------------------ //
  // Preloader 
  // ------------------------------------------------------------------------------ //

  $(document).ready(function () {
    setTimeout(function () {
      $('body').addClass('loaded');
    }, 3000);
  });


  // ------------------------------------------------------------------------------ //
  // Active Menu 
  // ------------------------------------------------------------------------------ //


  $('#everestNav').everestNav({
    stickyNav: true,
  });

  //Smooth Scrolling Using Navigation Menu
  $('a[href*="#"]').on('click', function (e) {
    $('html,body').animate({
      scrollTop: $($(this).attr('href')).offset().top - 70
    }, 500);
    e.preventDefault();
  });



  // ------------------------------------------------------------------------------ //
  // Team carousel  
  // ------------------------------------------------------------------------------ //


  $("#team-carousel").owlCarousel({
    items: 4,
    loop: true,
    margin: 30,
    dots: true,
    autoplayHoverPause: true,
    smartSpeed: 500,
    autoplay: false,
    responsive: {
      0: {
        items: 1
      },
      767: {
        items: 2
      },
      992: {
        items: 4
      }
    }
  });


  // ------------------------------------------------------------------------------ //
  // Service carousel  
  // ------------------------------------------------------------------------------ //


  $("#service-carousel").owlCarousel({
    items: 4,
    loop: true,
    margin: 15,
    dots: true,
    autoplayHoverPause: true,
    smartSpeed: 500,
    autoplay: true,
    responsive: {
      0: {
        items: 1
      },
      767: {
        items: 2
      },
      992: {
        items: 4
      }
    }
  });


  // ------------------------------------------------------------------------------ //
  // Testimonial carousel  
  // ------------------------------------------------------------------------------ //


  $("#testimonial-carousel").owlCarousel({
    items: 2,
    loop: true,
    margin: 30,
    dots: true,
    autoplayHoverPause: true,
    smartSpeed: 500,
    autoplay: true,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 2
      }
    }
  });

  // ------------------------------------------------------------------------------ //
  // Stat Counter  
  // ------------------------------------------------------------------------------ //

  $('.counter').counterUp({
    delay: 10,
    time: 1000
  });


  // ------------------------------------------------------------------------------ //
  // Skill Section  
  // ------------------------------------------------------------------------------ //


  $(document).ready(function () {

    $(".skills").addClass("active");
    $(".skills .skill .skill-bar span").each(function () {
      $(this).animate({
        "width": $(this).parent().attr("data-bar") + "%"
      }, 1000);
      $(this).append('<b>' + $(this).parent().attr("data-bar") + '%</b>');
    });
    setTimeout(function () {
      $(".skills .skill .skill-bar span b").animate({
        "opacity": "1"
      }, 1000);
    }, 2000);
  });

  // ------------------------------------------------------------------------------ //
  // Accordian   
  // ------------------------------------------------------------------------------ //


  var allPanels = $(".accordion > dd").hide();
  allPanels.first().slideDown();
  $(".accordion").each(function () {
    $(this).find("dt > a").first().addClass("active").parent().next().css({
      display: "block"
    });
  });

  $(document).on('click', '.accordion > dt > a', function (e) {
    var current = $(this).parent().next("dd");
    $(this).parents(".accordion").find("dt > a").removeClass("active");
    $(this).addClass("active");
    $(this).parents(".accordion").find("dd").slideUp();
    $(this).parent().next().slideDown();
    return false;

  });


  // ------------------------------------------------------------------------------ //
  // Skillbar
  // ------------------------------------------------------------------------------ //


	$(".skill_main").each(function() {
    $(this).waypoint(function() {
        var progressBar = $(".progress-bar");
        progressBar.each(function(indx){
            $(this).css("width", $(this).attr("aria-valuenow") + "%")
        })
    }, {
        triggerOnce: true,
        offset: 'bottom-in-view'

    });
});


  // ------------------------------------------------------------------------------ //
  // Parallax Background 
  // ------------------------------------------------------------------------------ //

  $(window).stellar();

})(jQuery);