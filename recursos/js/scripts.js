$(document).ready(function () {
  // Verificar si el modal ya ha sido mostrado
  if (!localStorage.getItem("modalShown")) {
    // Mostrar el modal
    $("#modalTerminosCondiciones").modal("show");

    // Marcar que el modal ha sido mostrado
    localStorage.setItem("modalShown", "true");
  }
});

(function ($) {
  "use strict";
  $(window).scroll(function () {
    if ($(this).scrollTop() > 200) {
      $(".back-to-top").fadeIn("slow");
    } else {
      $(".back-to-top").fadeOut("slow");
    }
  });
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 200, "easeInOutExpo");
    return false;
  });

  // Sticky Navbar
  $(window).scroll(function () {
    if ($(this).scrollTop() > 0) {
      $(".navbar").addClass("nav-sticky");
    } else {
      $(".navbar").removeClass("nav-sticky");
    }
  });

  $(document).ready(function () {
    $(".nav-link").hover(
      function () {
        $(this).find("i").addClass("bx-tada");
      },
      function () {
        $(this).find("i").removeClass("bx-tada");
      }
    );
  });

  $(document).ready(function () {
    $(".socials a").hover(
      function () {
        $(this).find("i").addClass("bx-tada");
      },
      function () {
        $(this).find("i").removeClass("bx-tada");
      }
    );
  });

  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
})(jQuery);

/* PANEL DE CONTROL*/
$.noConflict();

jQuery(document).ready(function ($) {
  "use strict";

  [].slice
    .call(document.querySelectorAll("select.cs-select"))
    .forEach(function (el) {
      new SelectFx(el);
    });

  jQuery(".selectpicker").selectpicker;

  $(".search-trigger").on("click", function (event) {
    event.preventDefault();
    event.stopPropagation();
    $(".search-trigger").parent(".header-left").addClass("open");
  });

  $(".search-close").on("click", function (event) {
    event.preventDefault();
    event.stopPropagation();
    $(".search-trigger").parent(".header-left").removeClass("open");
  });

  // $(".equal-height").matchHeight({
  //   property: "max-height",
  // });

  // var chartsheight = $('.flotRealtime2').height();
  // $('.traffic-chart').css('height', chartsheight-122);

  // Counter Number
  $(".count").each(function () {
    $(this)
      .prop("Counter", 0)
      .animate(
        {
          Counter: $(this).text(),
        },
        {
          duration: 3000,
          easing: "swing",
          step: function (now) {
            $(this).text(Math.ceil(now));
          },
        }
      );
  });

  // Menu Trigger
  $("#menuToggle").on("click", function (event) {
    var windowWidth = $(window).width();
    if (windowWidth < 1010) {
      $("body").removeClass("open");
      if (windowWidth < 760) {
        $("#left-panel").slideToggle();
      } else {
        $("#left-panel").toggleClass("open-menu");
      }
    } else {
      $("body").toggleClass("open");
      $("#left-panel").removeClass("open-menu");
    }
  });

  $(".menu-item-has-children.dropdown").each(function () {
    $(this).on("click", function () {
      var $temp_text = $(this).children(".dropdown-toggle").html();
      $(this)
        .children(".sub-menu")
        .prepend('<li class="subtitle">' + $temp_text + "</li>");
    });
  });

  // Load Resize
  $(window).on("load resize", function (event) {
    var windowWidth = $(window).width();
    if (windowWidth < 1010) {
      $("body").addClass("small-device");
    } else {
      $("body").removeClass("small-device");
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var images = document.querySelectorAll("img");
  images.forEach(function (img) {
    img.src = img.src + "?t=" + new Date().getTime();
  });
});
