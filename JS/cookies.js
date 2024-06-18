function setCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(";");
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
  }
  return null;
}

window.onbeforeunload = function () {
  var scrollPos =
    window.pageYOffset ||
    document.documentElement.scrollTop ||
    document.body.scrollTop ||
    0;
  setCookie("scrollTop", scrollPos, 1);
  setCookie("URL", window.location.href, 1);
};

window.onload = function () {
  if (getCookie("URL") === window.location.href) {
    var scrollPos = parseInt(getCookie("scrollTop"), 10);
    if (!isNaN(scrollPos)) {
      var h2Element = document.querySelector("h2");
      if (h2Element) {
        var h2Offset = h2Element.offsetHeight + 32; // 32px equals 2rem
        scrollPos += h2Offset;
      }
      setTimeout(function () {
        window.scrollTo(0, scrollPos);
      }, 0); // Delay the scroll adjustment until the page fully loads
    }
  }
};
