// Preload images
function preloadImages(urls) {
  urls.forEach(function (url) {
    const img = new Image();
    img.src = url;
  });
}

document.addEventListener("DOMContentLoaded", function () {
  const imageUrls = [
    "../images/texture.jpg",
  ];
  preloadImages(imageUrls);
});
