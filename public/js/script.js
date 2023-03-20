$(init);

function init() {
  //ANIMATIONS
  new WOW().init();
  $("body").addClass("wow animate__animated animate__fadeIn");
  $("header").addClass("wow animate__animated animate__fadeIn");
  $(".nav-link").addClass("wow animate__animated animate__fadeIn");
  // $(".dropdown-menu").addClass("wow animate__animated animate__fadeIn");
  $("footer").addClass("wow animate__animated animate__fadeIn");

  //CHANGEMENT DU LOGO
  onResize();
  addEventListener('resize', onResize);

  $("#newsletter form").submit(function () {
    alert("Inscription effectuée.");
  });

  $("#contactForm").submit(function () {
    alert("Demande de contact envoyée.");
  });

  $("#comment form").submit(function () {
    alert("Merci pour votre commentaire !");
  });
}

function onResize() {
  if ($("body").width() >= 1200) {
    $("#logo").attr("src", 'Images/logo_beauvaisis_blanc_inline.png');
    $("#logo").css("width", 553);
  }
  else if ($("body").width() >= 890) {
    $("#logo").attr("src", 'Images/logo_beauvaisis_blanc.png');
    $("#logo").css("width", 200);
  }
  else {
    $("#logo").attr("src", 'Images/logo_compresser_blanc.png');
    $("#logo").css("width", 90);
  }
}