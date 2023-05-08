$(document).ready(function () {
  $(".header__burger").click(function (event) {
    $(".header__burger, .menu").toggleClass("active");
    $("body").toggleClass("lock");
    $(".menu").toggleClass("open");
  });

  $(".menu__link").click(function (event) {
    $(".header__burger, .menu").removeClass("active");
    $("body").removeClass("lock");
  });
});

window.$crisp = [];
window.CRISP_WEBSITE_ID = "5c1fd92c-0248-4751-b426-7cc7a48c64e8";
(function () {
  d = document;
  s = d.createElement("script");
  s.src = "https://client.crisp.chat/l.js";
  s.async = 1;
  d.getElementsByTagName("head")[0].appendChild(s);
})();
